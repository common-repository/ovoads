<?php

namespace Ovoads\Models;

use Ovoads\BackOffice\Database\Model;
use Ovoads\Traits\Searchable;

class AdReport extends Model
{
    use Searchable;
    protected $table = 'ovoads_adreports';

    public function ad(){
        $this->belongsTo(Advertise::class, 'id','ad_id');
    }
}