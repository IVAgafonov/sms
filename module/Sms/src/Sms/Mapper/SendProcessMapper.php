<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\SendProcessInterface;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Sms\Exception\SmsException;

class SendProcessMapper implements SendProcessMapperInterface
{
    private $entityManager;
    private $sendProcessEntity;
    
    public function __construct($em, SendProcessInterface $sendProcessEntity)
    {
        $this->entityManager = $em;
        $this->sendProcessEntity = $sendProcessEntity;
    }
    /**
     * Convert send process (SendProcessInterface) to array.
     *
     * @param  SendProcessInterface $sendProcess
     * @return array
     */
    public function toArray(SendProcessInterface $sendProcess)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($sendProcess);
    }
    /**
     * Convert array to SendProcess (SendProcessInterface).
     *
     * @param  array $array
     * @return SendProcessInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->sendProcessEntity);
    }
    /**
     * Add send process record.
     *
     * @param  SendProcessInterface $sendProcess
     * @return int
     */
    public function add(SendProcessInterface $sendProcess)
    {
        $date = new \DateTime("now");
        $sendProcess->setTimeStamp($date);
        $this->entityManager->persist($sendProcess);
        $this->entityManager->flush();
        return $sendProcess->getId();
    }
    /**
     * Edit send process.
     *
     * @param  SendProcessInterface $sendProcess
     * @return int
     */
    public function edit(SendProcessInterface $sendProcess)
    {
        $date = new \DateTime("now");
        $sendProcess->setTimeStamp($date);
        $this->entityManager->persist($sendProcess);
        $this->entityManager->flush();
        return $sendProcess->getId();
    }
    /**
     * Delete send process by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->sendProcessEntity))->createQueryBuilder('p')
            ->delete(get_class($this->sendProcessEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get send process by id.
     *
     * @param  int $id
     * @return SendProcessInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $sendProcess = $this->entityManager->getRepository(
            get_class($this->sendProcessEntity)
        )->findBy(array('id' => $id));
        if (empty($sendProcess)) {
            throw new SmsException(_('Export error'));
        }
        return $sendProcess[0];
    }
    /**
     * Get send process by send id.
     *
     * @param  int $sendId
     * @return SendProcessInterface
     */   
    public function getBySendId($sendId)
    {
        $sendProcess = $this->entityManager->getRepository(
            get_class($this->sendProcessEntity)
        )->findBy(array('send_id' => $sendId));
        if (empty($sendProcess)) {
            return 0;
        }
        return $sendProcess[0];
    }
    /**
     * Get errors of send list.
     *
     * @param  string $date
     * @return int
     */
    public function getSendErrors()
    {
        $check_date = date("Y-m-d H:i:s", time()-300);
        $dateTime = new \DateTime($check_date);

        $sendProcessList = $this->entityManager->getRepository(get_class($this->sendProcessEntity))
                ->createQueryBuilder('b')
                ->where('b.time_stamp < :checkDate')
                ->andWhere('b.executed <> :exec')
                ->setParameter('checkDate', $dateTime)
                ->setParameter('exec', 0)
                ->getQuery();
        if (empty($sendProcessList->getResult())) {
            return 0;
        }
        return $sendProcessList->getResult();
    }
    /**
     * Get send process by base id.
     *
     * @param  int $baseId
     * @return SendProcessInterface
     */  
    public function getByBaseId($baseId)
    {
        $sendProcess = $this->entityManager->getRepository(
            get_class($this->sendProcessEntity)
        )->findBy(array('base_id' => $baseId));
        if (empty($sendProcess)) {
            return 0;
        }
        return $sendProcess[0];
    }
}

