<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


interface MemcachedProviderInterface
{
    /**
     * Add new key
     *
     * @param  string $key
     * @param  mixed $contents
     * @param  int $time
     * @return bool
     */
    public function add($key, $contents, $time);
    /**
     * Set key
     *
     * @param  string $key
     * @param  mixed $contents
     * @param  int $time
     * @return bool
     */
    public function set($key, $contents, $time);
    /**
     * Get value by key
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key);
    /**
     * Get value and key
     *
     * @param  string $key
     * @return bool
     */
    public function delete($key);
    /**
     * Set new expiried time
     *
     * @param  string $key
     * @param  int $time
     * @return bool
     */
    public function touch($key, $time);
}