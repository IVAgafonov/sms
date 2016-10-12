<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Entity\MessageInterface;
use Sms\Exception\SmsException;

class MessageService implements MessageServiceInterface
{
    private $maxMessages;
    
    public function __construct($config)
    {
        $this->maxMessages = $config['sms-max-messages'];
    }
    /**
     * Check messages count by user.
     *
     * @param  int $count
     * @return int
     * @throws SmsException
     */
    public function checkCount($count)
    {
        if ($count >= $this->maxMessages) {
            throw new SmsException(_('Messages limit is exceeded'));
        }
        return 0;
    }
    /**
     * Check message by title.
     *
     * @param  MessageInterface $message
     * @param  int $checkedMessageId
     * @return int
     * @throws SmsException
     */
    public function checkExists(MessageInterface $message, $checkedMessageId)
    {
        if ($checkedMessageId == 0) {
            return 0;
        }
        if ($message->getId()) {
            if ($checkedMessageId == $message->getId()) {
                return 0;
            }
        }
        throw new SmsException(_('Message with this title already exist'));
    }
    /**
     * Check message by user.
     *
     * @param  MessageInterface $message
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkUser(MessageInterface $message, $userId)
    {
        if ($message->getUserId() != $userId) {
            throw new SmsException(_('Message not found'));
        }
        return 0;
    }
}

