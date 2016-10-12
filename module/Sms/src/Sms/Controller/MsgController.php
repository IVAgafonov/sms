<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;

use Sms\Facade\MessageFacadeInterface;
use Sms\Factory\Form\FormFactoryInterface;
use Zend\View\Model\ViewModel;
use Sms\Exception\SmsException;
use Zend\Mvc\Controller\AbstractActionController;

class MsgController extends AbstractActionController
{
    private $user;
    private $messageFacade;
    private $formFactory;

    public function __construct(
        $user,
        MessageFacadeInterface $messageFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->user = $user;
        $this->messageFacade = $messageFacade;
        $this->formFactory = $formFactory;
    }

    public function indexAction()
    {
        $page = $this->params()->fromRoute('id', 1);
        try {
            $msgList = $this->messageFacade->getList($page);
        } catch (SmsException $ex) {
            return new ViewModel(array('emptyMessage' => $ex->getMessage()));
        }
        return new ViewModel(array('msgList' => $msgList, 'page' => $page));
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $messageForm = $this->formFactory->createMessageAddForm();
            $messageForm->setData($this->request->getPost());
            if (!$messageForm->isValid()) {
                return new ViewModel(array('form' => $messageForm));
            }
            $messageArray = $messageForm->getData();
            try {
                $this->messageFacade->add($messageArray['Msg']);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-msg');
            }
            $this->flashMessenger()->addSuccessMessage(_('Message successfully added'));
            return $this->redirect()->toRoute('sms-msg');
        }
        return new ViewModel(array('form' => $this->formFactory->createMessageAddForm()));
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $messageForm = $this->formFactory->createMessageEditForm();
            $messageForm->setData($this->request->getPost());
            if (!$messageForm->isValid()) {
                return new ViewModel(array('form' => $messageForm));
            }
            $messageArray = $messageForm->getData();
            try {
                $this->messageFacade->edit($messageArray['Msg']);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-msg');
            }
            $this->flashMessenger()->addSuccessMessage(_('Base successfully updated'));
            return $this->redirect()->toRoute('sms-msg');
        }
        $messageId = (int)$this->params()->fromRoute('id', 0);
        $editForm = $this->formFactory->createMessageEditForm();
        try {
            $messageArray = $this->messageFacade->getById($messageId);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-msg');
            }
        $editForm->setData(array('Msg' => $messageArray));
        return new ViewModel(array('form' => $editForm));
    }

    public function deleteAction()
    {
        $messageId = (int)$this->params()->fromRoute('id', 0);
        try {
            $this->messageFacade->delete($messageId);
        } catch (Exception $ex) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
            return $this->redirect()->toRoute('sms-msg');
        }
        $this->flashMessenger()->addSuccessMessage(_('Message successfully deleted'));
        return $this->redirect()->toRoute('sms-msg');
    }
}

