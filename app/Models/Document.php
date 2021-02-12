<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use UsesUuid;

    protected $table = 'documents';
    protected $primaryKey = 'document_id';
    public $timestamps = false;
}
