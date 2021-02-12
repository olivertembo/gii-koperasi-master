<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSuspendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_suspends', function (Blueprint $table) {
            $table->uuid('customer_suspend_uuid')->primary();
            $table->uuid('customer_uuid');
            $table->boolean('is_active');
            $table->integer('long_suspend');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE customer_suspends ALTER COLUMN customer_suspend_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('customer_suspends', function (Blueprint $table) {
            $table->foreign('customer_uuid')->references('customer_uuid')->on('customers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_suspends');
    }
}
