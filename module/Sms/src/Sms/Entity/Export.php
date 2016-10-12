<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 *
 * Export entity
 *
 * @ORM\Entity
 * @ORM\Table(name="export")
 *
 */
class Export implements ExportInterface
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
     * @ORM\Column(type="integer", name="user_id")
     */
    protected $user_id;
    /**
     * @var int
     * @ORM\Column(type="integer", name="base_id")
     */
    protected $base_id;
    /**
     * @var string
     * @ORM\Column(type="string", name="base_name", length=255)
     */
    protected $base_name;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="time_stamp")
     */
    protected $time_stamp;
    /**
     * @var int
     * @ORM\Column(type="integer", name="status")
     */
    protected $status;
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
    * Get user id.
    *
    * @return int
    */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
    * Set user id.
    *
    * @param int $user_id
    *
    * @return void
    */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
    * Get base name.
    *
    * @return string
    */
    public function getBaseName()
    {
        return $this->base_name;
    }
    /**
    * Set base name.
    *
    * @param string $file_name
    *
    * @return void
    */
    public function setBaseName($base_name)
    {
        $this->base_name = $base_name;
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
    * Get status.
    *
    * @return int
    */
    public function getStatus()
    {
        return $this->status;
    }
    /**
    * Set status.
    *
    * @param int $status
    *
    * @return void
    */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}

