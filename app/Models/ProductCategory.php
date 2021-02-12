<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'product_categories';
    protected $primaryKey = 'product_category_uuid';
    public $timestamps = true;
}
