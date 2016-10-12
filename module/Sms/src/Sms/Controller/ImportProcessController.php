<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Sms\Facade\ImportProcessFacadeInterface;

class ImportProcessController extends AbstractActionController
{
    private $importProcessFacade;

    public function __construct(
        ImportProcessFacadeInterface $importProcessFacade
    ) {
        $this->importProcessFacade = $importProcessFacade;
    }

    public function indexAction()
    {
        $importProcessId = htmlspecialchars($_GET['id']);
        $iteration = htmlspecialchars($_GET['iteration']);
        $this->importProcessFacade->process($importProcessId, $iteration);
    }
}

