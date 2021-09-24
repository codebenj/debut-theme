<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreeAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('free_addons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('shopify_domain', 255);
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->string('coupon_code', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('free_addons');
    }
}
