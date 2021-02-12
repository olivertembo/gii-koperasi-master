<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogRequestApi extends Model
{
    use UsesUuid;

    protected $table = 'log_request_apis';
    protected $primaryKey = 'log_request_api_uuid';
    public $timestamps = true;
}
