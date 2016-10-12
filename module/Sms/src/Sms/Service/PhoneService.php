<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Entity\PhoneInterface;
use Sms\Exception\SmsException;

class PhoneService implements PhoneServiceInterface
{
    /**
     * Check phone by dublicate.
     *
     * @param  PhoneInterface $newPhone
     * @param  int $checkedPhoneId
     * @return int
     * @throws SmsException
     */
    public function checkExists(PhoneInterface $newPhone, $checkedPhoneId)
    {
        if ($checkedPhoneId == 0) {
            return 0;
        }
        if ($newPhone->getId()) {
            if ($checkedPhoneId == $newPhone->getId()) {
                return 0;
            }
        }
        throw new SmsException(_('Phone number already exist in this base'));
    }
}