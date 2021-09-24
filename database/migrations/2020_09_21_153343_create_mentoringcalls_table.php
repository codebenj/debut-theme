<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentoringcallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentoringcalls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('mentoringcalls_shop_id_foreign');
            $table->string('name', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->integer('days')->default(0);
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
        Schema::dropIfExists('mentoringcalls');
    }
}
