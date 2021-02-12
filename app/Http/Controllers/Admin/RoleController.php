<?php

namespace App\Http\Controllers\Admin;


use App\Helpers\History;
use App\Models\Menu;
use App\Models\RoleMenu;
use App\Models\RoleUpgradeStatus;
use DB;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $menu_id = 11;
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
    public function index()
    {
        return view($this->path . 'index', [
            'url' => $this->url,
            'menu' => $this->menu,
        ]);
    }

    public function create()
    {
        return view($this->path . 'form', [
            'data' => new Role(),
            'url' => $this->url,
            'menu' => $this->menu,
        ]);
    }

    public function edit($id)
    {
        try {
            $data = Role::find($id);
            if ($data) {
                return view($this->path . 'form', [
                    'data' => $data,
                    'url' => $this->url,
                    'menu' => $this->menu,
                ]);
            } else {
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $menu_ids = $request->menu_id;
            $role_uuid = $request->role_uuid;
            if ($role_uuid) {
                $data = Role::find($role_uuid);
                History::log($this->menu->label, 'update', $request->role_name);
            } else {
                $data = new Role();
                History::log($this->menu->label, 'create', $request->role_name);
            }
            $data->role_code = $request->role_code;
            $data->role_name = $request->role_name;
            $data->is_active = $request->is_active;
            $data->is_verificator = $request->is_verificator;
            $data->loan_type = $request->loan_type;
            $data->role_type = $request->role_type;
            $data->save();
            db::update("update role_menus set is_active ='f' where role_uuid='{$data->role_uuid}'");
            foreach ($menu_ids as $menu_id) {
                $role_menu = RoleMenu::where('menu_id', $menu_id)->where('role_uuid', $data->role_uuid)->first();
                if ($role_menu) {
                    $role_menu->is_active = true;
                    $role_menu->save();
                    $menu = Menu::where('menu_id', $menu_id)->where('parent_id', '!=', 0)->first();
                    if ($menu) {
                        $role_menu_parent = RoleMenu::where('menu_id', $menu->parent_id)->where('role_uuid', $data->role_uuid)->first();
                        if ($role_menu_parent) {
                            $role_menu_parent->is_active = true;
                            $role_menu_parent->save();
                        } else {
                            $new_role_menu = new RoleMenu();
                            $new_role_menu->menu_id = $menu->parent_id;
                            $new_role_menu->role_uuid = $data->role_uuid;
                            $new_role_menu->is_active = true;
                            $new_role_menu->created_at = date('Y-m-d H:i:s');
                            $new_role_menu->save();
                        }
                    }
                } else {
                    $new_role_menu = new RoleMenu();
                    $new_role_menu->menu_id = $menu_id;
                    $new_role_menu->role_uuid = $data->role_uuid;
                    $new_role_menu->is_active = true;
                    $new_role_menu->created_at = date('Y-m-d H:i:s');
                    $new_role_menu->save();
                }
            }

            $upgrade_status = $request['upgrade_status'];
            RoleUpgradeStatus::where('role_uuid', $data->role_uuid)->delete();
            if ($upgrade_status) {
                foreach ($upgrade_status as $i) {
                    $role_us = new RoleUpgradeStatus();
                    $role_us->role_uuid = $data->role_uuid;
                    $role_us->upgrade_status_id = $i;
                    $role_us->save();
                }
            }
            db::commit();
            $flash[] = [
                'title' => "Success",
                'message' => "Data saved successfully",
                'type' => 'success'
            ];
            return redirect($this->url)->with(['flashs' => $flash]);
        } catch (\Exception $e) {
            db::rollback();
            $flash[] = ['title' => "Failed",
                'message' => "Data failed to saved",
                'type' => 'danger',
            ];
            return redirect()->back()->with(['flashs' => $flash]);
        }
    }

    public
    function delete($id)
    {
        $data = Role::find($id);
        History::log($this->menu->label, 'delete', $data->role_name);
        RoleMenu::where('role_uuid', $data->role_uuid)->delete();
        $data->delete();
    }

    public
    function dataTable(Request $request)
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


        $select = "roles.*, a.upgrade_status_name";

        $from = " roles 
        left join (
            select roles.role_uuid, string_agg(upgrade_status_name,',') upgrade_status_name
            from role_upgrade_statuses
            join roles on roles.role_uuid=role_upgrade_statuses.role_uuid
            join upgrade_statuses on upgrade_statuses.upgrade_status_id=role_upgrade_statuses.upgrade_status_id
            group by roles.role_uuid
        ) a on a.role_uuid=roles.role_uuid";

        $where = "
            (lower(role_name) LIKE '%{$search}%' OR
            lower(upgrade_status_name) LIKE '%{$search}%' OR
            lower(role_code) LIKE '%{$search}%')
        ";

        $etc = "ORDER BY {$orderBy} {$orderType}, role_name ASC ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $Data) {
            $actionData = '<a href="' . url($this->url . '/edit/' . $Data->role_uuid) . '" class="btn btn-xs btn-info  ti-pencil" title="Edit"></a>';
            $actionData .= '<button onclick="deleteData(\'' . $Data->role_uuid . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $Data->role_code,
                $Data->role_name,
                ($Data->is_active == true) ? 'Active' : "Inactive",
                ($Data->is_verificator == true) ? 'Yes' : "No",
                ($Data->loan_type == 1) ? 'Money' : (($Data->loan_type == 2) ? 'Product' : ''),
                ($Data->role_type == 1) ? 'Internal' : (($Data->role_type == 2) ? 'External' : ''),
                $Data->upgrade_status_name,
                $actionData,
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Role::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}
