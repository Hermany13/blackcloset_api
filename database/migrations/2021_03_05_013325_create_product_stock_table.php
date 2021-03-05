<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_product')->unsigned();
            $table->bigInteger('id_color')->unsigned();
            $table->bigInteger('id_size')->unsigned();
            $table->integer('quantity');
            $table->string('img_color');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            // Relationships
            $table->foreign('id_product')->references('id')->on('products_data');
            $table->foreign('id_color')->references('id')->on('colors');
            $table->foreign('id_size')->references('id')->on('sizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock');
    }
}
