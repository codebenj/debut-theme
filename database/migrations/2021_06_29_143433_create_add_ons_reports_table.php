<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnsReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_ons_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->text('stores_update_info')->nullable()->default(NULL);
            $table->longText('all_active_addons')->nullable()->default(NULL);
            $table->longText('plan_wise_active_addons')->nullable()->default(NULL);
            $table->longText('top_used_colors')->nullable()->default(NULL);
            $table->dateTime('report_generate_date', 0)->nullable()->default(NULL);
            $table->softDeletes();
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
        Schema::dropIfExists('add_ons_reports');
    }
}
