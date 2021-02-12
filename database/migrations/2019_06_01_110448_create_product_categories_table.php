<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->uuid('product_category_uuid')->primary();
            $table->string('product_category_name');
            $table->string('file_path');
            $table->longText('fileb64');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE product_categories ALTER COLUMN product_category_uuid SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
