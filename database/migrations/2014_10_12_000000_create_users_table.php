<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_uuid')->primary()->unique();
            $table->bigInteger('user_status_id');
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('gender_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('file_path')->nullable();
            $table->longText('fileb64')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('nik')->nullable();
            $table->integer('type')->nullable(false)->default(1);
            $table->rememberToken();
            $table->date('birthdate')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('forgot_pin_end_at')->nullable();
            $table->text('fcm_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE users ALTER COLUMN user_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('user_status_id')->references('user_status_id')->on('user_statuses')->onDelete('restrict');
            $table->foreign('city_id')->references('city_id')->on('cities')->onDelete('restrict');
            $table->foreign('gender_id')->references('gender_id')->on('genders')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
