<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * User entity.
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 *
 */
class User implements UserInterface, ProviderInterface
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $user_id;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true, nullable=true)
     */
    protected $username;
    /**
     * @var string
     * @ORM\Column(type="string", unique=true,  length=255)
     */
    protected $email;
    /**
     * @var string
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $display_name;
    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $password;
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $state;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $send_cost;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $balance;
    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $credit;
    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */    
    protected $naming;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $send_flag;
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Sms\Entity\Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
    /**
     * Initializes the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
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
    public function setId($user_id)
    {
        $this->user_id = (int)$user_id;
    }
    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    /**
     * Set username.
     *
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Set email.
     *
     * @param string $email
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * Get displayName.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }
    /**
     * Set display_name.
     *
     * @param string $display_name
     *
     * @return void
     */
    public function setDisplayName($display_name)
    {
        $this->display_name = $display_name;
    }
    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password.
     *
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    /**
     * Get state.
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }
    /**
     * Set state.
     *
     * @param int $state
     *
     * @return void
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    /**
     * Get send_cost.
     *
     * @return float
     */
    public function getSendCost()
    {
        return $this->send_cost;
    }
    /**
     * Set state.
     *
     * @param int $send_cost
     *
     * @return void
     */
    public function setSendCost($send_cost)
    {
        $this->send_cost = $send_cost;
    }
    /**
     * Get balance.
     *
     * @return int
     */
    public function getBalance()
    {
        return $this->balance;
    }
    /**
     * Set state.
     *
     * @param int $balance
     *
     * @return void
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }
    /**
     * Get credit.
     *
     * @return int
     */
    public function getCredit()
    {
        return $this->credit;
    }
    /**
     * Set credit.
     *
     * @param int $credit
     *
     * @return void
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }
    /**
     * Get send flag.
     *
     * @return int
     */
    public function getSendFlag()
    {
        return $this->send_flag;
    }
    /**
     * Set send flag.
     *
     * @param int $send_flag
     *
     * @return void
     */
    public function setSendFlag($send_flag)
    {
        $this->send_flag = $send_flag;
    }
    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }
    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }
    /**
     * Get naming.
     *
     * @return string
     */
    public function getNaming()
    {
        return $this->naming;
    }
    /**
     * Set naming.
     *
     * @param string $naming
     *
     * @return void
     */
    public function setNaming($naming)
    {
        $this->naming = $naming;
    }
}

