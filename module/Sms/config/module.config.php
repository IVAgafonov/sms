<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'zfcuser',
                        'action' => 'login',
                    )
                )
            ),
            'sms-admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/admin[/:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'user'   => '[0-9]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Admin',
                        'action' => 'index',
                    )
                )
            ),
            'sms-base' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/base[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Base',
                        'action' => 'index',
                    )
                )
            ),
            'sms-msg' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/messages[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Msg',
                        'action' => 'index',
                    )
                )
            ),
            'sms-phone' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/phones[/:action][/:id][/:page][/:filter]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'filter' => '[a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Phone',
                        'action' => 'index',
                    )
                )
            ),
            'sms-send' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/send[/:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page'   => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Send',
                        'action' => 'index',
                    )
                )
            ),
            'sms-import' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/import[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),                    
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Import',
                        'action' => 'index',
                    )
                )
            ),
            'sms-import-process' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/importprocess[/:action]',
                    'defaults' => array(
                        'controller' => 'Sms\Controller\ImportProcess',
                        'action' => 'index',
                    )
                )
            ),
            'sms-export-process' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/exportprocess[/:action]',
                    'defaults' => array(
                        'controller' => 'Sms\Controller\ExportProcess',
                        'action' => 'index',
                    )
                )
            ),
            'sms-send-process' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/sendprocess[/:action]',
                    'defaults' => array(
                        'controller' => 'Sms\Controller\SendProcess',
                        'action' => 'index',
                    )
                )
            ),
            'sms-cron-process' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/service/cron[/:action]',
                    'defaults' => array(
                        'controller' => 'Sms\Controller\Cron',
                        'action' => 'index',
                    )
                )
            ),
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'Sms\Authentication\AdapterMemcached' => 'Sms\Authentication\Adapter\Memcached'
        ),
        'factories' => array(
            'Sms\Authentication\Storage\MemcachedStorage' => 'Sms\Authentication\Factory\MemcachedStorageFactory',
            'Sms\Authentication\Adapter\MemcachedAdapter' => 'Sms\Authentication\Factory\MemcachedAdapterFactory'
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
            'Sms\Controller\Send' => 'Sms\Factory\SendControllerFactory',
            'Sms\Controller\Base' => 'Sms\Factory\BaseControllerFactory',
            'Sms\Controller\Msg' => 'Sms\Factory\MsgControllerFactory',
            'Sms\Controller\Phone' => 'Sms\Factory\PhoneControllerFactory',
            'Sms\Controller\Import' => 'Sms\Factory\ImportControllerFactory',
            'Sms\Controller\ImportProcess' => 'Sms\Factory\ImportProcessControllerFactory',
            'Sms\Controller\ExportProcess' => 'Sms\Factory\ExportProcessControllerFactory',
            'Sms\Controller\SendProcess' => 'Sms\Factory\SendProcessControllerFactory',
            'Sms\Controller\Cron' => 'Sms\Factory\CronControllerFactory',
            'Sms\Controller\Admin' => 'Sms\Factory\AdminControllerFactory',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'         => __DIR__.'/../view/sms/layout/layout.phtml',
            'sms/layout/admin'      => __DIR__.'/../view/sms/layout/admin.phtml',
            'sms/layout/guest'      => __DIR__.'/../view/sms/layout/guest.phtml',
            'sms/layout/user'       => __DIR__.'/../view/sms/layout/user.phtml',
            'sms/layout/clear'       => __DIR__.'/../view/sms/layout/clear.phtml',
            'error/404'             => __DIR__ .'/../view/error/404.phtml',
            'error/index'           => __DIR__ .'/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__.'/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'view_helpers' => array(
        'invokables'=> array(
            'PaginationHelper' => 'Sms\Helper\PaginationHelper',
            'PaginationPhoneFilteredHelper' => 'Sms\Helper\PaginationPhoneFilteredHelper',
            'PaginationUserFilteredHelper' => 'Sms\Helper\PaginationUserFilteredHelper'
        )
    ),
    'navigation' => array(
         'default' => array(
            array(
                'label' => _('Sms delivery'),
                'route' => 'sms-send',
            ),
            array(
                'label' => _('Messages'),
                'route' => 'sms-msg',
            ),
            array(
                'label' => _('Bases'),
                'route' => 'sms-base',
                'pages' => array (
                    array (
                        'label' => _('base add'),
                        'route' =>'sms-base',
                        'action' => 'add',
                    ),
                    array (
                        'label' => _('base edit'),
                        'route' =>'sms-base',
                        'action' => 'edit',
                    ),
                    array (
                        'label' => _('phone list'),
                        'route' =>'sms-phone',
                        'action' => 'base',
                    ),
                    array (
                        'label' => _('phone add'),
                        'route' =>'sms-phone',
                        'action' => 'add',
                    ),
                    array (
                        'label' => _('phone edit'),
                        'route' =>'sms-phone',
                        'action' => 'edit',
                    ),
                ),
            ),
            array(
                'label' => _('Import'),
                'route' => 'sms-import',
            ),
        ),
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'sms-languages' => array(
        array('ru_RU',_('Russian')),
        array('en_US',_('English')),
    )
);

