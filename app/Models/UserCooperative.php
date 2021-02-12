<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCooperative extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'user_cooperatives';
    protected $primaryKey = 'user_cooperative_uuid';
    public $timestamps = true;
}
