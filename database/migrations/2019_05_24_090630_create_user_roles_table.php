<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->uuid('user_role_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('role_uuid')->unsigned();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE user_roles ALTER COLUMN user_role_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('user_roles', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('user_roles');
    }
}
