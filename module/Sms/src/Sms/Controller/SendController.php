<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Sms\Facade\SendFacadeInterface;
use Sms\Factory\Form\FormFactoryInterface;
use Sms\Exception\SmsException;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class SendController extends AbstractActionController
{
    private $user;
    private $sendFacade;
    private $formFactory;

    public function __construct(
        $user,
        SendFacadeInterface $sendFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->user = $user;
        $this->sendFacade = $sendFacade;
        $this->formFactory = $formFactory;
    }

    public function indexAction()
    {
        $page = $this->params()->fromRoute('id', 1);
        try {
            $sendList = $this->sendFacade->getList($page);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-send');
        }
        return new ViewModel(array('sendList' => $sendList, 'page' => $page));
    }
    
    public function addAction()
    {
        $sendForm = $this->formFactory->createAddSendForm();
        if ($this->request->isPost()) {
            $sendForm->setData($this->request->getPost());
            if (!$sendForm->isValid()) {
                return new ViewModel(array('form' => $sendForm));
            }
            $sendArray = $sendForm->getData();
            $minDate = $this->sendFacade->checkDate($sendArray);
            if ($minDate) {
                $sendForm->get('start_time')->setMessages(
                    array(
                        _("Minimum sending time - ")
                    )
                );
                return new ViewModel(array('form' => $sendForm, 'min_time' => $minDate->format("Y-m-d H:i")));
            }
            $count = $this->sendFacade->checkNumbers($sendArray);
            if (!$count) {
                $sendForm->get('base_id')->setMessages(
                    array(
                        _("Can't find phone numbers in this base")
                    )
                );
                return new ViewModel(array('form' => $sendForm));
            }
            try {
                $this->sendFacade->add($sendArray);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-send');
            }
            $this->flashMessenger()->addSuccessMessage(_('Delivery successfully added'));
            return $this->redirect()->toRoute('sms-send');            
        }
        return new ViewModel(array('form' => $sendForm));
    }

    public function editAction()
    {
        $sendId = $this->params()->fromRoute('id', 0);
        $sendForm = $this->formFactory->createEditSendForm();
        if ($this->request->isPost()) {
            $sendForm->setData($this->request->getPost());
            if (!$sendForm->isValid()) {
                return new ViewModel(array('form' => $sendForm));
            }
            $sendArray = $sendForm->getData();
            $sendId = $sendArray['id'];
            try {
                #check send record by user and locked
                $checkArray = $this->sendFacade->getById($sendId);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-send');
            }
            $minDate = $this->sendFacade->checkDate($sendArray);
            if ($minDate) {
                $sendForm->get('start_time')->setMessages(
                    array(
                        _("Minimum sending time - ")
                    )
                );
                return new ViewModel(array('form' => $sendForm, 'min_time' => $minDate->format("Y-m-d H:i")));
            }
            $count = $this->sendFacade->checkNumbers($sendArray);
            if (!$count) {
                $sendForm->get('base_id')->setMessages(
                    array(
                        _("Can't find phone numbers in this base")
                    )
                );
                return new ViewModel(array('form' => $sendForm));
            }
            try {
                $sendArray['user_id'] = $checkArray['user_id'];
                $this->sendFacade->edit($sendArray);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-send');
            }
            $this->flashMessenger()->addSuccessMessage(_('Delivery successfully edited'));
            return $this->redirect()->toRoute('sms-send'); 
        }
        try {
            $sendArray = $this->sendFacade->getById($sendId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-send');
        }
        $sendForm->setData($sendArray);
        return new ViewModel(array('form' => $sendForm));
    }

    public function deleteAction()
    {
        $sendId = $this->params()->fromRoute('id', 0);
        try {
            $this->sendFacade->delete($sendId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-send');
        }
        $this->flashMessenger()->addSuccessMessage(_('Delivery successfully deleted'));
        return $this->redirect()->toRoute('sms-send'); 
    }
}

