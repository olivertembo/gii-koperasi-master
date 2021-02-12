<?php

namespace App\Http\Controllers\LoanTransaction;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComplainController extends Controller
{
    private $menu_id = 22;
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

        $select = "complains.complain_reason, complains.created_at,transactions.transaction_number, 
        users.name, customers.customer_number";

        $from = " complains 
        join transactions on transactions.transaction_uuid=complains.transaction_uuid
        join customers on customers.customer_uuid=transactions.customer_uuid
        join users on users.user_uuid=customers.user_uuid";

        $where = " 
            (
            lower(complain_reason) LIKE '%{$search}%' or
            lower(transaction_number) LIKE '%{$search}%' or
            lower(customer_number) LIKE '%{$search}%' or
            lower(name) LIKE '%{$search}%'
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
            $where .= " and transactions.cooperative_uuid in ($cu)";
        }

        $loan_type = '';
        foreach (Auth::user()->roles->pluck('loan_type')->toArray() as $n => $i) {
            $loan_type .= "$i";
            if ($n != count(Auth::user()->roles->pluck('loan_type')->toArray()) - 1) {
                $loan_type .= ",";
            }
        }

        if ($loan_type) {
            $where .= " and transactions.loan_type in ($loan_type)";
        }

        $etc = "ORDER BY {$orderBy} {$orderType} ";
        if ($length != 0) {
            $etc .= " limit {$length} offset {$start}";
        }

        $Datas = DB::select("SELECT {$select} FROM {$from} WHERE {$where} {$etc}");
        $recordsFiltered = DB::select("SELECT count(*) FROM {$from} WHERE {$where}")[0]->count;

        $hasils = [];
        foreach ($Datas as $key => $data) {
//            $actionData = '<button onclick="modalForm(\'' . url($this->url . '/edit/' . $data->coupon_uuid) . '\')" class="btn btn-xs btn-info  ti-pencil" title="Edit">';
//            $actionData .= '<button onclick="deleteData(\'' . url($this->url . '/delete/' . $data->coupon_uuid) . '\')" class="btn btn-xs btn-danger ti-trash" title="Delete">';
            $actionData = '';
            $hasils[] = [
                $start + $key + 1,
                $data->transaction_number,
                $data->customer_number,
                $data->name,
                $data->complain_reason,
                $data->created_at,
//                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Complain::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);

    }
}
