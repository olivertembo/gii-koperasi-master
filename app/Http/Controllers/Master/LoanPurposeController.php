<?php

namespace App\Http\Controllers\Master;

use App\Helpers\History;
use App\Models\LoanPurpose;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanPurposeController extends Controller
{
    private $menu_id = 31;
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
        $data = new LoanPurpose();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function edit($uuid)
    {
        $data = LoanPurpose::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = LoanPurpose::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label, 'delete', $data->loan_purpose_name);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $loan_purpose_uuid = $request['loan_purpose_uuid'];
            if ($loan_purpose_uuid) {
                $data = LoanPurpose::find($loan_purpose_uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'update', $request['loan_purpose_name']);
            } else {
                $data = new LoanPurpose();
                $data->created_at = date('Y-m-d H:i:s');

                History::log($this->menu->label, 'create', $request['loan_purpose_name']);
            }
            $data->loan_purpose_name = $request['loan_purpose_name'];
            $data->is_active = $request['is_active'];
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

        $from = " loan_purposes ";

        $where = " deleted_at is null and 
            (lower(loan_purpose_name) LIKE '%{$search}%')
        ";

        $etc = "ORDER BY {$orderBy} {$orderType}, updated_at desc ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->loan_purpose_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->loan_purpose_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->loan_purpose_name,
                ($data->is_active == true) ? 'Active' : 'Deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => LoanPurpose::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}