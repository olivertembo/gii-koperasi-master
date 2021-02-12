<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    protected $table = 'customer_statuses';
    protected $primaryKey = 'customer_status_id';
    public $timestamps = true;
}
