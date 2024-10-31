<?php 

namespace Ovoads\Models;

use Ovoads\BackOffice\Database\Model;
use Ovoads\Traits\Searchable;

class AdKeyword extends Model
{
    use Searchable;
    protected $table = 'ovoads_keywords';
}