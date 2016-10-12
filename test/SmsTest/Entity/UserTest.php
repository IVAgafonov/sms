<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SmsTest\Entity;

use Sms\Entity\User;

class UserTest extends \PHPUnit_Framework_TestCase {
    public function testInitial() {
        $user = new User();
        $this->assertNull($user->getId());
        $this->assertNull($user->getUsername());
        $this->assertNull($user->getEmail());
        $this->assertNull($user->getDisplayName());
        $this->assertNull($user->getPassword());
        $this->assertNull($user->getState());        
        $this->assertNull($user->getSendCost());
        $this->assertNull($user->getBalance());
        $this->assertNull($user->getCredit());
        $this->assertNull($user->getSendFlag());        
        $this->assertEmpty($user->getRoles()); 
        $this->assertNull($user->getNaming());
    }
}

