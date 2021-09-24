<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('payment_platform')->nullable();  // stripe or paypal
            $table->unsignedInteger('subscription_id')->nullable();  // id of subscription_stripe or subscription_paypal

            $table->string('stripe_customer_id',255)->nullable();
            $table->string('paypal_customer_id',255)->nullable();

            $table->string('card_brand', 255)->nullable();
            $table->string('card_last_four', 4)->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_subscriptions');
    }
}
