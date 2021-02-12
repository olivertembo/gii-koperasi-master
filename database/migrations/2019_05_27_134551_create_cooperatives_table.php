<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperatives', function (Blueprint $table) {
            $table->uuid('cooperative_uuid')->primary();
            $table->bigInteger('city_id');
            $table->bigInteger('additional_limit');
            $table->string('cooperative_name');
            $table->string('cooperative_code');
            $table->string('cooperative_address');
            $table->string('phone');
            $table->string('email');
            $table->string('website')->nullable();
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('origin')->nullable();
            $table->string('origin_type')->nullable();
            $table->longText('origin_details')->nullable();
            $table->bigInteger('partner_type_id')->nullable();
            $table->integer('profit_sharing_money')->nullable();
            $table->integer('profit_sharing_money_tenure')->nullable();
            $table->integer('profit_sharing_product')->nullable();
        });

        DB::statement('ALTER TABLE cooperatives ALTER COLUMN cooperative_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('cooperatives', function (Blueprint $table) {
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
            $table->foreign('updated_by')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooperatives');
    }
}
