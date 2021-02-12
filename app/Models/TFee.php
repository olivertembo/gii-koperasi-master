<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TFee extends Model
{
    use UsesUuid;
    protected $table = 't_fees';
    protected $primaryKey = 't_fee_uuid';
    public $timestamps = true;
}
