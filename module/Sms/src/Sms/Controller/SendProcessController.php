<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Sms\Facade\SendProcessFacadeInterface;

class SendProcessController extends AbstractActionController
{
    private $sendProcessFacade;

    public function __construct(
        SendProcessFacadeInterface $sendProcessFacade
    ) {
        $this->sendProcessFacade = $sendProcessFacade;
    }

    public function indexAction()
    {
        $sendProcessId = htmlspecialchars($_GET['id']);
        $iteration = htmlspecialchars($_GET['iteration']);
        $this->sendProcessFacade->process($sendProcessId, $iteration);
    }
}

