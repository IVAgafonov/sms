<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface ExportProcessFacadeInterface
{
    /**
    * Start export process.
    *
    * @param int $exportProcessId
    * @param int $iteration
    */
    public function process($exportProcessId, $iteration);
    /**
    * Finish export process.
    *
    * @param int $exportProcessId
    */
    public function finish($exportProcessId);
    /**
    * Start next iteration of export process.
    *
    * @param int $exportProcessId
    */
    public function nextIteration($exportProcessId);
}

