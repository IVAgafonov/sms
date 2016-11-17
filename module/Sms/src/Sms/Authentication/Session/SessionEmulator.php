<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Session;


use Zend\Http\Header\SetCookie;

class SessionEmulator implements SessionEmulatorInterface
{
    const SESSION_ID_LENGTH = 60;
    
    protected $response;
    
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getNewSessionId()
    {
        $sessionId = "";
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        for($i = 0; $i < static::SESSION_ID_LENGTH; $i++) {
            $sessionId .= $characters[rand(0, $charactersLength - 1)];
        }
        return $sessionId;
    }

    public function setSessionId($sessionId)
    {
        $cookie = new SetCookie('emsessionid', $sessionId, time() + 300, '/');
        $this->response->getHeaders()->addHeader($cookie);
    }
    
    public function getSessionId()
    {
        if (isset($_COOKIE['emsessionid'])) {
            return htmlspecialchars($_COOKIE['emsessionid']);
        }
        return false;
    }
    
    public function deleteSessionId($sessionId)
    {
        $cookie = new SetCookie('emsessionid', $sessionId, 0, '/');
        $this->response->getHeaders()->addHeader($cookie);
    }
}