<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory;


use Sms\Facade\CronFacade;
use Sms\Factory\Mapper\MapperFactory;
use Sms\Factory\Service\ServiceFactory;
use Sms\Controller\CronController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CronControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $config = $serviceLocator->getServiceLocator()->get('config');
        
        $cronController = new CronController(
            new CronFacade(
                new MapperFactory($em),
                new ServiceFactory($config['sms-config'])
            )
        );
        return $cronController;
    }
}

