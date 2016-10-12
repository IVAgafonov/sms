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

class ImportFacade implements ImportFacadeInterface
{
    protected $userId;
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $importMapper;

    public function __construct(
        $userId,
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->userId = $userId;
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->importMapper = $this->mapperFactory->createImportMapper();
    }
    /**
    * Prepare base to import.
    *
    * @param array $importArray
    * @return array
    */
    public function prepareBaseToImport($importArray)
    {
        $exchangeService = $this->serviceFactory->createExchangeService();
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $baseService = $this->serviceFactory->createBaseService();
        # check import data
        $exchangeService->checkBaseValues($importArray);
        # exists base
        if ($importArray['base_select']) {
            $base = $baseMapper->getById($importArray['base_select']);
            $baseService->checkLocked($base);
            $this->deleteExport($base->getId());
        # new base
        } else {
            $base = $baseMapper->toEntity(array('user_id' => $this->userId, 'name' => $importArray['base_name']));
            $baseService->checkExists($base, $baseMapper->getIdByName($importArray['base_name'], $this->userId));
            $baseMapper->setBaseStatus($base, BaseMapper::BASE_READY);
        }
        # prepare file to import
        $exchangeService->prepareFileToImport($importArray['base_file']['tmp_name'], $base->getId());
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $csvProvider->open($base->getId(), CsvProvider::IMPORT);
        $csvProvider->cursorPos(0);
        $params = $csvProvider->readRow();
        # if first line has invalid number - get base arguments
        if (!$exchangeService->importConvert($params)) {
            $baseMapper->setBaseParams($base, $params);
        }
        $csvProvider->close();
        # lock base to import
        $baseMapper->setBaseStatus($base, BaseMapper::BASE_IMPORT);
        $this->loggerService->log("Base with name '".$base->getName()."' has been prepared to import",$this->userId);
        return $baseMapper->toArray($base);
    }
    /**
    * Start import process.
    *
    * @param array $baseArray
    * @return array
    */
    public function import($baseArray)
    {
        # create import record
        $import = $this->importMapper->toEntity(
            array(
                'user_id' => $this->userId,
                'base_name' => $baseArray['name'],
                'imported' => 0,
                'fails' => 0,
                'status' => ImportMapper::PROCESS
            )
        );
        $this->importMapper->add($import);
        # create import process record
        $importProcessMapper = $this->mapperFactory->createImportProcessMapper();
        $importProcess = $importProcessMapper->toEntity(
            array(
                'base_id' => $baseArray['id'],
                'import_id' => $import->getId(),
                'iteration' => 0,
                'executed' => 1
            )
        );
        $importProcessMapper->add($importProcess);
        $exchangeService = $this->serviceFactory->createExchangeService();
        $this->loggerService->log("Import started. Process id -".$importProcess->getId(), $this->userId);
        # execute import process
        $exchangeService->processImport($importProcess->getId(), 0);
    }
    /**
    * Get import list.
    *
    * @param int $page
    * @return Paginator
    */
    public function getList($page)
    {
        $importList = $this->importMapper->getImportList($page, $this->userId);
        return $importList;
    }
    /**
    * Delete export file & export record.
    *
    * @param int $baseId
    */
    public function deleteExport($baseId)
    {
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $csvProvider->delete($baseId, CsvProvider::EXPORT);
        $exportMapper = $this->mapperFactory->createExportMapper();
        $export = $exportMapper->getByBaseId($baseId);
        if ($export) {
            $exportMapper->delete($export->getId());
        }
    }
}