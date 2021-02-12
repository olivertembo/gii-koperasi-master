<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Installment extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'installments';
    protected $primaryKey = 'installment_uuid';
    public $timestamps = true;

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'currency_id');
    }

    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction', 'transaction_uuid', 'transaction_uuid');
    }
}
