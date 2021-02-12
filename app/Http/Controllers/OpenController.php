<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PinHistory;
use App\Models\Transaction;
use App\Models\Coupon;
use App\Helpers\Curl;
use Illuminate\Support\Facades\Hash;

class OpenController extends Controller
{
    public function city(Request $request)
    {
        $key = strtoupper($request->get('q'));
        $data = City::whereRaw("upper(city_name) like '%$key%'")->get();
        $data_new = [];
        foreach ($data as $key => $value) {
            $data_new[] = [
                'id' => $value->city_id,
                'text' => $value->city_name . ' ' . (($value->tipe_dati2) ? '(' . $value->tipe_dati2 . ')' : '')
            ];
        }

        if (count($data) == 0) {
            $data_new[] = [
                'id' => 0,
                'text' => 'Not found'
            ];
        }
        echo json_encode($data_new);
    }

    public function forgotPin(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!empty($request->pin) && $request->pin == $request->cpin) {
                // $this->validate($request, [
                //     'pin' => 'required|numeric|digits:6',
                //     'cpin' => 'required|numeric|digits:6',

                // ]);
                PinHistory::where('user_uuid', $user->user_uuid)->update(['is_active' => false]);
                $pin = new PinHistory;
                $pin->user_uuid = $user->user_uuid;
                $pin->is_active = true;
                $pin->pin = Hash::make($request->pin);
                $pin->save();
                $params['success'] = 'Berhasil merubah pin';
            } elseif ($request->pin != $request->cpin) {
                $params['error'] = 'Pin dan confirm pin harus sama';
            } else {
                if (is_null($user->forgot_pin_end_at)) {
                    $params['error'] = 'User tidak ditemukan';
                } else if ($user->forgot_pin_end_at < date('Y-m-d H:i:s')) {
                    $params['error'] = 'Forgot pin melewati batas waktu / Sudah kadaluarsa';
                } else {
                    return view('forgot_pin');
                }
            }
        } catch (\Exception $e) {
            $params['error'] = 'Terjadi Kesalahan';
            // return view('forgot_pin',$params);    
        }
        return view('forgot_pin', $params);
    }

    public function getConfirmMail($user_uuid)
    {
        $data = User::where('user_uuid', $user_uuid)->whereNull('email_verified_at')->first();
        if ($data) {
            $data->email_verified_at = date('Y-m-d H:i:s');
            $data->save();
        }
        return view('open.email_verification', compact('data'));

    }

    public function cron()
    {
        ini_set('max_execution_time', 0);
        self::transactionDueDate();
        self::couponExp();
    }

    public function transactionDueDate()
    {
        $date = date('Y-m-d H:i:s');
        $dueDate = date('Y-m-d H:i:s', strtotime("+7Days"));
        $transactions = Transaction::with([
            'installments',
            'customer.user'
        ])
            ->whereHas('installments', function ($query) use ($date, $dueDate) {
                return $query->where('due_date', '>=', $date)
                    ->where('due_date', '<=', $dueDate)
                    ->where('pay_at', null);
            })
            ->get();
        foreach ($transactions as $key => $transaction) {
            foreach ($transaction->installments as $installment) {
                $body = "{$installment->invoice_number} due date installment at " . date('d-m-Y', strtotime($installment->due_date));
                $data = json_encode(['transaction_uuid' => $installment->transaction_uuid, 'loan_type' => $installment->transaction->loan_type]);
                $params = str_replace(' ', '%20', "to={$transaction->customer->user->fcm_token}&title=Transaction Invoice&body=" . $body . "&action=transaction_detail&data=" . $data);
                $url = "/api/v1/open/fcm/push";
                Curl::run($url, $params);
            }
        }
    }

    public function couponExp()
    {
        $dateStart = date('Y-m-d H:i:s');
        $dateEnd = date('Y-m-d H:i:s', strtotime("+7Days"));
        $coupons = Coupon::where('expired_at', '>=', $dateStart)
            ->where('expired_at', '>=', $dateEnd)
            ->get();
        foreach ($coupons as $coupon) {
            if ($coupon->is_percentage == 'true') {
                $discount = $coupon->percentage . '%';
            } else {
                $discount = $coupon->currency->currency_symbol . ' ' . number_format($coupon->amount, 0, '.', ',');
            }
            $isi = $coupon->coupon_name . ", expired at " . date('d M Y', strtotime($coupon->expired_at)) . ', discount ' . $discount;
            $params = str_replace(' ', '%20', "to=/topic/coupon&title=Coupon Promo&body=" . $isi . "&action=coupon");
            $url = "/api/v1/open/fcm/push";
            Curl::run($url, $params);
        }
    }
}