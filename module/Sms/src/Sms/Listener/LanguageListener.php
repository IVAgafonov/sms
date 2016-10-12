<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\Event;
use Zend\Validator\AbstractValidator;
use Zend\Http\Header\SetCookie;

class LanguageListener extends AbstractListenerAggregate
{
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();

        $this->listeners[] = $sharedManager->attach(
            'Zend\Mvc\Application',
            'route',
            array($this, 'selectLanguage')
        );

        $this->listeners[] = $sharedManager->attach(
            'Zend\Mvc\Application',
            'dispatch',
            array($this, 'changeLanguage')
        );
    }

    public function selectLanguage(Event $e)
    {
        $application = $e->getApplication();
        $config      = $application->getConfig();

        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->langs = $config['sms-languages'];

        $currentLang = 'ru_RU';

        if (isset($e->getApplication()->getRequest()->getCookie()->locale)) {
            $savedLang = $e->getApplication()->getRequest()->getCookie()->locale;
            foreach ($viewModel->langs as $lang) {
                if ($savedLang == $lang[0]) {
                    $currentLang = $savedLang;
                }
            }
        }
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale($currentLang)
            ->setFallbackLocale($currentLang);
        $viewModel->currentLang = $currentLang;
        $shortLang = substr($currentLang, 0, 2);
        $translator->addTranslationFile(
            "phpArray",
            "./vendor/zendframework/zend-i18n-resources/languages/".$shortLang."/Zend_Validate.php"
        );
        AbstractValidator::setDefaultTranslator($translator);
    }

    public function changeLanguage(Event $e)
    {
        $langGet = $e->getApplication()->getMvcEvent()->getRequest()->getQuery()->get('lang');

        if ($langGet != null) {
            $application = $e->getApplication();
            $controller = $e->getTarget();
            $config      = $application->getConfig();
			$uri = $e->getApplication()->getMvcEvent()->getRouter()->getRequestUri();
            $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
            $viewModel->langs = $config['sms-languages'];

            $changeLang = $langGet;
            foreach ($viewModel->langs as $lang) {
                if ($changeLang == $lang[0]) {
                    $currentLang = $changeLang;
                }
            }

            $cookie = new SetCookie('locale', $currentLang, time() + 365 * 60 * 60 * 24, '/');
            $e->getApplication()->getServiceManager()->get('Response')
                ->getHeaders()
                ->addHeader($cookie);

            $controller->flashMessenger()->addSuccessMessage(_('Language successfully changed'));
			$port = $uri->getPort() != 80 ? ":".$uri->getPort() : "";
            $redirect = $uri->getScheme()."://".$uri->getHost().$port.$uri->getPath();
            $controller->plugin('redirect')->toUrl($redirect);
        }
    }
}

