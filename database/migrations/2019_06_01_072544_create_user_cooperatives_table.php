<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCooperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_cooperatives', function (Blueprint $table) {
            $table->uuid('user_cooperative_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('cooperative_uuid');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE user_cooperatives ALTER COLUMN user_cooperative_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('user_cooperatives', function (Blueprint $table) {
            $table->foreign('cooperative_uuid')->references('cooperative_uuid')->on('cooperatives')->onDelete('restrict');
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
        Schema::dropIfExists('user_cooperatives');
    }
}
