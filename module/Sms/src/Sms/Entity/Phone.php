<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="phone", indexes={@ORM\Index(name="search_idx", columns={"base_id"})})
 * 
 */
class Phone implements PhoneInterface
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
     * @var string
     * @ORM\Column(type="string", name="number", length=255)
     */
    protected $number;
    /**
     * @var string
     * @ORM\Column(type="string", name="value1", length=255, nullable=true)
     */
    protected $value1;
    /**
     * @var string
     * @ORM\Column(type="string", name="value2", length=255, nullable=true)
     */
    protected $value2;
    /**
     * @var string
     * @ORM\Column(type="string", name="value3", length=255, nullable=true)
     */
    protected $value3;
    /**
     * @var string
     * @ORM\Column(type="string", name="value4", length=255, nullable=true)
     */
    protected $value4;
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
    * Get base_id.
    *
    * @return int
    */
    public function getBaseId()
    {
        return $this->base_id;
    }
    /**
    * Set base_id.
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
    * Get number.
    *
    * @return string
    */
    public function getNumber()
    {
        return $this->number;
    }
    /**
    * Set number.
    *
    * @param string $number
    *
    * @return void
    */
    public function setNumber($number)
    {
        $this->number = $number;
    }
    /**
    * Get value1.
    *
    * @return string
    */
    public function getValue1()
    {
        return $this->value1;
    }
    /**
    * Set value1.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue1($value)
    {
        $this->value1 = $value;
    }
    /**
    * Get value2.
    *
    * @return string
    */
    public function getValue2()
    {
        return $this->value2;
    }
    /**
    * Set value2.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue2($value)
    {
        $this->value2 = $value;
    }
    /**
    * Get value3.
    *
    * @return string
    */
    public function getValue3()
    {
        return $this->value3;
    }
    /**
    * Set value3.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue3($value)
    {
        $this->value3 = $value;
    }
    /**
    * Get value4.
    *
    * @return string
    */
    public function getValue4()
    {
        return $this->value4;
    }
    /**
    * Set value4.
    *
    * @param string $value
    *
    * @return void
    */
    public function setValue4($value)
    {
        $this->value4 = $value;
    }
    /**
    * Get int.
    *
    * @return string
    */
    public function getStatus()
    {
        return $this->status;
    }
    /**
    * Set status.
    *
    * @param string $status
    *
    * @return void
    */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}

