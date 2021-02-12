<?php

namespace App\Http\Controllers\LoanTransaction;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Coupon;
use App\Models\Installment;
use App\Models\Menu;
use App\Models\ShippingStatus;
use App\Models\Transaction;
use App\Models\TransferStatus;
use App\Models\TShippingAddress;
use App\Models\TShippingStatus;
use App\Models\TTransferAccount;
use App\Models\TTransferStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Curl;

class TransactionController extends Controller
{
    private $menu_id = 21;
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

        $select = "transactions.transaction_uuid,
        transaction_number, customer_number, users.name, loan_amount, fee_amount, coalesce(total_interest, 0)total_interest,total_fine,
        status_name,status_class,
        transactions.created_at,
        interest_type_name, interest_percentage,tenure, day_amount";

        $from = " transactions 
        join customers on customers.customer_uuid=transactions.customer_uuid
        join users on users.user_uuid=customers.user_uuid
        join(
              select *
             from (
             select a.transaction_uuid, a.transfer_status_id,transfer_status_name status_name,transfer_status_class status_class
             from (
                    select transaction_uuid, transfer_status_id,
                    ROW_NUMBER() OVER (PARTITION BY transaction_uuid ORDER BY created_at DESC) AS row
                    from t_transfer_statuses
             )a 
             join transfer_statuses on transfer_statuses.transfer_status_id=a.transfer_status_id
             where a.row=1 
						 ) a
						 union 
						 select * from (
						  select a.transaction_uuid, a.shipping_status_id,shipping_status_name status_name,shipping_status_class status_class
             from (
                    select transaction_uuid, shipping_status_id,
                    ROW_NUMBER() OVER (PARTITION BY transaction_uuid ORDER BY created_at DESC) AS row
                    from t_shipping_statuses
             )a 
             join shipping_statuses on shipping_statuses.shipping_status_id=a.shipping_status_id
             where a.row=1
						 )b
        ) status on status.transaction_uuid=transactions.transaction_uuid
        join t_fees on t_fees.transaction_uuid=transactions.transaction_uuid
        join t_interests on t_interests.transaction_uuid=transactions.transaction_uuid
        join interest_types on interest_types.interest_type_id=t_interests.interest_type_id
        left join (
            select transaction_uuid,sum(interest_amount)total_interest
            from installments
            group by transaction_uuid
        )interest on interest.transaction_uuid=transactions.transaction_uuid
         left join (
            select transaction_uuid,sum(fine_total_amount)total_fine
            from installments
            group by transaction_uuid
        )fine on fine.transaction_uuid=transactions.transaction_uuid";

        $where = " 
            (
            lower(status_name) LIKE '%{$search}%' or
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
            $actionData = '<div class="btn-group">
                                <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="' . url($this->url . '/detail/' . $data->transaction_uuid) . '">Detail</a>
                                                    </div>
                                                </div>';
            $hasils[] = [
                $start + $key + 1,
                $data->created_at,
                $data->transaction_number,
                $data->customer_number,
                $data->name,
                $data->tenure . ' ' . $data->interest_type_name . ' (' . $data->interest_percentage . '%/' . $data->day_amount . 'd)',
                $data->loan_amount,
                $data->fee_amount,
                $data->total_interest,
                0,
                '<lable class="' . $data->status_class . '">' . $data->status_name . '</lable>',
                (Auth::user()->isVerificator()) ? $actionData : '',
            ];
        }

