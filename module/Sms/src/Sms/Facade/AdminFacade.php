<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\BaseMapper;
use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;
use Sms\Exception\SmsException;

class AdminFacade implements AdminFacadeInterface
{
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;

    public function __construct(
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
    }
    /**
    * Get User array by userId.
    *
    * @param int $userId
    * @return array
    */
    public function getUserById($userId)
    {
        $userMapper = $this->mapperFactory->createUserMapper();
        $user = $userMapper->getById($userId);
        return $userMapper->toArray($user);
    }
    /**
    * Get user list (Paginator) by page & filter.
    *
    * @param int    $page
    * @param string $filter
    * @return Paginator
    */
    public function getUserList($page, $filter)
    {
        $userMapper = $this->mapperFactory->createUserMapper();
        $userList = $userMapper->getUserList($page, $filter);
        return $userList;
    }
    /**
    * Get user's send list (Paginator) by page & userId.
    *
    * @param int    $page
    * @param int    $userId
    * @return Paginator
    */
    public function getUserSendList($page, $userId)
    {
        $sendMapper = $this->mapperFactory->createSendMapper();
        $sendList = $sendMapper->getSendList($page, $userId);
        return $sendList;
    }   
    /**
    * Edit User.
    *
    * @param array    $array
    * @return int
    */
    public function editUser($array)
    {
        $userMapper = $this->mapperFactory->createUserMapper();
        $editedUser = $userMapper->toEntity($array);
        $userMapper->edit($editedUser);
        $this->loggerService->log("User (".$editedUser->getId().") has been edited.");
        return $editedUser->getId();
    }
    /**
    * Force delete active delivery.
    *
    * @param int    $sendId
    * @return int
    */
    public function deleteSend($sendId)
    {
        $sendMapper = $this->mapperFactory->createSendMapper();
        $send = $sendMapper->getById($sendId);
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $base = $baseMapper->getById($send->getBaseId());
        # delete delivery record
        $sendMapper->delete($sendId);
        # if base is not waiting to send / prepare to send / send
        if (!$sendMapper->getSendListByBaseId($base->getId())) {
            $baseMapper->setBaseStatus($base, BaseMapper::BASE_READY);
        }
        $sendProcessMapper = $this->mapperFactory->createSendProcessMapper();
        #delete delivery process record
        $sendProcess = $sendProcessMapper->getBySendId($sendId);
        if ($sendProcess) {
            $sendProcessMapper->delete($sendProcess->getId());
        }
        $this->loggerService->log("Delivery with message '".$send->getMessageTitle()."' and base ".$send->getBaseName()." has been deleted.");
        return $base->getUserId();
    }
    /**
    * Download user's base.
    *
    * @param int    $baseId
    * @return int
    */
    public function downloadUserBase($baseId)
    {
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $fullName = $csvProvider->isExists($baseId, CsvProvider::EXPORT);
        if ($fullName) {
            $exchangeService = $this->serviceFactory->createExchangeService();
            $response = $exchangeService->downloadFile($fullName, $baseId);
            return $response;
        } else {
            throw new SmsException(_("Can't find export file. Please try again."));
        }
    }
}

