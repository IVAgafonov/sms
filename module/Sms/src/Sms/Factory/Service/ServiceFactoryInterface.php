<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\Service;


interface ServiceFactoryInterface
{
    public function createCsvProvider();
    
    public function createLoggerService();
    
    public function createReportService();
    
    public function createBaseService();
    
    public function createMessageService();
    
    public function createPhoneService();
    
    public function createExchangeService();
    
    public function createSendService();
    
}

