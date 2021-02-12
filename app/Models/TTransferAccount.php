<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTransferAccount extends Model
{
    use UsesUuid;

    protected $table = 't_transfer_accounts';
    protected $primaryKey = 't_transfer_account_uuid';
    public $timestamps = true;

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_uuid', 'bank_uuid');
    }

    public function getAccountNumberAttribute($value)
    {
        return base64_decode($value);
    }

    public function setAccountNumberAttribute($value)
    {
        $this->attributes['account_number'] = base64_encode($value);
    }
}
