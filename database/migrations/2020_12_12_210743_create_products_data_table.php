<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->float('price')->nullable();
            $table->string('size');
            $table->string('color');
            $table->string('category');
            $table->integer('availability');
            $table->integer('status');
            $table->string('description');
            $table->string('image');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_data');
    }
}
