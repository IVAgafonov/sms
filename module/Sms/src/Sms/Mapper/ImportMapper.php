<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\ImportInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Sms\Exception\SmsException;

class ImportMapper implements ImportMapperInterface
{
    const PROCESS = 1;
    const READY  = 2;
    const ERROR  = 3;

    private $entityManager;
    private $importEntity;

    public function __construct($em, ImportInterface $importEntity)
    {
        $this->entityManager = $em;
        $this->importEntity = $importEntity;
    }
    /**
     * Convert Import (ImportInterface) to array.
     *
     * @param  ImportInterface $import
     * @return array
     */
    public function toArray(ImportInterface $import)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($import);
    }
    /**
     * Convert array to Import (ImportInterface).
     *
     * @param  array $array
     * @return ImportInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->importEntity);
    }
    /**
     * Add new import.
     *
     * @param  ImportInterface $import
     * @return int
     */
    public function add(ImportInterface $import)
    {
        $import->setTimeStamp(new \DateTime("now"));
        $this->entityManager->persist($import);
        $this->entityManager->flush();
        return $import->getId();
    }
    /**
     * Edit import.
     *
     * @param ImportInterface $import
     * @return int
     */
    public function edit(ImportInterface $import)
    {
        $import->setTimeStamp(new \DateTime("now"));
        $this->entityManager->persist($import);
        $this->entityManager->flush();
        return $import->getId();
    }
    /**
     * Delete import by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->importEntity))->createQueryBuilder('p')
            ->delete(get_class($this->importEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get import by id.
     *
     * @param  int $id
     * @return ImportInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $import = $this->entityManager->getRepository(
            get_class($this->importEntity)
        )->findBy(array('id' => $id));
        if (empty($import)) {
            throw new SmsException(_('Import not found'));
        }
        return $import[0];
    }
    /**
     * Get import list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getImportList($page, $userId)
    {
        $limit = 10;
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $importList = $this->entityManager->getRepository(get_class($this->importEntity))->createQueryBuilder('b')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getQuery();
        
        if (empty($importList->getResult())) {
            return 0;
        }
        $paginator = new Paginator($importList);
        return $paginator;
    }
}

