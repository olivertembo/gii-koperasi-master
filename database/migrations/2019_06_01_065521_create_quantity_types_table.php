<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuantityTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_types', function (Blueprint $table) {
            $table->uuid('quantity_type_uuid')->primary();
            $table->string('quantity_type_name');
            $table->string('quantity_type_symbol');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE quantity_types ALTER COLUMN quantity_type_uuid SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quantity_types');
    }
}
