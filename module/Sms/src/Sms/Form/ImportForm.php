<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;


use Sms\Entity\Base;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\ORM\EntityManager;

class ImportForm extends Form implements InputFilterProviderInterface
{
    private $em;
    private $baseEntity;
    private $user_id;

    public function __construct(EntityManager $em, Base $baseEntity, $user_id)
    {
        parent::__construct('importForm');
        $this->em = $em;
        $this->baseEntity = $baseEntity;
        $this->user_id = $user_id;
        $this->init();
    }

    public function init()
    {
        $this->setAttribute('action', '/service/import/import');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

        $this->add(
            array(
                'name' => 'base_select',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => _('Select base'),
                    'empty_option' => _('Import in new base'),
                    'empty_value' => 0,
                    'object_manager' => $this->em,
                    'target_class' => get_class($this->baseEntity),
                    'property' => 'name',
                    'find_method' => array(
                        'name' => 'findBy',
                        'params' => array(
                            'criteria' => array('user_id' => $this->user_id, 'status' => 1)
                        ),
                    ),
                ),
                'attributes' => array(
                    'class' => 'baseSelect'
                )
            )
        );

        $this->add(
            array(
                'name' => 'base_name',
                'attributes' => array(
                    'type' => 'text',
                ),
                'options' => array (
                    'label' => _('Base name'),
                    'label_attributes' => array(
                        'class' => 'newBase',
                    )
                )
            )
        );

        $this->add(
            array(
                'name' => 'base_file',
                'attributes' => array(
                    'type' => 'file',
                    'class' => 'upload'
                ),
                'options' => array (
                    'label' => _('Base file (*.csv)')
                )
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => _('import')
                )
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array(
            'base_select' => array(
                'required' => false,
            ),
            'base_name' => array(
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
            'base_file' => array(
                'required' => true,
                'validators' => array(
                    array(
                        'name' => 'Zend\Validator\File\Extension',
                        'options' => array(
                            'extension' => 'csv',
                        )
                    ),
                )
            )
        );
    }
}

