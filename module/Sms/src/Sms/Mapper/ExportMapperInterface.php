<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\ExportInterface;

interface ExportMapperInterface
{
 /**
     * Convert export (ExportInterface) to array.
     *
     * @param  ExportInterface $export
     * @return array
     */
    public function toArray(ExportInterface $export);
    /**
     * Convert array to Export (ExportInterface).
     *
     * @param  array $array
     * @return ExportInterface
     */    
    public function toEntity($array);
    /**
     * Add export record.
     *
     * @param  ExportInterface $export
     * @return int
     */
    public function add(ExportInterface $export);
    /**
     * Edit export.
     *
     * @param  ExportInterface $export
     * @return int
     */
    public function edit(ExportInterface $export);
    /**
     * Delete export by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id);
    /**
     * Get export by id.
     *
     * @param  int $id
     * @return ExportInterface
     * @throws SmsException
     */
    public function getById($id);
    /**
     * Get export by base id.
     *
     * @param  int $baseId
     * @return ExportInterface
     */   
    public function getByBaseId($baseId);
    /**
     * Get export list by page.
     *
     * @param  int $page
     * @param  int $userId
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getExportList($page, $userId);
}

