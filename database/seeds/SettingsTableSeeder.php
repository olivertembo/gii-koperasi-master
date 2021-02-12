<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create([
            'type' => 1,
            'title' => 'FAQ',
            'content' => '',
        ]);

        \App\Models\Setting::create([
            'type' => 2,
            'title' => 'Terms & Conditon',
            'content' => '',
        ]);
        \App\Models\Setting::create([
            'type' => 3,
            'title' => 'Privacy Policy',
            'content' => '',
        ]);
        \App\Models\Setting::create([
            'type' => 4,
            'title' => 'About us',
            'content' => '',
        ]);
        \App\Models\Setting::create([
            'type' => 5,
            'title' => 'Contact Info',
            'content' => '',
        ]);
    }
}
