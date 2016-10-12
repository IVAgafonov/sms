<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Sms\Facade\PhoneFacadeInterface;
use Sms\Factory\Form\FormFactoryInterface;
use Sms\Exception\SmsException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class PhoneController extends AbstractActionController
{
    private $user;
    private $phoneFacade;
    private $formFactory;

    public function __construct(
        $user,
        PhoneFacadeInterface $phoneFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->user = $user;
        $this->phoneFacade = $phoneFacade;
        $this->formFactory = $formFactory;
    }

    public function indexAction()
    {
        $this->flashMessenger()->addErrorMessage(_('Base not found'));
        return $this->redirect()->toRoute('sms-base');
    }

    public function baseAction()
    {
        $baseId = (int)$this->params()->fromRoute('id', 0);
        $page   = (int)$this->params()->fromRoute('page', 1);
        $phoneFilterForm = $this->formFactory->createPhoneFilterForm($baseId);
        if ($this->request->isPost()) {
            $phoneFilterForm->setData($this->request->getPost());
            $filter = $this->request->getPost()['Filter']['filter'];
        } else {
            $filter = htmlspecialchars($this->params()->fromRoute('filter', ''));
            $phoneFilterForm->setData(array('Filter' => array('filter' => $filter)));
        }
        try {
            $this->phoneFacade->checkBase($baseId);
            $phoneList = $this->phoneFacade->getList($page, $baseId, $filter);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        return new ViewModel(
            array(
            'phoneList' => $phoneList,
            'page' => $page,
            'baseId' => $baseId,
            'filter' => $filter,
            'filterForm' => $phoneFilterForm
            )
        );
    }

    public function addAction()
    {
        $baseId = (int)$this->params()->fromRoute('id', 0);
        $phoneForm = $this->formFactory->createPhoneAddForm($baseId);
        try {
            # check base will return array of checked base
            $baseParams = $this->phoneFacade->checkBase($baseId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        if ($this->request->isPost()) {
            $phoneForm->setData($this->request->getPost());
            if (!$phoneForm->isValid()) {
                return new ViewModel(array('form' => $phoneForm, 'baseParams' => $baseParams));
            }
            $phoneArray = $phoneForm->getData();
            $phoneArray['Phone']['base_id'] = $baseId;
            try {
                $this->phoneFacade->add($phoneArray['Phone']);
                $this->flashMessenger()->addSuccessMessage(_('Phone number successfully added'));
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
            }
            return $this->redirect()->toRoute(
                'sms-phone', array(
                    'action' => 'base',
                    'id' => $baseId
                )
            );
        }
        return new ViewModel(array('form' => $phoneForm, 'baseParams' => $baseParams));
    }

    public function editAction()
    {
        $phoneId = (int)$this->params()->fromRoute('id', 0);
        try {
            $phone = $this->phoneFacade->getById($phoneId);
            # check base will return array of checked base
            $baseParams = $this->phoneFacade->checkBase($phone['base_id']);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        $phoneForm = $this->formFactory->createPhoneEditForm($phone['id']);
        if ($this->request->isPost()) {
            $phoneForm->setData($this->request->getPost());
            if (!$phoneForm->isValid()) {
                return new ViewModel(array('form' => $phoneForm, 'baseParams' => $baseParams));
            }
            $phoneArray = $phoneForm->getData();
            $phoneArray['Phone']['base_id'] = $phone['base_id'];
            $phoneArray['Phone']['id'] = $phoneId;
            try {
                $this->phoneFacade->edit($phoneArray['Phone']);
                $this->flashMessenger()->addSuccessMessage(_('Phone number successfully edited'));
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
            }
            return $this->redirect()->toRoute(
                'sms-phone', array(
                    'action' => 'base',
                    'id' => $phone['base_id']
                )
            );
        }
        $phoneForm->setData(array('Phone' => $phone));
        return new ViewModel(array('form' => $phoneForm, 'baseParams' => $baseParams));
    }

    public function deleteAction()
    {
        $phoneId = (int)$this->params()->fromRoute('id', 0);
        try {
            $phone = $this->phoneFacade->getById($phoneId);
            # check base will return array of checked base
            $this->phoneFacade->checkBase($phone['base_id']);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        $this->phoneFacade->delete($phone);
        $this->flashMessenger()->addSuccessMessage(_('Phone number successfully deleted'));
        return $this->redirect()->toRoute(
            'sms-phone',
            array(
                'action' => 'base',
                'id' => $phone['base_id']
            )
        );
    }

    public function changeAction()
    {
        $request = $this->getRequest();
        if ($request->isXmlHttpRequest()) {
            $phoneId = preg_replace('~[^0-9]+~','',$request->getPost()->num);
            $statusBool = $request->getPost()->status;
            $newStatus = $statusBool == 'true' ? 1 : 0;
            try {
                $phone = $this->phoneFacade->getById($phoneId);
                $this->phoneFacade->checkBase($phone['base_id']);
                $this->phoneFacade->setStatus($phone, $newStatus);
            } catch (SmsException $ex) {
                $view = new JsonModel(
                    array(
                        'status' => !$newStatus,
                        'error' => 1,
                        'errorValue' => _('Error of change status')
                    )
                );
                return $view;
            }
            $view = new JsonModel(
                    array(
                        'status' => $newStatus,
                        'error' => 0,
                        'errorValue' => ''
                    )
                );
            return $view;
        }
    }
}

