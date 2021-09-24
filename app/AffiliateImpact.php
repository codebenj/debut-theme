<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateImpact extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email','status', 'impact_id'
    ];
}
