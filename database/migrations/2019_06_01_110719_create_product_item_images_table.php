<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductItemImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_item_images', function (Blueprint $table) {
            $table->uuid('product_item_image_uuid')->primary();
            $table->uuid('product_item_uuid');
            $table->string('file_path')->nullable();
            $table->longText('fileb64')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement('ALTER TABLE product_item_images ALTER COLUMN product_item_image_uuid SET DEFAULT uuid_generate_v4();');
        Schema::table('product_item_images', function (Blueprint $table) {
            $table->foreign('product_item_uuid')->references('product_item_uuid')->on('product_items')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_item_images');
    }
}
