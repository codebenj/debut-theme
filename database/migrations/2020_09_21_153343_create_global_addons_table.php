<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_addons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('subtitle')->nullable();
            $table->double('price', 8, 2);
            $table->timestamps();
            $table->string('plan_id', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('global_addons');
    }
}
