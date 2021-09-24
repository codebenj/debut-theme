<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPaypal extends Model
{
    protected $table = 'subscription_paypal';
    protected $guarded = [];

    const SUSPENDED = 'SUSPENDED';
    const CANCELLED = 'CANCELLED';
    const ACTIVE = 'ACTIVE';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('paypal_status', 'ACTIVE')
            ->orderBy('id', 'desc');
    }

    public function scopeActiveOrSuspended($query)
    {
        return $query->whereIn('paypal_status', ['ACTIVE', 'SUSPENDED'])
            ->orderBy('id', 'desc');
    }

    public function scopeStatus($query, $status)
    {
        if ( isset($status) && ! empty($status) ) {
            $query->where('paypal_status', $status);
        }

        return $query;
    }

    public function plan()
    {
        return $this->belongsTo(StripePlan::class, 'paypal_plan', 'paypal_plan');
    }
}

