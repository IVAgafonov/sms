<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface CronFacadeInterface {
    /**
    * Lock ready delivery.
    * Deliveries will locked in 30 min before send.
    *
    */
    public function lockReadyDelivery();
    /**
    * Start send data to sms gateway in 10 min before sending.
    * Data contains exact time of delivery, and delivery will start in time.
    */
    public function startReadyDelivery();
    /**
    * Check exchange errors.
    * Start over stopped processes of exchange.
    */
    public function checkErrorExchange();
}