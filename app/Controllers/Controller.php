<?php

namespace Ovoads\Controllers;

use Ovoads\BackOffice\CoreController;

class Controller extends CoreController
{

    public $viewPath = '';

    public function __construct()
    {
        $this->viewPath = OVOADS_ROOT . 'views';
    }
}
