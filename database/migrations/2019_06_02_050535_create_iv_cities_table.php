<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iv_cities', function (Blueprint $table) {
            $table->uuid('iv_city_uuid')->primary();
            $table->bigInteger('city_id');
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE iv_cities ALTER COLUMN iv_city_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('iv_cities', function (Blueprint $table) {
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('restrict');
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('iv_cities');
    }
}
