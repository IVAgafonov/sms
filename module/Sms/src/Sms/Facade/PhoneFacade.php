<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;

class PhoneFacade implements PhoneFacadeInterface
{
    protected $userId;
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $phoneMapper;
    
    public function __construct(
        $userId,
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->userId = $userId;
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->phoneMapper = $this->mapperFactory->createPhoneMapper();
    }

    public function add($array)
    {
        $newPhone = $this->phoneMapper->toEntity($array);
        $phoneService = $this->serviceFactory->createPhoneService();
        $checkPhoneId = $this->phoneMapper->getIdByNumber($newPhone->getNumber(), $newPhone->getBaseId());
        $phoneService->checkExists($newPhone, $checkPhoneId);
        $this->phoneMapper->add($newPhone);
        $this->loggerService->log("Phone number '".$newPhone->getNumber()."' has been created in base(".$newPhone->getBaseId().")",$this->userId);
        $this->deleteExport($newPhone->getBaseId());
    }

    public function edit($array)
    {
        $newPhone = $this->phoneMapper->toEntity($array);
        $phoneService = $this->serviceFactory->createPhoneService();
        $checkPhoneId = $this->phoneMapper->getIdByNumber($newPhone->getNumber(), $newPhone->getBaseId());
        $phoneService->checkExists($newPhone, $checkPhoneId);
        $this->phoneMapper->edit($newPhone);
        $this->loggerService->log("Phone number '".$newPhone->getNumber()."' has been updated in base(".$newPhone->getBaseId().")",$this->userId);
        $this->deleteExport($newPhone->getBaseId());
    }

    public function delete($phone)
    {
        $this->phoneMapper->delete($phone['id']);
        $this->loggerService->log("Phone number '".$phone['number']."' has been deleted from base (".$phone['bse_id'].")",$this->userId);
        $this->deleteExport($newPhone->getBaseId());
    }

    public function getList($page, $baseId, $filter)
    {
        $phoneList = $this->phoneMapper->getPhoneList($page, $baseId, $filter);
        return $phoneList;
    }

    public function getById($id)
    {
        $phone = $this->phoneMapper->getById($id);
        return $this->phoneMapper->toArray($phone);
    }
    /**
     * Check base by baseId
     * 
     * @param int $baseId
     * @return array
     * @throws SmsException
     */
    public function checkBase($baseId)
    {
        $baseService = $this->serviceFactory->createBaseService();
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $base = $baseMapper->getById($baseId);
        $baseService->checkUser($base, $this->userId);
        $baseService->checkLocked($base);
        return $baseMapper->toArray($base);
    }
    public function setStatus($phoneArray, $newStatus)
    {
        $phoneArray['status'] = $newStatus;
        $newPhone = $this->phoneMapper->toEntity($phoneArray);
        $this->phoneMapper->edit($newPhone);
    }
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