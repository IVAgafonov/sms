<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\ImportInterface;

interface ImportMapperInterface
{
    /**
     * Convert Import (ImportInterface) to array.
     *
     * @param  ImportInterface $import
     * @return array
     */
    public function toArray(ImportInterface $import);
    /**
     * Convert array to Import (ImportInterface).
     *
     * @param  array $array
     * @return ImportInterface
     */    
    public function toEntity($array);
    /**
     * Add new import.
     *
     * @param  ImportInterface $import
     * @return int
     */
    public function add(ImportInterface $import);
    /**
     * Edit import.
     *
     * @param ImportInterface $import
     * @return int
     */
    public function edit(ImportInterface $import);
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
     * Get import list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     * @throws MapperException
     */
    //public function getImportList($page, $userId);
    /**
     * Set base status by id.
     *
     * @params ImportInterface $import
     * @params int $status
     * @return int
     */
    //public function setImportStatus(ImportInterface $import, $newStatus);
}

