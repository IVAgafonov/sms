<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory;


use Sms\Facade\AdminFacade;
use Sms\Factory\Form\FormFactory;
use Sms\Factory\Mapper\MapperFactory;
use Sms\Factory\Service\ServiceFactory;
use Sms\Controller\AdminController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $config = $serviceLocator->getServiceLocator()->get('config');
        
        $adminController = new AdminController(
            new AdminFacade(
                new MapperFactory($em),
                new ServiceFactory($config['sms-config'])
            ),
            new FormFactory($em, 0)
        );
        return $adminController;
    }
}

