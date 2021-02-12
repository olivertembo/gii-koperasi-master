<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use UsesUuid;
    protected $table = 'banks';
    protected $primaryKey = 'bank_uuid';

    public $timestamps = true;
}
