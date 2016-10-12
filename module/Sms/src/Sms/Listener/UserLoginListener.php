<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Listener;


use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;

class UserLoginListener extends AbstractListenerAggregate
{
    protected $serviceFactory;
    
    public function setServiceFactory($serviceFactory) {
        $this->serviceFactory = $serviceFactory;
    }
    
    public function getServiceFactory() {
        return $this->serviceFactory;
    }
    
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();
        
        $this->listeners[] = $sharedManager->attach(
            'ZfcUser\Authentication\Adapter\AdapterChain',
            'authenticate.fail',
            array($this, 'onLoginError')
        );
        
        $this->listeners[] = $sharedManager->attach(
            'ZfcUser\Authentication\Adapter\AdapterChain',
            'authenticate.success',
            array($this, 'onLoginSuccess')
        );
    }

    public function onLoginSuccess(Event $e)
    {
        $loggerService = $this->serviceFactory->createLoggerService();
        $user = $e->getIdentity();
        $loggerService->log("User successfully logged from ip ".$_SERVER['REMOTE_ADDR']);
        $loggerService->log("User successfully logged from ip ".$_SERVER['REMOTE_ADDR'], $user);
    }

    public function onLoginError(Event $e)
    {
        $loggerService = $this->serviceFactory->createLoggerService();
        $loggerService->log("Error logging to account '".$_POST['identity']."' from ip ".$_SERVER['REMOTE_ADDR']);
    }
}

