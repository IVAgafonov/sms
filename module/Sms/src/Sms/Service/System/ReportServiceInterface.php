<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


interface ReportServiceInterface
{
    /**
     * Send report to email
     *
     * @param  string $subject
     * @param  array $array
     * @return int
     */
    public function sendReport($subject, $array);
}