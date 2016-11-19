<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


use Sms\Service\System\Strategy\MemcachedPoolInterface;

class MemcachedProvider implements MemcachedProviderInterface
{
    protected $instance;
    
    public function __construct(MemcachedPoolInterface $pool)
    {
        $this->instance = new \Memcached($pool->getInstance());
        if (empty($this->instance->getServerList())) {
            $this->instance->setOption(\Memcached::OPT_RECV_TIMEOUT, 500);
            $this->instance->setOption(\Memcached::OPT_SEND_TIMEOUT, 500);
            $this->instance->setOption(\Memcached::OPT_TCP_NODELAY, true);
            $this->instance->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, 50);
            $this->instance->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 500);
            $this->instance->setOption(\Memcached::OPT_RETRY_TIMEOUT, 250);
            $this->instance->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
            $this->instance->setOption(\Memcached::OPT_REMOVE_FAILED_SERVERS, true);
            $this->instance->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
            $this->instance->addServers($pool->getPool());
        }
    }
    /**
     * Add new key
     *
     * @param  string $key
     * @param  mixed $contents
     * @param  int $time
     * @return bool
     */
    public function add($key, $contents, $time)
    {
        return $this->instance->add($key, $contents, $time);
    }
    /**
     * Set key
     *
     * @param  string $key
     * @param  mixed $contents
     * @param  int $time
     * @return bool
     */
    public function set($key, $contents, $time)
    {
        return $this->instance->set($key, $contents, $time);
    }
    /**
     * Get value by key
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->instance->get($key);
    }
    /**
     * Get value and key
     *
     * @param  string $key
     * @return bool
     */
    public function delete($key)
    {
        return $this->instance->delete($key);
    }
    /**
     * Set new expiried time
     *
     * @param  string $key
     * @param  int $time
     * @return bool
     */
    public function touch($key, $time)
    {
        return $this->instance->touch($key, $time);
    }
}