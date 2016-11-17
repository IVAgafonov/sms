<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Session;


interface SessionEmulatorInterface {
    public function getNewSessionId();
}