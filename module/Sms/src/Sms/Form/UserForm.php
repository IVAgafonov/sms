<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct()
    {
        parent::__construct('userForm');
        $this->setAttribute('action', '/service/admin/edit');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'Sms\Form\UserFieldset',
                'options' => array(
                    'use_as_base_fieldset' => true,
                )
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => _('Edit')
                )
            )
        );
    }
}

