<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


interface ReportServiceInterface
{
    public function sendReport($subject, $array);
}