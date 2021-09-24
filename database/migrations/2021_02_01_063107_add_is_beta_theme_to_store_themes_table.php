<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsBetaThemeToStoreThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_themes', function (Blueprint $table) {
            //
            $table->Integer('is_beta_theme')->default('0');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_themes', function (Blueprint $table) {
            //
            $table->dropColumn(['is_beta_theme']);
            
        });
    }
}
