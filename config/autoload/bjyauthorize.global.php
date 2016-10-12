<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

return array(
    'bjyauthorize' => array(
        'unauthorized_strategy' => 'Sms\Strategy\ZFURedirectionStrategy',
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers' => array (
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'Sms\Entity\Role',
             ),
        ),
        'guards' => array(
            \BjyAuthorize\Guard\Controller::class => array(
                array('controller' => array('Sms\Controller\Admin'),
                      'roles' => array('admin')
                ),
                # users controllers
                array(
                    'controller' => array(
                        'Sms\Controller\Base',
                        'Sms\Controller\Send',
                        'Sms\Controller\Msg',
                        'Sms\Controller\Phone',
                        'Sms\Controller\Import'
                    ),
                    'roles' => array('user')
                ),
                array('controller' => array('zfcuser'), 
                    'action' => array('login', 'index', 'register'),
                    'roles' => array('guest', 'user')
                ),
                array('controller' => array('zfcuser'),
                    'action' => array('logout'),
                    'roles' => array('user')
                ),
                # process controllers
                array('controller' => array(
                    'Sms\Controller\ImportProcess',
                    'Sms\Controller\ExportProcess',
                    'Sms\Controller\SendProcess',
                    'Sms\Controller\Cron'
                    ),
                    'action' => array('index'),
                    'roles' => array('guest', 'user', 'admin')
                ),
            )
        ),
    ),
    'service_manager' => array(
        'invokables' => array (
            'Sms\Strategy\ZFURedirectionStrategy' => 'Sms\Strategy\ZFURedirectionStrategy'
        ),
    ),
);