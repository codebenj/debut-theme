<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('logo', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->string('offer_description', 255)->nullable();
            $table->integer('featured')->nullable()->default(0);
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
        Schema::dropIfExists('partners');
    }
}
