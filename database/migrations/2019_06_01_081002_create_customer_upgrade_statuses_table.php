<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerUpgradeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_upgrade_statuses', function (Blueprint $table) {
            $table->uuid('customer_upgrade_status_uuid')->primary();
            $table->uuid('customer_uuid');
            $table->uuid('verified_by')->nullable();
            $table->bigInteger('upgrade_status_id');
            $table->text('description')->nullable();
            $table->boolean('is_cooperative')->default(false);
            $table->boolean('is_dukcapil')->default(false);
            $table->boolean('is_id')->default(false);
            $table->boolean('is_id_selfie')->default(false);
            $table->boolean('is_slip')->default(false);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE customer_upgrade_statuses ALTER COLUMN customer_upgrade_status_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('customer_upgrade_statuses', function (Blueprint $table) {
            $table->foreign('verified_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('customer_uuid')->references('customer_uuid')->on('customers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_upgrade_statuses');
    }
}
