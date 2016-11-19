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
use Sms\Authentication\Session\SessionEmulator;
use Sms\Service\System\Strategy\ConfigMemcachedPoolStrategy;
use Sms\Service\System\MemcachedProvider;

class Module
{
    private $sm;
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $this->sm = $e->getApplication()->getServiceManager();
        # emulate session
        $config = $this->sm->get('Config');
        # get response for sessionEmulator
        $response = $this->sm->get('Response');
        $sessionEmulator = new SessionEmulator($response);
        # get memcached pool and name of instance
        $pool = new ConfigMemcachedPoolStrategy($config, '_');
        # create memcached provider
        $memcachedProvider = new MemcachedProvider($pool);
        # create new session id if not exists
        $sessionId = $sessionEmulator->getSessionId();
        if (!$sessionId) {
            do {
                $sessionId = $sessionEmulator->getNewSessionId();
            } while ($memcachedProvider->get($sessionId));
            $sessionEmulator->setSessionId($sessionId);
        }
        /*
        $response = $this->sm->get('Response');
        $sessionEmulator = new SessionEmulator($response);

        $sessionId = $sessionEmulator->getSessionId();
        if (!$sessionId) {
            $sessionId = $sessionEmulator->getNewSessionId();
            $sessionEmulator->setSessionId($sessionId);
        }
         * 
         */
        # set memcached storage as storage of auth service
        $memcachedStorage = $this->sm->get('Sms\Authentication\Storage\MemcachedStorage');
        $this->sm->get('zfcuser_auth_service')->setStorage($memcachedStorage);
        
        //$em->attach(new SessionInitListener());
        $em->attach(new DefaultRoleListener());
        $userLogginListener = new UserLoginListener();
        //$config = $this->sm->get('Config');
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

