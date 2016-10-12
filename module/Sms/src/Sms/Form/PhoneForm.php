<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\Form\Form;

class PhoneForm extends Form
{
    public function __construct()
    {
        parent::__construct('phoneForm');
        $this->setAttribute('action', '/service/phones/add');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'Sms\Form\PhoneFieldset',
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
                    'value' => _('Add')
                )
            )
        );
    }
}

