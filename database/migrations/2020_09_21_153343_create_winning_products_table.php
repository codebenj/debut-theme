<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWinningProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('winning_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('price', 255)->nullable();
            $table->string('cost', 255)->nullable();
            $table->string('profit', 255)->nullable();
            $table->text('aliexpresslink')->nullable();
            $table->text('facebookadslink')->nullable();
            $table->text('googletrendslink')->nullable();
            $table->text('youtubelink')->nullable();
            $table->text('competitorlink')->nullable();
            $table->string('age', 255);
            $table->string('gender', 255);
            $table->string('placement', 255);
            $table->string('saturationlevel', 255);
            $table->string('image', 255)->nullable();
            $table->timestamps();
            $table->string('interesttarget', 255)->nullable();
            $table->string('opinion', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('video', 255)->nullable();
            $table->string('category', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('winning_products');
    }
}
