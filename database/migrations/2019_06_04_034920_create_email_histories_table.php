<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_histories', function (Blueprint $table) {
            $table->uuid('email_history_uuid')->primary();
            $table->uuid('user_uuid');
            $table->string('email');
            $table->boolean('is_active')->default(false);
            $table->timestamp('varified_at');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE email_histories ALTER COLUMN email_history_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('email_histories', function (Blueprint $table) {
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
        Schema::dropIfExists('email_histories');
    }
}
