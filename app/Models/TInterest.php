<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TInterest extends Model
{
    use UsesUuid;

    protected $table = 't_interests';
    protected $primaryKey = 't_interest_uuid';
    public $timestamps = true;

    public function interestType()
    {
        return $this->belongsTo('App\Models\InterestType', 'interest_type_id', 'interest_type_id');
    }
}
