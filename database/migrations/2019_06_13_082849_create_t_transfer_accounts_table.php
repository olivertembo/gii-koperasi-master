<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTTransferAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_transfer_accounts', function (Blueprint $table) {
            $table->uuid('t_transfer_account_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->uuid('bank_uuid');
            $table->string('account_number');
            $table->string('recipient_name');
            $table->string('branch')->nullable();
            $table->string('amount')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE t_transfer_accounts ALTER COLUMN t_transfer_account_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_transfer_accounts', function (Blueprint $table) {
            $table->foreign('bank_uuid')->references('bank_uuid')->on('banks')->onDelete('restrict');
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_transfer_accounts');
    }
}
