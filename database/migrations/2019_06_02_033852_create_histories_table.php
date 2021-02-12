<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->uuid('history_uuid')->primary();
            $table->uuid('user_uuid');
            $table->string('type');
            $table->string('request');
            $table->string('reference');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE histories ALTER COLUMN history_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('histories', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('histories');
    }
}
