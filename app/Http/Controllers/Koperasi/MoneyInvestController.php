<?php

namespace App\Http\Controllers\Koperasi;

use App\Helpers\History;
use App\Models\Cooperative;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\MoneyInvest;
use App\Models\User;
use App\Models\UserCooperative;
use App\Models\UserRole;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;

class MoneyInvestController extends Controller
{
    private $menu_id = 41;
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
            'data' => new MoneyInvest(),
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
                'data' => MoneyInvest::find($uuid),
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
        $uuid = $request->money_invest_uuid;
        db::beginTransaction();
        try {
            $val = [
                'cooperative_uuid' => 'required',
                'amount' => 'required',
                'currency_id' => 'required',
            ];

            $msg = [
                'cooperative_uuid.required' => 'Partner is required',
                'amount.required' => 'Amount is required',
                'currency_id.required' => 'Currency is required',
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
                $data = MoneyInvest::find($uuid);
                History::log($this->menu->label, 'update', $request->amount);
            } else {
                $data = new MoneyInvest();
                History::log($this->menu->label, 'create', $request->amount);
            }
            $data->amount = $request->amount;
            $data->currency_id = $request->currency_id;
            $data->cooperative_uuid = $request->cooperative_uuid;
            if ($request->verified) {
                $data->verified_at = date('Y-m-d H:i:s');
                $data->verified_by = Auth::user()->user_uuid;
            } else {
                $data->verified_at = null;
                $data->verified_by = null;
            }
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

    public function delete($id)
    {
        try {
            $data = MoneyInvest::find($id);
            History::log($this->menu->label, 'delete', $data->amount);
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


        $select = "money_invests.*, cooperative_name, currency_name, currency_symbol, users.name";
        $from = " money_invests
        join cooperatives on cooperatives.cooperative_uuid=money_invests.cooperative_uuid
        join currencies on currencies.currency_id=money_invests.currency_id
        left join users on users.user_uuid=money_invests.verified_by
        ";

        $where = " users.deleted_at is null and 
            (amount::char LIKE '%{$search}%' OR
            lower(currency_name) LIKE '%{$search}%' OR
            lower(cooperative_name) LIKE '%{$search}%' OR
            lower(name) LIKE '%{$search}%')
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


        $etc = "ORDER BY {$orderBy} {$orderType}, created_at desc ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
            $actionData = '<a href="' . url($this->url . '/edit/' . $data->money_invest_uuid) . '" class="btn btn-xs btn-info  ti-pencil" title="Edit"></a>';
            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->money_invest_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';

            $hasils[] = [
                $start + $key + 1,
                $data->cooperative_name,
                $data->currency_symbol . ' ' . number_format($data->amount, 0, ',', '.'),
                ($data->verified_at) ? '<label class="label label-success">Verified</label>' : '<label class="label label-danger">Unverified</label>',
                $data->created_at,
                (Auth::user()->isVerificator()
                    and ((is_null($data->verified_at) and !Auth::user()->cooperatives->isEmpty()) or Auth::user()->cooperatives->isEmpty())) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => MoneyInvest::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}