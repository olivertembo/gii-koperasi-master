<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use UsesUuid;
    protected $table = 'roles';
    protected $primaryKey = 'role_uuid';
    protected $fillable = [
        'role_name',
    ];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_roles', 'role_uuid', 'user_uuid');
    }

    public function upgradeStatuses()
    {
        return $this->belongsToMany('App\Models\UpgradeStatus', 'role_upgrade_statuses', 'role_uuid', 'upgrade_status_id');
    }


    public function roleMenus()
    {
        return $this->hasMany('App\Models\RoleMenu', 'role_uuid', 'role_uuid');
    }

    public function userRoles()
    {
        return $this->hasMany('App\Models\UserRole', 'role_uuid', 'role_uuid');
    }
}
