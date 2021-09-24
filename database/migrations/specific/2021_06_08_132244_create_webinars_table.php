<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('presenter');
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->date('release_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('webinar_link')->nullable();
            $table->timestamps();
            $table->foreign('presenter')->references('id')->on('admin_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webinars');
    }
}
