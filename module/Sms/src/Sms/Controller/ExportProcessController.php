<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Sms\Facade\ExportProcessFacadeInterface;

class ExportProcessController extends AbstractActionController
{
    private $exportProcessFacade;

    public function __construct(
        ExportProcessFacadeInterface $exportProcessFacade
    ) {
        $this->exportProcessFacade = $exportProcessFacade;
    }

    public function indexAction()
    {
        $exportProcessId = htmlspecialchars($_GET['id']);
        $iteration = htmlspecialchars($_GET['iteration']);
        $this->exportProcessFacade->process($exportProcessId, $iteration);
    }
}

