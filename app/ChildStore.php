<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChildStore extends Model
{
    protected $table = 'childstores';

    public function scopeFirstStore($query, $store) {
        if ( isset($store) && ! empty($store) ) {
            $query->where('store', $store)->first();
        }

        return $query;
    }
}
