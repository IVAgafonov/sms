<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */


namespace Sms\Strategy;

interface ShardingStrategyInterface
{
    /**
     * Get entity manager by user id.
     *
     * @param  int $userId
     * @return int
     * @throws MapperException
     */
    public function getEmIdByUserId($userId);
}