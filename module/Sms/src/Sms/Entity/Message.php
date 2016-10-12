<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message entity
 *
 * @ORM\Entity
 * @ORM\Table(name="message")
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class Message implements MessageInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var int
     * @ORM\Column(type="integer", name="user_id")
     */
    protected $user_id;
    /**
     * @var string
     * @ORM\Column(type="string", name="title", length=255)
     */
    protected $title;
    /**
     * @var string
     * @ORM\Column(type="string", name="text", length=255)
     */
    protected $text;
    /**
    * Get id.
    *
    * @return int
    */
    public function getId()
    {
        return $this->id;
    }
    /**
    * Set id.
    *
    * @param int $id
    *
    * @return void
    */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
    * Get user_id.
    *
    * @return int
    */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
    * Set user_id.
    *
    * @param int $user_id
    *
    * @return void
    */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    /**
    * Get title.
    *
    * @return string
    */
    public function getTitle()
    {
        return $this->title;
    }
    /**
    * Set title.
    *
    * @param string $title
    *
    * @return void
    */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    /**
    * Get text.
    *
    * @return string
    */
    public function getText()
    {
        return $this->text;
    }
    /**
    * Set text.
    *
    * @param string $text
    *
    * @return void
    */
    public function setText($text)
    {
        $this->text = $text;
    }
}

