<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface AdminFacadeInterface {
    /**
    * Get User array by userId.
    *
    * @param int $userId
    * @return array
    */
    public function getUserById($userId);
    /**
    * Get user list (Paginator) by page & filter.
    *
    * @param int    $page
    * @param string $filter
    * @return Paginator
    */
    public function getUserList($page, $filter);
    /**
    * Get get user's send list (Paginator) by page & userId.
    *
    * @param int    $page
    * @param int    $userId
    * @return Paginator
    */
    public function getUserSendList($page, $userId);
    /**
    * Edit User.
    *
    * @param array    $array
    * @return int
    */
    public function editUser($array);
    /**
    * Force delete active delivery.
    *
    * @param int    $sendId
    * @return int
    */
    public function deleteSend($sendId);
    /**
    * Download user's base.
    *
    * @param int    $baseId
    * @return int
    */
    public function downloadUserBase($baseId);
}