<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;

use Sms\Entity\ExportProcessInterface;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Sms\Exception\SmsException;

class ExportProcessMapper implements ExportProcessMapperInterface
{
    private $entityManager;
    private $exportProcessEntity;
    
    public function __construct($em, ExportProcessInterface $exportProcessEntity)
    {
        $this->entityManager = $em;
        $this->exportProcessEntity = $exportProcessEntity;
    }
    /**
     * Convert export process (ExportProcessInterface) to array.
     *
     * @param  ExportProcessInterface $exportProcess
     * @return array
     */
    public function toArray(ExportProcessInterface $exportProcess)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($exportProcess);
    }
    /**
     * Convert array to ExportProcess (ExportProcessInterface).
     *
     * @param  array $array
     * @return ExportProcessInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->exportProcessEntity);
    }
    /**
     * Add export process record.
     *
     * @param  ExportProcessInterface $exportProcess
     * @return int
     */
    public function add(ExportProcessInterface $exportProcess)
    {
        $date = new \DateTime("now");
        $exportProcess->setTimeStamp($date);
        $this->entityManager->persist($exportProcess);
        $this->entityManager->flush();
        return $exportProcess->getId();
    }
    /**
     * Edit export process.
     *
     * @param  ExportProcessInterface $exportProcess
     * @return int
     */
    public function edit(ExportProcessInterface $exportProcess)
    {
        $date = new \DateTime("now");
        $exportProcess->setTimeStamp($date);
        $this->entityManager->persist($exportProcess);
        $this->entityManager->flush();
        return $exportProcess->getId();
    }
    /**
     * Delete export by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->exportProcessEntity))->createQueryBuilder('p')
            ->delete(get_class($this->exportProcessEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get export process by id.
     *
     * @param  int $id
     * @return ExportProcessInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $exportProcess = $this->entityManager->getRepository(
            get_class($this->exportProcessEntity)
        )->findBy(array('id' => $id));
        if (empty($exportProcess)) {
            throw new SmsException(_('Export error'));
        }
        return $exportProcess[0];
    }
    /**
     * Get export by base id.
     *
     * @param  int $baseId
     * @return ExportProcessInterface
     */   
    public function getByBaseId($baseId)
    {
        $exportProcess = $this->entityManager->getRepository(
            get_class($this->exportProcessEntity)
        )->findBy(array('base_id' => $baseId));
        if (empty($exportProcess)) {
            return false;
        }
        return $exportProcess[0];
    }
    /**
     * Get export errors.
     *
     * @return ExportProcessInterface
     */   
    public function getExportErrors()
    {
        $check_date = date("Y-m-d H:i:s", time()-300);
        $dateTime = new \DateTime($check_date);
        
        $exportProcessList = $this->entityManager->getRepository(get_class($this->exportProcessEntity))
                ->createQueryBuilder('b')
                ->where('b.time_stamp < :checkDate')
                ->setParameter('checkDate', $dateTime)
                ->getQuery();
        if (empty($exportProcessList->getResult())) {
            return 0;
        }
        return $exportProcessList->getResult();
    }
}

