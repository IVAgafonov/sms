<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface PhoneInterface
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
    * Get base_id.
    *
    * @return int
    */
    public function getBaseId();
    /**
    * Set base_id.
    *
    * @param int $base_id
    *
    * @return void
    */
    public function setBaseId($base_id);
    /**
    * Get number.
    *
    * @return string
    */
    public function getNumber();
    /**
    * Set number.
    *
    * @param string $number
    *
    * @return void
    */
    public function setNumber($number);
    /**
    * Get value1.
    *
    * @return string
    */
    public function getValue1();
    /**
    * Set value1.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue1($value);
    /**
    * Get value2.
    *
    * @return string
    */
    public function getValue2();
    /**
    * Set value2.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue2($value);
    /**
    * Get value3.
    *
    * @return string
    */
    public function getValue3();
    /**
    * Set value3.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue3($value);
    /**
    * Get value4.
    *
    * @return string
    */
    public function getValue4();
    /**
    * Set value4.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue4($value);
    /**
    * Get int.
    *
    * @return string
    */
    public function getStatus();
    /**
    * Set status.
    *
    * @param string $status
    *
    * @return void
    */
    public function setStatus($status);
}

