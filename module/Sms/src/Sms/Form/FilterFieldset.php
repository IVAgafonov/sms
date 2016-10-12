<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;

class FilterFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('Filter');
        $this->add(
            array(
                'name' => 'filter',
                'attributes' => array(
                    'type' => 'text',
                    'placeHolder' => _('Filter')
                ),
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'filter' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                    array(
                        'name' => 'StripTags'
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 30,
                        ),
                    ),
                ),
            ),
        );
    }
}

