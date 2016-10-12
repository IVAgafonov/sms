<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface ExportInterface
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
    * Get base id.
    *
    * @return int
    */
    public function getBaseId();
    /**
    * Set base id.
    *
    * @param int $base_id
    *
    * @return void
    */
    public function setBaseId($base_id);
    /**
    * Get base name.
    *
    * @return string
    */
    public function getBaseName();
    /**
    * Set base name.
    *
    * @param string $file_name
    *
    * @return void
    */
    public function setBaseName($base_name);
    /**
    * Get time_stamp.
    *
    * @return DateTime
    */
    public function getTimeStamp();
    /**
    * Set id.
    *
    * @param DateTime $time_stamp
    *
    * @return void
    */
    public function setTimeStamp($time_stamp);
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

