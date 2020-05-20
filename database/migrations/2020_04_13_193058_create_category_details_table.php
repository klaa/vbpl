<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_details', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->string('language');
            $table->string('name');
            $table->text('desc')->nullable();
            $table->string('keywords')->nullable();            
            $table->string('title')->nullable();            
            $table->timestamps();

            $table->primary(['category_id','language']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_details');
    }
}
