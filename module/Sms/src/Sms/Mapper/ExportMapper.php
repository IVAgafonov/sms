<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;

use Sms\Entity\ExportInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sms\Exception\SmsException;

class ExportMapper implements ExportMapperInterface
{
    const PROCESS = 1;
    const READY  = 2;
    const ERROR  = 3;
    
    private $entityManager;
    private $exportEntity;
    
    public function __construct($em, ExportInterface $exportEntity)
    {
        $this->entityManager = $em;
        $this->exportEntity = $exportEntity;
    }
    /**
     * Convert export (ExportInterface) to array.
     *
     * @param  ExportInterface $export
     * @return array
     */
    public function toArray(ExportInterface $export)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($export);
    }
    /**
     * Convert array to Export (ExportInterface).
     *
     * @param  array $array
     * @return ExportInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->exportEntity);
    }
    /**
     * Add export record.
     *
     * @param  ExportInterface $export
     * @return int
     */
    public function add(ExportInterface $export)
    {
        $date = new \DateTime("now");
        $export->setTimeStamp($date);
        $this->entityManager->persist($export);
        $this->entityManager->flush();
        return $export->getId();
    }
    /**
     * Edit export.
     *
     * @param  ExportInterface $export
     * @return int
     */
    public function edit(ExportInterface $export)
    {
        $date = new \DateTime("now");
        $export->setTimeStamp($date);
        $this->entityManager->persist($export);
        $this->entityManager->flush();
        return $export->getId();
    }
    /**
     * Delete export by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->exportEntity))->createQueryBuilder('p')
            ->delete(get_class($this->exportEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get export by id.
     *
     * @param  int $id
     * @return ExportInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $export = $this->entityManager->getRepository(
            get_class($this->exportEntity)
        )->findBy(array('id' => $id));
        if (empty($export)) {
            throw new SmsException(_('Export error'));
        }
        return $export[0];
    }
    /**
     * Get export by base id.
     *
     * @param  int $baseId
     * @return ExportInterface
     */   
    public function getByBaseId($baseId)
    {
        $export = $this->entityManager->getRepository(
            get_class($this->exportEntity)
        )->findBy(array('base_id' => $baseId));
        if (empty($export)) {
            return false;
        }
        return $export[0];
    }
    /**
     * Get export list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getExportList($page, $userId)
    {
        $limit = 10;
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $exportList = $this->entityManager->getRepository(get_class($this->exportEntity))->createQueryBuilder('b')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getQuery();
        
        if (empty($exportList->getResult())) {
            return 0;
        }
        $paginator = new Paginator($exportList);
        return $paginator;
    }
}

