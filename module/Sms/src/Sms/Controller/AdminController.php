<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Sms\Facade\AdminFacadeInterface;
use Sms\Factory\Form\FormFactoryInterface;
use Sms\Exception\SmsException;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class AdminController extends AbstractActionController
{
    private $adminFacade;

    public function __construct(
        AdminFacadeInterface $adminFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->adminFacade = $adminFacade;
        $this->formFactory = $formFactory;
    }
    
    public function indexAction()
    {
        $page = (int)$this->params()->fromRoute('id', 1);
        $userFilterForm = $this->formFactory->createUserFilterForm();
        if ($this->request->isPost()) {
            $userFilterForm->setData($this->request->getPost());
            $filter = $this->request->getPost()['Filter']['filter'];
        } else {
            $filter = htmlspecialchars($this->params()->fromRoute('filter', ''));
            $userFilterForm->setData(array('Filter' => array('filter' => $filter)));
        }
        try {
            $userList = $this->adminFacade->getUserList($page, $filter);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-admin');
        }
        return new ViewModel(
            array(
            'userList' => $userList,
            'page' => $page,
            'filter' => $filter,
            'filterForm' => $userFilterForm
            )
        );
    }
    
    public function editAction()
    {
        $userId = (int)$this->params()->fromRoute('id', 1);
        try {
            $user = $this->adminFacade->getUserById($userId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-admin');
        }
        $userForm = $this->formFactory->createUserEditForm();
        if ($this->request->isPost()) {
            $userForm->setData($this->request->getPost());
            if (!$userForm->isValid()) {
                return new ViewModel(array('form' => $userForm));
            }
            $userArray = $userForm->getData();
            try {
                $this->adminFacade->editUser($userArray['User']);
                $this->flashMessenger()->addSuccessMessage(_('User successfully edited'));
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
            }
            return $this->redirect()->toRoute('sms-admin');
        }
        $userForm->setData(array('User' => $user));
        return new ViewModel(array('form' => $userForm, 'user' => $user));
    }
    
    public function sendListAction()
    {
        $page = $this->params()->fromRoute('page', 1);
        $userId = $this->params()->fromRoute('id', 1);
        $user = $this->adminFacade->getUserById($userId);
        try {
            $sendList = $this->adminFacade->getUserSendList($page, $userId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-admin');
        }
        return new ViewModel(
            array(
                'sendList' => $sendList,
                'page' => $page,
                'user' => $user
            )
        );
    }
    
    public function deleteAction()
    {
        $sendId = $this->params()->fromRoute('id', 1);
        try {
            $userId = $this->adminFacade->deleteSend($sendId);
            $this->flashMessenger()->addSuccessMessage(_('Send successfully deleted'));
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }
        return $this->redirect()->toRoute('sms-admin', array('action' => 'sendlist', 'id' => $userId));
    }
    
    public function downloadAction()
    {
        $baseId = $this->params()->fromRoute('id', 1);
        try {
            return $sendList = $this->adminFacade->downloadUserBase($baseId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-admin');
        }
    }
}
    
    