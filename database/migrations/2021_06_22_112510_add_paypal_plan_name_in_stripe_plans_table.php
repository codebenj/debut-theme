<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaypalPlanNameInStripePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stripe_plans', function (Blueprint $table) {
            $table->string('paypal_plan_name')->nullable()->default(NULL)->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripe_plans', function (Blueprint $table) {
            $table->dropColumn(['paypal_plan_name']);
        });
    }
}
