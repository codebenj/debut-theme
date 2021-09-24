<?php

namespace App\Http\Controllers;

use App\AdminUser;
use App\Blog;
use App\Meta;
use App\PodcastMeta;
use App\PodcastMetaData;
use App\Podcasts;
use App\User;
use App\YoutubeMeta;
use App\YoutubeMetaData;
use App\YoutubeVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use View;

class VideoController extends Controller
{
    public function __construct() {
        $this->middleware('auth:admin', ['except' => ['landingVideos', 'videoDetail', 'searchVideos', 'videosBy']]);
        $nbShops = number_format(((int) User::where('password', '!=', '')->count()) + 43847);
        View::share(['nbShops' => $nbShops]);
    }

    //landing videos
    public function landingVideos(Request $request){
        if ($request->ajax()) {
            $podcasts = YoutubeVideos::getVideosOrderBY($request);
            return response()->json($podcasts);
        } else {
            $videos = YoutubeVideos::getVideosOrderBY($request);
            $all_tags_and_cat = YoutubeMetaData::get_all_videos_meta_in_array();
            return view('landing.videos', [
                'videos' => $videos,
                'page_title' => 'Videos',
                'all_tags_and_cat' => $all_tags_and_cat,
                'seo_url' => "video",
                'page_subtitle' => 'The Premiere Debutify Videos For Entrepreneurs, Dropshippers And Business In The Online World.'
            ]);
        }
    }

    // search videos on landing page
    public function searchVideos(Request $request) {
        $term = $request->all();
        $search_data = YoutubeVideos::query();

        if (isset($term['s']) && !empty($term['s'])) {
            $search_data->where('youtube_videos.title', 'like', '%' . $term['s'] . '%');
            $search_data->orWhere('youtube_videos.description', 'like', '%' . $term['s'] . '%');
        }
        if (isset($term['search_title']) && $term['search_title'] != null) {
            $search_data->where('youtube_videos.title', 'like', '%' . $term['search_title'] . '%');
            $search_data->orWhere('youtube_videos.description', 'like', '%' . $term['search_title'] . '%');
            $term_search = $term['search_title'];
        }
        if (isset($term['search_by_category']) && $term['search_by_category'] != null) {
            $search_data->whereHas('metas', function ($query) use($term) {
                $query->where('meta_id', '=', $term['search_by_category']);
            });
        }
        if (isset($term['search_by_tag']) && $term['search_by_tag'] != null) {
            $search_data->whereHas('metas', function ($query) use($term) {
                $query->where('meta_id', '=', $term['search_by_tag']);
            });
        }
        $search_data = $search_data->orderBy('id', 'DESC')
            ->groupBy('youtube_videos.id')
            ->paginate(8);

        $term_search = "";
        if (isset($term['search_title']) && $term['search_title'] != null) {
            $term_search = $term['search_title'];
        }
        if ($request->get('s') != null) {
            // $term = $request->get('s');
            $term_search = $term['s'];
        }
        $all_tags_and_cat = YoutubeMetaData::get_all_videos_meta_in_array();

        if ($request->ajax()) {
			$html = View::make('landing.videos-result',['videos' => $search_data]);
			$response = $html->render();

			return response()->json([
				'status' => 'success',
				'html' => $response
			]);
		}

        return view('landing.videos', ['videos' => $search_data, 'all_tags_and_cat' => $all_tags_and_cat, 'page_title' => 'Search Results', 'result_count' => count($search_data), 'term_search_value' => $term_search, 'seo_title' => 'You searched for ' . $term_search . ' | Debutify', 'search_field_value' => $term]);
    }

