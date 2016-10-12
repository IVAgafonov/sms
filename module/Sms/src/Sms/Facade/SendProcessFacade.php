<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\SendMapper;
use Sms\Mapper\BaseMapper;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;
use Sms\Strategy\SendStrategyInterface;

class SendProcessFacade implements SendProcessFacadeInterface
{
    protected $sendStrategy;
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $sendProcessMapper;

    public function __construct(
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory,
        SendStrategyInterface $sendStrategy
    ) {
        $this->sendStrategy = $sendStrategy;
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->sendProcessMapper = $this->mapperFactory->createSendProcessMapper();
    }

    public function process($sendProcessId, $iteration)
    {
        $sendProcess = $this->sendProcessMapper->getById($sendProcessId);
        $sendMapper = $this->mapperFactory->createSendMapper();
        $send = $sendMapper->getById($sendProcess->getSendId());
        $message = $send->getMessageText();
        //$this->loggerService->log('Debug. Start send process'.$message);
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $base = $baseMapper->getById($send->getBaseId());
        $baseParams = $baseMapper->getBaseParams($base);
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        $phones = $phoneMapper->getPhonesToExport($send->getBaseId(), $iteration);
        $userMapper = $this->mapperFactory->createUserMapper();
        $countPhones = count($phones);
        if ($countPhones > 0) {
            $success = $this->sendStrategy->sendPart($message, $baseParams, $phones, $send->getStartTime(), $userMapper, $send->getUserId());
            //$this->loggerService->log("Iteration № $iteration was complited", $user->getId());
            if ($success) {
                # if successfully send part
                $send->setSended($send->getSended() + count($phones));
                $sendMapper->edit($send);
                if ($countPhones < 10000) {
                    $this->finish($sendProcessId);
                } else {
                    $this->nextIteration($sendProcessId);
                }
            } else { 
                # insufficient funds
                $send->setStatus(SendMapper::SEND_SUSPENDED);
                $sendMapper->edit($send);
            }
            
        } else {
            $this->finish($sendProcessId);
        }

    }
    
    public function finish($sendProcessId)
    {
        $sendProcess = $this->sendProcessMapper->getById($sendProcessId);
        $sendMapper = $this->mapperFactory->createSendMapper();
        $send = $sendMapper->getById($sendProcess->getSendId());
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $base = $baseMapper->getById($send->getBaseId());
        $baseMapper->setBaseStatus($base, BaseMapper::BASE_READY);
        $send->setStatus(SendMapper::SEND_COMPLETE);
        $sendMapper->edit($send);
        $this->sendProcessMapper->delete($sendProcess->getId());
    }
    
    public function nextIteration($sendProcessId)
    {
        $sendProcess = $this->sendProcessMapper->getById($sendProcessId);
        $nextIteration = $sendProcess->getIteration() + 1;
        $sendProcess->setIteration($nextIteration);
        $this->sendProcessMapper->edit($sendProcess);
        $exchangeService = $this->serviceFactory->createExchangeService();
        $exchangeService->processSend($sendProcess->getId(), $nextIteration);
    }
}