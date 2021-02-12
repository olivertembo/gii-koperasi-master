<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUpgradeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_upgrade_statuses', function (Blueprint $table) {
            $table->uuid('role_upgrade_status_uuid')->primary();
            $table->uuid('role_uuid');
            $table->bigInteger('upgrade_status_id');
        });

        DB::statement('ALTER TABLE role_upgrade_statuses ALTER COLUMN role_upgrade_status_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('role_upgrade_statuses', function (Blueprint $table) {
            $table->foreign('upgrade_status_id')->references('upgrade_status_id')->on('upgrade_statuses')->onDelete('restrict');
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
        Schema::dropIfExists('role_upgrade_statuses');
    }
}
