<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'sms-config' => array(
        'sms-report-email' => 'igoradm90@gmail.com',//can be array
        'sms-max-bases' => 50,
        'sms-max-messages' => 50,
        'sms-csv-path' => __DIR__."/../../module/Sms/data/",
        'sms-log-path' => __DIR__."/../../logs/",
        'sms-url' => array(
            'host' => 'host',
            'port' => 85 # default - 0
        ),
        'sms-strategy-config' => array(
            'login'    => 'mylogin',
            'password' => 'mypwd',
            'host'     => 'mysmsgateway'
        )
    )
);
