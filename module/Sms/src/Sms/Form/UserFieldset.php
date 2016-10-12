<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;

class UserFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('User');

        $this->add(
            array(
                'name' => 'user_id',
                'attributes' => array(
                    'type' => 'hidden',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'send_cost',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Cost of send'),
                )
            )
        );

        $this->add(
            array(
                'name' => 'balance',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Balance')
                )
            )
        );

        $this->add(
            array(
                'name' => 'naming',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Naming')
                )
            )
        );

        $this->add(
            array(
                'name' => 'send_flag',
                'type' => 'Zend\Form\Element\Checkbox',
                'attributes' => array(
                    'class' => 'chbox',
                    'label' => _('User can send sms'),
                ),
                'label' => _('User can send sms'),
                'options' => array (
                    'label' => _('User can send sms'),
                    'use_hidden_element' => true,
                    'checked_value' => 1,
                    'unchecked_value' => 0
                )
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'user_id' => array(
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
            'send_cost' => array(
                'requierd' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty'
                    ),
                    array(
                        'name' => 'Float',
                        'options' => array(
                                    'min' => 0,
                        ),
                    ),
                )
            ),
            'balance' => array(
                'requierd' => true,
                'validators' => array(
                    array(
                        'name' => 'NotEmpty'
                    ),
                    array(
                        'name' => 'Float',
                        'options' => array(
                                    'min' => 0,
                        ),
                    ),
                )
            ),
            'naming' => array(
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
                            'max' => 11,
                        ),
                    ),
                ),
            ),
            'send_flag' => array(
                'required' => false,
            ),
        );
    }
}

