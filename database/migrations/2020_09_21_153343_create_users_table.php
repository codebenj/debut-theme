<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->index('name');
            $table->string('email', 255)->nullable()->index('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('shopify_grandfathered')->default(0);
            $table->string('shopify_namespace', 255)->nullable();
            $table->boolean('shopify_freemium')->default(0);
            $table->unsignedInteger('plan_id')->nullable();
            $table->softDeletes();
            $table->integer('theme_id')->nullable();
            $table->string('shopify_theme_id', 255)->nullable();
            $table->string('theme_url', 255)->nullable();
            $table->string('namespace', 255)->nullable()->index('namespace');
            $table->boolean('freemium')->default(0);
            $table->string('stripe_id', 255)->nullable();
            $table->string('card_brand', 255)->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->tinyInteger('subscribed')->default(0);
            $table->string('license_key', 255)->nullable();
            $table->string('all_addons', 255)->nullable();
            $table->string('custom_domain', 255)->nullable();
            $table->string('alladdons_plan', 255)->nullable();
            $table->string('shop_update', 255)->nullable();
            $table->string('sub_plan', 255)->nullable();
            $table->string('sub_trial_ends_at', 255)->nullable();
            $table->string('master_account', 255)->nullable();
            $table->string('child_account', 255)->nullable();
            $table->string('trial_days', 255)->nullable();
            $table->string('lastactivity', 255)->nullable();
            $table->string('trial_check', 255)->nullable();
            $table->string('theme_check', 255)->nullable();
            $table->boolean('grandfathered')->default(0);
            $table->boolean('review_given')->nullable();
            $table->longText('shopify_raw')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
