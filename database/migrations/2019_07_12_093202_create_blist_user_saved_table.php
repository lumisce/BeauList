<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlistUserSavedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blist_user_saved', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('blist_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->foreign('blist_id')
                ->references('id')->on('blists');
            $table->foreign('user_id')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blist_user_saved');
    }
}
