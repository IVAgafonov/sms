<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\Form;


interface FormFactoryInterface
{
    public function createUserEditForm();
    
    public function createBaseAddForm();
    
    public function createBaseEditForm();
    
    public function createMessageAddForm();
    
    public function createMessageEditForm();
    
    public function createPhoneAddForm($baseId);
    
    public function createPhoneEditForm($phoneId);
    
    public function createPhoneFilterForm($baseId);
    
    public function createUserFilterForm();
    
    public function createImportForm();
    
    public function createAddSendForm();
    
    public function createEditSendForm();
}

