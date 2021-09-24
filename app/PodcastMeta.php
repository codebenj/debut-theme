<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PodcastMeta extends Model
{
	protected $fillable = [
		'podcast_id', 'meta_id',
	];
}
