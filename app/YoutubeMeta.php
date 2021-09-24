<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubeMeta extends Model
{
    protected $fillable = [
        'video_id', 'meta_id'
    ];
}
