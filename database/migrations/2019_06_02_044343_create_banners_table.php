<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->uuid('banner_uuid')->primary();
            $table->string('title');
            $table->longText('content');
            $table->string('file_path')->nullable();
            $table->string('fileb64')->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE banners ALTER COLUMN banner_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('banners', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
