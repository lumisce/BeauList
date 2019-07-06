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
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('image');
            $table->string('description');
            $table->date('released_on');
            $table->boolean('discontinued')->default(false);
            $table->foreign('brand_id')
                ->references('id')->on('brands')
                ->onDelete('cascade');
            $table->foreign('category_id')
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
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
            $table->dropColumn(['brand_id', 'category_id', 'name', 'description', 'image','released_on', 'discontinued']);
        });
    }
}
