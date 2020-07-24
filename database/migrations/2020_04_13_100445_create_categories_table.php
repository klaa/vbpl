<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('category_type');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('keywords')->nullable();            
            $table->string('title')->nullable();
            $table->string('alias');
            $table->tinyInteger('published')->default(1);
            $table->integer('ordering')->default(0);
            $table->timestamps();
            $table->unique(['category_type','alias']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
