<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_product_items', function (Blueprint $table) {
            $table->uuid('t_product_item_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->uuid('product_item_uuid');
            $table->bigInteger('currency_id');
            $table->integer('price_amount');
            $table->integer('quantity');
            $table->integer('price_total_amount');
            $table->integer('weight')->default(0);
            $table->integer('weight_total')->default(0);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE t_product_items ALTER COLUMN t_product_item_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_product_items', function (Blueprint $table) {
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
            $table->foreign('currency_id')->references('currency_id')->on('currencies')->onDelete('restrict');
            $table->foreign('product_item_uuid')->references('product_item_uuid')->on('product_items')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_product_items');
    }
}
