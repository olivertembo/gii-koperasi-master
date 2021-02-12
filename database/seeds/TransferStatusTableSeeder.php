<?php

use Illuminate\Database\Seeder;

class TransferStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transfer_statuses')->insert([
            [
                'transfer_status_id' => 1,
                'transfer_status_name' => 'Waiting Process',
                'transfer_status_class' => 'label label-warning'],
            [
                'transfer_status_id' => 2,
                'transfer_status_name' => 'Transfer Process',
                'transfer_status_class' => 'label label-info'],
            [
                'transfer_status_id' => 3,
                'transfer_status_name' => 'Rejected',
                'transfer_status_class' => 'label label-danger',
            ],
            [
                'transfer_status_id' => 4,
                'transfer_status_name' => 'Transfered',
                'transfer_status_class' => 'label label-success',
            ]
        ]);
    }
}
