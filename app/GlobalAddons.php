<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GlobalAddons extends Model
{
    public function addons() {
        return $this->hasOne('App\AddOns', 'global_id');
    }
}