<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentDetail extends Model
{
    use UsesUuid;

    protected $table = 'installment_details';
    protected $primaryKey = 'installment_detail_uuid';
    public $timestamps = true;
}
