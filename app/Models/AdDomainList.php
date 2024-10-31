<?php 

namespace Ovoads\Models;

use Ovoads\BackOffice\Database\Model;
use Ovoads\Traits\Searchable;

class AdDomainList extends Model
{
    use Searchable;
    protected $table = 'ovoads_domain_lists';
}