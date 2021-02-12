<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CooperativeMember extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'cooperative_members';
    protected $primaryKey = 'cooperative_member_uuid';
    public $timestamps = true;

    public function city()
    {
        return $this->belongsTo('App\Models\City', 'city_id', 'city_id');
    }
}
