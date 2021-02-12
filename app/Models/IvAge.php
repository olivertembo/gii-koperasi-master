<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvAge extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'iv_ages';
    protected $primaryKey = 'iv_age_uuid';
    public $timestamps = true;
}
