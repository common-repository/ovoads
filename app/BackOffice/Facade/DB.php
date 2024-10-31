<?php

namespace Ovoads\BackOffice\Facade;

use Ovoads\BackOffice\Facade\Facade;

class DB extends Facade{
    protected static function getFacadeAccessor()
    {
        return 'db';
    }
}