<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'position',
        'quote_body',
        'quote_by',
        'hierarchy',
        'team_id',
    ];

    protected $appends = [
        'image_url',
        'default_image'
    ];

    public function team()
    {
        return $this->belongsTo('App\Team');
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function getDefaultImageAttribute()
    {
        return '/images/landing/meet-default.png';
    }
}
