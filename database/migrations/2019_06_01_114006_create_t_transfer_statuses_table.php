<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTTransferStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_transfer_statuses', function (Blueprint $table) {
            $table->uuid('t_transfer_status_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->uuid('created_by')->nullable();
            $table->bigInteger('transfer_status_id');
            $table->string('information')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE t_transfer_statuses ALTER COLUMN t_transfer_status_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_transfer_statuses', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
            $table->foreign('transfer_status_id')->references('transfer_status_id')->on('transfer_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_transfer_statuses');
    }
}
