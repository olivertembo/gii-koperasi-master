<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItem extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'product_items';
    protected $primaryKey = 'product_item_uuid';
    public $timestamps = true;

    public function quantityType()
    {
        return $this->belongsTo('App\Models\QuantityType', 'quantity_type_uuid', 'quantity_type_uuid');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'currency_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_uuid', 'product_uuid');
    }

    public function productItemImages()
    {
        return $this->hasMany('App\Models\ProductItemImage', 'product_item_uuid', 'product_item_uuid');
    }
}
