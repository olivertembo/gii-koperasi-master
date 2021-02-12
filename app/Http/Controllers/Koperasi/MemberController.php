<?php

namespace App\Http\Controllers\Koperasi;

use App\Models\Cooperative;
use App\Models\CooperativeMember;
use App\Models\Customer;
use App\Helpers\History;
use App\Models\Menu;
use App\Models\User;
use App\Models\UserRole;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class MemberController extends Controller
{
    private $menu_id = 14;
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
            'data' => new CooperativeMember(),
            'url' => $this->url,
            'menu' => $this->menu,
            'partner' => $partner,
        ]);
    }

    public function edit($id)
    {
        try {
            if (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) {
                $partner = Cooperative::whereIn('cooperative_uuid', Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray())->get();
            } else {
                $partner = Cooperative::all();
            }
            return view($this->path . 'form', [
                'data' => CooperativeMember::find($id),
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
        $uuid = $request->cooperative_member_uuid;
        db::beginTransaction();
        try {
            $val = [
                'cooperative_uuid' => 'required',
                'city_id' => 'required',
                'name' => 'required|max:100',
                'email' => 'required|email',
                'mobile_number' => 'required',
                'birthdate' => 'required',
                'birthplace' => 'required',
                'address' => 'required',
                'nik' => 'required',
                'join_date' => 'required',
                'photo' => 'image|mimes:jpeg,bmp,png,jpg,gif',
            ];

            $msg = [
                'cooperative_uuid.required' => 'Cooperative is required',
                'city_id.required' => 'City is required',
                'name.required' => 'Name is required',
                'name.max' => 'Name is max 100',
                'email.required' => 'Email is required',
                'email.email' => 'Email is required mail address format',
                'mobile_number.required' => 'Mobile number is required',
                'birthdate.required' => 'Birthdate is required',
                'birthplace.required' => 'Birthplace is required',
                'address.required' => 'Address is required',
                'nik.required' => 'Identity Number (NIK) is required',
                'join_date.required' => 'Join Date is required',
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

            if ($uuid) {
                $member = CooperativeMember::find($uuid);
                $member->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'update', $request->name);
            } else {
                $member = new CooperativeMember();
                $member->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label, 'create', $request->name);
            }
            $member->cooperative_uuid = $request->cooperative_uuid;
            $member->city_id = $request->city_id;
            $member->gender_id = $request->gender_id;
            $member->customer_status_id = $request->customer_status_id;
            $member->limit = $request->limit ?: 0;
            $member->name = $request->name;
            $member->email = $request->email;
            $member->mobile_number = $request->mobile_number;
            $member->birthdate = ($request->birthdate) ? date('Y-m-d', strtotime($request->birthdate)) : null;
            $member->birthplace = $request->birthplace;
            $member->address = $request->address;
            $member->postcode = $request->postcode;
            $member->nik = $request->nik;
            $member->member_number = $request->member_number;
            $member->mother_name = $request->mother_name;
            $member->join_date = $request->join_date;

            $file = $request->file('file');
            if ($file) {
                $member->file_path = $request->file('file')->store('/public/profile');
                $member->fileb64 = base64_encode($file);
            }
            $member->save();
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
            $data = CooperativeMember::find($id);
            History::log($this->menu->label, 'delete', $data->name);
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


        $select = "cooperative_members.*, customer_statuses.customer_status_name,
        cooperatives.cooperative_name,cities.city_name, cities.tipe_dati2";

        $from = " cooperative_members
         left join customer_statuses on customer_statuses.customer_status_id=cooperative_members.customer_status_id
         left join cooperatives on cooperatives.cooperative_uuid=cooperative_members.cooperative_uuid
         left join cities on cities.city_id=cooperative_members.city_id
         ";

        $where = "cooperative_members.deleted_at is null and
            (lower(cooperative_name) LIKE '%{$search}%' OR
            lower(name) LIKE '%{$search}%' OR
            lower(cooperative_members.email) LIKE '%{$search}%' OR
            lower(member_number) LIKE '%{$search}%' OR
            lower(mobile_number) LIKE '%{$search}%' OR
            lower(address) LIKE '%{$search}%' OR
            lower(city_name) LIKE '%{$search}%' OR
            lower(postcode) LIKE '%{$search}%' OR
            lower(to_char(join_date,'YYY-MM-DD')) LIKE '%{$search}%')
        ";

        $cu = '';
        foreach (Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray() as $n => $i) {
            $cu .= "'{$i}'";
            if ($n != count(Auth::user()->cooperatives->pluck('cooperative_uuid')->toArray()) - 1) {
                $cu .= ",";
            }
        }
        if ($cu) {
            $where .= " and cooperatives.cooperative_uuid in ($cu)";
        }


        $etc = " ORDER BY {$orderBy} {$orderType}, updated_at desc ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<a href="' . url($this->url . '/edit/' . $data->cooperative_member_uuid) . '" class="btn btn-xs btn-info  ti-pencil" title="Edit"></a>';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->cooperative_member_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';

            $url = ($data->file_path) ? Storage::url($data->file_path) : '/assets/images/default-avatar.png';
            $hasils[] = [
                $start + $key + 1,
                $data->cooperative_name,
                '<a href="javascript:void(0)"><img src="' . $url . '" alt="" width="40" class="img-circle" /></a> ' . $data->name,
                $data->email,
                $data->mobile_number,
                $data->address . ', ' . $data->city_name . (($data->tipe_dati2) ? ' (' . $data->tipe_dati2 . ')' : '') . ' ' . $data->postcode,
                $data->join_date,
                $actionData,
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => CooperativeMember::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }
}
