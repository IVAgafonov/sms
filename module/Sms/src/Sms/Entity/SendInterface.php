<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface SendInterface
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
    * @param string base_name
    *
    * @return void
    */
    public function setBaseName($base_name);
    /**
    * Get message id.
    *
    * @return int
    */
    public function getMessageId();
    /**
    * Set message id.
    *
    * @param int $message_id
    *
    * @return void
    */
    public function setMessageId($message_id);
    /**
    * Get message text.
    *
    * @return int
    */
    public function getMessageText();
    /**
    * Set message text.
    *
    * @param int $message_text
    *
    * @return void
    */
    public function setMessageText($message_text);
    /**
    * Get message title.
    *
    * @return string
    */
    public function getMessageTitle();
    /**
    * Set message title.
    *
    * @param int $message_title
    *
    * @return void
    */
    public function setMessageTitle($message_title);
    /**
    * Get start time.
    *
    * @return DateTime
    */
    public function getStartTime();
    /**
    * Set start time.
    *
    * @param DateTime $start_time
    *
    * @return void
    */
    public function setStartTime($start_time);
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
    /**
    * Get sended count.
    *
    * @return int
    */
    public function getSended();
    /**
    * Set sended count.
    *
    * @param int $sended
    *
    * @return void
    */
    public function setSended($sended);
}

