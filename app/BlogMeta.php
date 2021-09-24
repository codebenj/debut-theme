<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogMeta extends Model
{
    //
    protected $fillable = [
        'blog_id', 'meta_id',
    ];
}
