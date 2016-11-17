<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Strategy;


class SendStrategy implements SendStrategyInterface
{
    private $config;
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function sendPart($message, $baseParams, $phones, $startTime, $userMapper, $userId)
    {
        
        $smsCount = 0;
        $userNaming = $userMapper->getById($userId);
        $sendXmlRequest = '<?xml version="1.0" encoding="utf-8" ?>
            <package login="'.$this->config['send-strategy-config']['login'].'" password="'.$this->config['send-strategy-config']['password'].'">
                <message>
                    <default sender="'.$userNaming->getNaming().'"/>';
        foreach ($phones as $phone) {
            $readyMessage = $message;
            for($i = 1; $i <= 4; $i++) {
                if ($baseParams[1] != '') {
                    $getParamX = "getValue".$i;
                    $readyMessage = str_replace("%".$baseParams[$i]."%", $phone->$getParamX(), $readyMessage);
                }
            }
            # message was prepared
            $number = $phone->getNumber();
            $number[0] = 7;
            $sendXmlRequest .= '<msg date_beg="'.$startTime->format("c").'" recipient="'.$number.'">'.$readyMessage.'</msg>';
            $smsCount += $this->getSmsCountByLenght(strlen($readyMessage));
        }
        $sendXmlRequest .= "</message>
                     </package>";
        $user = $userMapper->getById($userId);
        $sendCost = $user->getSendCost() * $smsCount;
        # if user have enough funds
        if ($sendCost < $user->getBalance()) {
            # set new balance
            $user->setBalance($user->getBalance() - $sendCost);
            $userMapper->edit($user);
            # if user can send sms
            if ($user->getSendFlag()) {
                #send part
                if ($this->sendRequest($sendXmlRequest)) {
                    return $smsCount;
                } else {
                    return 0;
                }
            } else {
                return $smsCount;
            }
        }
        return 0;
    }
    
    private function getSmsCountByLenght($lenght)
    {
        if ($lenght == 0) {
            return 0;
        } elseif($lenght <= 70 ) {
            return 1;
        } elseif($lenght <= 134) {
            return 2;
        } elseif ($lenght <= 201 ) {
            return 3;
        } elseif ($lenght <= 255 ) {
            return 4;
        } else {
            return 0;
        }
    }
    
    private function checkBalance($balanse, $cost)
    {
        if ($balanse > $cost) {
            return true;
        } else {
            return false;
        }
    }
    
    private function sendRequest($xmlRequest)
    {
        //echo $xmlRequest;
        $curl_options = array(
            CURLOPT_URL => $this->config['send-strategy-config']['host'],
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_HEADER => array(
                'Host: '.$this->config['send-strategy-config']['host'], 
                'Content-Type: text/xml; charset=utf-8', 
                'Content-Length: '.strlen($xmlRequest)
            ),
            CURLOPT_POSTFIELDS => ($xmlRequest)
        );
        $curl = curl_init() or die("cURL init error");
        curl_setopt_array($curl, $curl_options);
        $response = curl_exec($curl);
        //print_r($response);
        curl_close($curl);
        if ($response == 100) {
            return 1;
        } else {
            return 0;
        }
    }
}