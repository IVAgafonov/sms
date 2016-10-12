<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Import entity
 *
 * @ORM\Entity
 * @ORM\Table(name="import")
 *
 */
class Import implements ImportInterface
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
     * @ORM\Column(type="integer", name="imported")
     */
    protected $imported;
    /**
     * @var int
     * @ORM\Column(type="integer", name="fails")
     */
    protected $fails;
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
    * @param string $base_name
    *
    * @return void
    */
    public function setBaseName($base_name)
    {
        $this->base_name = $base_name;
    }
    /**
    * Get time stamp.
    *
    * @return DateTime
    */
    public function getTimeStamp()
    {
        return $this->time_stamp;
    }
    /**
    * Set time stamp.
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
    * Get imported counts.
    *
    * @return int
    */
    public function getImported()
    {
        return $this->imported;
    }
    /**
    * Set imported counts.
    *
    * @param int $imported
    *
    * @return void
    */
    public function setImported($imported)
    {
        $this->imported = $imported;
    }
    /**
    * Get fails counts.
    *
    * @return int
    */
    public function getFails()
    {
        return $this->fails;
    }
    /**
    * Set imported fails.
    *
    * @param int $fails
    *
    * @return void
    */
    public function setFails($fails)
    {
        $this->fails = $fails;
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

