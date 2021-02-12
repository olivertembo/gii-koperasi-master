<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinHistory extends Model
{
    //
    use UsesUuid;
    
    public $incrementing = false;
    protected $primaryKey = 'pin_history_uuid';

}
