<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_fines', function (Blueprint $table) {
            $table->uuid('t_fine_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->bigInteger('fine_type_id');
            $table->bigInteger('currency_id')->nullable();
            $table->boolean('is_percentage');
            $table->integer('fine_percentage');
            $table->integer('fine_amount');
            $table->integer('day_amount');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE t_fines ALTER COLUMN t_fine_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_fines', function (Blueprint $table) {
            $table->foreign('fine_type_id')->references('fine_type_id')->on('fine_types')->onDelete('restrict');
            $table->foreign('currency_id')->references('currency_id')->on('currencies')->onDelete('restrict');
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
        Schema::dropIfExists('t_fines');
    }
}
