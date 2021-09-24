<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('name', 255);
            $table->decimal('price');
            $table->decimal('capped_amount')->nullable();
            $table->string('terms', 255)->nullable();
            $table->integer('trial_days')->nullable();
            $table->boolean('test')->default(0);
            $table->boolean('on_install')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
