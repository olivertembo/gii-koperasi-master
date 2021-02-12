<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_items', function (Blueprint $table) {
            $table->uuid('product_item_uuid')->primary();
            $table->uuid('product_uuid');
            $table->bigInteger('currency_id');
            $table->uuid('quantity_type_uuid');
            $table->string('sku');
            $table->string('product_item_name');
            $table->longText('product_item_description')->nullable();
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('weight_item')->default(0);
            $table->integer('total_stock')->default(0);
            $table->integer('total_sold')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE product_items ALTER COLUMN product_item_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('product_items', function (Blueprint $table) {
            $table->foreign('product_uuid')->references('product_uuid')->on('products')->onDelete('restrict');
            $table->foreign('currency_id')->references('currency_id')->on('currencies')->onDelete('restrict');
            $table->foreign('quantity_type_uuid')->references('quantity_type_uuid')->on('quantity_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_items');
    }
}
