<?php

use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')->insert([
            [
                'gender_id' => 1,
                'gender_name' => 'Male',
            ],
            [
                'gender_id' => 2,
                'gender_name' => 'Female',
            ]
        ]);
    }
}
