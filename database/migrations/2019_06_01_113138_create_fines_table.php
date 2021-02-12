<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fines', function (Blueprint $table) {
            $table->uuid('fine_uuid')->primary();
            $table->bigInteger('fine_type_id');
            $table->bigInteger('currency_id')->nullable();
            $table->boolean('is_percentage');
            $table->integer('fine_percentage');
            $table->integer('fine_amount');
            $table->integer('day_amount');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE fines ALTER COLUMN fine_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('fines', function (Blueprint $table) {
            $table->foreign('fine_type_id')->references('fine_type_id')->on('fine_types')->onDelete('restrict');
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
        Schema::dropIfExists('fines');
    }
}
