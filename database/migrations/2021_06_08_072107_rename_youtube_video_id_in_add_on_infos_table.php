<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameYoutubeVideoIdInAddOnInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('add_on_infos', function (Blueprint $table) {
            $table->renameColumn('youtube_video_id', 'wistia_video_id');
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
            $table->renameColumn('wistia_video_id', 'youtube_video_id');
        });
    }
}
