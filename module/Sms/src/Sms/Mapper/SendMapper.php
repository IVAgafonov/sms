<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\SendInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sms\Exception\SmsException;

class SendMapper implements SendMapperInterface
{
    /**
     * Status constants
     */
    const SEND_WAIT      = 1;
    const SEND_PREPARE   = 2;
    const SEND_SEND      = 3;
    const SEND_SUSPENDED = 4;
    const SEND_COMPLETE  = 5;
    const SEND_ERROR     = 6;
    
    protected $entityManager;
    protected $sendEntity;
    
    public function __construct(
        $entityManager,
        SendInterface $sendEntity
    ) {
        $this->entityManager = $entityManager;
        $this->sendEntity = $sendEntity;
    }
    /**
     * Convert send to array.
     *
     * @param  SendInterface $send
     * @return array
     */
    public function toArray(SendInterface $send)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($send);
    }
    /**
     * Convert array to Send (SendInterface).
     *
     * @param  array $array
     * @return SendInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->sendEntity);
    }
    /**
     * Add send.
     *
     * @param  SendInterface $send
     * @return int
     */
    public function add(SendInterface $send)
    {
        $this->entityManager->persist($send);
        $this->entityManager->flush();
        return $send->getId();
    }
    /**
     * Edit send.
     *
     * @param  SendInterface $send
     * @return int
     */
    public function edit(SendInterface $send)
    {
        $this->entityManager->persist($send);
        $this->entityManager->flush();
        return $send->getId();
    }
    /**
     * Delete send by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->sendEntity))->createQueryBuilder('p')
            ->delete(get_class($this->sendEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get send by id.
     *
     * @param  int $id
     * @return SendInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $send = $this->entityManager->getRepository(
            get_class($this->sendEntity)
        )->findBy(array('id' => $id));
        if (empty($send)) {
            throw new SmsException(_('Record not found'));
        }
        return $send[0];
    }
    /**
     * Get send list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getSendList($page, $userId)
    {
        $limit = 10;
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;

        $sendList = $this->entityManager->getRepository(get_class($this->sendEntity))
                ->createQueryBuilder('b')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getQuery();
        if (empty($sendList->getResult())) {
            return 0;
        }
        $paginator = new Paginator($sendList);
        return $paginator;
    }
    /**
     * Get send list by base id.
     *
     * @param  int $baseId
     * @return array
     */
    public function getSendListByBaseId($baseId)
    {
        $sendList = $this->entityManager->getRepository(get_class($this->sendEntity))
                ->createQueryBuilder('b')
                ->where('b.base_id = :base_id')
                ->andWhere('b.status < :status')
                ->setParameter('base_id', $baseId)
                ->setParameter('status', 4)
                ->getQuery();
        if (empty($sendList->getResult())) {
            return 0;
        }
        return $sendList->getResult();
    }
    /**
     * Set status prepare to ready send items.
     *
     * @param  string $date
     * @return int
     */
    public function lockReadySend($date)
    {
        $dateTime = new \DateTime($date);
        $qb = $this->entityManager->createQueryBuilder();
        $q = $qb->update(get_class($this->sendEntity), 'u')
                ->set('u.status', ':statusNew')
                ->where('u.start_time < :checkDate')
                ->andWhere('u.status = :status')
                ->setParameter('statusNew', SendMapper::SEND_PREPARE)
                ->setParameter('checkDate', $dateTime)
                ->setParameter('status', SendMapper::SEND_WAIT)
                ->getQuery();
        
        $q->execute();
        //$this->entityManager->flush();
        return 0;
    }
    /**
     * Get ready send items.
     *
     * @param  string $date
     * @return int
     */
    public function getReadySendList($date)
    {
        $dateTime = new \DateTime($date);
        $sendList = $this->entityManager->getRepository(get_class($this->sendEntity))
                ->createQueryBuilder('b')
                ->where('b.start_time < :checkDate')
                ->andWhere('b.status = :status1 OR b.status = :status2 OR b.status = :status3')
                ->setParameter('checkDate', $dateTime)
                ->setParameter('status1', SendMapper::SEND_PREPARE)
                ->setParameter('status2', SendMapper::SEND_SUSPENDED)
                ->setParameter('status3', SendMapper::SEND_ERROR)
                ->getQuery();
        if (empty($sendList->getResult())) {
            return 0;
        }
        return $sendList->getResult();
    }
}

