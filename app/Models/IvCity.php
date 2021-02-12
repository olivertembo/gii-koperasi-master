<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvCity extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'iv_cities';
    protected $primaryKey = 'iv_city_uuid';
    public $timestamps = true;

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'city_id');
    }
}
