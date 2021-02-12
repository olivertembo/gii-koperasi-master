<?php

namespace App\Http\Controllers\ProductLoan;

use App\Helpers\History;
use App\Models\Coupon;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Helpers\Curl;

class CouponController extends Controller
{
    private $menu_id = 39;
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
        $data = new Coupon();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function edit($uuid)
    {
        $data = Coupon::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = Coupon::find($uuid);
            $data->delete();
            History::log($this->menu->label, 'delete', $data->coupon_name . ' %');
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['coupon_uuid'];
            if ($uuid) {
                $data = Coupon::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'update', $request->coupon_name . ' %');
            } else {
                $data = new Coupon();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'create', $request->coupon_name . ' %');
            }
            $data->coupon_name = $request['coupon_name'];
            $data->is_percentage = $request['is_percentage'];
            $data->percentage = $request['percentage'] ?: 0;
            $data->amount = $request['amount'] ?: 0;
            $data->expired_at = $request['expired_at'];
            $data->begin_at = $request['begin_at'];
            $data->currency_id = $request['currency_id'];
            $data->save();
            db::commit();

            /**
             * fcm push
             */
//            if ($uuid) {

            $discount = '';
            if ($data->is_percentage == 'true') {
                $discount = $data->percentage . '%';
            } else {
                $discount = $data->currency->currency_symbol . ' ' . number_format($data->amount,0,'.',',');
            }
            $isi = $data->coupon_name . ", expired at " . date('d M Y', strtotime($data->expired_at)) . ', discount ' . $discount;
            $params = str_replace(' ', '%20', "to=/topics/coupon&title=Coupon Promo&body=" . $isi."&action=coupon");
            $url = "/api/v1/open/fcm/push";
            Curl::run($url, $params);
//            }
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

        $from = " coupons";

        $where = " deleted_at is null and 
            (
            lower(coupon_name) LIKE '%{$search}%' or
            percentage::char LIKE '%{$search}%' or
            amount::char LIKE '%{$search}%'
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->coupon_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->coupon_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->coupon_name,
                $data->is_percentage,
                $data->percentage . '%',
                $data->amount,
                $data->begin_at,
                $data->expired_at,
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Coupon::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }
}