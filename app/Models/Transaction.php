<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'transactions';
    protected $primaryKey = 'transaction_uuid';
    public $timestamps = true;

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_uuid', 'customer_uuid');
    }

    public function tProductItems()
    {
        return $this->hasMany('App\Models\TProductItem', 'transaction_uuid', 'transaction_uuid');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'currency_id');
    }

    public function tInterest()
    {
        return $this->hasOne('App\Models\TInterest', 'transaction_uuid', 'transaction_uuid');
    }

    public function loanPurpose()
    {
        return $this->hasOne('App\Models\LoanPurpose', 'loan_purpose_uuid', 'loan_purpose_uuid');
    }

    public function tTransferAccount()
    {
        return $this->hasOne('App\Models\TTransferAccount', 'transaction_uuid', 'transaction_uuid');
    }

    public function tShippingAddress()
    {
        return $this->hasOne('App\Models\TShippingAddress', 'transaction_uuid', 'transaction_uuid');
    }

    public function latestTransferStatus()
    {
        return $this->hasOne('App\Models\TTransferStatus', 'transaction_uuid', 'transaction_uuid')->latest();
    }

    public function latestShippingStatus()
    {
        return $this->hasOne('App\Models\TShippingStatus', 'transaction_uuid', 'transaction_uuid')->latest();
    }

    public function installments()
    {
        return $this->hasMany('App\Models\Installment', 'transaction_uuid', 'transaction_uuid')->orderBy('installment_to');
    }

    public function tFee()
    {
        return $this->belongsTo('App\Models\TFee', 'transaction_uuid', 'transaction_uuid');
    }

    public function cooperative()
    {
        return $this->belongsTo('App\Models\Cooperative', 'cooperative_uuid', 'cooperative_uuid');
    }
}
