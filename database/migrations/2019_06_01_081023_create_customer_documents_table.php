<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->uuid('customer_document_uuid')->primary();
            $table->uuid('customer_uuid');
            $table->bigInteger('document_id');
            $table->string('file_path');
            $table->longText('fileb64');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE customer_documents ALTER COLUMN customer_document_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('customer_documents', function (Blueprint $table) {
            $table->foreign('customer_uuid')->references('customer_uuid')->on('customers')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_documents');
    }
}
