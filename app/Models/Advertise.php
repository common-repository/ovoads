<?php

namespace Ovoads\Models;

use Ovoads\BackOffice\Database\Model;
use Ovoads\Traits\Searchable;

class Advertise extends Model
{
    use Searchable;
    
    protected $table = 'ovoads_advertises';
}