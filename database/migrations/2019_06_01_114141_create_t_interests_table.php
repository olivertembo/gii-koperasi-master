<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_interests', function (Blueprint $table) {
            $table->uuid('t_interest_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->bigInteger('interest_type_id');
            $table->integer('interest_percentage');
            $table->integer('tenure');
            $table->integer('day_amount');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE t_interests ALTER COLUMN t_interest_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('t_interests', function (Blueprint $table) {
            $table->foreign('interest_type_id')->references('interest_type_id')->on('interest_types')->onDelete('restrict');
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
        Schema::dropIfExists('t_interests');
    }
}
