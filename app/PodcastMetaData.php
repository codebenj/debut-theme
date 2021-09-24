<?php

namespace App;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;


class PodcastMetaData extends Model
{
    protected $fillable = [
		'meta_name', 'meta_type', 'slug'
	];

	public static function boot() {

        parent::boot();
        // On create
        self::creating(function ($model) {
              if (auth()->check()) {
                $model->slug = Str::slug($model->meta_name, '-');
              }
        });
        
    }

    
    // get all meta
  public static function get_all_podcast_meta_in_array(){
    $all_data = self::orderBy('id', 'desc')->get();
    $meta_data = [];
    foreach ($all_data as $key => $value) {
      $meta_data[$value->meta_type][$value->id] = $value->meta_name;
    }

    return $meta_data;
  }
  public static function get_cat_tag_name_by_slug($slug){
    return self::orderBy('id', 'desc')->select('meta_name')->where('slug',$slug)->first();
  }
}
