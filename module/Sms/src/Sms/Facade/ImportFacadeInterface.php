<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface ImportFacadeInterface {
    /**
    * Prepare base to import.
    *
    * @param array $importArray
    * @return array
    */
    public function prepareBaseToImport($importArray);
    /**
    * Start import process.
    *
    * @param array $baseArray
    * @return array
    */
    public function import($baseArray);
    /**
    * Get import list.
    *
    * @param int $page
    * @return Paginator
    */
    public function getList($page);
    /**
    * Delete export file & export record.
    *
    * @param int $baseId
    */
    public function deleteExport($baseId);
}