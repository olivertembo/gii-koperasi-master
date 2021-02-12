<?php

namespace App\Http\Controllers\ProductLoan;

use App\Helpers\History;
use App\Http\Controllers\Controller;
use App\Models\Cooperative;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $menu_id = 20;
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
        if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
            $partner = Cooperative::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
        } else {
            $partner = Cooperative::all();
        }
        $data = new Product();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
            'partner' => $partner,
        ]);
    }

    public function edit($uuid)
    {
        if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
            $partner = Cooperative::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
        } else {
            $partner = Cooperative::all();
        }
        $data = Product::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
            'partner' => $partner,
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = Product::find($uuid);
            $data->delete();
            History::log($this->menu->label, 'delete', $data->product_name);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['product_uuid'];
            if ($uuid) {
                $data = Product::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'update', $request->product_name);
            } else {
                $data = new Product();
                $data->created_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'create', $request->product_name);
            }
            $data->sku = $request['sku'];
            $data->product_name = $request['product_name'];
            $data->product_description = $request['product_description'];
            $data->product_category_uuid = $request['product_category_uuid'];
            $data->cooperative_uuid = $request['cooperative_uuid'];
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

        $from = " products
         join product_categories on product_categories.product_category_uuid=products.product_category_uuid
         join cooperatives on cooperatives.cooperative_uuid=products.cooperative_uuid 
         ";

        $where = " products.deleted_at is null and 
            (
            lower(product_category_name) LIKE '%{$search}%' or
            lower(product_name) LIKE '%{$search}%' or
            lower(cooperative_name) LIKE '%{$search}%' or
            lower(sku) LIKE '%{$search}%' or
            lower(product_description) LIKE '%{$search}%'
            )
        ";
        $cu = '';
        foreach (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray() as $n => $i) {
            $cu .= "'{$i}'";
            if ($n != count(Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) - 1) {
                $cu .= ",";
            }
        }
        if ($cu) {
            $where .= " and products.cooperative_uuid in ($cu)";
        }

        $etc = "ORDER BY {$orderBy} {$orderType}, products.updated_at desc ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<button type="button" onclick="modalForm(\'' . url($this->url . '/edit/' . $data->product_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button type="button" onclick="deleteData2(\'' . url($this->url . '/delete/' . $data->product_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->product_category_name,
                $data->cooperative_name,
                $data->sku,
                $data->product_name,
                $data->product_description,
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Product::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }
}
