<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Mapper;


use Sms\Entity\UserInterface;

interface UserMapperInterface
{
    /**
     * Convert User (UserInterface) to array.
     *
     * @param  UserInterface $user
     * @return array
     */
    public function toArray(UserInterface $user);
    /**
     * Convert array to User (UserInterface).
     *
     * @param  array $array
     * @return UserInterface
     */    
    public function toEntity($array);
    /**
     * Add user.
     *
     * @param  UserInterface $user
     * @return int
     */
    public function add(UserInterface $user);
    /**
     * Edit user.
     *
     * @param  UserInterface $user
     * @return int
     */
    public function edit(UserInterface $user);
    /**
     * Delete user by id.
     *
     * @param  int $id
     * @return int
     */
    public function delete($id);
    /**
     * Get user by id.
     *
     * @param  int $id
     * @return UserInterface
     */
    public function getById($id);
    /**
     * Get list of users by page.
     *
     * @param  int $page
     * @return Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getUserList($page, $filter);
}

