<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCooperativeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooperative_documents', function (Blueprint $table) {
            $table->uuid('cooperative_document_uuid')->primary();
            $table->uuid('cooperative_uuid');
            $table->string('cooperative_document_name');
            $table->string('file_path')->nullable();
            $table->longText('fileb64')->nullable();
            $table->text('description');
            $table->uuid('created_by');
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE cooperative_documents ALTER COLUMN cooperative_document_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('cooperative_documents', function (Blueprint $table) {
            $table->foreign('cooperative_uuid')->references('cooperative_uuid')->on('cooperatives')->onDelete('restrict');
            $table->foreign('created_by')->references('user_uuid')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooperative_documents');
    }
}
