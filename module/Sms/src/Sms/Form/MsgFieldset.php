<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;

class MsgFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('Msg');
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
                'name' => 'title',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Message name')
                )
            )
        );

        $this->add(
            array(
                'name' => 'text',
                'attributes' => array(
                    'type' => 'textarea',
                    'class' => 'msgarea'
                ),
                'options' => array (
                    'label' => _('Message text')
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
                        'name' => 'StripTags',
                    ),
                ),
            ),
            'title' => array(
                'requierd' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags',
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
                ),
            ),
            'text' => array(
                'required' => true,
                'filters' => array(
                    array(
                        'name' => 'StringTrim'
                    ),
                    array(
                        'name' => 'StripTags',
                    ),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 500,
                        ),
                    ),
                ),
            ),
        );
    }
}

