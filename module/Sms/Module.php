<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms;


use Zend\EventManager\EventInterface;
use Sms\Listener\DefaultRoleListener;
use Sms\Listener\UserLoginListener;
use Sms\Listener\LanguageListener;
use Sms\Factory\Service\ServiceFactory;

class Module
{
    private $sm;
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $this->sm = $e->getApplication()->getServiceManager();
        
        //
        //$this->sm->get('Sms\Authentication\AdapterMemcached')->setServiceManager($this->sm);
        $this->sm->get('zfcuser_auth_service')->setStorage(
            $this->sm->get('Sms\Authentication\Storage\MemcachedStorage')
        );
        //$this->sm->get('zfcuser_auth_service')->getStorage()->setServiceManager($this->sm);
        //$this->sm->get('ZfcUser\Authentication\Storage\Db')->setStorage(
        //    new \Sms\Authentication\Storage\MemcachedStorage()
        //);
        //
        $em->attach(new DefaultRoleListener());
        $userLogginListener = new UserLoginListener();
        $config = $this->sm->get('Config');
        $userLogginListener->setServiceFactory(new ServiceFactory($config['sms-config']));
        $em->attach($userLogginListener);
        $em->attach(new LanguageListener());
    }

    public function init(\Zend\ModuleManager\ModuleManager $mm)
    {
        $sharedEvents = $mm->getEventManager()->getSharedManager();
        $sharedEvents->attach('Sms\Controller\AdminController',
            'dispatch',
            function ($e) {
                $controller = $e->getTarget();
                $controller->layout('sms/layout/admin');
                $user = $this->sm->get('zfcuser_auth_service')->getIdentity();
                $controller->layout()->user = $user;
            },
            100
        );
        $sharedEvents->attach(
            array(
                'Sms\Controller\BaseController',
                'Sms\Controller\MsgController',
                'Sms\Controller\PhoneController',
                'Sms\Controller\SendController',
                'Sms\Controller\ImportController'
            ),
            'dispatch',
            function ($e) {
                $controller = $e->getTarget();
                $controller->layout('sms/layout/user');
                $user = $this->sm->get('zfcuser_auth_service')->getIdentity();
                $controller->layout()->user = $user;
            },
            100
        );
        $sharedEvents->attach(
            'ZfcUser\Controller\UserController',
            'dispatch',
            function ($e) {
                $controller = $e->getTarget();
                $controller->layout('sms/layout/guest');
            },
            100
        );
    }

    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                )
            )
        );
    }
}

