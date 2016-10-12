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
 * @ORM\Table(name="send_process")
 *
 */
class SendProcess implements SendProcessInterface
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
     * @ORM\Column(type="integer", name="send_id")
     */
    protected $send_id;
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
    * Get send id.
    *
    * @return int
    */
    public function getSendId()
    {
        return $this->send_id;
    }
    /**
    * Set send id.
    *
    * @param int $send_id
    *
    * @return void
    */
    public function setSendId($send_id)
    {
        $this->send_id = $send_id;
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

