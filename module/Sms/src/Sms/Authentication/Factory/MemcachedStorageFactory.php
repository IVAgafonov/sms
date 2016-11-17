<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Factory;


use Sms\Authentication\Storage\MemcachedStorage;
use Sms\Authentication\Session\SessionEmulator;
use Sms\Authentication\Strategy\ConfigMemcachedPoolStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MemcachedStorageFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        # get response for sessionEmulator
        $response = $serviceLocator->get('Response');
        $zcfUzerMapper = $serviceLocator->get('zfcuser_user_mapper');
        $sessionEmulator = new SessionEmulator($response);
        $pool = new ConfigMemcachedPoolStrategy($config['sms-config']['auth-strategy-config']['pool']);
        $memcachedStorage = new MemcachedStorage($pool, $sessionEmulator, $zcfUzerMapper);
        return $memcachedStorage;
    }
}