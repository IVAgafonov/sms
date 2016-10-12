<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\BaseInterface;

interface BaseMapperInterface
{
    /**
     * Convert Base (BaseInterface) to array.
     *
     * @param  BaseInterface $base
     * @return array
     */
    public function toArray(BaseInterface $base);
    /**
     * Convert array to Base (BaseInterface).
     *
     * @param  array $array
     * @return BaseInterface
     */    
    public function toEntity($array);
    /**
     * Add new base.
     *
     * @param  BaseInterface $base
     * @return int
     */
    public function add(BaseInterface $base);
    /**
     * Edit base.
     *
     * @param BaseInterface $base
     * @return int
     */
    public function edit(BaseInterface $base);
    /**
     * Delete base by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id);
    /**
     * Get base by id.
     *
     * @param  int $id
     * @return BaseInterface
     * @throws SmsException
     */
    public function getById($id);
    /**
     * Get base list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     * @throws MapperException
     */
    public function getBaseList($page, $userId);
    /**
     * Set base status by id.
     *
     * @params BaseInterface $base
     * @params int $status
     * @return int
     */
    public function setBaseStatus(BaseInterface $base, $newStatus);
    /**
     * Set base params.
     *
     * @param BaseInterface $base
     * @param array $params
     * @return int
     */
    public function setBaseParams(BaseInterface $base, $params);
    /**
     * Set base params.
     *
     * @param BaseInterface $base
     * @return array
     */
    public function getBaseParams(BaseInterface $base);
    /**
     * Check base by name.
     *
     * @params string $name
     * @params int $userId
     * @return int
     */
    public function getIdByName($name, $userId);
    /**
     * Get count bases by User.
     *
     * @params int $userId
     * @return int
     */
    public function getBasesCount($userId);
}

