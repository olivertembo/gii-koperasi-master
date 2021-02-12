<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_menus', function (Blueprint $table) {
            $table->uuid('user_menu_id')->primary();
            $table->bigInteger('menu_id');
            $table->uuid('user_uuid');
            $table->timestamps();
        });

        Schema::table('user_menus', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('menu_id')->references('menu_id')->on('menus')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_menus');
    }
}
