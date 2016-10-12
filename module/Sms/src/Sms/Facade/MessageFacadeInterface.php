<?php

/*
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface MessageFacadeInterface
{
    public function add($array);
    public function edit($array);
    public function delete($id);
    public function getList($page);
    public function getById($id);
}

