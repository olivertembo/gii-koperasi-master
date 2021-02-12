<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use UsesUuid;

    protected $table = 'histories';
    protected $primaryKey = 'history_uuid';
    public $timestamps = true;
}
