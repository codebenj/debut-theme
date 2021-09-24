<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_ons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('global_id')->index('global_id');
            $table->integer('user_id')->index('user_id');
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->string('invoiceitem', 255)->nullable();
            $table->string('shedule_time', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_ons');
    }
}
