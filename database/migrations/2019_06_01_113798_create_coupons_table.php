<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('coupon_uuid')->primary();
            $table->bigInteger('currency_id')->nullable();
            $table->string('coupon_name');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_percentage');
            $table->integer('percentage')->default(0);
            $table->integer('amount')->default(0);
            $table->timestamp('begin_at');
            $table->timestamp('expired_at');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE coupons ALTER COLUMN coupon_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('coupons', function (Blueprint $table) {
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
        Schema::dropIfExists('coupons');
    }
}
