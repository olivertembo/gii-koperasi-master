<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\Curl;
use App\Helpers\History;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    private $menu_id = 25;
    private $path, $url, $menu;

    public function __construct()
    {
        $menu = Menu::find($this->menu_id);
        $this->menu = $menu;
        $this->path = $menu->path;
        $this->url = $menu->url;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view($this->path . 'index', [
            'menu' => $this->menu,
            'url' => $this->url
        ]);
    }

    public function create()
    {
        $data = new Banner();
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function edit($uuid)
    {
        $data = Banner::find($uuid);
        return view($this->path . 'form', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function delete($uuid)
    {
        try {
            $data = Banner::find($uuid);
            $data->delete();
            History::log($this->menu->label, 'delete', $data->title);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['banner_uuid'];
            if ($uuid) {
                $data = Banner::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'update', $request->title);
            } else {
                $data = new Banner();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'create', $request->title);
            }
            $data->title = $request['title'];
            $data->content = $request['content'];
            $data->is_active = $request['is_active'];

            $file = $request->file('file');
            if ($file) {
                $data->file_path = $request->file('file')->store('/public/banner');
                $data->fileb64 = base64_encode($file);
            }
            $data->save();
            db::commit();

            if ($data->is_active == 't') {
                $body = $data->title;
                $data = json_encode(['banner_uuid' => $data->banner_uuid]);
                $params = str_replace(' ', '%20', "to=/topics/banner&title=Banner&body=" . $body . "&action=banner&data=" . $data);
                $url = "/api/v1/open/fcm/push";
                Curl::run($url, $params);
            }
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

        $from = " banners ";

        $where = " deleted_at is null and 
            (
            lower(title) LIKE '%{$search}%' or
            lower(content) LIKE '%{$search}%'
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->banner_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->banner_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $url = ($data->file_path) ? Storage::url($data->file_path) : '';
            $hasils[] = [
                $start + $key + 1,
                $data->title,
                $data->content,
                '<a href="javascript:void(0)"><img src="' . $url . '" alt="" width="100" class="img-thumbnail" /></a>',
                ($data->is_active == true) ? 'Active' : 'Deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Banner::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}
