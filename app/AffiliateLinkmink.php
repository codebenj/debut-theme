<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateLinkmink extends Model
{
    protected $fillable = [
        'user_id', 'conversion_id', 'paypal_id', 'paypal_plan', 'paypal_email', 'type', 'response'
    ];
}
