<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface BaseFacadeInterface {
    /**
    * Add new Base.
    *
    * @param array  $array
    * @return int
    */
    public function add($array);
    /**
    * Edit Base.
    *
    * @param array  $array
    * @return int
    */
    public function edit($array);
    /**
    * Delete Base by id.
    *
    * @param int  $id
    */
    public function delete($id);
    /**
    * Get base list by page.
    *
    * @param int  $page
    * @return Paginator
    */
    public function getList($page);
    /**
    * Get base array by id.
    *
    * @param int  $id
    * @return array
    */
    public function getById($id);
    /**
    * Export base by id.
    *
    * @param int  $baseId
    */
    public function export($baseId);
    /**
    * Get export list.
    *
    * @param int  $page
    * @return Paginator
    */
    public function getExportList($page);
    /**
    * Download exported file.
    *
    * @param int  $exportId
    * @return Response
    */
    public function download($exportId);
    /**
    * Delete export record.
    *
    * @param int  $baseId
    * @return Response
    */
    public function deleteExport($baseId);
}

