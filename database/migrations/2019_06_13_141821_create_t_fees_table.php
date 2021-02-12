<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_fees', function (Blueprint $table) {
            $table->uuid('t_fee_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->boolean('is_percentage');
            $table->integer('percentage');
            $table->bigInteger('currency_id')->nullable();
            $table->integer('amount');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE t_fees ALTER COLUMN t_fee_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_fees', function (Blueprint $table) {
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
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
        Schema::dropIfExists('t_fees');
    }
}
