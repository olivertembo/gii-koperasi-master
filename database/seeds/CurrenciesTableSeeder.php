<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'currency_id' => 1,
                'currency_name' => 'Indonesia Rupiah',
                'currency_symbol' => 'Rp',
                'currency_iso_code' => 'IDR',
            ]
        ]);
    }
}
