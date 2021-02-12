<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserShippingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_shipping_addresses', function (Blueprint $table) {
            $table->uuid('user_shipping_address_uuid')->primary();
            $table->uuid('user_uuid');
            $table->bigInteger('city_id');
            $table->string('recipient_name');
            $table->string('address');
            $table->string('mobile_number');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE user_shipping_addresses ALTER COLUMN user_shipping_address_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('user_shipping_addresses', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('user_shipping_addresses');
    }
}
