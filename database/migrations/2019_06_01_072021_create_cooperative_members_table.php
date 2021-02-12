<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperativeMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperative_members', function (Blueprint $table) {
            $table->uuid('cooperative_member_uuid')->primary();
            $table->uuid('cooperative_uuid');
            $table->bigInteger('city_id');
            $table->bigInteger('gender_id');
            $table->bigInteger('customer_status_id');
            $table->bigInteger('limit')->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('file_path')->nullable();
            $table->longText('fileb64')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('nik')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('member_number')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('join_date');
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE cooperative_members ALTER COLUMN cooperative_member_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('cooperative_members', function (Blueprint $table) {
            $table->foreign('cooperative_uuid')->references('cooperative_uuid')->on('cooperatives')->onDelete('restrict');
            $table->foreign('customer_status_id')->references('customer_status_id')->on('customer_statuses')->onDelete('restrict');
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('user_uuid')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('cooperative_members');
    }
}
