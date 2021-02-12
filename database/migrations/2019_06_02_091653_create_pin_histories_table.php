<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePinHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pin_histories', function (Blueprint $table) {
            $table->uuid('pin_history_uuid')->primary();
            $table->uuid('user_uuid');
            $table->boolean('is_active');
            $table->text('pin');
            $table->integer('wrong_total')->default(0);
            $table->timestamp('locked_up')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE pin_histories ALTER COLUMN pin_history_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('pin_histories', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pin_histories');
    }
}
