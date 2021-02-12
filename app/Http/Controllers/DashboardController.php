<?php

namespace App\Http\Controllers;

use App\Models\CooperativeMember;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $pathView = 'dashboard.';

    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['customer_total'] = Customer::whereHas('latestUpgradeStatus', function ($q) {
            $q->where('upgrade_status_id', 6);
        })->count();
        $data['transaction_total'] = Transaction::count();

        $men = Customer::whereHas('latestUpgradeStatus', function ($q) {
            $q->where('upgrade_status_id', 6);
        })->whereHas('user', function ($q) {
            $q->where('gender_id', 1);
        })->count();

        $women = Customer::whereHas('latestUpgradeStatus', function ($q) {
            $q->where('upgrade_status_id', 6);
        })->whereHas('user', function ($q) {
            $q->where('gender_id', 2);
        })->count();

        $data['gender'] = [
            'men' => ($men != 0) ? ($men / $data['customer_total']) * 100 : 0,
            'women' => ($women != 0) ? ($women / $data['customer_total']) * 100 : 0,
        ];

        $data['latest_trx'] = DB::select("select transactions.transaction_number, users.name, status_name,status_class, transactions.created_at,
        case
        when transactions.loan_type=1 then transactions.loan_amount
        when transactions.loan_type=2 then transactions.loan_amount+transactions.fee_amount+transactions.courier_cost
        END as total
        from transactions
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
				ORDER BY transactions.created_at desc limit 5");

        $data['registration'] = [
            'total_pendaftar' => Customer::whereHas('latestUpgradeStatus')->count(),
            'sesuai_kriteria' => Customer::whereHas('latestUpgradeStatus', function ($q) {
                $q->where('upgrade_status_id', 6);
            })->count(),
            'tidak_sesuai_kriteria' => Customer::whereHas('latestUpgradeStatus')->count() - Customer::whereHas('latestUpgradeStatus', function ($q) {
                    $q->where('upgrade_status_id', 6);
                })->count(),
        ];

        $age = collect(db::select("select count(*) jml, 
sum(age_21_25) age_21_25,
sum(age_26_30) age_26_30,
sum(age_31_40) age_31_40,
sum(age_41_50) age_41_50,
sum(age_51_60) age_51_60,
sum(age_60) age_60
from (
select 
case when age BETWEEN 21 and 25 then 1 else 0 end as age_21_25,
case when age BETWEEN 26 and 30 then 1 else 0 end as age_26_30,
case when age BETWEEN 31 and 40 then 1 else 0 end as age_31_40,
case when age BETWEEN 41 and 50 then 1 else 0 end as age_41_50,
case when age BETWEEN 51 and 60 then 1 else 0 end as age_51_60,
case when age > 60 then 1 else 0 end as age_60
from (
select name, birthdate, DATE_PART('year', now()::date) - DATE_PART('year', birthdate::date) age
from customers 
join users on users.user_uuid=customers.user_uuid
join customer_statuses on customer_statuses.customer_status_id=customers.customer_status_id
join (
	select a.upgrade_status_id, a.customer_uuid,upgrade_status_name,upgrade_status_class 
	from (
		select upgrade_status_id, customer_uuid,
		ROW_NUMBER() OVER (PARTITION BY customer_uuid ORDER BY created_at DESC) AS row
		from customer_upgrade_statuses
	)a 
	join upgrade_statuses on upgrade_statuses.upgrade_status_id=a.upgrade_status_id
  where a.row=1
)a on a.customer_uuid=customers.customer_uuid
where a.upgrade_status_id=6
) a
) b"))->first();

        $data['age'] = [
            'jml' => $age->jml,
            'age_21_25' => $age->age_21_25,
            'age_26_30' => $age->age_26_30,
            'age_31_40' => $age->age_31_40,
            'age_41_50' => $age->age_41_50,
            'age_51_60' => $age->age_51_60,
            'age_60' => $age->age_60,
        ];

        $data['city'] = db::select("select city_name, count(1) jml
from (select concat(city_name,' (',tipe_dati2,')' )city_name
from customers 
join users on users.user_uuid=customers.user_uuid
join cities on cities.city_id=users.city_id
join customer_statuses on customer_statuses.customer_status_id=customers.customer_status_id
join (
	select a.upgrade_status_id, a.customer_uuid,upgrade_status_name,upgrade_status_class 
	from (
		select upgrade_status_id, customer_uuid,
		ROW_NUMBER() OVER (PARTITION BY customer_uuid ORDER BY created_at DESC) AS row
		from customer_upgrade_statuses
	)a 
	join upgrade_statuses on upgrade_statuses.upgrade_status_id=a.upgrade_status_id
  where a.row=1
)a on a.customer_uuid=customers.customer_uuid
where a.upgrade_status_id=6
) a
GROUP BY city_name
order by jml DESC, city_name asc LIMIT 5");

        $data['city_partner_member'] = db::select("select cooperative_name, concat(city_name,' (',tipe_dati2,')' )city_name,  COALESCE(jml,0) jml
                from  cooperatives
                join cities on cities.city_id=cooperatives.city_id
                left join (
                    select cooperative_uuid, count(*) jml
                    from cooperative_members
                    GROUP BY cooperative_uuid
                )m on m.cooperative_uuid=cooperatives.cooperative_uuid
                order by jml DESC, cooperative_name, city_name asc LIMIT 5");
        $data['city_member'] = db::select("select  concat(city_name,' (',tipe_dati2,')' )city_name,  COALESCE(jml,0) jml
                from  cities
                join (
                    select city_id, count(*) jml
                    from cooperative_members
                    GROUP BY city_id
                )m on m.city_id=cities.city_id
                order by jml DESC, city_name asc LIMIT 5");
//        dd($data);

        $men = CooperativeMember::where('gender_id', 1)->count();
        $women = CooperativeMember::where('gender_id', 2)->count();
        $data['gender_member'] = [
            'men' => ($men != 0) ? ($men / $data['customer_total']) * 100 : 0,
            'women' => ($women != 0) ? ($women / $data['customer_total']) * 100 : 0,
        ];

        $age_member = collect(db::select("select count(*) jml, 
COALESCE(sum(age_21_25),0) age_21_25,
COALESCE(sum(age_26_30),0) age_26_30,
COALESCE(sum(age_31_40),0) age_31_40,
COALESCE(sum(age_41_50),0) age_41_50,
COALESCE(sum(age_51_60),0) age_51_60,
COALESCE(sum(age_60),0) age_60
from (
select 
case when age BETWEEN 21 and 25 then 1 else 0 end as age_21_25,
case when age BETWEEN 26 and 30 then 1 else 0 end as age_26_30,
case when age BETWEEN 31 and 40 then 1 else 0 end as age_31_40,
case when age BETWEEN 41 and 50 then 1 else 0 end as age_41_50,
case when age BETWEEN 51 and 60 then 1 else 0 end as age_51_60,
case when age > 60 then 1 else 0 end as age_60
from (
select  DATE_PART('year', now()::date) - DATE_PART('year', birthdate::date) age
from cooperative_members 
) a
) b"))->first();

        $data['age_member'] = [
            'jml' => $age_member->jml,
            'age_21_25' => $age_member->age_21_25,
            'age_26_30' => $age_member->age_26_30,
            'age_31_40' => $age_member->age_31_40,
            'age_41_50' => $age_member->age_41_50,
            'age_51_60' => $age_member->age_51_60,
            'age_60' => $age_member->age_60,
        ];

        $trx = collect(db::select(" select sum(approved) approved, sum(rejected) rejected
 from (
 select transaction_uuid,
 case when transfer_status_id IN(2,4) then 1 else 0 end approved,
 case when transfer_status_id=3 then 1 else 0 end rejected
from (
	select a.transaction_uuid, a.transfer_status_id
  from (
		select transaction_uuid, transfer_status_id,
    ROW_NUMBER() OVER (PARTITION BY transaction_uuid ORDER BY created_at DESC) AS row
    from t_transfer_statuses
	)a 
  where a.row=1 
) a
GROUP BY transaction_uuid,a.transfer_status_id
union
select transaction_uuid,
 case when shipping_status_id IN (2,4,5,6,7,9)  then 1 else 0 end approved,
 case when shipping_status_id=8 then 1 else 0 end rejected
from (
	select a.transaction_uuid, a.shipping_status_id
	from (
		select transaction_uuid, shipping_status_id,
		ROW_NUMBER() OVER (PARTITION BY transaction_uuid ORDER BY created_at DESC) AS row
		from t_shipping_statuses
	)a 
	where a.row=1
)b
)C"))->first();

        $data['transaction'] = [
            'approved' => $trx->approved,
            'rejected' => $trx->rejected
        ];

        $data['transaction_year'] = json_encode(db::select(" select tahun period, sum(approved) approved, sum(rejected) rejected
 from (
	select transaction_uuid,tahun,
	case when transfer_status_id IN(2,4) then 1 else 0 end approved,
	case when transfer_status_id=3 then 1 else 0 end rejected
	from (
		select a.transaction_uuid, a.transfer_status_id, to_char(created_at, 'YYYY') tahun
		from (
			select transaction_uuid, transfer_status_id,
			ROW_NUMBER() OVER (PARTITION BY transaction_uuid ORDER BY created_at DESC) AS row
			from t_transfer_statuses
		)a 
		join transactions on transactions.transaction_uuid=a.transaction_uuid
		where a.row=1 
	) a
	union
	select transaction_uuid,tahun,
	case when shipping_status_id IN (2,4,5,6,7,9)  then 1 else 0 end approved,
	case when shipping_status_id=8 then 1 else 0 end rejected
	from (
		select a.transaction_uuid, a.shipping_status_id,  to_char(created_at, 'YYYY') tahun
		from (
			select transaction_uuid, shipping_status_id, 
			ROW_NUMBER() OVER (PARTITION BY transaction_uuid ORDER BY created_at DESC) AS row
			from t_shipping_statuses
		)a 
		join transactions on transactions.transaction_uuid=a.transaction_uuid
		where a.row=1
	)b
)C
GROUP BY tahun 
order by tahun"));

//        dd($data);
        return view($this->pathView . 'index', $data);
    }
}
