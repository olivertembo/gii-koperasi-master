<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvSuspendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iv_suspends', function (Blueprint $table) {
            $table->uuid('iv_suspend_uuid')->primary();
            $table->integer('long_suspend')->default(0);
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE iv_suspends ALTER COLUMN iv_suspend_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('iv_suspends', function (Blueprint $table) {
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
        Schema::dropIfExists('iv_suspends');
    }
}
