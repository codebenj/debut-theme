<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;


class Podcasts extends Model {
    public static function boot() {

        parent::boot();
        // On create
        self::creating(function ($model) {
            if (auth()->check()) {
                $model->slug = Str::slug($model->title, '-');
            }
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'description',
        'podcast_widget',
        'feature_image',
        'podcast_publish_date',
        'author_id',
        'meta_description',
        'transcript_time',
        'alt_text',
        'guest_image_alt_text'
    ];

    public static function getPodcastsOrderBY($request) {
        if ($request->has('search')) {
            $query = self::select('title', 'feature_image', 'slug')->where('title', 'LIKE', '%' . $request->search . '%');
            $query = $query->limit(5)->get();
        } else {
            $query = self::orderBy('podcast_publish_date', 'desc');
            $query = $query->paginate(12);
        }
        return $query;
    }

    public static function addPodcast($request) {
        $podcast = self::updateOrCreate([
            'title' => $request->title,
            'description' => $request->description,
            'podcast_widget' => $request->podcast_widget,
            'feature_image' => $request->image_path,
            'podcast_transcript' => $request->podcast_transcript,
            'podcast_publish_date' => $request->podcast_publish_date,
            'author_id' => $request->podcast_author,
            'meta_description' => $request->meta_description,
            'transcript_time' => $request->transcript_time,
            'alt_text' => $request->alt_text,
            'guest_image_alt_text' => $request->guest_image_alt_text
        ]);
        return $podcast;
    }

    public static function getPodcastByID($id) {
        return self::where('id', $id)->first();
    }

    public static function updatePodcast($request) {
        $podcast = self::where(['id' => $request->podcast_id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'podcast_widget' => $request->podcast_widget,
            'feature_image' => $request->image_path,
            'slug' => $request->slug,
            'author_id' => $request->podcast_author,
            'podcast_transcript' => $request->podcast_transcript,
            'podcast_publish_date' => $request->podcast_publish_date,
            'meta_description' => $request->meta_description,
            'transcript_time' => $request->transcript_time,
            'alt_text' => $request->alt_text,
            'guest_image_alt_text' => $request->guest_image_alt_text
        ]);
        return $podcast;
    }

    public static function getPodcastDetailBySlug($slug) {
        return self::where('slug', $slug)->first();
    }
    public static function get_tag_and_category_meta($id) {
        $all_data = DB::table('podcast_metas')
            ->join('podcast_meta_data', 'podcast_meta_data.id', '=', 'podcast_metas.meta_id')
            ->select('podcast_meta_data.meta_name', 'podcast_meta_data.meta_type')
            ->where('podcast_metas.podcast_id', $id)
            ->get();
        return $all_data;

    }

    // relation with blog auth user
    public function currentauthUser() {
        return $this->belongsTo('App\AdminUser', 'author_id');
    }

    // get category relation with podcast and meta
    public function categories() {
        return $this->belongsToMany('App\PodcastMetaData', 'podcast_metas', 'podcast_id', 'meta_id')->where('meta_type', 'podcast_category');
    }

    // get tag relation with podcast and meta
    public function tags() {
        return $this->belongsToMany('App\PodcastMetaData', 'podcast_metas', 'podcast_id', 'meta_id')->where('meta_type', 'podcast_tag');
    }

    // get blog by meta tags and category

    public static function getPodcastByMeta($type, $meta_value) {

        $query = self::orderBy('id', 'desc')
            ->join('podcast_metas', 'podcast_metas.podcast_id', '=', 'podcasts.id')
            ->join('podcast_meta_data', 'podcast_meta_data.id', '=', 'podcast_metas.meta_id')
            ->select('podcasts.*')
            ->where('podcast_meta_data.slug', $meta_value)
            ->where('podcast_meta_data.meta_type', $type);
        $query = $query->paginate(12);
        return $query;
    }

    // get podcats by category
    public static function getPodcatsDetailByCategory($type, $meta_value, $id = null) {
        $query = self::orderBy('id', 'desc')
            ->join('podcast_metas', 'podcast_metas.podcast_id', '=', 'podcasts.id')
            ->join('podcast_meta_data', 'podcast_meta_data.id', '=', 'podcast_metas.meta_id')
            ->select('podcasts.*')
            ->where('podcast_meta_data.slug', $meta_value)
            ->whereNotIn('podcasts.id', [$id])
            ->where('podcast_meta_data.meta_type', $type)->limit(4)->get();
        return $query;
    }

    // get blog by meta tags and category
    public static function getPodcastsByAuthor($type, $meta_value) {

        $query = self::orderBy('id', 'desc')
            ->join('admin_users', 'admin_users.id', '=', 'podcasts.author_id')
            ->select('podcasts.*')
            ->where('admin_users.name', $meta_value)
            ->orWhere('admin_users.name', str_replace("-", " ", $meta_value));
        $query = $query->paginate(12);
        return $query;
    }

    public function metas() {
        return $this->hasMany('App\PodcastMeta','podcast_id','id');
    }
    public static function getNextPrevLink($podcast_id){

        $podcast_id_list = self::select('id','slug')->orderBy('id', 'desc')->get('slug','id')->toArray();
        if(!isset($podcast_id_list) && count($podcast_id_list) == 0) {
            return [];
        }
        $arr = array_filter($podcast_id_list, function($ar) use($podcast_id) {
           return ($ar['id'] == $podcast_id);
           //return ($ar['name'] == 'cat 1' AND $ar['id'] == '3');// you can add multiple conditions
        });

        $index = key($arr);

        if($index !== FALSE)
        {
            if(isset($podcast_id_list[$index + 1] ) ){
                 $next = $podcast_id_list[$index + 1];
            }else{
                 $next = $podcast_id_list[0];
            }
            if(isset($podcast_id_list[$index - 1])){
                $previous = $podcast_id_list[$index - 1];
            }else{
                $previous = $podcast_id_list[count($podcast_id_list)-1];
            }

        }
         return array(
            'previous'=>$previous,
            'next'=> $next
            );

    }

    public function getAltTextAttribute($value) {
        if (!$value) {
            return $this->title;
        }

        return $value;
    }
}
