<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\ExportMapper;
use Sms\Mapper\BaseMapper;
use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;

class ExportProcessFacade implements ExportProcessFacadeInterface
{
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $exportProcessMapper;

    public function __construct(
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->exportProcessMapper = $this->mapperFactory->createExportProcessMapper();
    }
    /**
    * Start export process.
    *
    * @param int $exportProcessId
    * @param int $iteration
    */
    public function process($exportProcessId, $iteration)
    {
        $exportProcess = $this->exportProcessMapper->getById($exportProcessId);
        $exchangeService = $this->serviceFactory->createExchangeService();
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        # get phones block to export
        $phones = $phoneMapper->getPhonesToExport($exportProcess->getBaseId(), $iteration);
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $csvProvider->open($exportProcess->getBaseId(), CsvProvider::EXPORT);
        $counter  = 0;
        # export phones to file
        foreach($phones as $phone) {
            $exportArray = $exchangeService->exportConvert($phoneMapper->toArray($phone));
            $csvProvider->writeRow($exportArray);
            $counter++;
        }
        $csvProvider->close();
        # if count < 10000 - export process is over
        if ($counter < 10000) {
            $this->finish($exportProcessId);
        } else {
            $this->nextIteration($exportProcessId);
        }
    }
    /**
    * Finish export process.
    *
    * @param int $exportProcessId
    */
    public function finish($exportProcessId)
    {
        $exportProcess = $this->exportProcessMapper->getById($exportProcessId);
        $baseMapper    = $this->mapperFactory->createBaseMapper();
        $baseId = $exportProcess->getBaseId();
        $base = $baseMapper->getById($baseId);
        # unlock base after export
        if ($base->getStatus()->getId() == BaseMapper::BASE_EXPORT) {
            $baseMapper->setBaseStatus($base, BaseMapper::BASE_READY);
        }
        $exportMapper = $this->mapperFactory->createExportMapper();
        $exportId = $exportProcess->getExportId();
        # delete export process record
        $this->exportProcessMapper->delete($exportProcess->getId());
        # set export record status "ready"
        if ($exportId) {
            $export = $exportMapper->getById($exportId);
            $export->setStatus(ExportMapper::READY);
            $exportMapper->edit($export);
        }
    }
    /**
    * Start next iteration of export process.
    *
    * @param int $exportProcessId
    */
    public function nextIteration($exportProcessId)
    {
        $exportProcess = $this->exportProcessMapper->getById($exportProcessId);
        # increment iteration
        $nextIteration = $exportProcess->getIteration() + 1;
        $exportProcess->setIteration($nextIteration);
        $this->exportProcessMapper->edit($exportProcess);
        $exchangeService = $this->serviceFactory->createExchangeService();
        # run next iteration
        $exchangeService->processExport($exportProcess->getId(), $nextIteration);
    }
}