<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'fines';
    protected $primaryKey = 'fine_uuid';
    public $timestamps = true;
}
