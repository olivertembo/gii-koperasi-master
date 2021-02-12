<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUpgradeStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upgrade_statuses', function (Blueprint $table) {
            $table->bigIncrements('upgrade_status_id');
            $table->string('upgrade_status_name');
            $table->string('upgrade_status_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upgrade_statuses');
    }
}
