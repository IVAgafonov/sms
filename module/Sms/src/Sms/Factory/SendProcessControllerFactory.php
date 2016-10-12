<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory;


use Sms\Strategy\SendStrategy;
use Sms\Strategy\DebugSendStrategy;
use Sms\Facade\SendProcessFacade;
use Sms\Factory\Mapper\MapperFactory;
use Sms\Factory\Service\ServiceFactory;
use Sms\Controller\SendProcessController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SendProcessControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $config = $serviceLocator->getServiceLocator()->get('config');
        
        $sendProcessController = new SendProcessController(
            new SendProcessFacade(
                new MapperFactory($em),
                new ServiceFactory($config['sms-config']),
                //new SendStrategy($config['sms-config'])
                new SendStrategy($config['sms-config'])
            )
        );
        return $sendProcessController;
    }
}

