<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('charge_id')->unique();
            $table->boolean('test')->default(0);
            $table->string('status', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('terms', 255)->nullable();
            $table->integer('type');
            $table->decimal('price');
            $table->decimal('capped_amount')->nullable();
            $table->integer('trial_days')->nullable();
            $table->timestamp('billing_on')->nullable();
            $table->timestamp('activated_on')->nullable();
            $table->timestamp('trial_ends_on')->nullable();
            $table->timestamp('cancelled_on')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('user_id')->index('charges_shop_id_foreign');
            $table->unsignedInteger('plan_id')->nullable()->index('charges_plan_id_foreign');
            $table->string('description', 255)->nullable();
            $table->bigInteger('reference_charge')->nullable()->index('charges_reference_charge_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charges');
    }
}
