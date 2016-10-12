<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\Form\Form;

class BaseForm extends Form
{
    public function __construct()
    {
        parent::__construct('baseForm');
        $this->setAttribute('action', '/service/base/add');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'Sms\Form\BaseFieldset',
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

