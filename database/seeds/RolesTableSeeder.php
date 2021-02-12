<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create(
            [
                'role_name' => 'Super Admin',
                'role_code' => 'superadmin',
                'is_active' => true,
                'is_verificator' => true,
                'role_type' => 1,
            ]
        );
        \App\Models\Role::create(
            [
                'role_name' => 'Partner',
                'role_code' => 'partner',
                'is_active' => true,
                'is_verificator' => true,
                'role_type' => 2,
            ]
        );
    }
}
