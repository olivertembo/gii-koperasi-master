<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerType extends Model
{
    protected $table = 'partner_types';
    protected $primaryKey = 'partner_type_id';
    public $timestamps = true;
}
