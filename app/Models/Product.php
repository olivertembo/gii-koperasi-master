<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'products';
    protected $primaryKey = 'product_uuid';
    public $timestamps = true;

    public function productCategory()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'product_category_uuid', 'product_category_uuid');
    }

    public function cooperative()
    {
        return $this->belongsTo('App\Models\Cooperative', 'cooperative_uuid', 'cooperative_uuid');
    }
}
