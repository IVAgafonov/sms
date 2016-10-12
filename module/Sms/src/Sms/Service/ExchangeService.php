<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Zend\Http\Response\Stream;
use Zend\Http\Headers;
use Sms\Exception\SmsException;

class ExchangeService implements ExchangeServiceInterface
{
    protected $config;
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function getHost()
    {
        $host = $this->config['sms-url']['host'];
        if ($this->config['sms-url']['port'] != 0) {
            $host .= ':'.$this->config['sms-url']['port'];
        }
        return $host;
    }
    
    public function prepareFileToImport($tmpFile, $baseId)
    {
        $importFile = $this->config['sms-csv-path']."import/".$baseId.".csv";
        if (!copy($tmpFile, $importFile)) {
            throw new SmsException(_('Error of upload file'));
        }
    }
    
    public function checkBaseValues($importArray)
    {
        if ($importArray['base_select'] == '') {
            if ($importArray['base_name'] == '') {
                throw new SmsException(_('Base name is not valid'));
            }
        }
        return 0;
    }
    
    public function downloadFile($fullName, $fileName)
    {
        $response = new Stream();
        $response->setStream(fopen($fullName, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($fullName));
        $response->setContentLength(filesize($fullName));
        $headers = new Headers();
        $headers->addHeaderLine('Content-Type', 'application/octet-stream')
            ->addHeaderLine('Content-Disposition', 'attachment; filename="'.$fileName.'.csv"')
            ->addHeaderLine('Content-Transfer-Encoding', 'binary')
            ->addHeaderLine('Content-Length', filesize($fullName))
            ->addHeaderLine('Cache-Control', 'must-revalidate')
            ->addHeaderLine('Pragma', 'public');
        $response->setHeaders($headers);
        return $response;
    }
    
    public function importConvert($array)
    {
        $phone['number'] = preg_replace('~[^0-9]+~', '', $array[0]); //remove everything except the numbers
        if ((is_numeric($phone['number'])) && 
            (strlen($phone['number']) >= 10) && 
            (strlen($phone['number']) <= 11)
            ) {
            if (strlen($phone['number']) == 10) {
                $phone['number'] = '7'.$phone['number'];
            }
            $phone['value1'] = $array[1];
            $phone['value2'] = $array[2];
            $phone['value3'] = $array[3];
            $phone['value4'] = $array[4];
            return $phone;
        } else {
            return 0;
        }
    }
    
    public function exportConvert($array)
    {
        $exportArray[] = $array['number'];
        $exportArray[] = $array['value1'];
        $exportArray[] = $array['value2'];
        $exportArray[] = $array['value3'];
        $exportArray[] = $array['value4'];
        return $exportArray;
    }
    
    public function processSend($sendProcessId, $iteration) {
        exec("wget -q -O - 'http://".$this->getHost()."/service/sendprocess?id=".$sendProcessId."&iteration=".$iteration."' > /dev/null &", $array);
    }
    
    public function processImport($importProcessId, $iteration) {
        exec("wget -q -O - 'http://".$this->getHost()."/service/importprocess?id=".$importProcessId."&iteration=".$iteration."' > /dev/null &", $array);
    }
    
    public function processExport($exportProcessId, $iteration) {
        exec("wget -q -O - 'http://".$this->getHost()."/service/exportprocess?id=".$exportProcessId."&iteration=".$iteration."' > /dev/null &", $array);
    }
}

