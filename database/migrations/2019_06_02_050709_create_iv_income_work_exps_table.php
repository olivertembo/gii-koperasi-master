<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIvIncomeWorkExpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iv_income_work_exps', function (Blueprint $table) {
            $table->uuid('iv_income_work_exp_uuid')->primary();
            $table->string('type_income')->default('>=');
            $table->bigInteger('income')->default(0);
            $table->string('type_work_exp')->default('>=');
            $table->bigInteger('work_exp')->default(0);
            $table->boolean('is_active');
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE iv_income_work_exps ALTER COLUMN iv_income_work_exp_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('iv_income_work_exps', function (Blueprint $table) {
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
        Schema::dropIfExists('iv_income_work_exps');
    }
}
