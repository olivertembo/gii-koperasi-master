<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('city_id');
            $table->bigInteger('province_id')->nullable();
            $table->string('city_name');
            $table->string('city_code');
            $table->string('tipe_dati2');
            $table->bigInteger('country_id');
            $table->bigInteger('latitude');
            $table->bigInteger('longitude');
            $table->bigInteger('dmaid');
            $table->string('timezone');
            $table->string('code');
            $table->timestamps();
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('province_id')->references('province_id')->on('provinces')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
