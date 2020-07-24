<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->string('name');
            $table->text('body');
            $table->string('keywords')->nullable();
            $table->text('desc')->nullable();
            $table->string('title')->nullable(); 
            $table->string('post_type');
            $table->string('vanban');
            $table->string('kyhieu');
            $table->tinyInteger('trangthai')->default(1);
            $table->date('ngaybanhanh');            
            $table->date('hieulucvb');            
            $table->string('post_type_2')->default('vbnn');
            $table->unsignedBigInteger('category_id');
            $table->tinyInteger('published')->default(1);            
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('is_featured')->default(0);
            $table->integer('ordering')->default(0);
            $table->timestamps();
            $table->unique(['alias','post_type']);
        });
        DB::statement('ALTER TABLE posts ADD FULLTEXT `post_fts_body` (`body`)');
        DB::statement('ALTER TABLE posts ADD FULLTEXT `post_fts_name` (`name`)');
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
