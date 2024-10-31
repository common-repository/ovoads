<?php

namespace Ovoads\BackOffice\Database\Relation;

use Ovoads\BackOffice\Database\Relation\Result\ManageResult;

trait RelationalResult{

    protected function manageRelationalResult(){
        $manage = new ManageResult($this->relations,$this->data);
        $this->data = $manage->manage();
    }

}