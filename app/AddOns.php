<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddOns extends Model
{
    public function users() {
        return $this->belongsTo('App\User');
    }

    public function globaladdons() {
        return $this->belongsTo('App\GlobalAddons');
    }

    public function scopeWithGlobal($query) {
        $query->leftJoin('global_addons', function ($join) {
            $join->on('add_ons.global_id', '=' , 'global_addons.id');
        });
        $query->select('global_addons.*','add_ons.status', 'add_ons.global_id', 'add_ons.user_id');
        $query->orderBy('title');
        return $query;
    }

    # Get Addon by user id
    public function scopeShop( $query, $shopId )
    {
        if ( isset( $shopId ) && ! empty( $shopId ) )
        {
            $query->where('user_id', $shopId);
        }

        return $query;
    }

    # Get Active Addon
    public function scopeActive( $query )
    {
        $query->where('status', 1); // 1 = Active

        return  $query;
    }

    # Get Addon by global id
    public function scopeGlobal( $query, $globalId)
    {
        if ( isset( $globalId ) && ! empty( $globalId ) )
        {
            $query->where('global_id', $globalId);
        }

        return $query;
    }
}


?>