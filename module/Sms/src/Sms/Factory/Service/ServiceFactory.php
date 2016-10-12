<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\Service;


use Sms\Service\System\CsvProvider;
use Sms\Service\System\LoggerService;
use Sms\Service\System\ReportService;
use Sms\Service\BaseService;
use Sms\Service\PhoneService;
use Sms\Service\MessageService;
use Sms\Service\ExchangeService;
use Sms\Service\SendService;

class ServiceFactory implements ServiceFactoryInterface
{
    private $config;
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    public function createCsvProvider()
    {
        return new CsvProvider($this->config);
    }
    public function createLoggerService()
    {
        return new LoggerService($this->config);
    }
    public function createReportService()
    {
        return new ReportService($this->config);
    }
    public function createBaseService()
    {
        return new BaseService($this->config);
    }
    public function createMessageService()
    {
        return new MessageService($this->config);
    }
    public function createPhoneService()
    {
        return new PhoneService();
    }
    public function createExchangeService()
    {
        return new ExchangeService($this->config);
    }
    public function createSendService()
    {
        return new SendService($this->config);
    }
}

