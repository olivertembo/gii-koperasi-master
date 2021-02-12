<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interests', function (Blueprint $table) {
            $table->uuid('interest_uuid')->primary();
            $table->bigInteger('interest_type_id');
            $table->integer('interest_percentage');
            $table->integer('tenure');
            $table->integer('day_amount');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE interests ALTER COLUMN interest_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('interests', function (Blueprint $table) {
            $table->foreign('interest_type_id')->references('interest_type_id')->on('interest_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interests');
    }
}
