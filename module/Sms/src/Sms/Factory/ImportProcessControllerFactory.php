<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory;


use Sms\Facade\ImportProcessFacade;
use Sms\Factory\Mapper\MapperFactory;
use Sms\Factory\Service\ServiceFactory;
use Sms\Controller\ImportProcessController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImportProcessControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $config = $serviceLocator->getServiceLocator()->get('config');

        $importProcessController = new ImportProcessController(
            new ImportProcessFacade(
                new MapperFactory($em),
                new ServiceFactory($config['sms-config'])
            )
        );
        return $importProcessController;
    }
}

