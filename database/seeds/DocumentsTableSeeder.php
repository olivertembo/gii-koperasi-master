<?php

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('documents')->insert([
            [
                'document_id' => 1,
                'document_name' => 'Identity Card',
                'document_description' => 'Identity Card',
                'mime' => 'jpg,jpeg,png,gif',
                'is_image' => true
            ],
            [
                'document_id' => 2,
                'document_name' => 'Selfie with Identity Card',
                'document_description' => 'Selfie with Identity Card',
                'mime' => 'jpg,jpeg,png,gif',
                'is_image' => true
            ],
            [
                'document_id' => 3,
                'document_name' => 'Income Statment',
                'document_description' => 'Income Statment',
                'mime' => 'jpg,jpeg,png,gif',
                'is_image' => true
            ],
        ]);

    }
}
