<?php

namespace App\Http\Controllers\Master;

use App\Helpers\History;
use App\Models\Cooperative;
use App\Models\LoanPurpose;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoperasiController extends Controller
{
    private $menu_id = 33;
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
        $data = new Cooperative();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
            'courier_provinces' => $this->getProvinces(),
            'courier_cities' => [],
            'courier_subdistricts' => [],
        ]);
    }

    public function edit(Request $request, $uuid)
    {
        $data = Cooperative::find($uuid);

        if ($data->origin_details) {
            $origin_details = json_decode($data->origin_details, true);
            $request['province'] = $origin_details['province_id'];
            $request['city'] = $origin_details['city_id'];
            $data->courier_province_id = $origin_details['province_id'];
            $data->courier_city_id = $origin_details['city_id'];

        }

        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
            'courier_provinces' => $this->getProvinces(),
            'courier_cities' => $this->getCities($request),
            'courier_subdistricts' => $this->getSubdistrict($request),
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = Cooperative::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label, 'delete', $data->cooperative_name);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['cooperative_uuid'];
            if ($uuid) {
                $data = Cooperative::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'update', $request['cooperative_name']);
            } else {
                $data = new Cooperative();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'create', $request['cooperative_name']);
            }
            $data->city_id = $request['city_id'];
            $data->cooperative_name = $request['cooperative_name'];
            $data->cooperative_code = $request['cooperative_code'];
            $data->cooperative_address = $request['cooperative_address'];
            $data->phone = $request['phone'];
            $data->email = $request['email'];
            $data->website = $request['website'];
            $data->additional_limit = $request['additional_limit'] ?: 0;
            $data->origin = $request->origin;
            $data->origin_type = $request->origin_type ?: 'subdistrict';
            $data->profit_sharing_money = $request->profit_sharing_money;
            $data->profit_sharing_money_tenure = $request->profit_sharing_money_tenure;
            $data->profit_sharing_product = $request->profit_sharing_product;
            $data->partner_type_id = $request->partner_type_id;

            $request['id'] = $request->origin;
            $origin_details = json_encode($this->getSubdistrict($request));
            $data->origin_details = $origin_details;
            $data->save();

            db::commit();
            return response()->json([
                'redirect_to' => $this->url,
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

        $from = " cooperatives
        left join cities on cities.city_id=cooperatives.city_id
        left join partner_types on partner_types.partner_type_id=cooperatives.partner_type_id
        ";

        $where = " deleted_at is null and 
            (
            lower(cooperative_name) LIKE '%{$search}%' or
            lower(cooperative_code) LIKE '%{$search}%' or
            lower(city_name) LIKE '%{$search}%' or
            lower(cooperative_address) LIKE '%{$search}%' or
            lower(phone) LIKE '%{$search}%' or
            lower(email) LIKE '%{$search}%' or
            lower(website) LIKE '%{$search}%' or
            lower(partner_type_name) LIKE '%{$search}%' or
            additional_limit::char LIKE '%{$search}%' 
            )
        ";

        $orderBy = $orderBy ?: 'updated_at';
        $orderType = $orderType ?: 'desc';
        $etc = "ORDER BY {$orderBy} {$orderType} ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<a href="' . url($this->url . '/edit/' . $data->cooperative_uuid) . '" class="btn btn-xs btn-info  ti-pencil" title="Edit"></a>';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->cooperative_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $origin = '';
            if ($data->origin_details) {
                $origin_details = json_decode($data->origin_details, true);
                $origin = $origin_details['subdistrict_name'] . ' - ' . $origin_details['city'] . ' (' . $origin_details['type'] . ')';
            }
            $hasils[] = [
                $start + $key + 1,
                $data->partner_type_name,
                $data->cooperative_code,
                $data->cooperative_name,
                $data->cooperative_address,
                $data->city_name . (($data->tipe_dati2) ? ' (' . $data->tipe_dati2 . ')' : ''),
                $data->phone,
                $data->email,
                $data->website,
                $data->additional_limit,
                $origin,
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Cooperative::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function getProvinces()
    {
        $url = env('RAJAONGKIR_URL') . "/api/province";
        $headers = [
            'content-type: application/x-www-form-urlencoded',
            'key:' . env('RAJAONGKIR_KEY'),
        ];

        return $this->_curl2($url, 'get', $headers, null);
    }

    public function getCities(Request $request)
    {
        $url = env('RAJAONGKIR_URL') . "/api/city";
        $headers = [
            'content-type: application/x-www-form-urlencoded',
            'key:' . env('RAJAONGKIR_KEY'),
        ];

        $data = [
            'province' => $request->province,
            'id' => $request->id,
        ];

        return $this->_curl2($url, 'get', $headers, $data);
    }

    public function getSubdistrict(Request $request)
    {
        $url = env('RAJAONGKIR_URL') . "/api/subdistrict";
        $headers = [
            'content-type: application/x-www-form-urlencoded',
            'key:' . env('RAJAONGKIR_KEY'),
        ];

        $data = [
            'city' => $request->city,
            'id' => $request->id,
        ];

        return $this->_curl2($url, 'get', $headers, $data);
    }

    private function _curl2($url, $method = 'GET', $headers, $datas = null)
    {
        if (!empty($datas)) {
            $query = http_build_query($datas);
            $url = $url . '?' . $query;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        if ($response) {
            if ($response['rajaongkir']['status']['code'] == 200) {
                return $response['rajaongkir']['results'];
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    private function _curl($url, $method, $headers, $datas = null)
    {
        if ($headers == null) {
            $headers = array("Content-Type: application/json");
        }

        if (!empty($datas)) {
            $query = http_build_query($datas);
            $url = $url . '?' . $query;
        }

        // Open connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (strtolower($method) == 'post') {
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($datas)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
            }
        }
        // Execute post
        $result = curl_exec($ch);
        if (FALSE === $result) {
            // error handling
            // dd(curl_error($ch), curl_errno($ch));
        }

        // Close connection
        curl_close($ch);

        return $result;
    }
}