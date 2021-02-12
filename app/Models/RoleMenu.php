<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use UsesUuid;
    protected $table = 'role_menus';
    protected $primaryKey = 'role_menu_uuid';
    protected $fillable = [
        'menu_id', 'role_uuid'
    ];

    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_uuid', 'role_uuid');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id', 'menu_id');
    }
}
