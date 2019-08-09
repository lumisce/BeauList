<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductUserHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('product_count')->default(1);
            $table->unsignedBigInteger('quantity_price_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('decluttered_reason_id')->nullable();
            $table->date('opened_on')->nullable();
            $table->date('expires_on')->nullable();
            $table->unsignedBigInteger('received_id')->nullable();
            $table->string('note')->default('');
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')->on('products');
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->foreign('quantity_price_id')
                ->references('id')->on('quantity_prices');
            $table->foreign('status_id')
                ->references('id')->on('product_user_history_status');
            $table->foreign('decluttered_reason_id')
                ->references('id')->on('product_user_history_decluttered_reason');
            $table->foreign('received_id')
                ->references('id')->on('product_user_history_received');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_user_history');
    }
}
