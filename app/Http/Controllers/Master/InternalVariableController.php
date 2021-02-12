<?php

namespace App\Http\Controllers\Master;

use App\Helpers\History;
use App\Models\Cooperative;
use App\Models\IvAdminFee;
use App\Models\IvAge;
use App\Models\IvCity;
use App\Models\IvIncomeWorkExp;
use App\Models\IvSuspend;
use App\Models\LoanPurpose;
use App\Models\Menu;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InternalVariableController extends Controller
{
    private $menu_id = 32;
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

    public function createAdminFee()
    {
        $data = new IvAdminFee();
        return view($this->path . 'form_adminfee', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function createAge()
    {
        $data = new IvAge();
        return view($this->path . 'form_age', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function createCities()
    {
        $data = new IvCity();
        return view($this->path . 'form_city', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function createIncome()
    {
        $data = new IvIncomeWorkExp();
        return view($this->path . 'form_income', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function createSuspends()
    {
        $data = new IvSuspend();
        return view($this->path . 'form_suspend', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function editAdminFee($uuid)
    {
        $data = IvAdminFee::find($uuid);
        return view($this->path . 'form_adminfee', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function editAge($uuid)
    {
        $data = IvAge::find($uuid);
        return view($this->path . 'form_age', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function editCities($uuid)
    {
        $data = IvCity::find($uuid);
        return view($this->path . 'form_city', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function editIncome($uuid)
    {
        $data = IvIncomeWorkExp::find($uuid);
        return view($this->path . 'form_income', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function editSuspends($uuid)
    {
        $data = IvSuspend::find($uuid);
        return view($this->path . 'form_suspend', [
            'menu' => $this->menu,
            'url' => $this->url,
            'data' => $data
        ]);
    }

    public function deleteAdminFee($uuid)
    {
        try {
            $data = IvAdminFee::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label . ' - admin fee', 'delete', $data->percentage . '/' . $data->amount);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function deleteAge($uuid)
    {
        try {
            $data = IvAge::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label . ' - age', 'delete', $data->age);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function deleteCities($uuid)
    {
        try {
            $data = IvCity::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label . ' - city', 'delete', $data->city->city_name);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function deleteIncome($uuid)
    {
        try {
            $data = IvIncomeWorkExp::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label . ' - Income & Work exp', 'delete', $data->income . '/' . $data->work_exp);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function deleteSuspends($uuid)
    {
        try {
            $data = IvSuspend::find($uuid);
            $data->deleted_at = date('Y-m-d H:i:s');
            $data->save();
            History::log($this->menu->label . ' - Suspends', 'delete', $data->long_suspend);
            return response()->json(null, 200);
        } catch (\Exception $e) {
            return response()->json(null, 500);
        }
    }

    public function saveAdminFee(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['iv_admin_fee_uuid'];
            if ($uuid) {
                $data = IvAdminFee::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label . ' - admin fee', 'update', $request['percentage'] . '/' . $request['amount']);
            } else {
                $data = new IvAdminFee();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label . ' - admin fee', 'create', $request['percentage'] . '/' . $request['amount']);
            }
            $data->is_percentage = $request['is_percentage'];
            $data->percentage = $request['percentage'] ?: 0;
            $data->amount = $request['amount'] ?: 0;
            $data->is_active = $request['is_active'];
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

    public function saveAge(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['iv_age_uuid'];
            if ($uuid) {
                $data = IvAge::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
                History::log($this->menu->label . ' - age', 'update', $request['age']);
            } else {
                $data = new IvAge();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
                History::log($this->menu->label . ' - age', 'create', $request['age']);
            }
            $data->age = $request['age'];
            $data->is_active = $request['is_active'];
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

    public function saveCities(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['iv_city_uuid'];
            if ($uuid) {
                $data = IvCity::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
            } else {
                $data = new IvCity();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
            }
            $data->city_id = $request['city_id'];
            $data->is_active = $request['is_active'];
            $data->save();
            db::commit();
            if ($uuid) {
                History::log($this->menu->label . ' - city', 'update', $data->city->city_name);
            } else {
                History::log($this->menu->label . ' - city', 'create', $data->city->city_name);
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

    public function saveIncome(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['iv_income_work_exp_uuid'];
            if ($uuid) {
                $data = IvIncomeWorkExp::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
            } else {
                $data = new IvIncomeWorkExp();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
            }
            $data->income = $request['income'];
            $data->work_exp = $request['work_exp'];
            $data->is_active = $request['is_active'];
            $data->save();
            db::commit();
            if ($uuid) {
                History::log($this->menu->label . ' - Income & Work exp', 'update', $data->income . '/' . $data->work_exp);
            } else {
                History::log($this->menu->label . ' - Income & Work exp', 'create', $data->income . '/' . $data->work_exp);
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

    public function saveSuspends(Request $request)
    {
        db::beginTransaction();
        try {
            $uuid = $request['iv_suspend_uuid'];
            if ($uuid) {
                $data = IvSuspend::find($uuid);
                $data->updated_at = date('Y-m-d H:i:s');
                $data->updated_by = Auth::user()->user_uuid;
            } else {
                $data = new IvSuspend();
                $data->created_at = date('Y-m-d H:i:s');
                $data->created_by = Auth::user()->user_uuid;
            }
            $data->long_suspend = $request['long_suspend'];
            $data->is_active = $request['is_active'];
            $data->save();
            db::commit();
            if ($uuid) {
                History::log($this->menu->label . ' - Suspends', 'update', $data->long_suspend);
            } else {
                History::log($this->menu->label . ' - Suspends', 'create', $data->long_suspend);
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

    public function datatableAdminFee(Request $request)
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

        $from = " iv_admin_fees ";

        $where = " deleted_at is null and 
            (
            percentage::char LIKE '%{$search}%' or
            amount::char LIKE '%{$search}%'
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/admin-fee/' . $data->iv_admin_fee_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData2(\'' . url($this->url . '/delete/admin-fee/' . $data->iv_admin_fee_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                ($data->is_percentage == 't') ? 'true' : 'false',
                $data->percentage,
                $data->amount,
                ($data->is_active == 't') ? 'active' : 'deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => IvAdminFee::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function datatableAge(Request $request)
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

        $from = " iv_ages ";

        $where = " deleted_at is null and 
            (
            age::char LIKE '%{$search}%' 
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/age/' . $data->iv_age_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData2(\'' . url($this->url . '/delete/age/' . $data->iv_age_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->age,
                ($data->is_active == 't') ? 'active' : 'deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => IvAge::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function datatableCities(Request $request)
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

        $from = " iv_cities
         join cities on cities.city_id=iv_cities.city_id";

        $where = " deleted_at is null and 
            (
            lower(city_name) LIKE '%{$search}%' 
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/cities/' . $data->iv_city_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData2(\'' . url($this->url . '/delete/cities/' . $data->iv_city_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->city_name . (($data->tipe_dati2) ? ' (' . $data->tipe_dati2 . ')' : ''),
                ($data->is_active == 't') ? 'active' : 'deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => IvCity::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function datatableIncome(Request $request)
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

        $from = " iv_income_work_exps";

        $where = " deleted_at is null and 
            (
            income::char LIKE '%{$search}%' or
            work_exp::char LIKE '%{$search}%' 
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/income/' . $data->iv_income_work_exp_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData2(\'' . url($this->url . '/delete/income/' . $data->iv_income_work_exp_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->type_income . ' ' . $data->income,
                $data->type_work_exp . ' ' . $data->work_exp,
                ($data->is_active == 't') ? 'active' : 'deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => IvIncomeWorkExp::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function datatableSuspends(Request $request)
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

        $from = " iv_suspends";

        $where = " deleted_at is null and 
            (
            long_suspend::char LIKE '%{$search}%'
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
            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/suspends/' . $data->iv_suspend_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
            $actionData .= '<button onclick="deleteData2(\'' . url($this->url . '/delete/suspends/' . $data->iv_suspend_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $hasils[] = [
                $start + $key + 1,
                $data->long_suspend,
                ($data->is_active == 't') ? 'active' : 'deactive',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => IvIncomeWorkExp::where('deleted_at', null)->count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }
}