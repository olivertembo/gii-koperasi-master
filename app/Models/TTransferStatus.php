<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTransferStatus extends Model
{
    use UsesUuid;
    protected $table = 't_transfer_statuses';
    protected $primaryKey = 't_transfer_status_uuid';
    public $timestamps = true;

    public function transferStatus()
    {
        return $this->belongsTo('App\Models\TransferStatus', 'transfer_status_id', 'transfer_status_id');
    }
}
