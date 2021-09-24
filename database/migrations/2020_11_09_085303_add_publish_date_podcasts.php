<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublishDatePodcasts extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('podcasts', function (Blueprint $table) {
			//
			$table->text('meta_description')->after('title')->nullable();
			$table->longText('podcast_transcript')->after('feature_image')->nullable();
			$table->text('transcript_time')->after('podcast_transcript')->nullable();
			$table->bigInteger('author_id')->after('transcript_time')->nullable();
			$table->date('podcast_publish_date')->after('author_id')->nullable();

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('podcasts', function (Blueprint $table) {
            $table->dropColumn(['meta_description', 'podcast_transcript', 'transcript_time', 'author_id','podcast_publish_date']);
		});
	}
}
