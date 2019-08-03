<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBlistContraintInBlistProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blist_product', function (Blueprint $table) {
            $table->dropForeign('blist_product_blist_id_foreign');
            $table->foreign('blist_id')
                ->references('id')->on('blists')
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
        Schema::table('blist_product', function (Blueprint $table) {
            $table->dropForeign('blist_product_blist_id_foreign');
            $table->foreign('blist_id')
                ->references('id')->on('blists');
        });
    }
}
