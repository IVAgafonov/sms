<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Strategy;


interface SendStrategyInterface
{
    public function sendPart($message, $baseParams, $phones, $startTime, $userMapper, $userId);
}