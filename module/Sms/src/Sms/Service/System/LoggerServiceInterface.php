<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


interface LoggerServiceInterface
{
    public function log($str, $userId);
}