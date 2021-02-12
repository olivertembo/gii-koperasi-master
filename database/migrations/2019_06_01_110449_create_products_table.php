<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('product_uuid')->primary();
            $table->uuid('product_category_uuid');
            $table->uuid('cooperative_uuid')->nullable();
            $table->string('sku');
            $table->string('product_name');
            $table->longText('product_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE products ALTER COLUMN product_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('cooperative_uuid')->references('cooperative_uuid')->on('cooperatives')->onDelete('restrict');
            $table->foreign('product_category_uuid')->references('product_category_uuid')->on('product_categories')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
