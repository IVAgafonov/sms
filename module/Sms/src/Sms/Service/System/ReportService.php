<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


class ReportService implements ReportServiceInterface
{
    private $email;
    
    public function __construct($config)
    {
        $this->email = $config['sms-report-email'];
    }
    /**
     * Send report to email
     *
     * @param  string $subject
     * @param  array $array
     * @return int
     */
    public function sendReport($subject, $array)
    {
        $report = "Sms report - \r\n";
        if (is_array($this->email)) {
            foreach($array as $key => $value) {
                    $report .= $key." - ".$value."\r\n";
            }
            foreach($this->email as $mail) {
                $headers = "From: Sms service <$mail>\r\n". 
                "MIME-Version: 1.0" . "\r\n" . 
                "Content-type: text/plain; charset=UTF-8" . "\r\n"; 
                mail($mail, $subject, $report, $headers);
            }
        } else {
            foreach($array as $key => $value) {
                    $report .= $key." - ".$value."\r\n";
                }
            $headers = "From: Sms service <".$this->email.">\r\n". 
               "MIME-Version: 1.0" . "\r\n" . 
               "Content-type: text/html; charset=UTF-8" . "\r\n"; 
            mail($this->email, $subject, $report);
        }
        return 0;
    }
}

