<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Controller;


use Sms\Facade\CronFacadeInterface;
use Sms\Exception\SmsException;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class CronController extends AbstractActionController
{
    private $cronFacade;

    public function __construct(
        CronFacadeInterface $cronFacade
    ) {
        $this->cronFacade = $cronFacade;
    }
    
    public function indexAction()
    {
        //throw new \Exception("Lock delivery");
        try {
            $this->cronFacade->lockReadyDelivery(); 
        } catch (SmsException $ex) {
            echo "error";
        }
        
        try {
            $this->cronFacade->startReadyDelivery();
        } catch (SmsException $ex) {
            echo "error";
        }
        
        try {
            $this->cronFacade->checkErrorExchange(); 
        } catch (SmsException $ex) {
            echo "error";
        }
    }
}
    
    