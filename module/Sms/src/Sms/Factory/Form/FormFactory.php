<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Factory\Form;


use Sms\Entity\Base;
use Sms\Entity\Message;
use Sms\Form\BaseForm;
use Sms\Form\MsgForm;
use Sms\Form\PhoneForm;
use Sms\Form\FilterForm;
use Sms\Form\ImportForm;
use Sms\Form\SendForm;
use Sms\Form\UserForm;

class FormFactory implements FormFactoryInterface
{
    protected $em;
    protected $userId;

    public function __construct($em, $userId)
    {
        $this->em = $em;
        $this->userId = $userId;
    }
    
    public function createUserEditForm()
    {
        return new UserForm();
    }
    
    public function createBaseAddForm()
    {
        return new BaseForm();
    }
    
    public function createBaseEditForm()
    {
        $baseForm = new BaseForm();
        $baseForm->get('submit')->setValue(_('Edit'));
        $baseForm->setAttribute('action', '/service/base/edit');
        return $baseForm;
    }
    
    public function createMessageAddForm()
    {
        return new MsgForm();
    }
    
    public function createMessageEditForm()
    {
        $msgForm = new MsgForm();
        $msgForm->get('submit')->setValue(_('Edit'));
        $msgForm->setAttribute('action', '/service/messages/edit');
        return $msgForm;
    }
    
    public function createPhoneAddForm($baseId)
    {
        $phoneForm = new PhoneForm();
        $phoneForm->setAttribute('action', '/service/phones/add/'.$baseId);  
        return $phoneForm;
    }
    
    public function createPhoneEditForm($phoneId)
    {
        $phoneForm = new PhoneForm();
        $phoneForm->get('submit')->setValue(_('Edit'));
        $phoneForm->setAttribute('action', '/service/phones/edit/'.$phoneId);
        return $phoneForm;
    }
    
    public function createPhoneFilterForm($baseId)
    {
        $phoneFilterForm = new FilterForm();
        $phoneFilterForm->setAttribute('action', '/service/phones/base/'.$baseId);
        return $phoneFilterForm;
    }
    
    public function createUserFilterForm()
    {
        $userFilterForm = new FilterForm();
        $userFilterForm->setAttribute('action', '/service/admin/index');
        return $userFilterForm;
    }
    
    public function createImportForm()
    {
        $importForm = new ImportForm($this->em, new Base(), $this->userId);
        return $importForm;
    }
    
    public function createAddSendForm()
    {
        $sendForm = new SendForm($this->em, new Base(), new Message(), $this->userId);
        return $sendForm;
    }
    
    public function createEditSendForm()
    {
        $sendForm = new SendForm($this->em, new Base(), new Message(), $this->userId);
        $sendForm->get('submit')->setValue(_('Edit'));
        $sendForm->setAttribute('action', '/service/send/edit');
        return $sendForm;
    }
}

