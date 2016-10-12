<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


class LoggerService implements LoggerServiceInterface
{
    private $path;
    public function __construct($config)
    {
        $this->path = $config['sms-log-path'];
    }
    public function log($str, $userId = 0)
    {
        $date = date("Y-n-j");
        $time = date("H.i.s");
        if ($userId) {
            # user log
            $fileName = $this->path.$userId."_".$date."_work.log";
        } else {
            # shared log
            $fileName = $this->path.$date."_work.log";
        }
        $str = "[$date $time] ".$str."\r\n";
        file_put_contents($fileName, $str, FILE_APPEND);
    }
}