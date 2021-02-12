<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('role_uuid')->primary();
            $table->string('role_name');
            $table->string('role_code');
            $table->boolean('is_verificator')->nullable();
            $table->boolean('is_active')->default(true);
            $table->tinyInteger("loan_type")->nullable(); //1 uang 2 barang
            $table->tinyInteger("role_type")->nullable(); //1 internal 2 external
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE roles ALTER COLUMN role_uuid SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
