<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model
{
    //
    protected $fillable = [
        'title',
        'content',
    ];
}
