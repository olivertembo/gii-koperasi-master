<?php

use Illuminate\Database\Seeder;

class UserStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_statuses')->insert([
            [
                'user_status_id' => 1,
                'user_status_name' => 'Active',
                'user_status_class' => 'label label-success'],
            [
                'user_status_id' => 2,
                'user_status_name' => 'Suspend',
                'user_status_class' => 'label label-warning'],
            [
                'user_status_id' => 3,
                'user_status_name' => 'Banned',
                'user_status_class' => 'label label-danger',
            ]
        ]);
    }
}
