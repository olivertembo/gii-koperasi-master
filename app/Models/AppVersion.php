<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppVersion extends Model
{
    use UsesUuid;
    use SoftDeletes;
    protected $table = 'app_versions';
    protected $primaryKey = 'app_version_uuid';

    public $timestamps = true;
}
