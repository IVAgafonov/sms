<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Form;


use Sms\Entity\BaseInterface;
use Sms\Entity\MessageInterface;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Doctrine\ORM\EntityManager;

class SendForm extends Form implements InputFilterProviderInterface
{
    private $em;
    private $baseEntity;
    private $messageEntity;
    private $user_id;

    public function __construct(EntityManager $em, BaseInterface $baseEntity, MessageInterface $messageEntity, $user_id)
    {
        parent::__construct('sendForm');
        $this->em = $em;
        $this->baseEntity = $baseEntity;
        $this->messageEntity = $messageEntity;
        $this->user_id = $user_id;
        $this->init();
    }

    public function init()
    {
        $this->setAttribute('action', '/service/send/add');
        $this->setAttribute('method', 'post');
        
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
                'name' => 'base_id',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => _('Select base'),
                    'object_manager' => $this->em,
                    'target_class' => get_class($this->baseEntity),
                    'property' => 'name',
                    'find_method' => array(
                        'name' => 'findBy',
                        'params' => array(
                            'criteria' => array('user_id' => $this->user_id, 'status' => array(1, 4, 6))
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
                'name' => 'message_id',
                'type' => 'DoctrineModule\Form\Element\ObjectSelect',
                'options' => array(
                    'label' => _('Select message'),
                    'object_manager' => $this->em,
                    'target_class' => get_class($this->messageEntity),
                    'property' => 'title',
                    'find_method' => array(
                        'name' => 'findBy',
                        'params' => array(
                            'criteria' => array('user_id' => $this->user_id)
                        ),
                    ),
                ),
                'attributes' => array(
                    'class' => 'messageSelect'
                )
            )
        );

        $this->add(
            array(
                'name' => 'start_time',
                'attributes' => array(
                    'type' => 'Zend\Form\Element\DateTime',
                    'class' => 'timestart',
                    'id' => 'datetimepicker',
                    'min' => '2010-01-01T00:00:00Z',
                    'max' => '2020-01-01T00:00:00Z',
                    'step' => '5'
                ),
                'options' => array (
                    'label' => _('Start time'),
                    'format' => 'Y-m-d\TH:iP'
                ),
            )
        );

        $this->add(
            array(
                'name' => 'submit',
                'attributes' => array(
                    'type' => 'submit',
                    'value' => _('send')
                )
            )
        );
    }

    public function getInputFilterSpecification()
    {
        return array();
    
        return array(
            'base_select' => array(
                'required' => true,
            ),
            'message_select' => array(
                'required' => true,
            ),
            'time_start' => array(
                'required' => true,
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
        );
    }
}

