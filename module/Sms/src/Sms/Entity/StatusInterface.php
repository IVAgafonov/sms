<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

interface StatusInterface
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
}

