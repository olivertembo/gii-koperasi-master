<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interest extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'interests';
    protected $primaryKey = 'interest_uuid';
    public $timestamps = true;

    public function type(){
        return $this->belongsTo('\App\Models\InterestType','interest_type_id','interest_type_id');
    }
}