    // single video detail page in landing
    public function videoDetail(Request $request, $slug) {
        $video_detail = YoutubeVideos::getVideoDetailBySlug($slug);
        if (!$video_detail) {
            return redirect()->route('landing_videos');
        }
        $seo_description = $video_detail->meta_description;
        $seo_title = $video_detail->title;
        $seo_feature_image = $video_detail->thumbnail;
        $seo_url = $slug;

        $description = html_entity_decode(htmlspecialchars_decode(strip_tags($video_detail->description), ENT_QUOTES));
        if (strlen($description) > 250 && preg_match('/\s/', $description)) {
            $pos = strpos($description, ' ', 250);
            $og_description = substr($description, 0, $pos);
        } else {
            $og_description = $description;
        }

        $latest_blog = Blog::orderBy('id', 'desc')->select('slug', 'title', 'feature_image')
            ->limit(1)->first(); // get blog

        $all_tags_and_cat = YoutubeMetaData::get_all_videos_meta_in_array();
        $latest_video_same_cat = [];
        if ($video_detail->id && isset($video_detail->categories[0]) && !empty($video_detail->categories[0])) {
            $latest_video_same_cat = YoutubeVideos::getVideosDetailByCategory('video_category', $video_detail->categories[0]['slug'], $video_detail->id);
        }
        if (isset($video_detail->id) && !empty($video_detail->id)) {
            $video_prev_next = YoutubeVideos::getNextPrevLink($video_detail->id);
        }

        list($width, $height) = ['', ''];
        if (isset($video_detail->thumbnail) && $video_detail->thumbnail != '') {
            list($width, $height) = @getimagesize($video_detail->thumbnail);
        }
        $author = '';
        $author_image = '';
        if(isset($video_detail->currentauthUser['name'])){
            $author = $video_detail->currentauthUser['name'];
        }
        if(isset($video_detail->currentauthUser['profile_image'])){
            $author_image = $video_detail->currentauthUser['profile_image'];
        }

        $schema_data = array(
            'slug' => $video_detail->slug,
            'created_at' => date(DATE_ISO8601, strtotime($video_detail->created_at)),
            'updated_at' => date(DATE_ISO8601, strtotime($video_detail->created_at)),
            'width' => $width,
            'height' => $height,
            'author' => str_replace(" ", "-", $author),
            'author_name' => $author,
            'author_image' => $author_image,
            'base_url' => Route('landing_videos'),
            'description' => 'YOUTUBE VIDEO',
        );

        return view('landing.single-video', [
            'video' => $video_detail,
            'latest_blog' => $latest_blog,
            'seo_description' => $seo_description,
            'og_description' => $og_description,
            'seo_description' => $seo_description,
            'seo_feature_image' => $seo_feature_image,
            'seo_title' => $seo_title,
            'all_tags_and_cat' => $all_tags_and_cat,
            'latest_video_same_cat' => $latest_video_same_cat,
            'latest_blog' => $latest_blog,
            'schema_data' => $schema_data,
            'seo_url' => $seo_url,
            'video_prev_next'=>$video_prev_next ?? ''
        ]);
    }

    public function videosBy(Request $request, $slug) {

        if ($request->is('video/author/*')) {
            $search_by = 'video_author';
            $page_title = "Author";
            $video = YoutubeVideos::getVideosByAuthor($search_by, $slug);
            $tag_category_name['meta_name'] = ucwords(str_replace("-", " ", $slug));
            $meta_name = "Author " . $tag_category_name['meta_name'] . " | Debutify Videos";
        } elseif ($request->is('video/category/*')) {
            $search_by = 'video_category';
            $page_title = "Category";
            $video = YoutubeVideos::getVideoByMeta($search_by, $slug);
            $tag_category_name = YoutubeMetaData::get_cat_tag_name_by_slug($slug);
            $meta_name = "Category " . ucwords(optional($tag_category_name)->meta_name) . " | Debutify Videos";
        } else {
            $search_by = 'video_tag';
            $page_title = "Tag";
            $video = YoutubeVideos::getVideoByMeta($search_by, $slug);
            $tag_category_name = YoutubeMetaData::get_cat_tag_name_by_slug($slug);
            $meta_name = "Tag " . ucwords(optional($tag_category_name)->meta_name) . " | Debutify Videos";
        }
        $all_tags_and_cat = YoutubeMetaData::get_all_videos_meta_in_array();

        return view('landing.videos', ['videos' => $video, 'seo_title' => $meta_name, 'all_tags_and_cat' => $all_tags_and_cat, 'page_title' => $page_title, 'tag_category_name' => $tag_category_name]);

    }

