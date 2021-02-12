<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_banks', function (Blueprint $table) {
            $table->uuid('user_bank_uuid')->primary();
            $table->uuid('bank_uuid');
            $table->uuid('user_uuid');
            $table->string('account_number');
            $table->string('recipient_name');
            $table->string('branch')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('verified_at')->nullable();
            $table->uuid('verified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE user_banks ALTER COLUMN user_bank_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('user_banks', function (Blueprint $table) {
            $table->foreign('bank_uuid')->references('bank_uuid')->on('banks')->onDelete('restrict');
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('verified_by')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_banks');
    }
}
