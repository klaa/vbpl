<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_details', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->char('language');
            $table->string('name');
            $table->text('body');
            $table->string('keywords')->nullable();
            $table->text('desc')->nullable();
            $table->string('title')->nullable();            
            $table->timestamps();

            $table->primary(['post_id','language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_details');
    }
}
