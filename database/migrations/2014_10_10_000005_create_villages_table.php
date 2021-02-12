<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->bigIncrements('village_id');
            $table->bigInteger('subdistrict_id')->nullable();
            $table->string('village_name');
            $table->string('village_code');
            $table->timestamps();
        });

        Schema::table('villages', function (Blueprint $table) {
            $table->foreign('subdistrict_id')->references('subdistrict_id')->on('subdistricts')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('villages');
    }
}
