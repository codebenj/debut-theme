<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddonSettingsTitleInAddOnInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('add_on_infos', function (Blueprint $table) {
            $table->string('addon_settings_title')->nullable()->default(NULL)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_on_infos', function (Blueprint $table) {
            $table->dropColumn(['addon_settings_title']);
        });
    }
}
