<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use UsesUuid;
    protected $table = 'settings';
    protected $primaryKey = 'setting_uuid';
}
