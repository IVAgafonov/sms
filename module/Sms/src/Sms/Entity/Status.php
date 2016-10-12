<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Status entity
 *
 * @ORM\Entity
 * @ORM\Table(name="status")
 *
 */
class Status implements StatusInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column(type="string", name="name", length=255)
     */
    protected $name;
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
}

