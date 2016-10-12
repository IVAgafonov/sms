<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\File;


use Sms\Mapper\File\CsvProvider;

class CsvProviderFactory implements CsvProviderFactoryInterface
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
}

