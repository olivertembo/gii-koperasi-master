<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerUpgradeStatus extends Model
{
    use UsesUuid;

    protected $table = 'customer_upgrade_statuses';
    protected $primaryKey = 'customer_upgrade_status_uuid';
    public $timestamps = true;

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'customer_uuid', 'customer_uuid');
    }

    public function upgradeStatus()
    {
        return $this->belongsTo('App\Models\UpgradeStatus', 'upgrade_status_id', 'upgrade_status_id');
    }
}
