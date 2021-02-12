<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TFine extends Model
{
    use UsesUuid;

    protected $table = 't_interests';
    protected $primaryKey = 't_interest_uuid';
    public $timestamps = true;
}
