<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System\Strategy;


class ConfigMemcachedPoolStrategy implements MemcachedPoolInterface
{
    # Pool addresses of memcached servers
    protected $pool;
    # Instance name of memcached servers
    protected $instance;
    
    public function __construct($config, $poolName)
    {
        $this->pool = $config['memcached-instances'][$poolName];
        $this->instance = $poolName;
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
    /**
    * Get servers pool from storage.
    *
    * @param void
    *
    * @return array
    */
    public function getInstance()
    {
        return $this->instance;
    }
}