<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'coupons';
    protected $primaryKey = 'coupon_uuid';
    public $timestamps = true;

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'user_uuid');
    }
}
