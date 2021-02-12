<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvSuspend extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'iv_suspends';
    protected $primaryKey = 'iv_suspend_uuid';
    public $timestamps = true;
}
