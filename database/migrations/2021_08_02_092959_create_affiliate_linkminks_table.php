<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateLinkminksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_linkminks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('conversion_id')->nullable();
            $table->string('paypal_id')->nullable();
            $table->string('paypal_plan')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('type')->nullable();
            $table->text('response')->nullable();
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
        Schema::dropIfExists('affiliate_linkminks');
    }
}
