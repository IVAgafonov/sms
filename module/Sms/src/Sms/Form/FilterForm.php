<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\Form\Form;

class FilterForm extends Form
{
    public function __construct()
    {
        parent::__construct('filterForm');
        $this->setAttribute('action', '/service/phones/base');
        $this->setAttribute('method', 'post');

        $this->add(
            array(
                'type' => 'Sms\Form\FilterFieldset',
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
                    'value' => _('Find')
                )
            )
        );
    }
}

