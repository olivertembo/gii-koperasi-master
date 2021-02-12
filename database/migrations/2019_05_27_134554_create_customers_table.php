<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('customer_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('cooperative_uuid')->nullable();
            $table->bigInteger('customer_status_id');
            $table->bigInteger('job_id');
            $table->bigInteger('limit')->default(0);
            $table->string('customer_number')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('join_date')->nullable();
            $table->integer('work_experience');
            $table->string('work_place');
            $table->bigInteger('income');
            $table->bigInteger('currency_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE customers ALTER COLUMN customer_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('user_uuid')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('cooperative_uuid')->references('cooperative_uuid')->on('cooperatives')->onDelete('restrict');
            $table->foreign('customer_status_id')->references('customer_status_id')->on('customer_statuses')->onDelete('restrict');
            $table->foreign('job_id')->references('job_id')->on('jobs')->onDelete('restrict');
            $table->foreign('currency_id')->references('currency_id')->on('currencies')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
