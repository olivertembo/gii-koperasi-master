<?php

use Illuminate\Database\Seeder;

class CustomerStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer_statuses')->insert([
            [
                'customer_status_id' => 1,
                'customer_status_name' => 'Active',
                'customer_status_class' => 'label label-success'],
            [
                'customer_status_id' => 2,
                'customer_status_name' => 'Suspend',
                'customer_status_class' => 'label label-warning'],
            [
                'customer_status_id' => 3,
                'customer_status_name' => 'Banned',
                'customer_status_class' => 'label label-danger',
            ]
        ]);
    }
}
