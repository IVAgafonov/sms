<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\PhoneInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sms\Exception\SmsException;


class PhoneMapper implements PhoneMapperInterface
{
    /**
     * Status constants
     */
    const PHONE_ACTIVE   = 1;
    const PHONE_INACTIVE = 0;

    protected $entityManager;
    protected $phoneEntity;

    public function __construct($entityManager, PhoneInterface $phoneEntity)
    {
        $this->entityManager = $entityManager;
        $this->phoneEntity = $phoneEntity;
    }
    /**
     * Convert Base (PhoneInterface) to array.
     *
     * @param  PhoneInterface $phone
     * @return array
     */
    public function toArray(PhoneInterface $phone)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($phone);
    }
    /**
     * Convert array to Phone (PhoneInterface).
     *
     * @param  array $array
     * @return PhoneInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, clone($this->phoneEntity));
    }
    /**
     * Add object.
     *
     * @param  PhoneInterface $phone
     * @return int
     */
    public function add(PhoneInterface $phone)
    {
        $phone->setStatus($this::PHONE_ACTIVE);
        $this->entityManager->persist($phone);
        $this->entityManager->flush();
        return $phone->getId();
    }
    /**
     * Edit object.
     *
     * @param  PhoneInterface $phone
     * @return int
     * @throws SmsException
     */
    public function edit(PhoneInterface $phone)
    {
        //$this->checkDoublePhoneInBase($data['Phone']);
        //$phone->setStatus($this::PHONE_ACTIVE);
        $this->entityManager->persist($phone);
        $this->entityManager->flush();
        return $phone->getId();
    }
    /**
     * Delete phone by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->phoneEntity))->createQueryBuilder('p')
            ->delete(get_class($this->phoneEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get phone by id.
     *
     * @param  int $id
     * @return PhoneInterface
     * @throws SmsException
     */
    public function getById($id)
    {
        $phone = $this->entityManager->getRepository(
            get_class($this->phoneEntity)
        )->findBy(array('id' => $id));
        if (empty($phone)) {
            throw new SmsException(_('Phone number not found'));
        }
        return $phone[0];
    }
    /**
     * Get list of phones by page.
     *
     * @param  int $page
     * @param  int $baseId
     * @param  string $filter
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getPhoneList($page, $baseId, $filter)
    {
        $limit = 10;
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        if ($filter == '') {
            $phoneList = $this->entityManager->getRepository(get_class($this->phoneEntity))->createQueryBuilder('o')
                ->where('o.base_id = :base_id')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->setParameter('base_id', $baseId)
                ->getQuery();
        } else {
            $phoneList = $this->entityManager->getRepository(get_class($this->phoneEntity))->createQueryBuilder('o')
                ->where('o.base_id = :base_id')
                ->andWhere('o.number LIKE :filter OR o.value1 LIKE :filter OR o.value2 LIKE :filter OR o.value3 LIKE :filter OR o.value4 LIKE :filter')
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->setParameter('base_id', $baseId)
                ->setParameter('filter', "%$filter%")
                ->getQuery();
        }
        if (empty($phoneList->getResult())) {
            return 0;
        }
        $paginator = new Paginator($phoneList);
        return $paginator;
    }
    /**
     * Delete all phones by base id.
     *
     * @params int $baseId
     * @return int
     */
    public function deleteAllByBaseId($baseId)
    {
        $this->entityManager->getRepository(get_class($this->phoneEntity))->createQueryBuilder('p')
            ->delete(get_class($this->phoneEntity), 'p')
            ->where('p.base_id = :base_id')
            ->setParameter('base_id', $baseId)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Hold base by id.
     *
     * @param int $id
     * @param int $status
     * @return int
     */
    public function getPhonesCountByBaseId($id)
    {
        $phonesCount = $this->entityManager->getRepository(get_class($this->phoneEntity))->createQueryBuilder('p')
               ->select('count(p.id)')
                ->where('p.base_id = :base_id')
                ->setParameter('base_id', $id)
                ->getQuery()->getSingleScalarResult();
        return $phonesCount;
    }
    /**
     * Get phone by number and base id.
     *
     * @param string $number
     * @param int $baseId
     * @return int
     * @throws SmsException
     */    
    public function getPhoneByNumber($number, $baseId)
    {
        $phone = $this->entityManager->getRepository(
            get_class($this->phoneEntity)
        )->findBy(
            array(
                'base_id' => $baseId,
                'number' => $number
            )
        );
        return $phone;
        /*
        if (empty($phoneCheck)) {
            return 0;
        } else {
            if ($phoneCheck[0]->getId() != $phoneArray['id']) {
                throw new MapperException(_('Phone number already exist in base'));
            } else {
                return 0;
            }
        }
         * 
         */
    }
    /**
     * Check double phone by number in base.
     *
     * @params array $phoneArray
     * @return int
     */
    protected function checkDoublePhoneInBase($phoneArray)
    {
        /*
        $phoneCheck = $this->entityManager->getRepository(
            get_class($this->phoneEntity)
        )->findBy(
            array(
                'base_id' => $phoneArray['base_id'],
                'number' => $phoneArray['number']
            )
        );
        if (empty($phoneCheck)) {
            return 0;
        } else {
            if ($phoneCheck[0]->getId() != $phoneArray['id']) {
                throw new MapperException(_('Phone number already exist in base'));
            } else {
                return 0;
            }
        }*/
    }
    /**
     * Set phone status.
     *
     * @params int $phoneId
     * @params int $status
     * @return int
     */
    public function setPhoneStatus($phoneId, $status)
    {
        $phone = $this->getById($phoneId);
        $phone->setStatus($status);
        $this->entityManager->persist($phone);
        $this->entityManager->flush();
        return 0;       
    }
    /**
     * Check base by name.
     *
     * @params string $number
     * @params int $baseId
     * @return int
     */
    public function getIdByNumber($number, $baseId)
    {
        $phone = $this->entityManager->getRepository(
            get_class($this->phoneEntity)
        )->findBy(array('base_id' => $baseId, 'number' => $number));
        if (empty($phone)) { //if phone with this name is not exist return 0
            return 0;
        } else {
            return $phone[0]->getId();
        }
    }
    /**
     * import Phone.
     *
     * @param  PhoneInterface $phone
     * @return int
     */
    public function importPhone(PhoneInterface $phone)
    {
        $phone->setStatus($this::PHONE_ACTIVE);
        $this->entityManager->persist($phone);
        return 0;
    }
    /**
     * flush Phones.
     *
     * @return int
     */
    public function flushPhones()
    {
        $this->entityManager->flush();
        return 0;
    }
    /**
     * Get phones to export.
     *
     * @return int
     * @throws MapperException
     */
    public function getPhonesToExport($baseId, $iteration)
    {
        $offset = $iteration * 10000;
        $phoneList = $this->entityManager->getRepository(get_class($this->phoneEntity))->createQueryBuilder('o')
            ->where('o.base_id = :base_id')
            ->setMaxResults(10000)
            ->setFirstResult($offset)
            ->setParameter('base_id', $baseId)
            ->getQuery()
            ->getResult();
        return $phoneList;
    }
}

