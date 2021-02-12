<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class History
{
    public static function log($type, $req, $ref)
    {
        $data = new \App\Models\History();
        $data->user_uuid = Auth::user()->user_uuid;
        $data->type = $type;
        $data->request = $req;
        $data->reference = $ref;
        $data->save();
    }
}