<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id')->index('steps_module_id_foreign');
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->text('video1')->nullable();
            $table->text('video2')->nullable();
            $table->timestamps();
            $table->integer('position')->nullable();
            $table->text('tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steps');
    }
}
