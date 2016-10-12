<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

return array('doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__.'/../../module/Sms/src/Sms/Entity/'),
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Sms' => 'zfcuser_entity',
                ),
            ),
            'orm_host0' => array(
                'drivers' => array(
                    'Sms' => 'zfcuser_entity',
                ),
            ),
            'orm_host1' => array(
                'drivers' => array(
                    'Sms' => 'zfcuser_entity',
                ),
            ),
            'orm_host2' => array(
                'drivers' => array(
                    'Sms' => 'zfcuser_entity',
                ),
            ),
        ),
        'connection' => array(
            # test connection
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'charset' => 'utf8',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    ), 
                )
            ),
            # shardings connections
            'orm_host0' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'charset' => 'utf8',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    ), 
                )
            ),
            'orm_host1' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'charset' => 'utf8',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    ),
                )
            ),
            'orm_host2' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'charset' => 'utf8',
                    'driverOptions' => array(
                        1002 => 'SET NAMES utf8'
                    ),
                )
            )
        )
    ),
);

