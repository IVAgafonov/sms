<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface ImportInterface
{
    /**
    * Get id.
    *
    * @return int
    */
    public function getId();
    /**
    * Set id.
    *
    * @param int $id
    *
    * @return void
    */
    public function setId($id);
    /**
    * Get user id.
    *
    * @return int
    */
    public function getUserId();
    /**
    * Set user id.
    *
    * @param int $user_id
    *
    * @return void
    */
    public function setUserId($user_id);
    /**
    * Get base name.
    *
    * @return string
    */
    public function getBaseName();
    /**
    * Set base name.
    *
    * @param string $base_name
    *
    * @return void
    */
    public function setBaseName($base_name);
    /**
    * Get time stamp.
    *
    * @return DateTime
    */
    public function getTimeStamp();
    /**
    * Set time stamp.
    *
    * @param DateTime $time_stamp
    *
    * @return void
    */
    public function setTimeStamp($time_stamp);
    /**
    * Get imported counts.
    *
    * @return int
    */
    public function getImported();
    /**
    * Set imported counts.
    *
    * @param int $imported
    *
    * @return void
    */
    public function setImported($imported);
    /**
    * Get fails counts.
    *
    * @return int
    */
    public function getFails();
    /**
    * Set imported fails.
    *
    * @param int $fails
    *
    * @return void
    */
    public function setFails($fails);
    /**
    * Get status.
    *
    * @return int
    */
    public function getStatus();
    /**
    * Set status.
    *
    * @param int $status
    *
    * @return void
    */
    public function setStatus($status);
}

