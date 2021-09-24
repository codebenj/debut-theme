<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Themefile extends Model
{
    protected $fillable = [
        'theme_id' , 'file_names'
    ];
}