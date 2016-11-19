<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Authentication\Session;


interface SessionEmulatorInterface {
    /**
     * Create new session id
     *
     * @param void
     * 
     * @return string
     */
    public function getNewSessionId();
    /**
     * Set session id
     *
     * @param string
     * 
     * @return void
     */
    public function setSessionId($sessionId);
    /**
     * Get session id
     *
     * @param void
     * 
     * @return string
     */
    public function getSessionId();
    /**
     * Set session id
     *
     * @param string
     * 
     * @return void
     */
    public function deleteSessionId($sessionId);
}