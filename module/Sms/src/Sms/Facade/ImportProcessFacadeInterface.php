<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface ImportProcessFacadeInterface
{
    /**
    * Start import process.
    *
    * @param int $importProcessId
    * @param int $iteration
    */
    public function process($importProcessId, $iteration);
    /**
    * Finish import process.
    *
    * @param int $importProcessId
    * @param int $iteration
    */
    public function finish($importProcessId);
    /**
    * Start next iteration of import process.
    *
    * @param int $importProcessId
    */
    public function nextIteration($importProcessId);
}