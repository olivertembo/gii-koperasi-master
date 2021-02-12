<?php

use Illuminate\Database\Seeder;

class MenuRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_uuid = \App\Models\Role::first()->role_uuid;
        $menu = \App\Models\Menu::where('is_active', true)->get();
        foreach ($menu as $i) {
            \App\Models\RoleMenu::create([
                'role_uuid' => $role_uuid,
                'menu_id' => $i->menu_id,
            ]);
        }
    }
}
