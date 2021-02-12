<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUpgradeStatus extends Model
{
    use UsesUuid;

    protected $table = 'role_upgrade_statuses';
    protected $primaryKey = 'role_upgrade_status_uuid';
    public $timestamps = false;
}
