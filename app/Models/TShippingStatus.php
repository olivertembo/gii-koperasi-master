<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TShippingStatus extends Model
{
    use UsesUuid;
    protected $table = 't_shipping_statuses';
    protected $primaryKey = 't_shipping_status_uuid';
    public $timestamps = true;

    public function shippingStatus()
    {
        return $this->belongsTo('App\Models\ShippingStatus', 'shipping_status_id', 'shipping_status_id');
    }
}
