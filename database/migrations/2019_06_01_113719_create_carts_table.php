<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('cart_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('product_item_uuid');
            $table->bigInteger('currency_id');
            $table->integer('price_amount');
            $table->integer('quantity');
            $table->integer('price_total_amount');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE carts ALTER COLUMN cart_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('product_item_uuid')->references('product_item_uuid')->on('product_items')->onDelete('restrict');
            $table->foreign('currency_id')->references('currency_id')->on('currencies')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
