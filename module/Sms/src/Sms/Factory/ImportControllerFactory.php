<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory;


use Sms\Facade\ImportFacade;
use Sms\Factory\Form\FormFactory;
use Sms\Factory\Mapper\MapperFactory;
use Sms\Factory\Service\ServiceFactory;
use Sms\Controller\ImportController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ImportControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $em = $serviceLocator->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $user = $serviceLocator->getServiceLocator()->get('zfcuser_auth_service')->getIdentity();
        $config = $serviceLocator->getServiceLocator()->get('config');

        $importController = new ImportController(
            $user,
            new ImportFacade(
                $user->getId(),
                new MapperFactory($em),
                new ServiceFactory($config['sms-config'])
            ),
            new FormFactory($em, $user->getId())
        );
        return $importController;
    }
}

