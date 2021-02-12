<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->uuid('complain_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->text('complain_reason');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE complains ALTER COLUMN complain_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('complains', function (Blueprint $table) {
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complains');
    }
}
