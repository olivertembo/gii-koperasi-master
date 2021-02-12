<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TShippingAddress extends Model
{
    use UsesUuid;
    protected $table = 't_shipping_addresses';
    protected $primaryKey = 't_shipping_address_uuid';
    public $timestamps = true;

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'city_id');
    }
}
