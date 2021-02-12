<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpgradeStatus extends Model
{
    protected $table = 'upgrade_statuses';
    protected $primaryKey = 'upgrade_status_id';
}
