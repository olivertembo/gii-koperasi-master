<?php

use Illuminate\Database\Seeder;

class PartnerTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partner_types')->insert([
            [
                'partner_type_id' => 1,
                'partner_type_name' => 'Internal'
            ],
            [
                'partner_type_id' => 2,
                'partner_type_name' => 'Investor'
            ],
            [
                'partner_type_id' => 3,
                'partner_type_name' => 'Koperasi'
            ],
        ]);
    }
}
