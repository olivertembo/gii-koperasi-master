<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'banners';
    protected $primaryKey = 'banner_uuid';
    public $timestamps = true;
}
