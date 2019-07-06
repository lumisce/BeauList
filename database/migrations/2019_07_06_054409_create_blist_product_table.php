<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlistProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blist_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('blist_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->foreign('blist_id')
                ->references('id')->on('blists');
            $table->foreign('product_id')
                ->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blist_product');
    }
}