    // delete video
    public function deleteVideo(Request $request, $id) {
            $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }
        $video = YoutubeVideos::find($id);
        if ($video) {
            $video->delete();
        }
        $request->session()->flash('status', 'Video deleted successfully');
        return redirect()->route('videos');
    }

    //  admin section show video list
    public function videos(Request $request) {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }
        $videos = YoutubeVideos::orderBy('id', 'desc')->get();
        return view('admin.videos', ['videos' => $videos]);
    }


    // ajax video search (admin)
    public function ajaxSearchVideos(Request $request){
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }
        $videos = YoutubeVideos::where(function ($query) use($request) {
            if($request->query('query') != ''){
                $query->where('title', 'like', '%' . $request->query('query') . '%')
                ->orWhere('meta_description', 'like', '%'.$request->query('query').'%')
                ->orWhere('description', 'like', '%'.$request->query('query').'%')
                ->orWhere('transcript', 'like', '%'.$request->query('query').'%');
            }
        })->orderBy('id', 'desc')
            ->paginate(20);

        $html = View::make('admin.video_table',['videos' => $videos]);

        $response = $html->render();
        return response()->json([
            'status' => 'success',
            'html' => $response
        ]);
    }

    //  admin section add video form
    public function addVideo(Request $request) {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }
        $author_detail = AdminUser::select('id', 'name')->get();
        return view('admin.addvideo', ['author_detail' => $author_detail]);
    }

    //  admin section add new video form action
    public function newVideo(Request $request) {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }
        $get_data = $request->all();
        $video_slug = Str::slug($get_data['title'], '-');
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:youtube_videos,title',
            'description' => 'required',
            'slug' => 'unique:youtube_videos,slug,' . $video_slug,
            'video_id' => 'required',
            'transcript' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)->withInput();
        }

        $thumbnail = '';
        $link = '';
        if($request->video_id){
            $thumbnail = 'https://img.youtube.com/vi/'.$request->video_id.'/maxresdefault.jpg';
            $link = 'https://www.youtube.com/watch?v='.$request->video_id;
        }
        $video = new YoutubeVideos();
        $video->thumbnail = $thumbnail;
        $video->title = $request->title;
        $video->description = $request->description;
        $video->transcript = $request->transcript;
        $video->slug = $video_slug;
        $video->status = $request->status;
        $video->link = $link;
        $video->video_id = $request->video_id;
        $video->meta_description = $request->meta_description;
        $video->publish_date = $request->publish_date;
        $video->watching_time = $request->watching_time;
        $video->author_id = $request->video_author;
        $video->save();
        self::saveVideoMetas($video->id, $request);

        $request->session()->flash('status', 'Video added successfully');
        return redirect()->route('videos', '');
    }

    // store video meta data
    public static function saveVideoMetas($video_id, $request){
        if (isset($video_id) && !empty($video_id)) {
            $metatag = YoutubeMeta::where(['video_id' => $video_id])->delete();

            if (isset($request->video_tags) && !empty($request->video_tags)) {
                $tagArray = $request->video_tags;
                YoutubeMeta::where('video_id', '=', $video_id)->delete();
                foreach ($tagArray as $key => $value) {
                    $metatags = YoutubeMetaData::updateOrCreate(['meta_name' => $value, 'meta_type' => 'video_tag']);
                    if ($metatags->id) {
                        $metatag = YoutubeMeta::updateOrCreate(['video_id' => $video_id, 'meta_id' => $metatags->id]);
                    }
                }
            }
            if (isset($request->video_categories) && !empty($request->video_categories)) {
                $categoryArray = $request->video_categories;
                foreach ($categoryArray as $key => $value) {
                    $metacategory = YoutubeMetaData::updateOrCreate(['meta_name' => $value, 'meta_type' => 'video_category']);
                    if ($metacategory->id) {
                        $metacategories = YoutubeMeta::updateOrCreate(['video_id' => $video_id, 'meta_id' => $metacategory->id]);
                    }
                }
            }
        }
    }

    // get all video tag and category
    public function get_all_video_meta(Request $request) {
        $all_data = YoutubeMetaData::where(function ($query) use ($request) {
            if ($request->query('query') != '') {
                $query->where('meta_name', 'like', '%' . $request->query('query') . '%');
                $query->where('meta_type', 'like', '%' . $request->query('type') . '%');
            }
        })
            ->orderBy('id', 'desc')
            ->get();
        $data = [];
        foreach ($all_data as $key => $value) {
            if ($request->query('type') == 'video_category') {
                $data[] = ['text' => $value->meta_name, 'value' => $value->meta_name];
            } else {
                $data[] = ['text' => $value->meta_name, 'value' => $value->meta_name];
            }
        }
        return response()
            ->json($data);

    }

    // show video (edit view)
    public function showVideo(Request $request, $id) {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }

        $video = YoutubeVideos::getVideoByID($id);
        $author_detail = AdminUser::select('id', 'name')->get();
        $meta_data = YoutubeVideos::get_tag_and_category_meta($id);
        $meta_value = [];
        $videotTags = [];
        $videocategory = [];
        foreach ($meta_data as $key => $value) {
            $meta_value[$value->meta_type][] = $value->meta_name;
        }
        if (isset($meta_value['video_tag'])) {
            $videotTags = $meta_value['video_tag'];
        }
        if (isset($meta_value['video_category'])) {
            $videocategory = $meta_value['video_category'];
        }
        return view('admin.edit_video', ['video' => $video, 'author_detail' => $author_detail, 'video_tags' => $videotTags, 'video_categories' => $videocategory]);
    }

    // update video
    public static function editVideo(Request $request, $id) {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('youtube videos', $roles)) {
                echo "You don't have permission to youtube videos.";
                die;
            }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'video_id' => 'required',
            'description' => 'required',
            'transcript' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $video = YoutubeVideos::find($id);
        if ($video) {
            $slug = Str::slug($request->title, '-');
            $request->request->add(['slug' => $slug]);
            $video = YoutubeVideos::updateVideo($request, $id);
            self::saveVideoMetas($id, $request);
        }
        $request->session()->flash('status', 'Video updated successfully');
        return redirect()->route('videos');
    }

}
