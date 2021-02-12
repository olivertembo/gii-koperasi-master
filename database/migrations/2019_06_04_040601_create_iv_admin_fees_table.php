<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvAdminFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iv_admin_fees', function (Blueprint $table) {
            $table->uuid('iv_admin_fee_uuid')->primary();
            $table->boolean('is_percentage');
            $table->integer('percentage')->default(0);
            $table->bigInteger('currency_id')->nullable();
            $table->integer('amount')->default(0);
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE iv_admin_fees ALTER COLUMN iv_admin_fee_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('iv_admin_fees', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('user_uuid')->on('users')->onDelete('restrict');
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
        Schema::dropIfExists('iv_admin_fees');
    }
}
