<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuantityType extends Model
{
    use UsesUuid;
    protected $table = 'quantity_types';
    protected $primaryKey = 'quantity_type_uuid';

}
