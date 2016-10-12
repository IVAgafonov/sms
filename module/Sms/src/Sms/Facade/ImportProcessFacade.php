<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\ImportMapper;
use Sms\Mapper\BaseMapper;
use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;

class ImportProcessFacade implements ImportProcessFacadeInterface
{
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $importProcessMapper;

    public function __construct(
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->importProcessMapper = $this->mapperFactory->createImportProcessMapper();
    }
    /**
    * Start import process.
    *
    * @param int $importProcessId
    * @param int $iteration
    */
    public function process($importProcessId, $iteration)
    {
        $importProcess = $this->importProcessMapper->getById($importProcessId);
        $importMapper = $this->mapperFactory->createImportMapper();
        $exchangeService = $this->serviceFactory->createExchangeService();
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        if ($iteration != $importProcess->getIteration()) {
            return 0;
        }
        $imported = 0;
        $fail     = 0;
        $counter  = 0;
        $countReaded = $iteration * 10000;
        $baseId = $importProcess->getBaseId();
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $csvProvider->open($baseId, CsvProvider::IMPORT);
        $csvProvider->cursorPos(0);
        $row = $csvProvider->readRow();
        if ($exchangeService->importConvert($row)) {
            $csvProvider->cursorPos(0);
        }
        for($i = 1; $i <= $countReaded; $i++) {
            $csvProvider->readRow();
        }
        while ($row = $csvProvider->readRow()) {
            $phoneArray = $exchangeService->importConvert($row);
            if ($phoneArray) {
                $phone = $phoneMapper->toEntity($phoneArray);
                $phone->setBaseId($baseId);
                $phoneMapper->importPhone($phone);
                $imported++;
            } else {
                $fail++;
            }
            $counter++;
            if ($counter == 10000) break; 
        }
        $phoneMapper->flushPhones();
        $import = $importMapper->getById($importProcess->getImportId());
        $import->setImported($import->getImported() + $imported);
        $import->setFails($import->getFails() + $fail);
        $importMapper->edit($import);
        if ($counter < 10000) {
            $this->finish($importProcessId);
        } else {
            $this->nextIteration($importProcessId);
        }
    }
    /**
    * Finish import process.
    *
    * @param int $importProcessId
    * @param int $iteration
    */
    public function finish($importProcessId)
    {
        $importProcess = $this->importProcessMapper->getById($importProcessId);
        $baseMapper    = $this->mapperFactory->createBaseMapper();
        $baseId = $importProcess->getBaseId();
        $base = $baseMapper->getById($baseId);
        $baseMapper->setBaseStatus($base, BaseMapper::BASE_READY);
        $importMapper  = $this->mapperFactory->createImportMapper();
        $import = $importMapper->getById($importProcess->getImportId());
        $import->setStatus(ImportMapper::READY);
        $importMapper->edit($import);
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $csvProvider->delete($baseId, CsvProvider::IMPORT);
        $this->importProcessMapper->delete($importProcess->getId());
    }
    /**
    * Start next iteration of import process.
    *
    * @param int $importProcessId
    */
    public function nextIteration($importProcessId)
    {
        $importProcess = $this->importProcessMapper->getById($importProcessId);
        # increment iteration of import process
        $nextIteration = $importProcess->getIteration() + 1;
        $importProcess->setIteration($nextIteration);
        $this->importProcessMapper->edit($importProcess);
        $exchangeService = $this->serviceFactory->createExchangeService();
        # run next iteration
        $exchangeService->processImport($importProcess->getId(), $nextIteration);
    }
}