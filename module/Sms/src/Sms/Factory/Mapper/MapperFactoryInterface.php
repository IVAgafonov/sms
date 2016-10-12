<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\Mapper;


interface MapperFactoryInterface
{

    public function createBaseMapper();
    
    public function createMessageMapper();
    
    public function createPhoneMapper();
    
    public function createImportMapper();
    
    public function createImportProcessMapper();
    
    public function createExportMapper();
    
    public function createExportProcessMapper();
    
    public function createSendMapper();
    
    public function createSendProcessMapper();
    
    public function createUserMapper();
}