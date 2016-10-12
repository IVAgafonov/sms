<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Service\System;


interface CsvProviderInterface
{
    public function open($baseId, $type);
    public function readRow();
    public function writeRow($array);
    public function cursorPos($row);
    public function close();
    public function create($baseId, $type);
    public function delete($baseId, $type);
    public function isExists($baseId, $type);
}

