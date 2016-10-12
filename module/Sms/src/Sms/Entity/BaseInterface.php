<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface BaseInterface
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
    * Get user_id.
    *
    * @return int
    */
    public function getUserId();
    /**
    * Set user_id.
    *
    * @param int $user_id
    *
    * @return void
    */
    public function setUserId($user_id);
    /**
    * Get name.
    *
    * @return string
    */
    public function getName();
    /**
    * Set name.
    *
    * @param string $name
    *
    * @return void
    */
    public function setName($name);
    /**
    * Get param_name1.
    *
    * @return string
    */
    public function getParamName1();
    /**
    * Set param_name1.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName1($param_name);
    /**
    * Get param_name2.
    *
    * @return string
    */
    public function getParamName2();
    /**
    * Set param_name2.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName2($param_name);
    /**
    * Get param_name3.
    *
    * @return string
    */
    public function getParamName3();
    /**
    * Set param_name3.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName3($param_name);
    /**
    * Get param_name4.
    *
    * @return string
    */
    public function getParamName4();
    /**
    * Set param_name4.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName4($param_name);
    /**
    * Get status.
    *
    * @return \Sms\Entity\Status
    */
    public function getStatus();
    /**
    * Set status.
    *
    * @param \Sms\Entity\StatusInterface $status
    *
    * @return void
    */
    public function setStatus(\Sms\Entity\StatusInterface $status);
}

