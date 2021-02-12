<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvAdminFee extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'iv_admin_fees';
    protected $primaryKey = 'iv_admin_fee_uuid';
    public $timestamps = true;
}
