<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use UsesUuid;
    use SoftDeletes;
    protected $table = 'user_banks';
    public $incrementing = false;
    protected $primaryKey = 'user_bank_uuid';

    public function bank()
    {
        return $this->HasOne('App\Models\Bank', 'bank_uuid', 'bank_uuid');
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
