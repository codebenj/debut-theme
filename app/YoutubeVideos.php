<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class YoutubeVideos extends Model
{
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
        'link',
        'thumbnail',
        'slug',
        'transcript',
        'video_id',
        'status',
        'watching_time',
        'publish_date',
    ];

//    public static function getVideos($request){
//        $query = self::orderBy('id', 'desc');
//        $query = $query->paginate(10);
//    }

    // relation with blog auth user
    public function currentauthUser() {
        return $this->belongsTo('App\AdminUser', 'author_id');
    }

    // get category relation with video and meta
    public function categories() {
        return $this->belongsToMany('App\YoutubeMetaData', 'youtube_metas', 'video_id', 'meta_id')->where('meta_type', 'video_category');
    }

    // get tag relation with video and meta
    public function tags() {
        return $this->belongsToMany('App\YoutubeMetaData', 'youtube_metas', 'video_id', 'meta_id')->where('meta_type', 'video_tag');
    }

    public function metas() {
        return $this->hasMany('App\YoutubeMeta','video_id','id');
    }

    //get single video
    public static function getVideoByID($id) {
        return self::where('id', $id)->first();
    }

    public static function get_tag_and_category_meta($id) {
        $all_data = DB::table('youtube_metas')
            ->join('youtube_meta_data', 'youtube_meta_data.id', '=', 'youtube_metas.meta_id')
            ->select('youtube_meta_data.meta_name', 'youtube_meta_data.meta_type')
            ->where('youtube_metas.video_id', $id)
            ->get();
        return $all_data;
    }

    // get videos by category
    public static function getVideosDetailByCategory($type, $meta_value, $id = null) {
        $query = self::orderBy('id', 'desc')
            ->join('youtube_metas', 'youtube_metas.video_id', '=', 'youtube_videos.id')
            ->join('youtube_meta_data', 'youtube_meta_data.id', '=', 'youtube_metas.meta_id')
            ->select('youtube_videos.*')
            ->where('youtube_meta_data.slug', $meta_value)
            ->whereNotIn('youtube_videos.id', [$id])
            ->where('youtube_meta_data.meta_type', $type)->limit(4)->get();
        return $query;
    }

    // get blog by meta tags and category

    public static function getVideoByMeta($type, $meta_value) {
        $query = self::orderBy('id', 'desc')
            ->join('youtube_metas', 'youtube_metas.video_id', '=', 'youtube_videos.id')
            ->join('youtube_meta_data', 'youtube_meta_data.id', '=', 'youtube_metas.meta_id')
            ->select('youtube_videos.*')
            ->where('youtube_meta_data.slug', $meta_value)
            ->where('youtube_meta_data.meta_type', $type);
        $query = $query->paginate(12);
        return $query;
    }

    // get video by meta tags and category
    public static function getVideosByAuthor($type, $meta_value) {

        $query = self::orderBy('id', 'desc')
            ->join('admin_users', 'admin_users.id', '=', 'youtube_videos.author_id')
            ->select('youtube_videos.*')
            ->where('admin_users.name', $meta_value)
            ->orWhere('admin_users.name', str_replace("-", " ", $meta_value));
        $query = $query->paginate(12);
        return $query;
    }


    public static function getVideosOrderBY($request) {
        if ($request->has('search')) {
            $query = self::select('title', 'thumbnail', 'slug')->where('title', 'LIKE', '%' . $request->search . '%');
            $query = $query->limit(5)->get();
        } else {
            $query = self::orderBy('publish_date', 'desc');
            $query = $query->paginate(12);
        }
        return $query;
    }

    public static function getVideosSearch($term)
    {
        $query = self::where('title', 'like', '%'. $term .'%')->orderBy('publish_date', 'desc');
        $query = $query->paginate(12);
        return $query;
    }

    //update video
    public static function updateVideo($request, $id) {
        $link = $thumbnail = $video_slug = '';
        //update link and thumbnail
        if($request->video_id){
            $link = 'https://www.youtube.com/watch?v='.$request->video_id;
            $thumbnail = 'https://img.youtube.com/vi/'.$request->video_id.'/maxresdefault.jpg';
        }

        //update query
        $video = self::where('id', $id)->update([
            'title' => $request->title,
            'description' => $request->description,
            'video_id' => $request->video_id,
            'link' => $link,
            'slug' => $request->slug,
            'thumbnail' => $thumbnail,
            'transcript' => $request->transcript,
            'watching_time' => $request->watching_time,
            'status' => $request->status,
            'author_id' => $request->video_author,
            'publish_date' => $request->publish_date,
            'meta_description' => $request->meta_description
        ]);
        return $video;
    }

    // get video by unique slug
    public static function getVideoDetailBySlug($slug) {
        return self::where('slug', $slug)->where('status', 1)->first();
    }

    public static function  getNextPrevLink($video_id){

        $video_id_list = self::select('id','slug')->orderBy('id', 'desc')->get('slug','id')->toArray();
        if(!isset($video_id_list) && count($video_id_list) == 0) {
            return [];
        }
        $arr = array_filter($video_id_list, function($ar) use($video_id) {
            return ($ar['id'] == $video_id);
            //return ($ar['name'] == 'cat 1' AND $ar['id'] == '3');// you can add multiple conditions
        });

        $index = key($arr);

        if($index !== FALSE)
        {
            if(isset($video_id_list[$index + 1] ) ){
                $next = $video_id_list[$index + 1];
            }else{
                $next = $video_id_list[0];
            }
            if(isset($video_id_list[$index - 1])){
                $previous = $video_id_list[$index - 1];
            }else{
                $previous = $video_id_list[count($video_id_list)-1];
            }

        }
        return array(
            'previous'=>$previous,
            'next'=> $next
        );

    }
}
