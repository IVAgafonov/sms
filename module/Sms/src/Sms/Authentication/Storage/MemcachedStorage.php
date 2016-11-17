<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Storage;


use Zend\Authentication\Storage\StorageInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Mapper\UserInterface as UserMapper;


class MemcachedStorage implements StorageInterface {

    protected $memcached;
    protected $sessionEmulator;
    protected $resolvedIdentity;
    protected $zfcUserMapper;
    
    public function __construct($pool, $sessionEmulator, $zcfUzerMapper)
    {
        $this->sessionEmulator = $sessionEmulator;
        $this->zfcUserMapper = $zcfUzerMapper;
        $this->memcached = new \Memcached('_');
        if (empty($this->memcached->getServerList())) {
            $this->memcached->setOption(\Memcached::OPT_RECV_TIMEOUT, 500);
            $this->memcached->setOption(\Memcached::OPT_SEND_TIMEOUT, 500);
            $this->memcached->setOption(\Memcached::OPT_TCP_NODELAY, true);
            $this->memcached->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, 50);
            $this->memcached->setOption(\Memcached::OPT_CONNECT_TIMEOUT, 500);
            $this->memcached->setOption(\Memcached::OPT_RETRY_TIMEOUT, 250);
            $this->memcached->setOption(\Memcached::OPT_DISTRIBUTION, \Memcached::DISTRIBUTION_CONSISTENT);
            $this->memcached->setOption(\Memcached::OPT_REMOVE_FAILED_SERVERS, true);
            $this->memcached->setOption(\Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
            $this->memcached->addServers($pool->getPool());
        }
        //$this->memcached->addServer("192.168.74.22", "11211");
    }
    /**
     * Check is session is Empty
     *
     * @param void
     * 
     * @return bool
     */
    public function isEmpty()
    {
        $sessionId = $this->sessionEmulator->getSessionId();
        if ($sessionId) {
            return $this->memcached->get($sessionId) ? false : true;
        }
        return true;
    }
    /**
     * Write session data
     *
     * @param mixed $contents
     * 
     * @return void
     */
    public function write($contents)
    {
        $newSessionId = "";
        do {
            $newSessionId = $this->sessionEmulator->getNewSessionId();
        } while ($this->memcached->get($newSessionId));
        $this->sessionEmulator->setSessionId($newSessionId);
        $this->memcached->set($newSessionId, $contents,  300);
    }
    /**
     * Read session data
     *
     * @param void
     * 
     * @return mixed
     */
    public function read()
    {
        if (null !== $this->resolvedIdentity) {
            return $this->resolvedIdentity;
        }
        $sessionId = $this->sessionEmulator->getSessionId();
        $identity = $this->memcached->get($sessionId);
        $this->sessionEmulator->setSessionId($sessionId);
        $this->memcached->touch($sessionId, 300);

        if (is_int($identity) || is_scalar($identity)) {
            $identity = $this->zfcUserMapper->findById($identity);
        }

        if ($identity) {
            $this->resolvedIdentity = $identity;
        } else {
            $this->resolvedIdentity = null;
        }
        return $this->resolvedIdentity;
    }
    /**
     * Clear session record
     *
     * @param void
     * 
     * @return void
     */
    public function clear()
    {
        $sessionId = $this->sessionEmulator->getSessionId();
        $this->sessionEmulator->deleteSessionId($sessionId);
        $this->memcached->delete($sessionId);
    }
}