<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Storage;

class AddOnInfo extends Model
{
    protected $fillable = [
        'name',
        'addon_settings_title',
        'description',
        'wistia_video_id',
        'cost',
        'conversion_rate',
        'icon_path',
        'category',
    ];
    
    protected $appends = [
        'thumbnail',
        'icon_url',
    ];

    public function getThumbnailAttribute()
    {
        $response = json_decode(@file_get_contents('http://fast.wistia.net/oembed?url=http://home.wistia.com/medias/'.$this->wistia_video_id.'?embedType=async&videoWidth=640'));
        return $response->thumbnail_url ?? '';
    }

    public function getIconUrlAttribute()
    {
        return $this->icon_path ? Storage::url($this->icon_path) : '';
    }
}
