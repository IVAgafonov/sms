<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\BaseInterface;
use Sms\Entity\StatusInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Sms\Exception\SmsException;

class BaseMapper implements BaseMapperInterface
{
    /**
     * Status constants
     */
    const BASE_READY  = 1;
    const BASE_IMPORT = 2;
    const BASE_EXPORT = 3;
    const BASE_SEND   = 4;
    const BASE_ERROR  = 5;
    
    protected $entityManager;
    protected $baseEntity;
    protected $statusEntity;
    
    public function __construct(
        $entityManager,
        BaseInterface $baseEntity,
        StatusInterface $statusEntity
    ) {
        $this->entityManager = $entityManager;
        $this->baseEntity = $baseEntity;
        $this->statusEntity = $statusEntity;
    }
    /**
     * Convert Base (BaseInterface) to array.
     *
     * @param  BaseInterface $base
     * @return array
     */
    public function toArray(BaseInterface $base)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->extract($base);
    }
    /**
     * Convert array to Base (BaseInterface).
     *
     * @param  array $array
     * @return BaseInterface
     */    
    public function toEntity($array)
    {
        $hydrator = new DoctrineHydrator($this->entityManager);
        return $hydrator->hydrate($array, $this->baseEntity);
    }
    /**
     * Add new base.
     *
     * @param  BaseInterface $base
     * @return int
     */
    public function add(BaseInterface $base)
    {
        $base->setStatus(
            $this->entityManager->getReference(
                get_class($this->statusEntity),
                $this::BASE_READY
            )
        );
        $this->entityManager->persist($base);
        $this->entityManager->flush();
        return $base->getId();
    }
    /**
     * Edit base.
     *
     * @param BaseInterface $base
     * @return int
     */
    public function edit(BaseInterface $base)
    {
        $base->setStatus(
            $this->entityManager->getReference(
                get_class($this->statusEntity),
                $this::BASE_READY
            )
        );
        $this->entityManager->persist($base);
        $this->entityManager->flush();
        return $base->getId();
    }
    /**
     * Delete base by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(get_class($this->baseEntity))->createQueryBuilder('p')
            ->delete(get_class($this->baseEntity), 'p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        return 0;
    }
    /**
     * Get base by id.
     *
     * @param  int $id
     * @return Base
     * @throws SmsException
     */
    public function getById($id)
    {
        $base = $this->entityManager->getRepository(
            get_class($this->baseEntity)
        )->findBy(array('id' => $id));
        if (empty($base)) {
            throw new SmsException(_('Base not found'));
        }
        return $base[0];
    }
    /**
     * Get base list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getBaseList($page, $userId)
    {
        $limit = 10;
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;

        $baseList = $this->entityManager->getRepository(get_class($this->baseEntity))->createQueryBuilder('b')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getQuery();
        
        if (empty($baseList->getResult())) {
            return 0;
        }

        $paginator = new Paginator($baseList);
        return $paginator;
    }
    /**
     * Set base status by id.
     *
     * @param BaseInterface $base
     * @param int $newStatus
     * @return int
     */
    public function setBaseStatus(BaseInterface $base, $newStatus)
    {
        $base->setStatus(
            $this->entityManager->getReference(
                get_class($this->statusEntity),
                $newStatus
            )
        );
        $this->entityManager->persist($base);
        $this->entityManager->flush();
    }
    /**
     * Set base params.
     *
     * @param BaseInterface $base
     * @param array $params
     * @return int
     */
    public function setBaseParams(BaseInterface $base, $params)
    {
        if ($params[1]) {
            $base->setParamName1($params[1]);
        }
        if ($params[2]) {
            $base->setParamName2($params[2]);
        }
        if ($params[3]) {
            $base->setParamName3($params[3]);
        }
        if ($params[4]) {
            $base->setParamName4($params[4]);
        }
        $this->entityManager->persist($base);
        $this->entityManager->flush();
    }
    /**
     * Get base params.
     *
     * @param BaseInterface $base
     * @param array $params
     * @return int
     */
    public function getBaseParams(BaseInterface $base)
    {
        $params[] = 'number';
        $params[] = $base->getParamName1();
        $params[] = $base->getParamName2();
        $params[] = $base->getParamName3();
        $params[] = $base->getParamName4();
        return $params;
    }
    /**
     * Check base by name.
     *
     * @param string $name
     * @param int $userId
     * @return int
     */
    public function getIdByName($name, $userId)
    {
        $base = $this->entityManager->getRepository(
            get_class($this->baseEntity)
        )->findBy(array('user_id' => $userId, 'name' => $name)); 
        if (empty($base)) { #if base with this name is not exist - return 0
            return 0;
        } else {
            return $base[0]->getId();
        }
    }
    /**
     * Get count bases by User.
     *
     * @param int $userId
     * @return int
     */
    public function getBasesCount($userId)
    {
        $count = $this->entityManager->getRepository(get_class($this->baseEntity))->createQueryBuilder('b')
               ->select('count(b.id)')
                ->where('b.user_id = :user_id')
                ->setParameter('user_id', $userId)
                ->getQuery()->getSingleScalarResult();
        return $count;
    }
}

