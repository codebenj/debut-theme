<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
class StripePlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'stripe_plan',
        'cost',
        'description'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeCycle($query, $cycle) {
        if ( isset( $cycle ) && ! empty( $cycle ) ) {
            $query->where('slug', 'LIKE', "%{$cycle}%");
        }

        return $query;
    }

    public function scopePlan($query, $plan) {
        if ( isset( $plan ) && ! empty( $plan ) ) {
            $query->where('plan_name', $plan);
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCycleAttribute()
    {
        [, , $cycle] = preg_split('/(?=[A-Z])/', $this->name);

        if ($cycle === 'Yearly' || $cycle == 'Annually')
        {
            return 'Yearly';
        }
        return $cycle;
    }
}























?>
