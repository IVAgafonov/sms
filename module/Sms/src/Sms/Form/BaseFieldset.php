<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;

class BaseFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('Base');

        $this->add(
            array(
                'name' => 'id',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'name',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Base name'),
                )
            )
        );

        $this->add(
            array(
                'name' => 'param_name1',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Param name')
                )
            )
        );

        $this->add(
            array(
                'name' => 'param_name2',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Param name')
                )
            )
        );

        $this->add(
            array(
                'name' => 'param_name3',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Param name')
                )
            )
        );

        $this->add(
            array(
                'name' => 'param_name4',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Param name')
                )
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'id' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim',
                    ),
                    array(
                        'name' => 'StripTags'
                    ),
                ),
            ),
            'name' => array(
                'requierd' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags'
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty'
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 1,
                            'max' => 30,
                        ),
                    ),
                )
            ),
            'param_name1' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
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
            'param_name2' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
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
            'param_name3' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
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
            'param_name4' => array(
                'required' => false,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
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

