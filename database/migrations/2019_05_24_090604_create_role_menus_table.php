<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menus', function (Blueprint $table) {
            $table->uuid('role_menu_uuid')->primary();
            $table->bigInteger('menu_id')->unsigned();
            $table->uuid('role_uuid')->unsigned();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::statement('ALTER TABLE role_menus ALTER COLUMN role_menu_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('role_menus', function (Blueprint $table) {
            $table->foreign('menu_id')->references('menu_id')->on('menus')->onDelete('restrict');
            $table->foreign('role_uuid')->references('role_uuid')->on('roles')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_menus');
    }
}
