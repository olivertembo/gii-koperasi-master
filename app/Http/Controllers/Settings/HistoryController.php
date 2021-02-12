<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\History;
use App\Models\Cooperative;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    private $menu_id = 24;
    private $path, $url, $menu;

    public function __construct()
    {
        $menu = Menu::find($this->menu_id);
        $this->menu = $menu;
        $this->path = $menu->path;
        $this->url = $menu->url;
    }

    public function index(Request $request)
    {
        return view($this->path . 'index', [
            'menu' => $this->menu,
            'url' => $this->url
        ]);
    }

    public function dataTable(Request $request)
    {
        $start = $request->input('start');
        $search = strtolower($request->input('search')['value']);
        $length = $request->input('length');

        $order_arr = $request->input('order');
        $order_arr = $order_arr[0];
        $orderByColumnIndex = $order_arr['column']; // index of the sorting column (0 index based - i.e. 0 is the first record)
        $orderType = $order_arr['dir']; // ASC or DESC

        $orderBy = $request->input('columns');
        $orderBy = $orderBy[$orderByColumnIndex]['name'];//Get name of the sorting column from its index

        $select = "histories.*, users.name";

        $from = " histories
        left join users on users.user_uuid=histories.user_uuid";

        $where = "
            (
            lower(histories.type) LIKE '%{$search}%' or
            lower(request) LIKE '%{$search}%' or
            lower(reference) LIKE '%{$search}%' or
            lower(name) LIKE '%{$search}%'
            )
        ";

        $orderBy = $orderBy ?: 'created_at';
        $orderType = $orderType ?: 'desc';
        $etc = "ORDER BY {$orderBy} {$orderType} ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
//            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->cooperative_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
//            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->cooperative_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->type,
                $data->request,
                $data->reference,
                $data->name,
                $data->created_at,
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => \App\Models\History::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}