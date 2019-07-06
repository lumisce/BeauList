<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuantityPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantity_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('quantity');
            $table->string('unit');
            $table->double('price');
            $table->string('currency');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quantity_prices');
    }
}
