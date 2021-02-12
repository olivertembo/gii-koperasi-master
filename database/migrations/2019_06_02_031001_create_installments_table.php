<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->uuid('installment_uuid')->primary();
            $table->uuid('transaction_uuid');
            $table->bigInteger('currency_id');
            $table->string('invoice_number');
            $table->bigInteger('installment_amount');
            $table->integer('installment_to');
            $table->string('payment_transaction_number')->nullable();
            $table->timestamp('pay_at')->nullable();
            $table->date('due_date');
            $table->bigInteger('interest_amount');
            $table->bigInteger('fine_amount');
            $table->integer('day');
            $table->bigInteger('fine_total_amount');
            $table->integer('day_total');
            $table->longText('xendit_response')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE installments ALTER COLUMN installment_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('installments', function (Blueprint $table) {
            $table->foreign('transaction_uuid')->references('transaction_uuid')->on('transactions')->onDelete('restrict');
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
        Schema::dropIfExists('installments');
    }
}
