<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->foreign('plan_id')->references('id')->on('plans')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('reference_charge')->references('charge_id')->on('charges')->onUpdate('RESTRICT')->onDelete('CASCADE');
            $table->foreign('user_id', 'charges_shop_id_foreign')->references('id')->on('users')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropForeign('charges_plan_id_foreign');
            $table->dropForeign('charges_reference_charge_foreign');
            $table->dropForeign('charges_shop_id_foreign');
        });
    }
}
