<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Customer;
use App\Models\InstallmentDetail;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    private $menu_id = 15;
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

        $select = "customers.customer_uuid, customer_number, name, email, mobile_number,city_name, join_date, 
        file_path, users.created_at,customers.limit,
        customer_status_name,customer_status_class";

        $from = " customers 
        join users on users.user_uuid=customers.user_uuid
        left join cities on cities.city_id=users.city_id
        join customer_statuses on customer_statuses.customer_status_id=customers.customer_status_id
        join (
             select a.upgrade_status_id, a.customer_uuid,upgrade_status_name,upgrade_status_class from (
                    select upgrade_status_id, customer_uuid,
                    ROW_NUMBER() OVER (PARTITION BY customer_uuid ORDER BY created_at DESC) AS row
                    from customer_upgrade_statuses
             )a 
             join upgrade_statuses on upgrade_statuses.upgrade_status_id=a.upgrade_status_id
             where a.row=1
        )a on a.customer_uuid=customers.customer_uuid";

        $where = " a.upgrade_status_id=6 and
            (
            lower(customer_number) LIKE '%{$search}%' or
            lower(customer_status_name) LIKE '%{$search}%' or
            lower(customer_number) LIKE '%{$search}%' or
            lower(name) LIKE '%{$search}%' or
            lower(email) LIKE '%{$search}%' or
            lower(mobile_number) LIKE '%{$search}%' or
            lower(city_name) LIKE '%{$search}%' or
            join_date::char LIKE '%{$search}%'
            )
        ";

        $etc = "ORDER BY {$orderBy} {$orderType} ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;
        $where = " 1=1 and a.upgrade_status_id=6";
        $total = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<div class="btn-group">
                                <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="' . url($this->url . '/detail/' . $data->customer_uuid) . '">Detail</a>
                                                    </div>
                                                </div>';
            $hasils[] = [
                $start + $key + 1,
                $data->customer_number,
                $data->name,
                $data->email,
                $data->mobile_number,
                $data->city_name,
                '<lable class="' . $data->customer_status_class . '">' . $data->customer_status_name . '</lable>',
                $data->join_date,
                $data->limit,
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function detail($uuid)
    {
        $data = Customer::find($uuid);
        return view($this->path . 'detail', [
            'data' => $data,
            'menu' => $this->menu,
            'url' => $this->url
        ]);
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $cust = Customer::find($request->customer_uuid);
            $cust->customer_status_id = $request->customer_status_id;
            $cust->job_id = $request->job_id;

            $cust->mother_name = $request->mother_name;
            $cust->work_experience = $request->work_experience;
            $cust->work_place = $request->work_place;
            $cust->income = $request->income;
            $cust->limit = $request->limit;
            $cust->save();

            $user = User::find($cust->user_uuid);
            $user->city_id = $request->city_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile_number = $request->mobile_number;
            $user->address = $request->address;
            $user->postcode = $request->postcode;
            $user->nik = $request->nik;
            $user->birthdate = $request->birthdate;
            $user->birthplace = $request->birthplace;
            $user->save();

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
