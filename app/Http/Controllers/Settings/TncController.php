<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\History;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TncController extends Controller
{
    private $menu_id = 28;
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
        $data = Setting::where('type', 2)->first();
        if (empty($data)) {
            $data = new Setting();
        }
        return view($this->path . 'index', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data,
        ]);
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['setting_uuid'];
            if ($uuid) {
                $data = Setting::find($uuid);
                $data->type = 2;
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'update', $request->title);
            } else {
                $data = new Setting();
                $data->type = 2;
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'create', $request->title);
            }
            $data->title = $request['title'];
            $data->content = $request['content'];
            $data->save();
            db::commit();
            return response()->json([
                "redirect_to" => $this->url,
                "message" => "Saved successfully"
            ], 200);
        } catch (\Exception $e) {
            db::rollback();
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
