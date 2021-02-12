<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductItemImage extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'product_item_images';
    protected $primaryKey = 'product_item_image_uuid';
    public $timestamps = true;

    public function productItem()
    {
        return $this->belongsTo('App\Models\ProductItem', 'product_item_uuid', 'product_item_uuid');
    }
}
