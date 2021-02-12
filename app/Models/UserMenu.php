<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $table = 'user_menus';
    protected $primaryKey = 'user_menu_id';
    protected $fillable = [
        'user_uuid', 'menu_id'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_uuid', 'user_uuid');
    }

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id', 'menu_id');
    }
}
