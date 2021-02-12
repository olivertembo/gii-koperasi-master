<?php

use Illuminate\Database\Seeder;

class InterestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interest_types')->insert([
            [
                'interest_type_id' => 1,
                'interest_type_name' => 'Day',
            ],
            [
                'interest_type_id' => 2,
                'interest_type_name' => 'Week',
            ],
            [
                'interest_type_id' => 3,
                'interest_type_name' => 'Month',
            ],
            [
                'interest_type_id' => 4,
                'interest_type_name' => 'Year',
            ],
        ]);
    }
}
