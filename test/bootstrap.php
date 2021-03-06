<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

use Zend\Loader\StandardAutoloader;

chdir(dirname(__DIR__));

include 'init_autoloader.php';

$loader = new StandardAutoloader();
$loader->registerNamespace('SmsTest', __DIR__ . '/SmsTest');
$loader->register();

Zend\Mvc\Application::init(include 'config/application.config.php');