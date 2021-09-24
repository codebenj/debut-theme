<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthorIdColumnInYoutubeVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->bigInteger('author_id')->nullable()->after('watching_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('youtube_videos', function (Blueprint $table) {
            $table->dropColumn('author_id');
        });
    }
}
