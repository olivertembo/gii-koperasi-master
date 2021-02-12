<?php

use Illuminate\Database\Seeder;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            [
                'job_id' => 1,
                'job_name' => 'ASN/Honorer',
            ],
            [
                'job_id' => 2,
                'job_name' => 'Swasta/Karyawan',
            ],
            [
                'job_id' => 3,
                'job_name' => 'Wirausaha/Wiraswasta',
            ],
        ]);
    }
}
