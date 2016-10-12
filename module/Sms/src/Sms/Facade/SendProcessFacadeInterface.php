<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface SendProcessFacadeInterface
{
    public function process($sendProcessId, $iteration);
}