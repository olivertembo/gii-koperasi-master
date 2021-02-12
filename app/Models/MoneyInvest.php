<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoneyInvest extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'money_invests';
    protected $primaryKey = 'money_invest_uuid';
    public $timestamps = true;
}
