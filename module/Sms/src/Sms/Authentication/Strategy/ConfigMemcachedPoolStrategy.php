<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Strategy;


class ConfigMemcachedPoolStrategy implements MemcachedPoolInterface
{
    # Pool addresses of memcached servers
    protected $pool;

    public function __construct($pool)
    {
        $this->pool = $pool;
    }
    /**
    * Get servers pool from storage.
    *
    * @param void
    *
    * @return array
    */
    public function getPool()
    {
        return $this->pool;
    }
}