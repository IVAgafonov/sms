<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\MessageInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sms\Exception\SmsException;

class MessageMapper implements MessageMapperInterface
{
    protected $entityManager;
    protected $messageEntity;

    public function __construct($entityManager, MessageInterface $messageEntity)
    {
        $this->entityManager = $entityManager;
        $this->messageEntity = $messageEntity;
    }
    /**
     * Convert Message (MessageInterface) to array.
     *
     * @param  MessageInterface $message
     * @return array
     */
    public function toArray(MessageInterface $message)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($message);
    }
    /**
     * Convert array to Message (MessageInterface).
     *
     * @param  array $array
     * @return MessageInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->messageEntity);
    }
    /**
     * Add message.
     *
     * @param  MessageInterface $message
     * @return int
     */
    public function add(MessageInterface $message)
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
        return $message->getId();
    }
    /**
     * Edit message.
     *
     * @param  MessageInterface $message
     * @return int
     */
    public function edit(MessageInterface $message)
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
        return $message->getId();
    }
    /**
     * Delete message by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->messageEntity))->createQueryBuilder('p')
            ->delete(get_class($this->messageEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get object by id.
     *
     * @param  int $id
     * @return MessageInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $message = $this->entityManager->getRepository(
            get_class($this->messageEntity)
        )->findBy(array('id' => $id));
        if (empty($message)) {
            throw new SmsException(_('Message not found'));
        }
        return $message[0];
    }
    /**
     * Get list of messages by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getMessageList($page, $userId)
    {
        $limit = 10;
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;

        $msgList = $this->entityManager->getRepository(get_class($this->messageEntity))->createQueryBuilder('b')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getQuery();

        if (empty($msgList->getResult())) {
            return 0;
        }

        $paginator = new Paginator($msgList);
        return $paginator;
    }
    /**
     * Check message by name.
     *
     * @param string $title
     * @param int $userId
     * @return int
     */
    public function getIdByTitle($title, $userId)
    {
        $msg = $this->entityManager->getRepository(
            get_class($this->messageEntity)
        )->findBy(array('user_id' => $userId, 'title' => $title)); 
        if (empty($msg)) { //if message with this title is not exist return 0
            return 0;
        } else {
            return $msg[0]->getId();
        }
    }
    /**
     * Get count messages by User.
     *
     * @param int $userId
     * @return int
     * @throws MapperException
     */
    public function getMessagesCount($userId)
    {
        $count = $this->entityManager->getRepository(get_class($this->messageEntity))->createQueryBuilder('b')
               ->select('count(b.id)')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->getQuery()->getSingleScalarResult();
        return $count;
    }
}

