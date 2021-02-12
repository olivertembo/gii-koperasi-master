<?php

use Illuminate\Database\Seeder;

class ShippingStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shipping_statuses')->insert([
            [
                'shipping_status_id' => 1,
                'shipping_status_name' => 'Waiting Process',
                'shipping_status_class' => 'label label-warning'],
            [
                'shipping_status_id' => 2,
                'shipping_status_name' => 'On Process',
                'shipping_status_class' => 'label label-info'],
            [
                'shipping_status_id' => 4,
                'shipping_status_name' => 'Shipping',
                'shipping_status_class' => 'label label-info',
            ],
            [
                'shipping_status_id' => 5,
                'shipping_status_name' => 'Return Request',
                'shipping_status_class' => 'label label-danger',
            ],
            [
                'shipping_status_id' => 6,
                'shipping_status_name' => 'Return Process',
                'shipping_status_class' => 'label label-danger',
            ],
            [
                'shipping_status_id' => 7,
                'shipping_status_name' => 'Received',
                'shipping_status_class' => 'label label-success',
            ],
            [
                'shipping_status_id' => 8,
                'shipping_status_name' => 'Rejected',
                'shipping_status_class' => 'label label-danger',
            ],
            [
                'shipping_status_id' => 9,
                'shipping_status_name' => 'Complain',
                'shipping_status_class' => 'label label-warning',
            ],
        ]);
    }
}
