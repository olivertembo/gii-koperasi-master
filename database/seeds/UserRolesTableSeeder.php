<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\UserRole::create([
            'user_uuid' => \App\Models\User::first()->user_uuid,
            'role_uuid' => \App\Models\Role::where('role_code', 'superadmin')->first()->role_uuid,
        ]);
    }
}
