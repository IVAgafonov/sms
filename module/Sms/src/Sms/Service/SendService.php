<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Entity\SendInterface;
use Sms\Mapper\SendMapper;
use Sms\Exception\SmsException;

class SendService implements SendServiceInterface
{
    /**
     * Check bases by user.
     *
     * @param  SendInterface $send
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkUser(SendInterface $send, $userId)
    {
        if ($send->getUserId() != $userId) {
            throw new SmsException(_('Record not found'));
        }
        return 0;
    }
    /**
     * Check delivery to edit.
     *
     * @param  SendInterface $send
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkLockedToEdit(SendInterface $send)
    {
        if ($send->getStatus() != SendMapper::SEND_WAIT) {
            throw new SmsException(_("Processing. You can't access to that process."));
        }
        return 0;
    }
    /**
     * Check delivery to delete.
     *
     * @param  SendInterface $send
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkLockedToDelete(SendInterface $send)
    {
        if (($send->getStatus() != SendMapper::SEND_WAIT) && ($send->getStatus() != SendMapper::SEND_COMPLETE)) {
            throw new SmsException(_("Processing. You can't access to that process."));
        }
        return 0;
    }
}

