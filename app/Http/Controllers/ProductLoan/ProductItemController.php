<?php

namespace App\Http\Controllers\ProductLoan;

use App\Helpers\History;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\ProductItemImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class ProductItemController extends Controller
{
    private $menu_id = 36;
    private $path, $url, $menu;

    public function __construct()
    {
        $menu = Menu::find($this->menu_id);
        $this->menu = $menu;
        $this->path = $menu->path;
        $this->url = $menu->url;
    }

    public function index()
    {
        return view($this->path . 'index', [
            'menu' => $this->menu,
            'url' => $this->url
        ]);
    }

    public function create()
    {
        if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
            $product = Product::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
        } else {
            $product = Product::all();
        }
        $data = new ProductItem();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
            'product' => $product,
        ]);
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['product_item_uuid'];
            if ($uuid) {
                $data = ProductItem::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'update', $request->product_item_name);
            } else {
                $data = new ProductItem();
                $data->created_at = date('Y-m-d H:i:s');
                History::log($this->menu->label, 'create', $request->product_item_name);
            }
            $data->product_uuid = $request['product_uuid'];
            $data->currency_id = $request['currency_id'];
            $data->quantity_type_uuid = $request['quantity_type_uuid'];
            $data->sku = $request['sku'];
            $data->product_item_name = $request['product_item_name'];
            $data->product_item_description = $request['product_item_description'];
            $data->price = $request['price'];
            $data->quantity = $request['quantity'];
            $data->is_active = $request['is_active'] ?: false;
            $data->weight_item = $request['weight_item'];
            $data->total_stock = $request['total_stock'];
            $data->save();

            $file = $request->file('file');
            if ($file) {
                foreach ($file as $i) {
                    $img = new ProductItemImage();
                    $img->product_item_uuid = $data->product_item_uuid;
                    $img->file_path = $i->store('/public/product_item_images');
                    $ext = $i->getClientOriginalExtension();
                    $img->fileb64 = 'data:image/' . $ext . ';base64,' . base64_encode(file_get_contents($i));
                    $img->save();
                }
            }
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

    public function card()
    {
        return view($this->path . 'card', [
            'menu' => $this->menu,
            'url' => $this->url,
        ]);
    }

    public function item(Request $request)
    {
        $offset = $request->offset ?: 0;
        $limit = 8;

        $product_category_uuid = $request->product_category_uuid;
        $product_uuid = $request->product_uuid;
        $is_active = $request->is_active;
        $search = strtolower($request->search);

        $where = "1=1  ";
        if ($product_category_uuid) {
            $where .= " and products.product_category_uuid='{$product_category_uuid}'";
        }

        if ($product_uuid) {
            $where .= " and product_items.product_uuid='{$product_uuid}'";
        }

        if ($is_active) {
            $where .= " and product_items.is_active='$is_active'";
        }

        if ($search) {
            $where .= " 
            and (lower(products.sku) like '%$search%' 
            or lower(product_items.sku) like '%$search%' 
            or lower(product_item_name) like '%$search%'
            or lower(product_name) like '%$search%' 
            or lower(product_category_name) like '%$search%') 
            ";
        }

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

        $data = ProductItem::join('products', 'products.product_uuid', 'product_items.product_uuid')
            ->join('product_categories', 'product_categories.product_category_uuid', 'products.product_category_uuid')
            ->whereRaw($where)
            ->select('product_items.*')
            ->limit($limit)->offset($offset)
            ->orderBy('updated_at', 'desc')->get();
        $new_data = [];
        $page = [];
        $n = 0;
        for ($i = 0; $i < ceil(count($data) / $limit); $i++) {
            $page[] = $n;
            $n += $limit;
        }
        $new_data['pagination'] = [
            'previous' => ($offset == 0) ? $offset : $offset - $limit,
            'next' => $offset + $limit,
            'page' => $page,
            'offset' => $offset,
            'limit' => $limit,
            'start' => (count($data) == 0) ? 0 : $offset + 1,
            'end' => (count($data) == 0) ? 0 : (($offset + 1 <= count($data)) ? count($data) : ((($offset + 1) * 8 >= count($data)) ? (($offset + 1) * 8) : count($data))),
            'total' => ProductItem::count(),

        ];
        $product_item = [];
        foreach ($data as $d) {
            $images = [];
            foreach ($d->productItemImages as $i) {
                $images[] = [
                    'product_item_image_uuid' => $i->product_item_image_uuid,
                    'file_path' => Storage::url($i->file_path)
                ];
            }
            $product_item[] = [
                'product_item_uuid' => $d->product_item_uuid,
                'product_item_sku' => $d->sku,
                'product_sku' => $d->product->sku,
                'product_category_name' => $d->product->productCategory->product_category_name,
                'cooperative_name' => ($d->product->cooperative) ? $d->product->cooperative->cooperative_name : 'STIA',
                'product_item_name' => $d->product_item_name,
                'quantity_type_name' => $d->quantityType->quantity_type_name,
                'quantity' => $d->quantity,
                'currency_symbol' => $d->currency->currency_symbol,
                'price' => number_format($d->price, 0, ',', '.'),
                'images' => $images,
                'status' => ($d->is_active == true) ? 'Active' : 'Deactive'
            ];
        }
        $new_data['product_item'] = $product_item;
        return response()->json($new_data);
    }

    public function detail($uuid)
    {
        $data = ProductItem::find($uuid);
        return view($this->path . 'detail', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function edit($uuid)
    {
        if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
            $product = Product::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
        } else {
            $product = Product::all();
        }
        $data = ProductItem::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
            'product' => $product
        ]);
    }

    public function productItemImage($uuid)
    {
        $data = ProductItemImage::where('product_item_uuid', $uuid)->get();

        $new_data = [];
        foreach ($data as $i) {
            $new_data[] = [
                'product_item_image_uuid' => $i->product_item_image_uuid,
                'file_path' => Storage::url($i->file_path)
            ];
        }
        return response()->json($new_data);
    }

    public function productItemImageDelete($uuid)
    {
        try {
            $data = ProductItemImage::find($uuid);
            $data->delete();
            History::log($this->menu->label . ' - delete image', 'delete', $data->productItem->product_item_name);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function delete($uuid)
    {
        try {
            $data = ProductItem::find($uuid);
            $data->delete();
            ProductItemImage::where('product_item_uuid', $data->product_item_uuid)->delete();
            History::log($this->menu->label . ' - delete image', 'delete', $data->product_item_name);
            ProductItemImage::where('product_item_uuid', $uuid)->delete();
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
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

        $select = "product_items.*,currencies.*, quantity_types.*,products.product_name, product_categories.product_category_name";

        $from = " product_items
         join products on products.product_uuid=product_items.product_uuid
         join product_categories on product_categories.product_category_uuid=products.product_category_uuid
         left join cooperatives on cooperatives.cooperative_uuid=products.cooperative_uuid
         join currencies on currencies.currency_id=product_items.currency_id
         join quantity_types on quantity_types.quantity_type_uuid=product_items.quantity_type_uuid
         ";

        $where = " product_items.deleted_at is null and 
            (
            lower(product_category_name) LIKE '%{$search}%' or
            lower(product_name) LIKE '%{$search}%' or
            lower(product_item_name) LIKE '%{$search}%' or
            lower(cooperative_name) LIKE '%{$search}%' or
            lower(product_items.sku) LIKE '%{$search}%' or
            product_items.price::char LIKE '%{$search}%' or
            lower(product_item_description) LIKE '%{$search}%'
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

        $etc = "ORDER BY {$orderBy} {$orderType}, product_items.updated_at desc ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '';
            if (Auth::user()->isVerificator() or (!Auth::user()->isVerificator() && $data->is_active != true)) {
                $actionData = '<button type="button" onclick="modalForm(\'' . url($this->url . '/edit/' . $data->product_item_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
                $actionData .= '<button type="button" onclick="deleteData2(\'' . url($this->url . '/delete/' . $data->product_item_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            }
            $hasils[] = [
                $start + $key + 1,
                $data->product_category_name,
                $data->product_name,
                $data->sku,
                $data->product_item_name,
                $data->product_item_description,
                $data->currency_symbol . ' ' . number_format($data->price, 0, ',', '.') . ' / ' . $data->quantity . ' ' . $data->quantity_type_symbol,
                $data->weight_item,
                $data->total_stock,
                $data->total_sold,
                ($data->is_active == true) ? 'Active' : 'Deactive',
                $actionData,
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => ProductItem::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

}