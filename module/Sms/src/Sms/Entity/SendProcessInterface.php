<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface SendProcessInterface
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
    * Get iteration.
    *
    * @return int
    */
    public function getIteration();
    /**
    * Set iteration.
    *
    * @param int $iteration
    *
    * @return void
    */
    public function setIteration($iteration);
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
    * Get send id.
    *
    * @return int
    */
    public function getSendId();
    /**
    * Set send id.
    *
    * @param int $send_id
    *
    * @return void
    */
    public function setSendId($send_id);
    /**
    * Get executed.
    *
    * @return int
    */
    public function getExecuted();
    /**
    * Set executed.
    *
    * @param int $executed
    *
    * @return void
    */
    public function setExecuted($executed);
}

