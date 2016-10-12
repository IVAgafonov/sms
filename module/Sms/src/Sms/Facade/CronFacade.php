<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


use Sms\Mapper\SendMapper;
use Sms\Service\System\CsvProvider;
use Sms\Factory\Mapper\MapperFactoryInterface;
use Sms\Factory\Service\ServiceFactoryInterface;

class CronFacade implements CronFacadeInterface
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
    * Lock ready delivery.
    * Deliveries will locked in 30 min before send.
    *
    */
    public function lockReadyDelivery() {
        $check_date = date("Y-m-d H:i:s", time()+1800);
        $sendMapper = $this->mapperFactory->createSendMapper();
        $sendMapper->lockReadySend($check_date);
    }
    /**
    * Start send data to sms gateway in 10 min before sending.
    * Data contains exact time of delivery, and delivery will start in time.
    */
    public function startReadyDelivery() {
        $check_date = date("Y-m-d H:i:s", time()+600);
        $sendMapper = $this->mapperFactory->createSendMapper();
        $sendProcessMapper = $this->mapperFactory->createSendProcessMapper();
        # Get deliveries, which ready to send
        $sendList = $sendMapper->getReadySendList($check_date);
        $exchangeService = $this->serviceFactory->createExchangeService();
        if ($sendList) {
            foreach ($sendList as $send) {
                $sendProcess = $sendProcessMapper->getBySendId($send->getId());
                # lock delivery to send
                $send->setStatus(SendMapper::SEND_SEND);
                $sendMapper->edit($send);
                $sendProcess->setExecuted(1);
                $sendProcessMapper->edit($sendProcess);
                # start send process
                $exchangeService->processSend($sendProcess->getId(), $sendProcess->getIteration());
            }
        }
        # check errors in send process list
        # get send errors
        $sendProcessErrorList = $sendProcessMapper->getSendErrors();
        if ($sendProcessErrorList) {
            # resume sending stopped deliveries
            foreach ($sendProcessErrorList as $sendError) {
                $send = $sendMapper->getById($sendError->getSendId());
                $send->setStatus(SendMapper::SEND_ERROR);
                $sendMapper->edit($send);
            }
        }
    }
    /**
    * Check exchange errors.
    * Start over stopped processes of exchange.
    */
    public function checkErrorExchange() {
        $exportProcessMapper = $this->mapperFactory->createExportProcessMapper();
        $importProcessMapper = $this->mapperFactory->createImportProcessMapper();
        $exportErrors = $exportProcessMapper->getExportErrors();
        $importErrors = $importProcessMapper->getImportErrors();
        $csvProvider = $this->serviceFactory->createCsvProvider();
        $baseMapper = $this->mapperFactory->createBaseMapper();
        $phoneMapper = $this->mapperFactory->createPhoneMapper();
        $exchangeService = $this->serviceFactory->createExchangeService();
        if ($exportErrors) {
            foreach($exportErrors as $exportError) {
                $base = $baseMapper->getById($exportError->getBaseId());
                # delete file
                if ($csvProvider->isExists($base->getId(), CsvProvider::EXPORT)) {
                    $csvProvider->delete($base->getId(), CsvProvider::EXPORT);
                }
                # prepare file
                $csvProvider->open($base->getId(), CsvProvider::EXPORT);
                $csvProvider->writeRow($baseMapper->getBaseParams($base));
                $csvProvider->close();
                # export start over
                $exportError->setIteration(0);
                $exportProcessMapper->edit($exportError);
                $exchangeService->processExport($exportError->getId(), 0);
            }
        }
        if ($importErrors) {
            foreach($importErrors as $importError) {
                # preapare base to import
                $base = $baseMapper->getById($importError->getBaseId());
                $csvProvider->open($base->getId(), CsvProvider::IMPORT);
                $csvProvider->cursorPos(0);
                $params = $csvProvider->readRow();
                # if first row is not valud number - get params from this row
                if (!$exchangeService->importConvert($params)) {
                    $baseMapper->setBaseParams($base, $params);
                }
                #delete numbers
                $phoneMapper->deleteAllByBaseId($base->getId());
                #import start over
                $importError->setIteration(0);
                $importProcessMapper->edit($importError);
                $exchangeService->processImport($importError->getId(), 0);
            }
        }
    }
}

