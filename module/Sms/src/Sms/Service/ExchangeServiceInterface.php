<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service;


interface ExchangeServiceInterface
{
    public function prepareFileToImport($tmpFile, $baseId);
}

