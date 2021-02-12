<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_versions', function (Blueprint $table) {
            $table->uuid('app_version_uuid')->primary();
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->string('version');
            $table->string('url');
            $table->string('message');
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('type');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE app_versions ALTER COLUMN app_version_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('app_versions', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_versions');
    }
}
