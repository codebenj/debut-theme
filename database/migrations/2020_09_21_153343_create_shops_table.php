<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shopify_domain', 255)->index('idx_shops_shopify_domain');
            $table->string('shopify_token', 255)->nullable();
            $table->string('shopowner_email', 255)->nullable();
            $table->integer('theme_id')->nullable();
            $table->string('shopify_theme_id', 255)->nullable();
            $table->string('theme_url', 255)->nullable();
            $table->timestamps();
            $table->boolean('grandfathered')->default(0);
            $table->softDeletes();
            $table->string('namespace', 255)->nullable();
            $table->unsignedInteger('plan_id')->nullable()->index('shops_plan_id_foreign');
            $table->boolean('freemium')->default(0);
            $table->string('stripe_id', 255)->nullable();
            $table->string('card_brand', 255)->nullable();
            $table->string('card_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->tinyInteger('subscribed')->default(0);
            $table->string('license_key', 255)->nullable();
            $table->string('custom_domain', 255)->nullable();
            $table->string('alladdons_plan', 255)->nullable();
            $table->string('all_adons', 255)->nullable();
            $table->string('shop_update', 255)->nullable();
            $table->string('sub_plan', 255)->nullable();
            $table->string('sub_trial_ends_at', 255)->nullable();
            $table->string('master_account', 255)->nullable();
            $table->string('child_account', 255)->nullable();
            $table->string('trial_days', 255)->nullable();
            $table->string('lastactivity', 255)->nullable();
            $table->string('trial_check', 255)->nullable();
            $table->string('theme_check', 255)->nullable();
            $table->index(['shopify_token', 'shopify_domain', 'deleted_at', 'namespace'], 'idx_shops_shopify_token_shopify_domain_deleted_at_namespace');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
