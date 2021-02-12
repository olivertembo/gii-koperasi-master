<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use UsesUuid;
    protected $table = 'user_roles';
    protected $primaryKey = 'user_role_uuid';
    protected $fillable = [
        'user_uuid', 'role_uuid'
    ];

    public $timestamps = true;


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_uuid', 'user_uuid');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'role_uuid', 'role_uuid');
    }
}
