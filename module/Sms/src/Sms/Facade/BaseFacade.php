<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\BaseMapper;
use Sms\Mapper\ExportMapper;
use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;
use Sms\Exception\SmsException;

class BaseFacade implements BaseFacadeInterface
{
    protected $userId;
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $baseMapper;
    
    public function __construct(
        $userId,
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->userId = $userId;
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->baseMapper = $this->mapperFactory->createBaseMapper();
    }
    /**
    * Add new Base.
    *
    * @param array  $array
    * @return int
    */
    public function add($array)
    {
        $baseService = $this->serviceFactory->createBaseService();
        $newBase = $this->baseMapper->toEntity($array);
        # check base limit
        $baseService->checkCount($this->baseMapper->getBasesCount($this->userId));
        # check base name for duplicate 
        $baseService->checkExists($newBase, $this->baseMapper->getIdByName($newBase->getName(), $this->userId));
        $newBase->setUserId($this->userId);
        $this->baseMapper->add($newBase);
        $this->loggerService->log("Base with name '".$newBase->getName()."' has been created",$this->userId);
        return $newBase->getId();
    }
    /**
    * Edit Base.
    *
    * @param array  $array
    * @return int
    */
    public function edit($array)
    {
        $baseService = $this->serviceFactory->createBaseService();
        $editedBase = $this->baseMapper->toEntity($array);
        # check base by user
        $baseService->checkUser($editedBase, $this->userId);
        # check base status
        $baseService->checkLocked($editedBase);
        # check base name for duplicate 
        $baseService->checkExists($editedBase, $this->baseMapper->getIdByName($editedBase->getName(), $this->userId));
        $editedBase->setUserId($this->userId);
        $this->baseMapper->edit($editedBase);
        $this->loggerService->log("Base has been edited. New name '".$editedBase->getName()."'",$this->userId);
        $this->deleteExport($editedBase->getId());
        return $editedBase->getId();
    }
    /**
    * Delete Base by id.
    *
    * @param int  $id
    */
    public function delete($id)
    {
        $baseService = $this->serviceFactory->createBaseService();
        $base = $this->baseMapper->getById($id);
        $baseService->checkUser($base, $this->userId);
        $baseService->checkLocked($base);
        #delete export
        $this->deleteExport($base->getId());
        #delete all numbers from this base
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        $phoneMapper->deleteAllByBaseId($base->getId());
        $this->baseMapper->delete($base->getId());
        $this->loggerService->log("Base with name '".$base->getName()."' has been deleted",$this->userId);
    }
    /**
    * Get base list by page.
    *
    * @param int  $page
    * @return Paginator
    */
    public function getList($page)
    {
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        #get base list by page and user
        $baseList['baseList'] = $this->baseMapper->getBaseList($page, $this->userId);
        if ($baseList['baseList']) {
            foreach ($baseList['baseList'] as $base) {
                #get numbers count of each base
                $baseList['counts'][$base->getId()] = $phoneMapper->getPhonesCountByBaseId($base->getId());
            }
        } else {
            $baseList['counts'] = 0;
        }
        return $baseList;
    }
    /**
    * Get base array by id.
    *
    * @param int  $id
    * @return array
    */
    public function getById($id)
    {
        $baseService = $this->serviceFactory->createBaseService();
        $base = $this->baseMapper->getById($id);
        $baseService->checkUser($base, $this->userId);
        $baseService->checkLocked($base);
        return $this->baseMapper->toArray($base);
    }
    /**
    * Export base by id.
    *
    * @param int  $baseId
    */
    public function export($baseId)
    {
        $exportMapper = $this->mapperFactory->createExportMapper();
        $baseService = $this->serviceFactory->createBaseService();
        # get base
        $base = $this->baseMapper->getById($baseId);
        # check base by user & status
        $baseService->checkUser($base, $this->userId);
        $baseService->checkLocked($base);
        # lock base to export
        $this->baseMapper->setBaseStatus($base, BaseMapper::BASE_EXPORT);
        $csvProvider = $this->serviceFactory->createCsvProvider();
        # if base export file exists - delete file & export record
        if ($csvProvider->isExists($base->getId(), CsvProvider::EXPORT)) {
            $csvProvider->delete($base->getId(), CsvProvider::EXPORT);
            $export = $exportMapper->getByBaseId($baseId);
            if ($export) {
                $exportMapper->delete($export->getId());
            }
        }
        # create export file
        $csvProvider->open($base->getId(), CsvProvider::EXPORT);
        # write base arguments
        $csvProvider->writeRow($this->baseMapper->getBaseParams($base));
        $csvProvider->close();
        # create export record
        $export = $exportMapper->toEntity(
            array(
                'base_id' => $base->getId(),
                'base_name' => $base->getName(),
                'user_id' => $this->userId,
                'status' => ExportMapper::PROCESS
            )
        );
        $exportMapper->add($export);
        # create export process record
        $exportProcessMapper = $this->mapperFactory->createExportProcessMapper();
        $exportProcess = $exportProcessMapper->toEntity(
            array(
                'base_id' => $base->getId(),
                'iteration' => 0,
                'export_id' => $export->getId(),
                'executed' => 1
            )
        );
        $exportProcessMapper->add($exportProcess);
        # run export process
        $exchangeService = $this->serviceFactory->createExchangeService();
        $exchangeService->processExport($exportProcess->getId(), 0);
    }
    /**
    * Get export list.
    *
    * @param int  $page
    * @return Paginator
    */
    public function getExportList($page)
    {
        $exportMapper = $this->mapperFactory->createExportMapper();
        $exportList = $exportMapper->getExportList($page, $this->userId);
        return $exportList;
    }
    /**
    * Download exported file.
    *
    * @param int  $exportId
    * @return Response
    */
    public function download($exportId)
    {
        # get export record
        $exportMapper = $this->mapperFactory->createExportMapper();
        $export = $exportMapper->getById($exportId);
        $baseService = $this->serviceFactory->createBaseService();
        # get base
        $base = $this->baseMapper->getById($export->getBaseId());
        # check base by user & lock
        $baseService->checkUser($base, $this->userId);
        $baseService->checkLocked($base);
        $csvProvider = $this->serviceFactory->createCsvProvider();
        # check exists file
        $fullName = $csvProvider->isExists($base->getId(), CsvProvider::EXPORT);
        if ($fullName) {
            # send file
            $exchangeService = $this->serviceFactory->createExchangeService();
            $response = $exchangeService->downloadFile($fullName, $export->getBaseName());
            return $response;
        } else {
            # if file not exists - delete export record
            $exportMapper->delete($export->getId());
            throw new SmsException(_("Can't find export file. Please try again."));
        }
    }
    /**
    * Delete export record.
    *
    * @param int  $baseId
    * @return Response
    */
    public function deleteExport($baseId)
    {
        # get base
        $base = $this->baseMapper->getById($baseId);
        $baseService = $this->serviceFactory->createBaseService();
        # check user & lock
        $baseService->checkUser($base, $this->userId);
        $baseService->checkLocked($base);
        # delete file
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $csvProvider->delete($baseId, CsvProvider::EXPORT);
        # delete export record
        $exportMapper = $this->mapperFactory->createExportMapper();
        $export = $exportMapper->getByBaseId($baseId);
        if ($export) {
            $exportMapper->delete($export->getId());
        }
    }
}