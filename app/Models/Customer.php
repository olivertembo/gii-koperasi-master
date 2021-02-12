<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'customers';
    protected $primaryKey = 'customer_uuid';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_uuid', 'user_uuid');
    }

    public function cooperative()
    {
        return $this->belongsTo('App\Models\Cooperative', 'cooperative_uuid', 'cooperative_uuid');
    }

    public function customerDocuments()
    {
        return $this->hasMany('App\Models\CustomerDocument', 'customer_uuid', 'customer_uuid');
    }

    public function customerUpgradeStatus()
    {
        return $this->hasMany('App\Models\CustomerUpgradeStatus', 'customer_uuid', 'customer_uuid');
    }

    public function latestUpgradeStatus()
    {
        return $this->hasOne('App\Models\CustomerUpgradeStatus', 'customer_uuid', 'customer_uuid')->latest();
    }

    public function customerStatus()
    {
        return $this->belongsTo('App\Models\CustomerStatus', 'customer_status_id', 'customer_status_id')->latest();
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id', 'currency_id');
    }

    public function job()
    {
        return $this->belongsTo('App\Models\Job', 'job_id', 'job_id');
    }
}
