<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubdistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdistricts', function (Blueprint $table) {
            $table->bigIncrements('subdistrict_id');
            $table->bigInteger('city_id')->nullable();
            $table->string('subdistrict_name');
            $table->string('subdistrict_code');
            $table->timestamps();
        });

        Schema::table('subdistricts', function (Blueprint $table) {
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subdistricts');
    }
}
