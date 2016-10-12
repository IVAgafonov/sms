<?php

/* 
 * @Copyright (C) 2016 Igor Agafonov
 * @licenseGPL
 */

namespace Sms\Facade;


interface SendFacadeInterface {
    public function getList($page);
    public function add($data);
    public function edit($data);
    public function delete($id);
    public function getById($id);
}