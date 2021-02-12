<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_shipping_addresses', function (Blueprint $table) {
            $table->uuid('t_shipping_address_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->bigInteger('city_id');
            $table->string('recipient_name');
            $table->string('address');
            $table->string('mobile_number');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE t_shipping_addresses ALTER COLUMN t_shipping_address_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_shipping_addresses', function (Blueprint $table) {
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_shipping_addresses');
    }
}
