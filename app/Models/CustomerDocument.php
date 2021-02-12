<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use UsesUuid;

    protected $table = 'customer_documents';
    protected $primaryKey = 'customer_document_uuid';
    public $timestamps = true;

    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id', 'document_id');
    }
}
