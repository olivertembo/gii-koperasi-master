<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create(
            [
                'user_status_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('secret'),
                'type' => 1,
            ]
        );
    }
}
