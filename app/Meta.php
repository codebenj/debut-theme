<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Meta extends Model
{
    
       public static function boot() {

        parent::boot();
        // On create
        self::creating(function ($model) {
              // if (auth()->check()) {
                $model->slug = Str::slug($model->meta_name, '-');
              // }
        });
        
    }
    
 
    protected $fillable = [
        'meta_name', 'meta_type',
    ];


    public static function get_all_blog_meta_in_array(){
        $all_data = self::orderBy('id', 'desc')->get();
        $meta_data = [];
        foreach ($all_data as $key => $value) {
            $meta_data[$value->meta_type][$value->id] = $value->meta_name;
        }

        return $meta_data;
    }

    // get category name and tag name by slug

    public static function get_cat_tag_name_by_slug($slug){

        return self::orderBy('id', 'desc')->select('meta_name')->where('slug',$slug)->first();

    }
    public static function get_all_blog_meta_tags_sitemap(){
        $all_data = self::select('meta_name','slug')->where(['meta_type'=>'blog_tag'])->orderBy('id', 'desc')->get();
        return $all_data;
    }
    public static function get_all_blog_meta_categories_sitemap(){
        $all_data = self::select('meta_name','slug')->where(['meta_type'=>'blog_category'])->orderBy('id', 'desc')->get();
        return $all_data;
    }
}
