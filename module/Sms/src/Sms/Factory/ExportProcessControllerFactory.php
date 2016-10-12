<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory;


use Sms\Facade\ExportProcessFacade;
use Sms\Factory\Mapper\MapperFactory;
use Sms\Factory\Service\ServiceFactory;
use Sms\Controller\ExportProcessController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ExportProcessControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $config = $serviceLocator->getServiceLocator()->get('config');
        
        $exportProcessController = new ExportProcessController(
            new ExportProcessFacade(
                new MapperFactory($em),
                new ServiceFactory($config['sms-config'])
            )
        );
        return $exportProcessController;
    }
}