        echo json_encode([
            'draw' => $request->input('draw'),
            'recordsTotal' => Transaction::count(),
            'recordsFiltered' => $recordsFiltered,
            'data' => $hasils,
        ]);
    }

    public function detail($uuid)
    {
        $data = Transaction::find($uuid);
        $histori = [];
        if ($data->courier_resi && $data->courier_code) {
            $data_form = [
                'courier' => $data->courier_code,
                'waybill' => $data->courier_resi,
            ];
            $res = $this->getWeyBill($data_form);
            if ($res['status']['code'] == 200) {
                $histori = $res['result'];
            }
        }

        return view($this->path . 'detail', [
            'data' => $data,
            'menu' => $this->menu,
            'url' => $this->url,
            'histori' => $histori
        ]);
    }

    public function save(Request $request)
    {
        db::beginTransaction();
        try {
            $trx = Transaction::find($request->transaction_uuid);
            $tenure = $trx->tInterest->tenure;
            $day = $trx->tInterest->day_amount;
            $interest_percentage = $trx->tInterest->interest_percentage;

            $status = '';

            if ($trx->tProductItems->isEmpty()) {
                //money loan
                $tfstatus = new TTransferStatus();
                $tfstatus->transaction_uuid = $trx->transaction_uuid;
                $tfstatus->created_by = Auth::user()->user_uuid;
                $tfstatus->transfer_status_id = $request->transfer_status_id;
                $tfstatus->information = $request->information;
                $tfstatus->save();

                $tfacc = TTransferAccount::where('transaction_uuid', $trx->transaction_uuid)->first();
                $tfacc->bank_uuid = $request->bank_uuid;
                $tfacc->account_number = $request->account_number;
                $tfacc->recipient_name = $request->recipient_name;
                $tfacc->branch = $request->branch;
                $tfacc->save();

                $transfer_status = TransferStatus::find($request->transfer_status_id);
                $status = $transfer_status->transfer_status_name;

                $installment_amount = ceil($trx->loan_amount / $tenure);
            } else {
                //product loan
                if ($request->shipping_status_id) {
                    $tsstatus = new TShippingStatus();
                    $tsstatus->transaction_uuid = $trx->transaction_uuid;
                    $tsstatus->created_by = Auth::user()->user_uuid;
                    $tsstatus->shipping_status_id = $request->shipping_status_id;
                    $tsstatus->information = $request->information;
                    $tsstatus->save();

                    $shipping_status = ShippingStatus::find($request->shipping_status_id);
                    $status = $shipping_status->shipping_status_name;
                }

                if ($request->recipient_name) {
                    $tsadd = TShippingAddress::where('transaction_uuid', $trx->transaction_uuid)->first();
                    $tsadd->city_id = $request->city_id;
                    $tsadd->recipient_name = $request->recipient_name;
                    $tsadd->address = $request->address;
                    $tsadd->mobile_number = $request->mobile_number;
                    $tsadd->save();
                }

                $potongan = 0;
                if ($trx->coupon_uuid) {
                    $coupon = Coupon::find($trx->coupon_uuid);
                    if ($coupon) {
                        if ($coupon->is_percentage == true) {
                            $potongan = ($coupon->percantage / 100) * $trx->loan_amount;
                        } else {
                            $potongan = $coupon->amount;
                        }
                    }
                }
                $trx->discount = $potongan;
                $trx->courier_resi = $request->courier_resi;
                $installment_amount = ceil(($trx->loan_amount + $trx->fee_amount - $trx->discount + $trx->courier_cost) / $tenure);
            }

            $interest_amount = ($interest_percentage / 100) * $trx->loan_amount;
            if ($trx->installments->isEmpty()) {
                if ($request->transfer_status_id == 4 or $request->shipping_status_id == 7) {
                    $trx->due_date = date('Y-m-d');
                    $due_date = date('Y-m-d');
                    for ($i = 1; $i <= $tenure; $i++) {
                        $total = Installment::whereRaw("to_char(created_at,'YYYY-MM-DD')='" . date('Y-m-d') . "'")->count();
                        $ins = new Installment();
                        $ins->transaction_uuid = $trx->transaction_uuid;
                        $ins->currency_id = $trx->currency_id;
                        $ins->invoice_number = 'INV' . date('Ymd') . str_pad($total + 1, 7, 0, STR_PAD_LEFT);
                        $ins->installment_amount = $installment_amount;
                        $ins->installment_to = $i;
                        $ins->due_date = date("Y-m-d", strtotime($due_date . "+" . $day . " day"));
                        $ins->interest_amount = $interest_amount;
                        $ins->fine_amount = 0;
                        $ins->day = 0;
                        $ins->fine_total_amount = 0;
                        $ins->day_total = 0;
                        $ins->save();

                        $due_date = $ins->due_date;
                    }
                }
            }
            $trx->save();
            db::commit();
            // mail notif
            Curl::run('/api/v1/open/mail/transaction/' . $trx->transaction_uuid, '');

            //push notif

            $data = json_encode(['transaction_uuid' => $trx->transaction_uuid, 'loan_type' => $trx->loan_type]);
            $body = "{$trx->transaction_number} your transaction status is " . $status . " at " . date('d M Y H:i');
            $params = str_replace(' ', '%20', "to={$trx->customer->user->fcm_token}&title=Transaction Status&body=" . $body . "&action=transaction_detail&data=" . $data);
            $url = "/api/v1/open/fcm/push";
            Curl::run($url, $params);
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

    public function getWeyBill($data)
    {

        $url = env('RAJAONGKIR_URL') . "/api/waybill";
        $headers = [
            'content-type: application/x-www-form-urlencoded',
            'key:' . env('RAJAONGKIR_KEY'),
        ];

        return $this->_curl2($url, 'POST', $headers, $data);
    }

    private function _curl2($url, $method = 'GET', $headers, $datas = null)
    {
        if (!empty($datas) && $method == 'GET') {
            $query = http_build_query($datas);
            $url = $url . '?' . $query;
        } elseif (!empty($datas) && $method == 'POST') {
            $query = http_build_query($datas);
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response, true);

        if ($response) {
            if ($response['rajaongkir']['status']['code'] == 200) {
                return $response['rajaongkir'];
            } else {
                return $response['rajaongkir'];
            }
        } else {
            return [];
        }
    }
}
