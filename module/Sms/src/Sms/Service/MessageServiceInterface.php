<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Entity\MessageInterface;

interface MessageServiceInterface
{
    /**
     * Check messages count by user.
     *
     * @param  int $count
     * @return int
     * @throws SmsException
     */
    public function checkCount($count);
    /**
     * Check message by title.
     *
     * @param  MessageInterface $message
     * @param  int $checkedMessageId
     * @return int
     * @throws SmsException
     */
    public function checkExists(MessageInterface $message, $checkedMessageId);
    /**
     * Check message by user.
     *
     * @param  MessageInterface $message
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkUser(MessageInterface $message, $userId);
}

