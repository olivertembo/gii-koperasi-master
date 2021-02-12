<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use UsesUuid;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'user_uuid';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Menus()
    {
        return $this->belongsToMany('App\Models\Menu', 'user_menus', 'user_uuid', 'menu_uuid');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_roles', 'user_uuid', 'role_uuid');
    }

    public function cooperatives()
    {
        return $this->belongsToMany('App\Models\Cooperative', 'user_cooperatives', 'user_uuid', 'cooperative_uuid');
    }

    public function userMenus()
    {
        return $this->hasMany('App\Models\UserMenu', 'user_uuid', 'user_uuid');
    }

    public function userRoles()
    {
        return $this->hasMany('App\Models\UserRole', 'user_uuid', 'user_uuid');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'user_uuid', 'user_uuid');
    }

    public function isVerificator()
    {
        $is = false;
        foreach ($this->roles as $i) {
            if ($i->is_verificator == true) {
                $is = true;
                break;
            }
        }
        return $is;
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'city_id');
    }
}
