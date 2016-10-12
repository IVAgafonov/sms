<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Entity\BaseInterface;

interface BaseServiceInterface
{
    /**
     * Check bases count
     *
     * @param  int $count
     * @return int
     * @throws SmsException
     */
    public function checkCount($count);
    /**
     * Check base name for duplicate.
     *
     * @param  BaseInterface $newBase
     * @param  int $baseId
     * @return int
     * @throws SmsException
     */
    public function checkExists(BaseInterface $newBase, $baseId);
    /**
     * Check base status.
     *
     * @param  BaseInterface $base
     * @return int
     * @throws SmsException
     */
    public function checkLocked(BaseInterface $base);
    /**
     * Check base by user.
     *
     * @param  BaseInterface $base
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkUser(BaseInterface $base, $userId);
}

