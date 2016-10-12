<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;

use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Fieldset;

class PhoneFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('Phone');
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
                'name' => 'number',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Pnone number')
                )
            )
        );

        $this->add(
            array(
                'name' => 'value1',
                'attributes' => array(
                    'type' => 'text',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'value2',
                'attributes' => array(
                    'type' => 'text',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'value3',
                'attributes' => array(
                    'type' => 'text',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'value4',
                'attributes' => array(
                    'type' => 'text',
                ),
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
            'number' => array(
                'requierd' => true,
                'filters' => array(
                    array(
                        'name' => 'Digits'
                    ),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty'
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => 11,
                            'max' => 11,
                            'messages' => array(
                                'stringLengthTooShort' => _('Number must contain 11 digits'),
                                'stringLengthTooLong' => _('Number must contain 11 digits')
                            ),
                        ),
                    ),
                )
            ),
            'value1' => array(
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
            'value2' => array(
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
                    )
                ),
            ),
            'value3' => array(
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
                    )
                ),
            ),
            'value4' => array(
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
                    )
                ),
            ),
        );
    }
}

