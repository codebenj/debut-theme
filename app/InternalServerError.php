<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InternalServerError extends Model
{
    //
    protected $fillable = [
        'user_id',
        'error_message',
    ];
}
