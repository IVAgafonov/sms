<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\Mapper;


use Sms\Entity\Base;
use Sms\Entity\Status;
use Sms\Mapper\BaseMapper;
use Sms\Entity\Message;
use Sms\Mapper\MessageMapper;
use Sms\Entity\Phone;
use Sms\Mapper\PhoneMapper;
use Sms\Entity\Import;
use Sms\Mapper\ImportMapper;
use Sms\Entity\Export;
use Sms\Mapper\ExportMapper;
use Sms\Entity\ImportProcess;
use Sms\Mapper\ImportProcessMapper;
use Sms\Entity\ExportProcess;
use Sms\Mapper\ExportProcessMapper;
use Sms\Entity\Send;
use Sms\Mapper\SendMapper;
use Sms\Entity\SendProcess;
use Sms\Mapper\SendProcessMapper;
use Sms\Entity\User;
use Sms\Mapper\UserMapper;

class MapperFactory implements MapperFactoryInterface
{
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function createBaseMapper()
    {
        return new BaseMapper($this->em, new Base(), new Status());
    }
    
    public function createMessageMapper()
    {
        return new MessageMapper($this->em, new Message());
    }
    
    public function createPhoneMapper()
    {
        return new PhoneMapper($this->em, new Phone());
    }
    
    public function createImportMapper()
    {
        return new ImportMapper($this->em, new Import());
    }
    
    public function createImportProcessMapper()
    {
        return new ImportProcessMapper($this->em, new ImportProcess());
    }
    
    public function createExportMapper()
    {
        return new ExportMapper($this->em, new Export());
    }
    
    public function createExportProcessMapper()
    {
        return new ExportProcessMapper($this->em, new ExportProcess());
    }
    
    public function createSendMapper()
    {
        return new SendMapper($this->em, new Send());
    }
    
    public function createSendProcessMapper()
    {
        return new SendProcessMapper($this->em, new SendProcess());
    }
    
    public function createUserMapper()
    {
        return new UserMapper($this->em, new User());
    }
}

