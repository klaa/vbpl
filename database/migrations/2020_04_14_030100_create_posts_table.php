<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('alias');
            $table->string('post_type');
            $table->unsignedBigInteger('category_id');
            $table->tinyInteger('published')->default(1);            
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('is_featured')->default(0);
            $table->integer('ordering')->default(0);
            $table->timestamps();
            $table->unique(['alias','post_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
