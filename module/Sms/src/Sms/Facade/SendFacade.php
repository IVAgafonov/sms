<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\BaseMapper;
use Sms\Mapper\SendMapper;
use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;

class SendFacade implements SendFacadeInterface
{
    protected $userId;
    protected $mapperFactory;
    protected $serviceFactory;
    protected $loggerService;
    protected $sendMapper;
    
    public function __construct(
        $userId,
        MapperFactoryInterface $mapperFactory,
        ServiceFactoryInterface $serviceFactory
    ) {
        $this->userId = $userId;
        $this->mapperFactory = $mapperFactory;
        $this->serviceFactory = $serviceFactory;
        $this->loggerService = $this->serviceFactory->createLoggerService();
        $this->sendMapper = $this->mapperFactory->createSendMapper();
    }

    public function add($array)
    {
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $messageMapper = $this->mapperFactory->createMessageMapper();
        $base = $baseMapper->getById($array['base_id']);
        $message = $messageMapper->getById($array['message_id']);
        $send = $this->sendMapper->toEntity(
            array(
                'user_id' => $this->userId,
                'base_id' => $base->getId(),
                'base_name' => $base->getName(),
                'message_text' => $message->getText(),
                'message_id' => $message->getId(),
                'message_title' => $message->getTitle(),
                'start_time' => $array['start_time'],
                'status' => SendMapper::SEND_WAIT,
                'sended' => 0
            )
        );
        $this->sendMapper->add($send);
        $baseMapper->setBaseStatus($base, BaseMapper::BASE_SEND);
        $sendProcessMapper = $this->mapperFactory->createSendProcessMapper();
        $sendProcess = $sendProcessMapper->toEntity(
            array(
                'send_id' => $send->getId(),
                'iteration' => 0,
                'executed' => 0
            )
        );
        $sendProcessMapper->add($sendProcess);
        # start export file
        $exportProcessMapper = $this->mapperFactory->createExportProcessMapper();
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $existsExportProcess = $exportProcessMapper->getByBaseId($base->getId());
        if ((!$existsExportProcess) && (!$csvProvider->isExists($base->getId(), CsvProvider::EXPORT))) {
            $exportProcess = $exportProcessMapper->toEntity(
                array(
                    'base_id' => $base->getId(),
                    'iteration' => 0,
                    'export_id' => 0,
                    'executed' => 1
                )
            );
            
        $exportProcessMapper->add($exportProcess);
        $exchangeService = $this->serviceFactory->createExchangeService();
        $exchangeService->processExport($exportProcess->getId(), 0);
        }
        # create report
        $reportService = $this->serviceFactory->createReportService();
        $reportService->sendReport(
            'new delivery ('.$send->getId().') has been created',
            array(
                'user id' => $this->userId,
                'base id' => $base->getId(),
                'base name' => $base->getName(),
                'message title' => $message->getTitle(),
                'message text' => $message->getText(),
                'start time' => $array['start_time']
            )
        );
    }

    public function edit($array)
    {
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $messageMapper = $this->mapperFactory->createMessageMapper();
        $sendService = $this->serviceFactory->createSendService();
        $send = $this->sendMapper->getById($array['id']);
        $oldBase = $send->getBaseId();
        $sendService->checkUser($send, $this->userId);
        $sendService->checkLockedToEdit($send);
        $base = $baseMapper->getById($array['base_id']);
        $message = $messageMapper->getById($array['message_id']);
        $send->setStartTime(new \DateTime($array["start_time"]));
        $send->setBaseId($base->getId());
        $send->setBaseName($base->getName());
        $send->setMessageId($message->getId());
        $send->setMessageTitle($message->getTitle());
        $send->setMessageText($message->getText());
        $this->sendMapper->edit($send);
        #export if base was changed
        if ($oldBase != $array['base_id']) {
            $oldBaseFree = $baseMapper->getById($oldBase);
            if (!$this->sendMapper->getSendListByBaseId($oldBase)) {
                $baseMapper->setBaseStatus($oldBaseFree, BaseMapper::BASE_READY);
            }
            $baseMapper->setBaseStatus($base, BaseMapper::BASE_SEND);
            $csvProvider = $this->serviceFactory->createCsvProvider();
            $exportProcessMapper = $this->mapperFactory->createExportProcessMapper();
            $existsExportProcess = $exportProcessMapper->getByBaseId($array['base_id']);
            if ((!$existsExportProcess) && (!$csvProvider->isExists($base->getId(), CsvProvider::EXPORT))) {
                $exportProcess = $exportProcessMapper->toEntity(
                    array(
                        'base_id' => $array['base_id'],
                        'iteration' => 0,
                        'export_id' => 0,
                        'executed' => 1
                    )
                );
                $exportProcessMapper->add($exportProcess);
                $exchangeService = $this->serviceFactory->createExchangeService();
                $exchangeService->processExport($exportProcess->getId(), 0);
            }
        }
        # write log
        $this->loggerService->log("Send with message '".$message->getTitle()."' and base ".$base->getName()." has been edited. New send time - ".$array["start_time"].".",$this->userId);
        # create report
        $reportService = $this->serviceFactory->createReportService();
        $reportService->sendReport(
            'new delivery ('.$send->getId().') has been edited',
            array(
                'user id' => $this->userId,
                'base id' => $base->getId(),
                'base name' => $base->getName(),
                'message title' => $message->getTitle(),
                'message text' => $message->getText(),
                'start time' => $array['start_time']
            )
        );
    }

    public function delete($id)
    {
        $send = $this->sendMapper->getById($id);
        $sendService = $this->serviceFactory->createSendService();
        $sendService->checkUser($send, $this->userId);
        $sendService->checkLockedToDelete($send);
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $base = $baseMapper->getById($send->getBaseId());
        $this->sendMapper->delete($id);
        # if base is not wait to send / prepare to send / send
        if (!$this->sendMapper->getSendListByBaseId($base->getId())) {
            $baseMapper->setBaseStatus($base, BaseMapper::BASE_READY);
        }
        $sendProcessMapper = $this->mapperFactory->createSendProcessMapper();
        $sendProcess = $sendProcessMapper->getBySendId($id);
        if ($sendProcess) {
            $sendProcessMapper->delete($sendProcess->getId());
        }
        $this->loggerService->log("Send with message '".$send->getMessageTitle()."' and base ".$send->getBaseName()." has been deleted.", $this->userId);
        # create report
        $reportService = $this->serviceFactory->createReportService();
        $reportService->sendReport(
            'new delivery ('.$send->getId().') has been deleted',
            array(
                'user id' => $this->userId,
            )
        );
    }

    public function getList($page)
    {
        $sendList = $this->sendMapper->getSendList($page, $this->userId);
        return $sendList;
    }

    public function getById($id)
    {
        $send = $this->sendMapper->getById($id);
        $sendArray = $this->sendMapper->toArray($send);
        $sendArray['start_time'] = $sendArray["start_time"]->format("Y-m-d H:i");
        return $sendArray;
    }

    public function checkDate($sendArray)
    {
        $start_date = new \DateTime($sendArray["start_time"]);
        $min_date = new \DateTime(date("Y-m-d H:i:s", time()+3600));
        if ($start_date < $min_date) {
                return $min_date;
        }
        return 0;
    }

    public function checkNumbers($sendArray)
    {
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        $count = $phoneMapper->getPhonesCountByBaseId($sendArray["base_id"]);
        return $count;
    }
}

