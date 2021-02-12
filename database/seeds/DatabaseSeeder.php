<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PartnerTypesSeeder::class);
        $this->call(GendersTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(CustomerStatusTableSeeder::class);
        $this->call(DocumentsTableSeeder::class);
        $this->call(FineTypesTableSeeder::class);
        $this->call(InterestTypesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(QuantityTypesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(ShippingStatusTableSeeder::class);
        $this->call(TransferStatusTableSeeder::class);
        $this->call(UpgradeStatusesTable::class);
        $this->call(UserStatusesSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(MenuRolesTableSeeder::class);
    }
}
