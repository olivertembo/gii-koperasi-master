<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogRequestApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_request_apis', function (Blueprint $table) {
            $table->uuid('log_request_api_uuid')->primary();
            $table->uuid('user_uuid')->nullable();
            $table->string('ip')->nullable();
            $table->string('method')->nullable();
            $table->string('url')->nullable();
            $table->text('input')->nullable();
            $table->text('information')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE log_request_apis ALTER COLUMN log_request_api_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('log_request_apis', function (Blueprint $table) {
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
        Schema::dropIfExists('log_request_apis');
    }
}
