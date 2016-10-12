<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 *
 * Export process entity
 *
 * @ORM\Entity
 * @ORM\Table(name="export_process")
 *
 */
class ExportProcess implements ExportProcessInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var int
     * @ORM\Column(type="integer", name="base_id")
     */
    protected $base_id;
    /**
     * @var int
     * @ORM\Column(type="integer", name="iteration")
     */
    protected $iteration;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="time_stamp")
     */
    protected $time_stamp;
    /**
     * @var int
     * @ORM\Column(type="integer", name="export_id")
     */
    protected $export_id;
    /**
     * @var int
     * @ORM\Column(type="integer", name="executed")
     */
    protected $executed;
    /**
    * Get id.
    *
    * @return int
    */
    public function getId()
    {
        return $this->id;
    }
    /**
    * Set id.
    *
    * @param int $id
    *
    * @return void
    */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
    * Get base id.
    *
    * @return int
    */
    public function getBaseId()
    {
        return $this->base_id;
    }
    /**
    * Set base id.
    *
    * @param int $base_id
    *
    * @return void
    */
    public function setBaseId($base_id)
    {
        $this->base_id = $base_id;
    }
    /**
    * Get iteration.
    *
    * @return int
    */
    public function getIteration()
    {
        return $this->iteration;
    }
    /**
    * Set iteration.
    *
    * @param int $iteration
    *
    * @return void
    */
    public function setIteration($iteration)
    {
        $this->iteration = $iteration;
    }
    /**
    * Get time_stamp.
    *
    * @return DateTime
    */
    public function getTimeStamp()
    {
        $this->time_stamp;
    }
    /**
    * Set id.
    *
    * @param DateTime $time_stamp
    *
    * @return void
    */
    public function setTimeStamp($time_stamp)
    {
        $this->time_stamp = $time_stamp;
    }
    /**
    * Get export id.
    *
    * @return int
    */
    public function getExportId()
    {
        return $this->export_id;
    }
    /**
    * Set export id.
    *
    * @param int $export_id
    *
    * @return void
    */
    public function setExportId($export_id)
    {
        $this->export_id = $export_id;
    }
    /**
    * Get executed.
    *
    * @return int
    */
    public function getExecuted()
    {
        return $this->executed;
    }
    /**
    * Set executed.
    *
    * @param int $executed
    *
    * @return void
    */
    public function setExecuted($executed)
    {
        $this->executed = $executed;
    }
}

