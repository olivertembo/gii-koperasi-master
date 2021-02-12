<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyInvestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_invests', function (Blueprint $table) {
            $table->uuid('money_invest_uuid')->primary();
            $table->uuid('cooperative_uuid');
            $table->bigInteger('currency_id');
            $table->integer('amount');
            $table->uuid('verified_by');
            $table->timestamp('verified_at');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE money_invests ALTER COLUMN money_invest_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('money_invests', function (Blueprint $table) {
            $table->foreign('cooperative_uuid')->references('cooperative_uuid')->on('cooperatives')->onDelete('restrict');
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
        Schema::dropIfExists('money_invests');
    }
}
