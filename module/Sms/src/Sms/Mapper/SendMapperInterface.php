<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\SendInterface;

interface SendMapperInterface
{
    /**
     * Convert send to array.
     *
     * @param  SendInterface $send
     * @return array
     */
    public function toArray(SendInterface $send);
    /**
     * Convert array to Send (SendInterface).
     *
     * @param  array $array
     * @return SendInterface
     */    
    public function toEntity($array);
    /**
     * Add send.
     *
     * @param  SendInterface $send
     * @return int
     */
    public function add(SendInterface $send);
    /**
     * Edit send.
     *
     * @param  SendInterface $send
     * @return int
     */
    public function edit(SendInterface $send);
    /**
     * Delete send by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id);
    /**
     * Get send by id.
     *
     * @param  int $id
     * @return object
     * @throws SmsException
     */
    public function getById($id);
    /**
     * Get send list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getSendList($page, $userId);
}

