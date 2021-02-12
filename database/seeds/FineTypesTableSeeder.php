<?php

use Illuminate\Database\Seeder;

class FineTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fine_types')->insert([
            [
                'fine_type_id' => 1,
                'fine_type_symbol' => '>'
            ],
            [
                'fine_type_id' => 2,
                'fine_type_symbol' => '>='
            ],
            [
                'fine_type_id' => 3,
                'fine_type_symbol' => '=='
            ],
        ]);
    }
}
