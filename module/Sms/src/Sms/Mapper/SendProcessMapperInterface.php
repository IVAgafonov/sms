<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\SendProcessInterface;

interface SendProcessMapperInterface
{
    /**
     * Convert send process (SendProcessInterface) to array.
     *
     * @param  SendProcessInterface $sendProcess
     * @return array
     */
    public function toArray(SendProcessInterface $sendProcess);
    /**
     * Convert array to SendProcess (SendProcessInterface).
     *
     * @param  array $array
     * @return SendProcessInterface
     */
    public function toEntity($array);
    /**
     * Add send process record.
     *
     * @param  SendProcessInterface $sendProcess
     * @return int
     */
    public function add(SendProcessInterface $sendProcess);
    /**
     * Edit send process.
     *
     * @param  SendProcessInterface $sendProcess
     * @return int
     */
    public function edit(SendProcessInterface $sendProcess);
    /**
     * Delete send process by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id);
    /**
     * Get send process by id.
     *
     * @param  int $id
     * @return SendProcessInterface
     * @throws SmsException
     */
    public function getById($id);
    /**
     * Get send process by send id.
     *
     * @param  int $sendId
     * @return SendProcessInterface
     */   
    public function getBySendId($sendId);
}

