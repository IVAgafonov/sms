<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


interface ExportProcessInterface
{
    /**
    * Get id.
    *
    * @return int
    */
    public function getId();
    /**
    * Set id.
    *
    * @param int $id
    *
    * @return void
    */
    public function setId($id);
    /**
    * Get base id.
    *
    * @return int
    */
    public function getBaseId();
    /**
    * Set base id.
    *
    * @param int $base_id
    *
    * @return void
    */
    public function setBaseId($base_id);
    /**
    * Get iteration.
    *
    * @return int
    */
    public function getIteration();
    /**
    * Set iteration.
    *
    * @param int $iteration
    *
    * @return void
    */
    public function setIteration($iteration);
    /**
    * Get time_stamp.
    *
    * @return DateTime
    */
    public function getTimeStamp();
    /**
    * Set id.
    *
    * @param DateTime $time_stamp
    *
    * @return void
    */
    public function setTimeStamp($time_stamp);
    /**
    * Get export id.
    *
    * @return int
    */
    public function getExportId();
    /**
    * Set export id.
    *
    * @param int $export_id
    *
    * @return void
    */
    public function setExportId($export_id);
    /**
    * Get executed.
    *
    * @return int
    */
    public function getExecuted();
    /**
    * Set executed.
    *
    * @param int $executed
    *
    * @return void
    */
    public function setExecuted($executed);
}

