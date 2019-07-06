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
            $table->unsignedBigInteger('blist');
            $table->unsignedBigInteger('product');
            $table->timestamps();
            $table->foreign('blist')
                ->references('id')->on('blists');
            $table->foreign('product')
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
