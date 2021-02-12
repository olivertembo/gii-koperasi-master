<?php

namespace App\Http\Controllers\ProductLoan;

use App\Helpers\History;
use App\Models\Fine;
use App\Models\Interest;
use App\Models\LoanPurpose;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    private $menu_id = 35;
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
        $data = new Fine();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function edit($uuid)
    {
        $data = Fine::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = Fine::find($uuid);
            $data->delete();
            History::log($this->menu->label, 'delete', $data->day_amount);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['fine_uuid'];
            if ($uuid) {
                $data = Fine::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'update', $request->day_amount);
            } else {
                $data = new Fine();
                $data->created_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'create', $request->day_amount);
            }
            $data->fine_type_id = $request['fine_type_id'];
            $data->currency_id = $request['currency_id'];
            $data->is_percentage = $request['is_percentage'];
            $data->fine_percentage = $request['fine_percentage'] ?: 0;
            $data->fine_amount = $request['fine_amount'] ?: 0;
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

        $from = " fines
         join fine_types on fine_types.fine_type_id=fines.fine_type_id 
         left join currencies on currencies.currency_id=fines.currency_id 
         ";

        $where = " deleted_at is null and 
            (
            lower(currency_name) LIKE '%{$search}%' or
            lower(currency_symbol) LIKE '%{$search}%' or
            lower(currency_iso_code) LIKE '%{$search}%' or
            lower(fine_type_symbol) LIKE '%{$search}%' or
            fine_percentage::char LIKE '%{$search}%' or
            fine_amount::char LIKE '%{$search}%' or
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->fine_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->fine_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->fine_type_symbol . ' ' . $data->day_amount,
                $data->is_percentage,
                $data->fine_percentage . '/day',
                $data->currency_symbol . ' ' . $data->fine_amount . '/day',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Fine::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}