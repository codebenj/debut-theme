<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Updates extends Model
{
    protected $appends = ['is_showable'];

    public function getFooterButtonTextAttribute($value)
    {
        return $value ?: 'View Changelog';
    }

    public function getFooterButtonLinkAttribute($value)
    {
        return $value ?: url('/app/changelog');
    }

    public function getIsShowableAttribute()
    {
        if (!$this->show_until) {
            return true;
        }
        
        return !Carbon::parse($this->show_until)->endOfDay()->isPast();
    }
}