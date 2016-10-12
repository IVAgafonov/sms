<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Strategy;

use BjyAuthorize\View\RedirectionStrategy;
use Zend\EventManager\EventManagerInterface;

class ZFURedirectionStrategy extends RedirectionStrategy
{
    public function __construct()
    {
        $this->setRedirectRoute('home');
    }
}

