<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_histories', function (Blueprint $table) {
            $table->uuid('otp_history_uuid')->primary();
            $table->uuid('user_uuid')->nullable();
            $table->string('mobile_number', 15);
            $table->text('otp');
            $table->timestamp('expired_at');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE otp_histories ALTER COLUMN otp_history_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('otp_histories', function (Blueprint $table) {
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
        Schema::dropIfExists('otp_histories');
    }
}
