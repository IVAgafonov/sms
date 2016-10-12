<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Send entity
 *
 * @ORM\Entity
 * @ORM\Table(name="send")
 *
 */
class Send implements SendInterface
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
     * @var int
     * @ORM\Column(type="integer", name="base_id")
     */
    protected $base_id;
    /**
     * @var string
     * @ORM\Column(type="string", name="base_name", length=255)
     */
    protected $base_name;
    /**
     * @var int
     * @ORM\Column(type="integer", name="message_id")
     */
    protected $message_id;
    /**
     * @var int
     * @ORM\Column(type="string", name="message_text", length=255)
     */
    protected $message_text;
    /**
     * @var string
     * @ORM\Column(type="string", name="message_title", length=255)
     */
    protected $message_title;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="start_time")
     */
    protected $start_time;
    /**
     * @var int
     * @ORM\Column(type="integer", name="status")
     */
    protected $status;
    /**
     * @var int
     * @ORM\Column(type="integer", name="sended")
     */
    protected $sended;
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
    * Get user id.
    *
    * @return int
    */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
    * Set user id.
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
    * Get base id.
    *
    * @return int
    */
    public function getBaseId()
    {
        return $this->base_id;
    }
    /**
    * Set base id.
    *
    * @param int $base_id
    *
    * @return void
    */
    public function setBaseId($base_id)
    {
        $this->base_id = $base_id;
    }
    /**
    * Get base name.
    *
    * @return string
    */
    public function getBaseName()
    {
        return $this->base_name;
    }
    /**
    * Set base name.
    *
    * @param string base_name
    *
    * @return void
    */
    public function setBaseName($base_name)
    {
        $this->base_name = $base_name;
    }
    /**
    * Get message id.
    *
    * @return int
    */
    public function getMessageId()
    {
        return $this->message_id;
    }
    /**
    * Set message id.
    *
    * @param int $message_id
    *
    * @return void
    */
    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }
    /**
    * Get message text.
    *
    * @return int
    */
    public function getMessageText()
    {
        return $this->message_text;
    }
    /**
    * Set message text.
    *
    * @param int $message_text
    *
    * @return void
    */
    public function setMessageText($message_text)
    {
        $this->message_text = $message_text;
    }
    /**
    * Get message title.
    *
    * @return string
    */
    public function getMessageTitle()
    {
        return $this->message_title;
    }
    /**
    * Set message title.
    *
    * @param int $message_title
    *
    * @return void
    */
    public function setMessageTitle($message_title)
    {
        $this->message_title = $message_title;
    }
    /**
    * Get start time.
    *
    * @return DateTime
    */
    public function getStartTime()
    {
        return $this->start_time;
    }
    /**
    * Set start time.
    *
    * @param DateTime $start_time
    *
    * @return void
    */
    public function setStartTime($start_time)
    {
        $this->start_time = $start_time;
    }
    /**
    * Get status.
    *
    * @return int
    */
    public function getStatus()
    {
        return $this->status;
    }
    /**
    * Set status.
    *
    * @param int $status
    *
    * @return void
    */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    /**
    * Get sended count.
    *
    * @return int
    */
    public function getSended()
    {
        return $this->sended;
    }
    /**
    * Set sended count.
    *
    * @param int $sended
    *
    * @return void
    */
    public function setSended($sended)
    {
        $this->sended = $sended;
    }
}

