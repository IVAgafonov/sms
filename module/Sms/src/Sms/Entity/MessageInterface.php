<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use Doctrine\ORM\Mapping as ORM;

interface MessageInterface
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
    * Get title.
    *
    * @return string
    */
    public function getTitle();
    /**
    * Set title.
    *
    * @param string $title
    *
    * @return void
    */
    public function setTitle($title);
    /**
    * Get text.
    *
    * @return string
    */
    public function getText();
    /**
    * Set text.
    *
    * @param string $text
    *
    * @return void
    */
    public function setText($text);
}

