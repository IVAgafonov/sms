<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\Form\Form;

class MsgForm extends Form
{
    public function __construct()
    {
        parent::__construct('messageForm');
        $this->setAttribute('action', '/service/messages/add');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'Sms\Form\MsgFieldset',
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
                    'value' => 'Add'
                )
            )
        );
    }
}

