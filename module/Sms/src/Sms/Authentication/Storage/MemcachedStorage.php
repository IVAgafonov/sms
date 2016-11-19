<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Storage;


use Zend\Authentication\Storage\StorageInterface;
use Sms\Service\System\MemcachedProviderInterface;
use Sms\Authentication\Session\SessionEmulatorInterface;

class MemcachedStorage implements StorageInterface {

    protected $memcached;
    protected $sessionEmulator;
    protected $resolvedIdentity;
    protected $zfcUserMapper;
    
    public function __construct(
        MemcachedProviderInterface $memcachedProvider,
        SessionEmulatorInterface $sessionEmulator,
        $zcfUzerMapper
    ){
        $this->memcached = $memcachedProvider;
        $this->sessionEmulator = $sessionEmulator;
        $this->zfcUserMapper = $zcfUzerMapper;
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
        $sessionId = $this->sessionEmulator->getSessionId();
        if (!$sessionId) {
            return false;
        }
        $this->memcached->set($sessionId, $contents,  300);
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
        $this->memcached->delete($sessionId);
    }
}