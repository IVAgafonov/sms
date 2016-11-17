<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Strategy;


class DebugSendStrategy implements SendStrategyInterface
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
                if ($this->sendRequest($sendXmlRequest, $userId, $startTime)) {
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

    private function sendRequest($xmlRequest, $userId, $startTime)
    {
        $fname = '/var/www/test5/sms/debug/'.$userId.$startTime->format('Y-m-d H-i-s').'.log';
        file_put_contents($fname, $xmlRequest, FILE_APPEND);
        return 1;
    }
}