<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


use Sms\Mapper\BaseMapper;
use Sms\Entity\BaseInterface;
use Sms\Exception\SmsException;

class BaseService implements BaseServiceInterface
{
    private $maxBases;
    
    public function __construct($config)
    {
        $this->maxBases = $config['sms-max-bases'];
    }
    /**
     * Check bases count
     *
     * @param  int $count
     * @return int
     * @throws SmsException
     */
    public function checkCount($count)
    {
        if ($count >= $this->maxBases) {
            throw new SmsException(_('Databases limit is exceeded'));
        }
        return 0;
    }
    /**
     * Check base name for duplicate.
     *
     * @param  BaseInterface $newBase
     * @param  int $checkedBaseId
     * @return int
     * @throws SmsException
     */
    public function checkExists(BaseInterface $newBase, $checkedBaseId)
    {
        if ($checkedBaseId == 0) {
            return 0;
        }
        if ($newBase->getId()) {
            if ($checkedBaseId == $newBase->getId()) {
                return 0;
            }
        }
        throw new SmsException(_('Base already exist'));
    }
    /**
     * Check base status.
     *
     * @param  BaseInterface $base
     * @return int
     * @throws SmsException
     */
    public function checkLocked(BaseInterface $base)
    {
        if ($base->getStatus()->getId() != BaseMapper::BASE_READY) {
            throw new SmsException(_('The base is busy'));
        }
        return 0;
    }
    /**
     * Check bases by user.
     *
     * @param  BaseInterface $base
     * @param  int $userId
     * @return int
     * @throws SmsException
     */
    public function checkUser(BaseInterface $base, $userId)
    {
        if ($base->getUserId() != $userId) {
            throw new SmsException(_('Base not found'));
        }
        return 0;
    }

}