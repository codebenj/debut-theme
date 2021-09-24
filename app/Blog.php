<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;



class Blog extends Model
{

    //  public static function metas()
    // {
    //     // return  $this->belongsToMany('App\Meta', 'blog_metas', 'blog_id', 'meta_id');
    //     return $this->belongsToMany('App\Meta');
    // }
    // //
    public static function boot() {

        parent::boot();
        // On create
        self::creating(function ($model) {
            if (auth()->check()) {

                // if(empty($model->blog_slug)){
                //     $model->slug = Str::slug($model->title, '-');
                // }else{
                //     $model->slug = Str::slug($model->blog_slug, '-');
                // }
            }
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // fillable column 
    protected $fillable = [
        'title',
        'description',
        'meta_description',
        'feature_image',
        'slug',
        'author_id',
        'blog_publish_date',
        'alt_text',
        'status',
        'auto_publish_at',
        'auto_publish_time',
        'most_popular',
        'picked_by_editors'
    ];
    // fillable column 


    // get blog all 
    public static function getBlogsOrderBY($request) {
        if ($request->has('search')) {
            $query = self::select('title', 'feature_image', 'slug')
                        ->where('status', 1)
                        ->where('title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            $query = $query->limit(5)->get();
        } else {
            $query = self::orderBy('blog_publish_date', 'desc')->where('status', 1);
            $query = $query->paginate(12);
        }
        return $query;
    }
    // get blog all 


    // add blog function call in controller 
    public static function addBlog($request) {
        if(!empty($request->blog_slug)){
            $blog_slug = Str::slug($request->blog_slug, '-');
        }else{
            $blog_slug = Str::slug($request->title, '-');
        }

        $blog = self::updateOrCreate([
            'title' => $request->title,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'feature_image' => $request->image_path,
            'slug' => $blog_slug,
            'blog_publish_date' => $request->blog_publish_date,
            'author_id' => $request->blog_author,
            'alt_text' => $request->alt_text,
            'status' => $request->status,
            'auto_publish_at' => $request->auto_publish_at,
            'auto_publish_time' => $request->auto_publish_time ? Carbon::parse($request->auto_publish_time)->toTimeString() : null,
            'most_popular' => $request->has('most_popular'),
            'picked_by_editors' => $request->has('picked_by_editors')
        ]);
        return $blog;
    }
    // add blog function call in controller 

    

    // get blog by single id 

    public static function getBlogByID($id) {
        return self::where('id', $id)->first();
    }
    // get blog by single id 



    // get tags and category in mix

    public static function get_tag_and_category_meta($id){
        $deals = DB::table('blog_metas')
        ->join('metas','metas.id', '=', 'blog_metas.meta_id')
        ->select('metas.meta_name','metas.meta_type')
        ->where('blog_metas.blog_id',$id)
        ->get();
        return $deals;
        
    }
    //get tags and category in mix 

    // get tag relation with blog and meta 
    public function tags() {
        return $this->belongsToMany('App\Meta', 'blog_metas','blog_id', 'meta_id')->where('meta_type','blog_tag');
    }
    // get tag relation with blog and meta 


    // get category relation with blog and meta 
    public function categories() {
        return $this->belongsToMany('App\Meta', 'blog_metas','blog_id', 'meta_id')->where('meta_type','blog_category');
    }
    // get category relation with blog and meta 


    // relation with blog auth user
    public function currentauthUser() {
        return $this->belongsTo('App\AdminUser', 'author_id');
    }
    //relation with blog auth user 


                // do not delete this comment function
                    // get tag and category by id for listing

                    // public static function get_tag_category_listing($blogs){
                    //         $newarray = [];
                    //         foreach ($blogs as $key => $blog) {
                    //             $meta_data = self::get_tag_and_category_meta($blog['id']);
                    //             $meta_value = [];
                    //             $blogTags = "";
                    //             $categoryTags = "";
                    //             foreach ($meta_data as $key => $meta_val) {
                    //                 $meta_value[$meta_val->meta_type][] = $meta_val->meta_name;
                    //             }
                    //             if(isset($meta_value['blog_tag'])){
                    //                 $blogTags = implode(',', $meta_value['blog_tag']);
                    //             }
                    //             if(isset($meta_value['blog_category'])){
                    //                 $categoryTags = implode(',', $meta_value['blog_category']);
                    //             }
                    //             $meta_val = $blog;
                    //             $meta_val->blog_tags = $meta_value['blog_tag'];
                    //             $meta_val->blog_category = $meta_value['blog_category'];
                    //             $newarray[] = $meta_val;
                    //                     # code...
                    //         }

                    //         return $newarray;
                    // }
                // do not delete this comment function



    // update blog function from admin 

    public static function updateBlog($request) {
        if(!empty($request->blog_slug)){
            $blog_slug = Str::slug($request->blog_slug, '-');
        }else{
            $blog_slug = Str::slug($request->title, '-');
        }
                        // $blog_custom_date = date("M d Y");
                        // if(!empty($request->blog_publish_date)){
                        //     $timestamp = strtotime($request->blog_publish_date); 
                        //     $blog_custom_date=  date(' M d Y', $timestamp);
                        // }

        $podcast = self::where(['id' => $request->blog_id])->update([
            'title' => $request->title,
            'description' => $request->description,
            'meta_description' => $request->meta_description,
            'feature_image' => $request->image_path,
            'slug' => $blog_slug,
            'blog_publish_date' => $request->blog_publish_date,
            'author_id' => $request->blog_author,
            'alt_text' => $request->alt_text,
            'status' => $request->status,
            'auto_publish_at' => $request->auto_publish_at,
            'auto_publish_time' => $request->auto_publish_time ? Carbon::parse($request->auto_publish_time)->toTimeString() : null,
            'most_popular' => $request->has('most_popular'),
            'picked_by_editors' => $request->has('picked_by_editors'),
        ]);
        return $podcast;
    }
    // update blog function from admin 


    // get blog by unique slug 
    public static function getBlogDetailBySlug($slug, $preview = false) {
        if ($preview) {
            return self::where('slug', $slug)->first();
        }

        return self::where('slug', $slug)->where('status', 1)->first();
    }
    // get blog by unique slug 


    // get blog by category 
    public static function getBlogDetailByCategory($type, $meta_value, $id = null) {
        if($id !== null){
        $query = self::orderBy('id', 'desc')
                ->join('blog_metas','blog_metas.blog_id', '=', 'blogs.id')
                ->join('metas','metas.id', '=', 'blog_metas.meta_id')
                ->select('blogs.*')
                ->where('metas.slug',$meta_value)
                ->whereNotIn('blogs.id',[$id])
                ->where('metas.meta_type',$type)->limit(4)->get();
                return $query;
        }else{
            $query = self::orderBy('id', 'desc')
                ->join('blog_metas','blog_metas.blog_id', '=', 'blogs.id')
                ->join('metas','metas.id', '=', 'blog_metas.meta_id')
                ->select('blogs.*')
                ->where('metas.slug',$meta_value)
                ->where('metas.meta_type',$type)->limit(4)->get();
                return $query;
        }
        
    }
    // get blog by category 



    // get blog by meta tags and category 

    public static function getBlogsByMeta($type, $meta_value) {

        $query = self::orderBy('id', 'desc')
        ->join('blog_metas','blog_metas.blog_id', '=', 'blogs.id')
        ->join('metas','metas.id', '=', 'blog_metas.meta_id')
        ->select('blogs.*')
        ->where('metas.slug',$meta_value)
        ->where('metas.meta_type',$type);
        $query = $query->paginate(12);
        return $query;
    }
    // get blog by meta tags and category 
    
    // get blog by meta tags and category 

    public static function getBlogsByAuthor($type, $meta_value) {

        $query = self::orderBy('id', 'desc')
        ->join('admin_users','admin_users.id', '=', 'blogs.author_id')
        ->select('blogs.*')
        ->where('admin_users.name',$meta_value)
        ->orWhere('admin_users.name',str_replace("-"," ",$meta_value));
        $query = $query->paginate(12);
        return $query;
    }
    // get blog by meta tags and category 

    public static function getNextPrevLink($blog_id){
       
        $blog_id_list = self::select('id','slug')->orderBy('id', 'desc')->get('slug','id')->toArray();
        if(!isset($blog_id_list) && count($blog_id_list) == 0) {
            return [];
        }
        $arr = array_filter($blog_id_list, function($ar) use($blog_id) {
           return ($ar['id'] == $blog_id);
        });
        $index = key($arr);
        if($index !== FALSE)
        {
            if(isset($blog_id_list[$index + 1] ) ){
                 $next = $blog_id_list[$index + 1];
            }else{
                 $next = $blog_id_list[0];
            }
            if(isset($blog_id_list[$index - 1])){
                $previous = $blog_id_list[$index - 1];
            }else{
                $previous = $blog_id_list[count($blog_id_list)-1];
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
