<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Factory;


use Sms\Authentication\Adapter\MemcachedAdapter;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MemcachedAdapterFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $zcfUzerMapper = $serviceLocator->get('zfcuser_user_mapper');
        $memcachedAdapterOptions = $serviceLocator->get('zfcuser_module_options');
        $memcachedStorage = $serviceLocator->get('Sms\Authentication\Storage\MemcachedStorage');
        $memcachedAdapter = new MemcachedAdapter();
        $memcachedAdapter->setStorage($memcachedStorage);
        $memcachedAdapter->setOptions($memcachedAdapterOptions);
        $memcachedAdapter->setMapper($zcfUzerMapper);
        return $memcachedAdapter;
    }
}