<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\ImportProcessInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Sms\Exception\SmsException;

class ImportProcessMapper implements ImportProcessMapperInterface
{
    private $entityManager;
    private $importProcessEntity;
    
    public function __construct($em, ImportProcessInterface $importProcessEntity)
    {
        $this->entityManager = $em;
        $this->importProcessEntity = $importProcessEntity;
    }
    /**
     * Convert ImportProcess (ImportProcessInterface) to array.
     *
     * @param  ImportProcessInterface $importProcess
     * @return array
     */
    public function toArray(ImportProcessInterface $importProcess)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($importProcess);
    }
    /**
     * Convert array to ImportProcess (ImportProcessInterface).
     *
     * @param  array $array
     * @return ImportProcessInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->importProcessEntity);
    }
    /**
     * Add new import.
     *
     * @param  ImportProcessInterface $importProcess
     * @return int
     */
    public function add(ImportProcessInterface $importProcess)
    {
        $importProcess->setTimeStamp(new \DateTime("now"));
        $this->entityManager->persist($importProcess);
        $this->entityManager->flush();
        return $importProcess->getId();
    }
    /**
     * Edit import.
     *
     * @param ImportProcessInterface $importProcess
     * @return int
     */
    public function edit(ImportProcessInterface $importProcess)
    {
        $importProcess->setTimeStamp(new \DateTime("now"));
        $this->entityManager->persist($importProcess);
        $this->entityManager->flush();
        return $importProcess->getId();
    }
    /**
     * Delete import process by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->importProcessEntity))->createQueryBuilder('p')
            ->delete(get_class($this->importProcessEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get import process by id.
     *
     * @param  int $id
     * @return ImportProcessInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $importProcess = $this->entityManager->getRepository(
            get_class($this->importProcessEntity)
        )->findBy(array('id' => $id));
        if (empty($importProcess)) {
            throw new SmsException(_('Import not found'));
        }
        return $importProcess[0];
    }
    /**
     * Get import errors.
     *
     * @return ImportProcessInterface
     */   
    public function getImportErrors()
    {
        $check_date = date("Y-m-d H:i:s", time()-300);
        $dateTime = new \DateTime($check_date);
        
        $importProcessList = $this->entityManager->getRepository(get_class($this->importProcessEntity))
                ->createQueryBuilder('b')
                ->where('b.time_stamp < :checkDate')
                ->setParameter('checkDate', $dateTime)
                ->getQuery();
        if (empty($importProcessList->getResult())) {
            return 0;
        }
        return $importProcessList->getResult();
    }
}

