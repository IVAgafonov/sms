<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\MessageInterface;

interface MessageMapperInterface
{
    /**
     * Convert Message (MessageInterface) to array.
     *
     * @param  MessageInterface $message
     * @return array
     */
    public function toArray(MessageInterface $message);
    /**
     * Convert array to Message (MessageInterface).
     *
     * @param  array $array
     * @return MessageInterface
     */    
    public function toEntity($array);
    /**
     * Add new message.
     *
     * @param  MessageInterface $message
     * @return int
     */
    public function add(MessageInterface $message);
    /**
     * Edit message.
     *
     * @param MessageInterface $message
     * @return int
     */
    public function edit(MessageInterface $message);
    /**
     * Delete message by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id);
    /**
     * Get message by id.
     *
     * @param  int $id
     * @return MessageInterface
     * @throws SmsException
     */
    public function getById($id);
    /**
     * Get list of messages by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     * @throws SmsException
     */
    public function getMessageList($page, $userId);
    /**
     * Get message id by name.
     *
     * @param string $title
     * @param int $userId
     * @return int
     */
    public function getIdByTitle($title, $userId);
    /**
     * Get messages count by user.
     *
     * @param int $userId
     * @return int
     */    
    public function getMessagesCount($userId);
}

