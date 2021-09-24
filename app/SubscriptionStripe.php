<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionStripe extends Model
{
	protected $table = 'subscription_stripe';

    const CANCELLED = 'canceled';
    const ACTIVE = 'active';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('ends_at')->orderBy('id', 'desc');
    }

    public function scopeStatus($query, $status)
    {
        if ( isset($status) && ! empty($status) ) {
            $query->where('stripe_status', $status);
        }

        return $query;
    }

    public function plan()
    {
        return $this->belongsTo(StripePlan::class, 'stripe_plan', 'stripe_plan');
    }
}
