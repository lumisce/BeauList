<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name');
            $table->unsignedBigInteger('brand');
            $table->unsignedBigInteger('category')->nullable();
            $table->string('image');
            $table->date('released_on');
            $table->boolean('discontinued');
            $table->foreign('brand')
                ->references('id')->on('brands')
                ->onDelete('cascade');
            $table->foreign('category')
                ->references('id')->on('categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand', 'category']);
            $table->dropColumn(['brand', 'category', 'name', 'image','released_on', 'discontinued']);
        });
    }
}
