<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Strategy;


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
}