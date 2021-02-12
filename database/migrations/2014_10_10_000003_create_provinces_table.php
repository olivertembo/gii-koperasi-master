<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->bigIncrements('province_id');
            $table->bigInteger('country_id')->nullable();
            $table->string('province_name');
            $table->string('province_code');
            $table->timestamps();
        });

        Schema::table('provinces', function (Blueprint $table) {
            $table->foreign('country_id')->references('country_id')->on('countries')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
