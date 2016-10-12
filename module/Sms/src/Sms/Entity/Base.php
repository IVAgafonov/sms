<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 *
 * Base entity
 * 
 * @ORM\Entity
 * @ORM\Table(name="base")
 *
 */
class Base implements BaseInterface
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
     * @ORM\Column(type="string", name="name", length=255)
     */
    protected $name;
    /**
     * @var string
     * @ORM\Column(type="string", name="param_value1", length=255, nullable=true)
     */
    protected $param_name1;
    /**
     * @var string
     * @ORM\Column(type="string", name="param_value2", length=255, nullable=true)
     */
    protected $param_name2;
    /**
     * @var string
     * @ORM\Column(type="string", name="param_value3", length=255, nullable=true)
     */
    protected $param_name3;
    /**
     * @var string
     * @ORM\Column(type="string", name="param_value4", length=255, nullable=true)
     */
    protected $param_name4;
    /**
     * @ORM\ManyToOne(targetEntity="\Sms\Entity\Status", cascade={"persist"}) 
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
    * Get user_id.
    *
    * @return int
    */
    public function getUserId()
    {
        return $this->user_id;
    }
    /**
    * Set user_id.
    *
    * @param int $user_id
    *
    * @return void
    */
    public function setUserId($user_id)
    {
        $this->user_id = (int)$user_id;
    }
    /**
    * Get name.
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }
    /**
    * Set name.
    *
    * @param string $name
    *
    * @return void
    */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
    * Get param_name1.
    *
    * @return string
    */
    public function getParamName1()
    {
        return $this->param_name1;
    }
    /**
    * Set param_name1.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName1($param_name)
    {
        $this->param_name1 = $param_name;
    }
    /**
    * Get param_name2.
    *
    * @return string
    */
    public function getParamName2()
    {
        return $this->param_name2;
    }
    /**
    * Set param_name2.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName2($param_name)
    {
        $this->param_name2 = $param_name;
    }
    /**
    * Get param_name3.
    *
    * @return string
    */
    public function getParamName3()
    {
        return $this->param_name3;
    }
    /**
    * Set param_name3.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName3($param_name)
    {
        $this->param_name3 = $param_name;
    }
    /**
    * Get param_name4.
    *
    * @return string
    */
    public function getParamName4()
    {
        return $this->param_name4;
    }
    /**
    * Set param_name4.
    *
    * @param string $param_name
    *
    * @return void
    */
    public function setParamName4($param_name)
    {
        $this->param_name4 = $param_name;
    }
    /**
    * Get status.
    *
    * @return \Sms\Entity\Status
    */
    public function getStatus()
    {
        return $this->status;
    }
    /**
    * Set status.
    *
    * @param \Sms\Entity\StatusInterface $status
    *
    * @return void
    */
    public function setStatus(\Sms\Entity\StatusInterface $status)
    {
        $this->status = $status;
    }
}

