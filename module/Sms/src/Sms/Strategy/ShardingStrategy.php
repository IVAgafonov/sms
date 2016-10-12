<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Strategy;


class ShardingStrategy
{
    /**
     * Get entity manager by user id.
     *
     * @param  int $userId
     * @return int
     * @throws MapperException
     */
    public function getEmIdByUserId($userId)
    {
        # shards count 
        $shards = 2; 
        # em id = userId % shards count 
        //return $userId % $shards; //in sharding mode
        return 0;
    }
}

