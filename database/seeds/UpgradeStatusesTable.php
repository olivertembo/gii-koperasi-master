<?php

use Illuminate\Database\Seeder;

class UpgradeStatusesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('upgrade_statuses')->insert([
            [
                'upgrade_status_id' => 1,
                'upgrade_status_name' => 'Not Upgrade',
                'upgrade_status_class' => 'label label-warning'],
            [
                'upgrade_status_id' => 2,
                'upgrade_status_name' => 'Rejected',
                'upgrade_status_class' => 'label label-danger'],
            [
                'upgrade_status_id' => 3,
                'upgrade_status_name' => 'Submission',
                'upgrade_status_class' => 'label label-info',
            ],
            [
                'upgrade_status_id' => 4,
                'upgrade_status_name' => 'Customer Verfication',
                'upgrade_status_class' => 'label label-info',
            ],
            [
                'upgrade_status_id' => 5,
                'upgrade_status_name' => 'Data Verfication',
                'upgrade_status_class' => 'label label-info',
            ],
            [
                'upgrade_status_id' => 6,
                'upgrade_status_name' => 'Approved',
                'upgrade_status_class' => 'label label-success',
            ]
        ]);
    }
}
