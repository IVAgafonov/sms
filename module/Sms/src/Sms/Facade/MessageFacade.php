<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;

class MessageFacade implements MessageFacadeInterface
{
    protected $userId;
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $messageMapper;
    
    public function __construct(
        $userId,
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->userId = $userId;
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->messageMapper = $this->mapperFactory->createMessageMapper();
    }
    
    public function add($array)
    {
        $messageService = $this->serviceFactory->createMessageService();
        $newMessage = $this->messageMapper->toEntity($array);
        $messageService->checkCount($this->messageMapper->getMessagesCount($this->userId));
        $messageService->checkExists($newMessage, $this->messageMapper->getIdByTitle($newMessage->getTitle(), $this->userId));
        $newMessage->setUserId($this->userId);
        $this->messageMapper->add($newMessage);
        $this->loggerService->log("Message with title '".$newMessage->getTitle()."' has been created",$this->userId);
    }

    public function edit($array)
    {
        $messageService = $this->serviceFactory->createMessageService();
        $editedMessage = $this->messageMapper->toEntity($array);
        #check message count
        $messageService->checkCount($this->messageMapper->getMessagesCount($this->userId));
        $messageService->checkUser($editedMessage, $this->userId);
        #check message name for duplicate title
        $messageService->checkExists($editedMessage, $this->messageMapper->getIdByTitle($editedMessage->getTitle(), $this->userId));
        $editedMessage->setUserId($this->userId);
        $this->messageMapper->edit($editedMessage);
        $this->loggerService->log("Message with title '".$editedMessage->getTitle()."' has been edited",$this->userId);
    }

    public function delete($id)
    {
        $message = $this->messageMapper->getById($id);
        $this->messageMapper->delete($message->getId());
        $this->loggerService->log("Message with title '".$message->getTitle()."' has been deleted",$this->userId);
    }

    public function getList($page)
    {
        $msgList = $this->messageMapper->getMessageList($page, $this->userId);
        return $msgList;
    }
    
    public function getById($id)
    {
        $messageService = $this->serviceFactory->createMessageService();
        $message = $this->messageMapper->getById($id);
        $messageService->checkUser($message, $this->userId);
        return $this->messageMapper->toArray($message);
    }
}

