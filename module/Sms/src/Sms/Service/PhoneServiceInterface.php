<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Entity\PhoneInterface;

interface PhoneServiceInterface
{
    /**
     * Check phone by dublicate.
     *
     * @param  PhoneInterface $newPhone
     * @param  int $checkedPhoneId
     * @return int
     * @throws SmsException
     */
    public function checkExists(PhoneInterface $newPhone, $checkedPhoneId);
}

