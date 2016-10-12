<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;

use Sms\Facade\BaseFacadeInterface;
use Sms\Factory\Form\FormFactoryInterface;
use Sms\Exception\SmsException;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController
{
    private $user;
    private $baseFacade;
    private $formFactory;

    public function __construct(
        $user,
        BaseFacadeInterface $baseFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->user = $user;
        $this->baseFacade = $baseFacade;
        $this->formFactory = $formFactory;
    }

    public function indexAction()
    {
        $page = $this->params()->fromRoute('id', 1);
        try {
            $baseListData = $this->baseFacade->getList($page);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        return new ViewModel(
            array(
                'page' => $page,
                'baseList' => $baseListData['baseList'],
                'counts' => $baseListData['counts']
            )
        );
    }

    public function addAction()
    {
        if ($this->request->isPost()) {
            $baseForm = $this->formFactory->createBaseAddForm();
            $baseForm->setData($this->request->getPost());
            if (!$baseForm->isValid()) {
                return new ViewModel(array('form' => $baseForm));
            }
            $baseArray = $baseForm->getData();
            try {
                $this->baseFacade->add($baseArray['Base']);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-base');
            }
            $this->flashMessenger()->addSuccessMessage(_('Base successfully added'));
            return $this->redirect()->toRoute('sms-base');
        }
        return new ViewModel(array('form' => $this->formFactory->createBaseAddForm()));
    }

    public function editAction()
    {
        if ($this->request->isPost()) {
            $baseForm = $this->formFactory->createBaseEditForm();
            $baseForm->setData($this->request->getPost());
            if (!$baseForm->isValid()) {
                return new ViewModel(array('form' => $baseForm));
            }
            $baseArray = $baseForm->getData();
            try {
                $this->baseFacade->edit($baseArray['Base']);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-base');
            }
            $this->flashMessenger()->addSuccessMessage(_('Base successfully updated'));
            return $this->redirect()->toRoute('sms-base');
        }
        $baseId = (int)$this->params()->fromRoute('id', 0);
        $editForm = $this->formFactory->createBaseEditForm();
        try {
            $baseArray = $this->baseFacade->getById($baseId);
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
                return $this->redirect()->toRoute('sms-base');
            }
        $editForm->setData(array('Base' => $baseArray));
        return new ViewModel(array('form' => $editForm));
    }

    public function deleteAction()
    {
        $baseId = (int)$this->params()->fromRoute('id', 0);
        
        try {
            $this->baseFacade->delete($baseId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        $this->flashMessenger()->addSuccessMessage(_('Base successfully deleted'));
        return $this->redirect()->toRoute('sms-base');
    }

    public function exportAction()
    {
        $page = $this->params()->fromRoute('id', 1);
        try {
            $exportList = $this->baseFacade->getExportList($page);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }
        return new ViewModel(array('exportList' => $exportList, 'page' => $page));
    }
    
    public function downloadAction()
    {
        $exportId = $this->params()->fromRoute('id', 1);
        try {
            return $this->baseFacade->download($exportId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
    }
    
    public function prepareAction()
    {
        $baseId = $this->params()->fromRoute('id', 1);
        try {
            $this->baseFacade->export($baseId);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
            return $this->redirect()->toRoute('sms-base');
        }
        $this->flashMessenger()->addSuccessMessage(_('Preparing to download was started'));
        return $this->redirect()->toRoute('sms-base');
    }
}

