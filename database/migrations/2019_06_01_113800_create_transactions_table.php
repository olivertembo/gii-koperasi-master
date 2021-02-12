<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('transaction_uuid')->primary();
            $table->uuid('customer_uuid');
            $table->uuid('loan_purpose_uuid')->nullable();
            $table->uuid('coupon_uuid')->nullable();
            $table->string('transaction_number');
            $table->bigInteger('currency_id');
            $table->integer('loan_amount');
            $table->integer('fee_amount');
            $table->integer('discount')->default(0);
            $table->date('due_date')->nullable();
            $table->tinyInteger("loan_type"); //1 uang 2 barang
            $table->timestamps();
            $table->softDeletes();

            $table->string('courier_resi')->nullable();
            $table->integer('weight_total')->nullable();
            $table->uuid('cooperative_uuid')->nullable();

            $table->string('destination')->nullable();
            $table->string('destination_type')->nullable();
            $table->string('destination_details')->nullable();
            $table->string('courier_code')->nullable();
            $table->string('courier_name')->nullable();
            $table->string('courier_service_code')->nullable();
            $table->string('courier_service_description')->nullable();
            $table->integer('courier_cost')->nullable();
            $table->longText('courier_details')->nullable();
        });
        DB::statement('ALTER TABLE transactions ALTER COLUMN transaction_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('customer_uuid')->references('customer_uuid')->on('customers')->onDelete('restrict');
            $table->foreign('currency_id')->references('currency_id')->on('currencies')->onDelete('restrict');
            $table->foreign('loan_purpose_uuid')->references('loan_purpose_uuid')->on('loan_purposes')->onDelete('restrict');
            $table->foreign('coupon_uuid')->references('coupon_uuid')->on('coupons')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
