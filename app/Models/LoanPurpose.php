<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanPurpose extends Model
{
    use UsesUuid;
    use SoftDeletes;

    protected $table = 'loan_purposes';
    protected $primaryKey = 'loan_purpose_uuid';
    public $timestamps = true;
}
