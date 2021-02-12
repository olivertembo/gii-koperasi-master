<?php

use Illuminate\Database\Seeder;

class QuantityTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\QuantityType::create([
            'quantity_type_name' => 'Kilogram',
            'quantity_type_symbol' => 'Kg',
        ]);
        \App\Models\QuantityType::create([
            'quantity_type_name' => 'Liter',
            'quantity_type_symbol' => 'L',
        ]);
        \App\Models\QuantityType::create([
            'quantity_type_name' => 'Unit',
            'quantity_type_symbol' => 'Unit',
        ]);
        \App\Models\QuantityType::create([
            'quantity_type_name' => 'Set',
            'quantity_type_symbol' => 'Set',
        ]);
        \App\Models\QuantityType::create([
            'quantity_type_name' => 'Pack',
            'quantity_type_symbol' => 'Pack',
        ]);
    }
}
