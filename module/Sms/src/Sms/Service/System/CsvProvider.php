<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


use Sms\Exception\SmsException;

class CsvProvider implements CsvProviderInterface
{
    #types
    const EXPORT = 1;
    const IMPORT = 2;

    private $dir;
    private $handle;
    private $fileName;

    public function __construct($config)
    {
        $this->dir = $config['sms-csv-path'];
    }
    
    public function open($baseId, $type)
    {
        if ($type == CsvProvider::EXPORT) {
            $this->fileName = $this->dir."export/".$baseId.".csv";
        } elseif ($type == CsvProvider::IMPORT) {
            $this->fileName = $this->dir."import/".$baseId.".csv";
        } else {
            throw SmsException("Invalid csv type");
        }
        if (($this->handle = fopen($this->fileName, "a+")) == false) {
            throw SmsException('Error IO operation');
        }
    }
    
    public function readRow()
    {
        return fgetcsv($this->handle, 1000, ";");
    }
    
    public function writeRow($array)
    {
        fputcsv($this->handle, $array, ";");
    }
    
    public function cursorPos($pos)
    {
        fseek($this->handle, $pos);
    }
    
    public function close()
    {
        fclose($this->handle);
    }
    
    public function create($baseId, $type)
    {
        $this->open($baseId, $type);
        $this->close();
    }
    
    public function delete($baseId, $type)
    {
        if ($type == CsvProvider::EXPORT) {
            $this->fileName = $this->dir."export/".$baseId.".csv";
        } elseif ($type == CsvProvider::IMPORT) {
            $this->fileName = $this->dir."import/".$baseId.".csv";
        } else {
            throw SmsException("Invalid type");
        }
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
    }
    
    public function isExists($baseId, $type)
    {
        if ($type == CsvProvider::EXPORT) {
            $this->fileName = $this->dir."export/".$baseId.".csv";
        } elseif ($type == CsvProvider::IMPORT) {
            $this->fileName = $this->dir."import/".$baseId.".csv";
        } else {
            throw SmsException("Invalid csv type");
        }
        if (file_exists($this->fileName)) {
            return $this->fileName;
        } else {
            return false;
        }
    }
}

