<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainSubscription extends Model
{
    protected $guarded = [];
    protected $table = 'main_subscriptions';

    const PAYMENT_PLATFORM_STRIPE = 'stripe';
    const PAYMENT_PLATFORM_PAYPAL = 'paypal';

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
