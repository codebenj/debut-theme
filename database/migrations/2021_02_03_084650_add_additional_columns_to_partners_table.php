<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('page_heading')->nullable();
            $table->text('page_subheading')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('page_heading');
            $table->dropColumn('page_subheading');
            $table->dropColumn('seo_title');
            $table->dropColumn('seo_description');
        });
    }
}
