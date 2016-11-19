<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System\Strategy;


interface MemcachedPoolInterface
{
    /**
    * Get servers pool from storage.
    *
    * @param void
    *
    * @return array
    */
    public function getPool();
    /**
    * Get servers pool name.
    *
    * @param void
    *
    * @return array
    */
    public function getInstance();
}