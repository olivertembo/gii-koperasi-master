<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTShippingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_shipping_statuses', function (Blueprint $table) {
            $table->uuid('t_shipping_status_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->uuid('created_by')->nullable();
            $table->bigInteger('shipping_status_id');
            $table->string('information')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE t_shipping_statuses ALTER COLUMN t_shipping_status_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_shipping_statuses', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
            $table->foreign('shipping_status_id')->references('shipping_status_id')->on('shipping_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_shipping_statuses');
    }
}
