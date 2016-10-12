<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\PhoneInterface;

interface PhoneMapperInterface
{
    /**
     * Convert Phone (PhoneInterface) to array.
     *
     * @param  PhoneInterface $phone
     * @return array
     */
    public function toArray(PhoneInterface $phone);
    /**
     * Convert array to Phone (PhoneInterface).
     *
     * @param  array $array
     * @return PhoneInterface
     */    
    public function toEntity($array);
    /**
     * Get list of objects by page.
     *
     * @param  int $page
     * @param  int $baseId
     * @param  string $filter
     * @param  int $limit
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     * @throws SmsException
     */
    public function getPhoneList($page, $baseId, $filter);
    /**
     * Get phones count in base.
     *
     * @params int $id
     * @return int
     * @throws SmsException
     */
    public function getPhonesCountByBaseId($id);
    /**
     * Delete all phones from base.
     *
     * @params int $id
     * @return int
     * @throws SmsException
     */
    public function deleteAllByBaseId($id);
    /**
     * Set phone status.
     *
     * @params int $id
     * @params int $status
     * @return int
     * @throws SmsException
     */
    public function setPhoneStatus($id, $status);
    /**
     * Check base by name.
     *
     * @params string $number
     * @params int $baseId
     * @return int
     */
    public function getIdByNumber($number, $baseId);
    /**
     * import Phone.
     *
     * @param  PhoneInterface $phone
     * @return int
     */
    public function importPhone(PhoneInterface $phone);
    /**
     * Get phones to export.
     *
     * @return int
     * @throws SmsException
     */
    public function getPhonesToExport($baseId, $iteration);
    /**
     * flush Phones.
     *
     * @return int
     * @throws SmsException
     */
    public function flushPhones();
}

