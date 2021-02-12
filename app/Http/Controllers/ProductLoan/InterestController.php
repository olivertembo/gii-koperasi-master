<?php

namespace App\Http\Controllers\ProductLoan;

use App\Helpers\History;
use App\Models\Interest;
use App\Models\LoanPurpose;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterestController extends Controller
{
    private $menu_id = 34;
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

    public function create()
    {
        $data = new Interest();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function edit($uuid)
    {
        $data = Interest::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = Interest::find($uuid);
            $data->delete();
            History::log($this->menu->label, 'delete', $data->interest_percentage . ' %');
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['interest_uuid'];
            if ($uuid) {
                $data = Interest::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'update', $request->interest_percentage . ' %');
            } else {
                $data = new Interest();
                $data->created_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'create', $request->interest_percentage . ' %');
            }
            $data->interest_type_id = $request['interest_type_id'];
            $data->interest_percentage = $request['interest_percentage'];
            $data->tenure = $request['tenure'];
            $data->day_amount = $request['day_amount'];
            $data->save();
            db::commit();
            return response()->json([
                "message" => "Saved successfully"
            ], 200);
        } catch (\Exception $e) {
            db::rollback();
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
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

        $select = "*";

        $from = " interests
         join interest_types on interest_types.interest_type_id=interests.interest_type_id ";

        $where = " deleted_at is null and 
            (
            lower(interest_type_name) LIKE '%{$search}%' or
            interest_percentage::char LIKE '%{$search}%' or
            tenure::char LIKE '%{$search}%' or
            day_amount::char LIKE '%{$search}%'
            )
        ";

        $etc = "ORDER BY {$orderBy} {$orderType}, updated_at desc ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->interest_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->interest_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->tenure . ' ' . $data->interest_type_name,
                $data->interest_percentage . '% / ' . $data->day_amount.' days',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Interest::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}