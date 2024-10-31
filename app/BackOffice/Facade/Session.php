<?php

namespace Ovoads\BackOffice\Facade;

use Ovoads\BackOffice\Facade\Facade;

class Session extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'session';
    }
}