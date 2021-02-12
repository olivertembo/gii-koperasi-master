<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserShippingAddress extends Model
{
    use UsesUuid;
    use SoftDeletes;
    protected $table = 'user_shipping_addresses';
    protected $primaryKey = 'user_shipping_address_uuid';
    public $timestamps = true;

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'city_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_uuid', 'user_uuid');
    }
}
