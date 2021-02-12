<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'carts';
    protected $primaryKey = 'cart_uuid';
    public $timestamps = true;

    public function productItem()
    {
        return $this->belongsTo('App\Models\ProductItem', 'product_item_uuid', 'product_item_uuid');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'currency_id');
    }
}
