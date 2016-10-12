<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sms\Facade\ImportFacadeInterface;
use Sms\Factory\Form\FormFactoryInterface;
use Sms\Exception\SmsException;

class ImportController extends AbstractActionController
{
    private $user;
    private $importFacade;
    private $formFactory;

    public function __construct(
        $user,
        ImportFacadeInterface $importFacade,
        FormFactoryInterface $formFactory
    ) {
        $this->user = $user;
        $this->importFacade = $importFacade;
        $this->formFactory = $formFactory;
    }

    public function indexAction()
    {
        $page = $this->params()->fromRoute('id', 1);
        try {
            $importList = $this->importFacade->getList($page);
        } catch (SmsException $ex) {
            $this->flashMessenger()->addErrorMessage($ex->getMessage());
        }
        return new ViewModel(array('importList' => $importList, 'page' => $page));
        /*
        $this->layout()->user = $this->user;
        $page = $this->params()->fromRoute('id', 1);
        try {
            $importList = $this->importService->getListByPage($page, $this->user->getId());
        } catch (MapperException $e) {
            return new ViewModel(array('emptyMessage' => $e->getMessage()));
        }
        return new ViewModel(array('importList' => $importList, 'page' => $page));
         * 
         */
    }

    public function importAction()
    {
        if ($this->request->isPost()) {
            $importData = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $importForm = $this->formFactory->createImportForm();
            $importForm->setData($importData);
            if (!$importForm->isValid()) {
                return new ViewModel(array('importForm' => $importForm));
            }
            try {
                $baseArray = $this->importFacade->prepareBaseToImport($importData);
                $this->importFacade->import($baseArray);
                $this->flashMessenger()->addSuccessMessage(_('Import start'));
            } catch (SmsException $ex) {
                $this->flashMessenger()->addErrorMessage($ex->getMessage());
            }
            return $this->redirect()->toRoute('sms-import');
        }
        $importForm = $this->formFactory->createImportForm();
        return new ViewModel(array('importForm' => $importForm));
    }
}

