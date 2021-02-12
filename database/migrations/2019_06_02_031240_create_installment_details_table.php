<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('installment_details', function (Blueprint $table) {
//            $table->uuid('installment_detail_uuid')->primary();
//            $table->uuid('installment_uuid');
//            $table->string('invoice_number');
//            $table->bigInteger('installment_amount');
//            $table->integer('installment_to');
//            $table->string('payment_transaction_number')->nullable();
//            $table->timestamp('pay_at')->nullable();
//            $table->date('due_date');
//            $table->bigInteger('interest_amount');
//            $table->bigInteger('fine_amount');
//            $table->integer('day');
//            $table->bigInteger('fine_total_amount');
//            $table->integer('day_total');
//            $table->timestamps();
//        });
//
//        DB::statement('ALTER TABLE installment_details ALTER COLUMN installment_detail_uuid SET DEFAULT uuid_generate_v4();');
//        Schema::table('installment_details', function (Blueprint $table) {
//            $table->foreign('installment_uuid')->references('installment_uuid')->on('installments')->onDelete('restrict');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('installment_details');
    }
}
