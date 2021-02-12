<?php

namespace App\Http\Controllers\Koperasi;

use App\Helpers\History;
use App\Models\Cooperative;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\User;
use App\Models\UserCooperative;
use App\Models\UserRole;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class AdminController extends Controller
{
    private $menu_id = 13;
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
            'url' => $this->url,
            'menu' => $this->menu,
        ]);
    }

    public function create()
    {
        if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
            $partner = Cooperative::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
        } else {
            $partner = Cooperative::all();
        }
        return view($this->path . 'form', [
            'data' => new User(),
            'url' => $this->url,
            'menu' => $this->menu,
            'partner' => $partner,
        ]);
    }

    public function edit($uuid)
    {
        try {
            if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
                $partner = Cooperative::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
            } else {
                $partner = Cooperative::all();
            }
            return view($this->path . 'form', [
                'data' => User::find($uuid),
                'url' => $this->url,
                'menu' => $this->menu,
                'partner' => $partner,
            ]);
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function save(Request $request)
    {
        $user_uuid = $request->user_uuid;
        db::beginTransaction();
        try {
            $val = [
                'name' => 'required|max:100',
                'birthdate' => 'required',
                'address' => 'required',
                'photo' => 'image|mimes:jpeg,bmp,png,jpg,gif',
            ];

            if ($request->password and !empty($user_uuid)) {
                $val = array_merge($val, [
                    'password' => 'required|confirmed|min:8|alpha_num',
                ]);
            } elseif (empty($user_uuid)) {
                $val = array_merge($val, [
                    'password' => 'required|confirmed|min:8|alpha_num',
                ]);
            }

            if ($user_uuid) {
                $user = User::find($user_uuid);
                $val = array_merge($val, [
                    'email' => 'required|email|unique:users,email,' . $user->user_uuid . ',user_uuid',
                    'mobile_number' => 'required|unique:users,mobile_number,' . $user->user_uuid . ',user_uuid',
                ]);
            } else {
                $val = array_merge($val, [
                    'email' => 'required|email|unique:users',
                    'mobile_number' => 'required|unique:users',
                ]);
            }

            $msg = [
                'name.required' => 'Name is required',
                'name.max' => 'Name is max 100',
                'email.required' => 'Email is required',
                'email.email' => 'Email is required mail address format',
                'mobile_number.required' => 'Mobile is required',
                'mobile_number.unique' => 'Mobile is already used',
                'password.required' => 'Password is required',
                'password.alpha_num' => 'Password is alphanum required',
                'password.min' => 'Password is min 8',
                'birthdate.required' => 'Birthdate is required',
                'address.required' => 'Address is required',
                'photo.mimes' => 'Photo mimes is jpeg,bmp,png,jpg,gif required',
            ];
            $validator = Validator::make($request->all(), $val, $msg);
            if ($validator->fails()) {
                $err = '<ul>';
                foreach ($validator->errors()->all() as $e) {
                    $err .= "<li>" . $e . "</li>";
                }
                $err .= " </ul>";
                return response()->json([
                    "redirect_to" => '',
                    "message" => $err
                ], 200);
            }

            if ($user_uuid) {
                $user = User::find($user_uuid);
                History::log($this->menu->label, 'update', $request->email);
            } else {
                $user = new User();
                History::log($this->menu->label, 'create', $request->email);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->mobile_number = $request->mobile_number;
            $user->birthdate = ($request->birthdate) ? date('Y-m-d', strtotime($request->birthdate)) : null;
            $user->address = $request->address;
            $user->user_status_id = $request->user_status_id;
            $user->gender_id = $request->gender_id;
            $user->type = 2;
            $user->save();

            $user_role = UserRole::where('user_uuid', $user->user_uuid)->first();
            if ($user_role) {
                $user_role->role_uuid = $request->role_uuid;
                $user_role->updated_at = date('Y-m-d H:i:s');
                $user_role->save();
            } else {
                $user_role = new UserRole();
                $user_role->user_uuid = $user->user_uuid;
                $user_role->role_uuid = $request->role_uuid;
                $user_role->created_at = date('Y-m-d H:i:s');
                $user_role->save();
            }

            UserCooperative::where('user_uuid', $user->user_uuid)->delete();
            if ($request->cooperative_uuid) {
                $user_coop = new UserCooperative();
                $user_coop->user_uuid = $user->user_uuid;
                $user_coop->cooperative_uuid = $request->cooperative_uuid;
                $user_coop->save();
            }

            $file = $request->file('file');
            if ($file) {
                $user = User::find($user->user_uuid);
                $user->file_path = $request->file('file')->store('/public/profile');
                $user->save();
            }
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

    public function delete($id)
    {
        try {
            $data = User::find($id);
            History::log($this->menu->label, 'delete', $data->email);
            $data->delete();
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


        $select = "users.*, user_statuses.user_status_name, roles.role_name, b.cooperative_name";

        $cu = '';
        $where2 = ' where 1=1 ';
        foreach (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray() as $n => $i) {
            $cu .= "'{$i}'";
            if ($n != count(Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) - 1) {
                $cu .= ",";
            }
        }
        if ($cu) {
            $where2 .= " and cooperatives.cooperative_uuid in ($cu)";
        }

        $from = " users
         left join user_statuses on user_statuses.user_status_id=users.user_status_id
         left join ( 
             select * from (
                    select role_uuid, user_uuid,
                    ROW_NUMBER() OVER (PARTITION BY role_uuid, user_uuid ORDER BY updated_at DESC) AS row
                    from user_roles
             )a where a.row=1
         )a on a.user_uuid=users.user_uuid
         join(
            select user_uuid, string_agg(cooperative_name, ',')cooperative_name
            from user_cooperatives
            join cooperatives on cooperatives.cooperative_uuid=user_cooperatives.cooperative_uuid
            $where2
            group by user_uuid
         ) b on b.user_uuid=users.user_uuid
         left join roles on roles.role_uuid=a.role_uuid";

        $where = " users.type=2 and users.deleted_at is null and 
            (lower(name) LIKE '%{$search}%' OR
            lower(email) LIKE '%{$search}%' OR
            lower(mobile_number) LIKE '%{$search}%' OR
            lower(user_status_name) LIKE '%{$search}%' OR
            lower(cooperative_name) LIKE '%{$search}%' OR
            lower(role_name) LIKE '%{$search}%')
        ";


        $etc = "ORDER BY {$orderBy} {$orderType}, name ASC ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<a href="' . url($this->url . '/edit/' . $data->user_uuid) . '" class="btn btn-xs btn-info  ti-pencil" title="Edit"></a>';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->user_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';

            $url = ($data->file_path) ? Storage::url($data->file_path) : '/assets/images/default-avatar.png';
            $hasils[] = [
                $start + $key + 1,
                '<a href="javascript:void(0)"><img src="' . $url . '" alt="" width="40" class="img-circle" /></a> ' . $data->name,
                $data->email,
                $data->mobile_number,
                $data->role_name,
                $data->user_status_name,
                $data->cooperative_name,
                $data->last_login_at,
                $actionData,
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => User::where('type', 2)->where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}