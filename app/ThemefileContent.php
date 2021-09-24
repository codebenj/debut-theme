<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThemefileContent extends Model
{
    protected $fillable = [
        'themefile_id', 'themefile_content'
    ];
}