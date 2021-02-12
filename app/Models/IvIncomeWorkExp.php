<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IvIncomeWorkExp extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'iv_income_work_exps';
    protected $primaryKey = 'iv_income_work_exp_uuid';
    public $timestamps = true;
}
