<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TProductItem extends Model
{
    use UsesUuid;

    protected $table = 't_product_items';
    protected $primaryKey = 't_product_item_uuid';
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
