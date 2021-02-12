<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('country_id');
            $table->bigInteger('continent_id')->nullable();
            $table->string('country_name');
            $table->string('fips104');
            $table->string('iso2');
            $table->string('iso3');
            $table->string('ison');
            $table->string('internet');
            $table->string('capital');
            $table->string('mapreference');
            $table->string('nationalitysingular');
            $table->string('nationalityplural');
            $table->string('population');
            $table->string('title');
            $table->string('phone_code')->nullable();
            $table->text('comment');
            $table->timestamps();
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->foreign('continent_id')->references('continent_id')->on('continents')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
