<?php

namespace App\Http\Controllers;

use App\Podcasts;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Redirect;
use View;
use File;
use App\AdminUser;
use App\Blog;
use App\PodcastMeta;
use App\PodcastMetaData;



class PodcastController extends Controller {
    public function __construct() {
        $this->middleware('auth:admin', ['except' => ['podcast', 'podcastdetail', 'search_podcasts','podcasts_by']]);
        $nbShops = number_format(((int) User::where('password', '!=', '')->count()) + 43847);
        View::share([
            'nbShops' => $nbShops,
        ]);

    } // podcast view
    public function podcast(Request $request) {

        if ($request->ajax()) {
            $podcasts = Podcasts::getPodcastsOrderBY($request);
            return response()->json($podcasts);
        } else {
            $podcasts = Podcasts::getPodcastsOrderBY($request);
            $all_tags_and_cat = PodcastMetaData::get_all_podcast_meta_in_array();
            $data = ['podcasts' => $podcasts,
                     'page_title' => 'Ecomonics - A Debutify Podcast',
                     'all_tags_and_cat' => $all_tags_and_cat,
                     'seo_title' => "Ecommerce, Shopify & Dropshipping Podcasts | Ecomonics | Debutify",
                     'seo_description' => 'Ecomonics is a series of Debutify’s Podcasts that brings valuable knowledge to you shared by various successful eCommerce and Dropshipping experts.',
                     'seo_url' => "podcast",
                     'page_subtitle' => 'The Premiere Debutify Podcast For Entrepreneurs, Dropshippers And Business In The Online World.',
                 ];
            return view('landing.podcast', $data);
        }
    }

    public function podcastdetail(Request $request, $slug) {
        $podcast_detail = Podcasts::getPodcastDetailBySlug($slug);
        if (!$podcast_detail) {
            return redirect()->route('podcast');
        }

        $podcast_prev_next = '';
        $seo_description = $podcast_detail->meta_description;
        $seo_title = $podcast_detail->title;
        $seo_feature_image = $podcast_detail->feature_image;
        $seo_url = $slug;

        $description = html_entity_decode(htmlspecialchars_decode(strip_tags($podcast_detail->description), ENT_QUOTES));
        if (strlen($description) > 250 && preg_match('/\s/', $description)) {
            $pos = strpos($description, ' ', 250);
            $og_description = substr($description, 0, $pos);

        } else {
            $og_description = $description;
        }

        $latest_blog = Blog::orderBy('id', 'desc')->select('slug', 'title', 'feature_image')
            ->limit(1)->first(); // get blog

        $all_tags_and_cat = PodcastMetaData::get_all_podcast_meta_in_array();
        $latest_podcast_same_cat = [];
        if ($podcast_detail->id && isset($podcast_detail->categories[0]) && !empty($podcast_detail->categories[0])) {
            $latest_podcast_same_cat = Podcasts::getPodcatsDetailByCategory('podcast_category', $podcast_detail->categories[0]['slug'], $podcast_detail->id);
        }
        if (isset($podcast_detail->id) && !empty($podcast_detail->id)) {
            $podcast_prev_next = Podcasts::getNextPrevLink($podcast_detail->id);
        }
        // echo "<pre>";
        // print_r($podcast_prev_next);
        // die;
        list($width, $height) = ['', ''];
        if (isset($podcast_detail->feature_image) && $podcast_detail->feature_image != '') {
            list($width, $height) = @getimagesize($podcast_detail->feature_image);
        }
        $author = '';
        $author_image = '';
        if(isset($podcast_detail->currentauthUser['name'])){
            $author = $podcast_detail->currentauthUser['name'];
        }
        if(isset($podcast_detail->currentauthUser['profile_image'])){
            $author_image = $podcast_detail->currentauthUser['profile_image'];
        }

        $schema_data = array(
            'slug' => $podcast_detail->slug,
            'created_at' => date(DATE_ISO8601, strtotime($podcast_detail->podcast_publish_date)),
            'updated_at' => date(DATE_ISO8601, strtotime($podcast_detail->podcast_publish_date)),
            'width' => $width,
            'height' => $height,
            'author' => str_replace(" ", "-", $author),
            'author_name' => $author,
            'author_image' => $author_image,
            'base_url' => Route('podcast'),
            'description' => 'PODCAST',
        );
        $view_data = array(
            'podcast_detail' => $podcast_detail,
            'seo_description' => $seo_description,
            'og_description' => $og_description,
            'seo_description' => $seo_description,
            'seo_feature_image' => $seo_feature_image,
            'seo_title' => $seo_title,
            'all_tags_and_cat' => $all_tags_and_cat,
            'latest_blog' => $latest_blog,
            'latest_podcast_same_cat' => $latest_podcast_same_cat,
            'schema_data' => $schema_data,
            'seo_url' => $seo_url,
            'podcast_prev_next'=>$podcast_prev_next
        );
        return view('landing.single-podcast', $view_data);
    }

    public function podcasts(Request $request) {
        $roles = json_decode(Auth::user()->user_role, 1);
        if (!isset($roles) || empty($roles) || !in_array('podcasts', $roles)) {
            echo "You don't have permission to podcasts.";
            die;
        }
        $podcasts = Podcasts::orderBy('id', 'desc')->get();
        $newarray = [];
        foreach ($podcasts as $key => $podcast) {
            $meta_data = Podcasts::get_tag_and_category_meta($podcast['id']);
            $meta_value = [];
            $podcastTags = "";
            $categoryTags = "";
            foreach ($meta_data as $key => $meta_val) {
                $meta_value[$meta_val->meta_type][] = $meta_val->meta_name;
            }
            if (isset($meta_value['podcast_tag'])) {
                $podcastTags = implode(',', $meta_value['podcast_tag']);
            }
            if (isset($meta_value['podcast_category'])) {
                $categoryTags = implode(',', $meta_value['podcast_category']);
            }
            $meta_val = $podcast;

            $meta_val->podcast_tags = $podcastTags;
            $meta_val->podcast_category = $categoryTags;

            $newarray[] = $meta_val;
            # code...

        }
        return view('admin.podcasts', ['podcasts' => $podcasts]);
    }

    // showpodcast
    public function showpodcast(Request $request, $id) {
        $roles = json_decode(Auth::user()->user_role, 1);
        if (!isset($roles) || empty($roles) || !in_array('podcasts', $roles)) {
            echo "You don't have permission to podcasts.";
            die;
        }
        $podcast = Podcasts::getPodcastByID($id);
        $author_detail = AdminUser::select('id', 'name')->get();
        $meta_data = Podcasts::get_tag_and_category_meta($id);
        $meta_value = [];
        $podcastTags = [];
        $podcastcategory = [];
        foreach ($meta_data as $key => $value) {
            $meta_value[$value->meta_type][] = $value->meta_name;
        }
        if (isset($meta_value['podcast_tag'])) {
            $podcastTags = $meta_value['podcast_tag'];
        }
        if (isset($meta_value['podcast_category'])) {
            $podcastcategory = $meta_value['podcast_category'];
        }
        return view('admin.editpodcast', ['podcast' => $podcast, 'author_detail' => $author_detail, 'podcast_tags' => $podcastTags, 'podcast_category' => $podcastcategory]);
    }

    public function addpodcast(Request $request) {
        $roles = json_decode(Auth::user()->user_role, 1);
        if (!isset($roles) || empty($roles) || !in_array('podcasts', $roles)) {
            echo "You don't have permission to podcasts.";
            die;
        }
        $author_detail = AdminUser::select('id', 'name')->get();
        return view('admin.addpodcast', ['author_detail' => $author_detail]);
    }

    public function newpodcast(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:podcasts,title',
            'podcast_widget' => 'required',
            'feature_image' => 'mimes:jpeg,jpg,png,gif|max:20000',
            'description' => 'required',
            'alt_text' => 'nullable',
            'guest_image_alt_text' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }
        $podcast = Podcasts::addPodcast($request);
        self::save_podcast_meta($podcast->id, $request);
        $request->session()->flash('status', 'Podcast added successfully');
        return redirect()->route('podcasts');
    }

    //save meta data update or insert
    public static function save_podcast_meta($podcast_id, $request) {
        if (isset($podcast_id) && !empty($podcast_id)) {

            $metatag = PodcastMeta::where(['podcast_id' => $podcast_id])->delete();

            if (isset($request->podcast_tags) && !empty($request->podcast_tags)) {
                $newArray = $request->podcast_tags;
                PodcastMeta::where('podcast_id', '=', $podcast_id)->delete();
                foreach ($newArray as $key => $value) {
                    $metatags = PodcastMetaData::updateOrCreate(['meta_name' => $value, 'meta_type' => 'podcast_tag']);
                    if ($metatags->id) {
                        $metatag = PodcastMeta::updateOrCreate(['podcast_id' => $podcast_id, 'meta_id' => $metatags->id]);
                    }
                }
            }

            if (isset($request->podcast_categories) && !empty($request->podcast_categories)) {
                $newArray = $request->podcast_categories;
                foreach ($newArray as $key => $value) {
                    $metacategory = PodcastMetaData::updateOrCreate(['meta_name' => $value, 'meta_type' => 'podcast_category']);
                    if ($metacategory->id) {
                        $metacategories = PodcastMeta::updateOrCreate(['podcast_id' => $podcast_id, 'meta_id' => $metacategory->id]);

                    }
                }
            }

        }

    }

    public function uploadimage(Request $request){
        if ($request->has('feature_image')) {
            $path_to_delete = str_replace(config('app.url') . '/', "", $request->get('last_used'));
            if (File::exists($path_to_delete)) {
                unlink($path_to_delete);
            }
            $file = $request->file('feature_image');
            $file = is_array($file) ? $file[0] : $file;
            $filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('podcast', $filename, 'public');
            $url = config('app.url') . '/storage/' . $path;
            return response()->json(['success'=> true, 'url'=>$url]);
        }
        return response()->json(['success'=> false, 'url'=> ""]);
    }

    public static function editpodcast(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:podcasts,title,' . $id,
            'podcast_widget' => 'required',
            'feature_image' => 'mimes:jpeg,jpg,png,gif|max:20000',
            'description' => 'required',
            'alt_text' => 'nullable',
            'guest_image_alt_text' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        $podcast = Podcasts::find($id);
        if ($podcast) {
            $url = $request->get('last_used');

            $slug = Str::slug($request->title, '-');
            $request->request->add(['image_path' => $url, 'podcast_id' => $id, 'slug' => $slug]);
            $podcast = Podcasts::updatePodcast($request);
            self::save_podcast_meta($id, $request);
        }
        $request->session()->flash('status', 'Podcast updated successfully');
        return redirect()->route('podcasts');
    }

    // deletepodcast
    public function deletepodcast(Request $request, $id) {
        $roles = json_decode(Auth::user()->user_role, 1);
        if (!isset($roles) || empty($roles) || !in_array('podcasts', $roles)) {
            echo "You don't have permission to podcasts.";
            die;
        }
        $podcast = Podcasts::find($id);
        if ($podcast) {
             $path_to_delete = str_replace(config('app.url') . '/', "", $podcast->feature_image);
              if (File::exists($path_to_delete)) {
                  unlink($path_to_delete);
              }
            $podcast->delete();
        }
        $request->session()->flash('status', 'Podcast deleted successfully');
        return redirect()->route('podcasts');
    }

    // get all podcast tag and category
    public function get_all_podcast_meta(Request $request) {
        $all_data = PodcastMetaData::where(function ($query) use ($request) {
            if ($request->query('query') != '') {
                $query->where('meta_name', 'like', '%' . $request->query('query') . '%');
                $query->where('meta_type', 'like', '%' . $request->query('type') . '%');
            }
        })
            ->orderBy('id', 'desc')
            ->get();
        $data = [];
        foreach ($all_data as $key => $value) {
            if ($request->query('type') == 'podcast_category') {
                $data[] = ['text' => $value->meta_name, 'value' => $value->meta_name];
            } else {
                $data[] = ['text' => $value->meta_name, 'value' => $value->meta_name];
            }
        }
        return response()
            ->json($data);

    }

    public function podcasts_by(Request $request, $slug) {
        if ($request->is('podcast/author/*')) {
            $search_by = 'podcast_author';
            $page_title = "Author";
            $podcast = Podcasts::getPodcastsByAuthor($search_by, $slug);
            $tag_category_name['meta_name'] = ucwords(str_replace("-", " ", $slug));
            $meta_name = "Author " . $tag_category_name['meta_name'] . " | Debutify podcast";
        } elseif ($request->is('podcast/category/*')) {
            $search_by = 'podcast_category';
            $page_title = "Category";
            $podcast = Podcasts::getPodcastByMeta($search_by, $slug);
            $tag_category_name = PodcastMetaData::get_cat_tag_name_by_slug($slug);
            $meta_name = "Category " . ucwords(optional($tag_category_name)->meta_name) . " | Debutify podcast";
        } else {
            $search_by = 'podcast_tag';
            $page_title = "Tag";
            $podcast = Podcasts::getPodcastByMeta($search_by, $slug);
            $tag_category_name = PodcastMetaData::get_cat_tag_name_by_slug($slug);
            $meta_name = "Tag " . ucwords(optional($tag_category_name)->meta_name) . " | Debutify podcast";
        }

        $all_tags_and_cat = PodcastMetaData::get_all_podcast_meta_in_array();

        return view('landing.podcast', [
            'podcasts' => $podcast,
            'seo_title' => $meta_name,
            'all_tags_and_cat' => $all_tags_and_cat,
            'page_title' => $page_title,
            'tag_category_name' => $tag_category_name
        ]);

    }
    public function search_podcasts(Request $request) {

        $term = $request->all();

        $search_data = Podcasts::query();
        if (isset($term['s']) && !empty($term['s'])) {
                $search_data->where('podcasts.title', 'like', '%' . $term['s'] . '%');
                $search_data->orWhere('podcasts.description', 'like', '%' . $term['s'] . '%');
            }
        if (isset($term['search_title']) && $term['search_title'] != null) {
                $search_data->where('podcasts.title', 'like', '%' . $term['search_title'] . '%');
                 $search_data->orWhere('podcasts.description', 'like', '%' . $term['search_title'] . '%');
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
            ->groupBy('podcasts.id')
            ->paginate(8);

        $term_search = "";
        if (isset($term['search_title']) && $term['search_title'] != null) {
            $term_search = $term['search_title'];
        }
        if ($request->get('s') != null) {
            $term_search = $term['s'];
        }

        if ($request->ajax()) {
			$html = View::make('landing.podcasts-result',['podcasts' => $search_data]);
			$response = $html->render();

			return response()->json([
				'status' => 'success',
				'html' => $response
			]);
		}

        $all_tags_and_cat = PodcastMetaData::get_all_podcast_meta_in_array();
        return view('landing.podcast', ['podcasts' => $search_data, 'all_tags_and_cat' => $all_tags_and_cat, 'page_title' => 'Search Results', 'result_count' => count($search_data), 'term_search_value' => $term_search, 'seo_title' => 'You searched for ' . $term_search . ' | Debutify', 'search_field_value' => $term]);

    }

    public function ajax_search_podcast(Request $request){
                $podcasts = Podcasts::where(function ($query) use($request) {
                if($request->query('query') != ''){
                  $query->where('title', 'like', '%' . $request->query('query') . '%')
                       ->orWhere('meta_description', 'like', '%'.$request->query('query').'%')
                       ->orWhere('description', 'like', '%'.$request->query('query').'%')
                       ->orWhere('podcast_widget', 'like', '%'.$request->query('query').'%')
                       ->orWhere('feature_image', 'like', '%'.$request->query('query').'%')
                       ->orWhere('podcast_transcript', 'like', '%'.$request->query('query').'%');
                }
              })->orderBy('id', 'desc')
              ->paginate(50);
              $newarray = [];
              if(is_array($podcasts)) {
                foreach ($podcasts as $key => $podcast) {
                    $meta_data = Podcasts::get_tag_and_category_meta($podcast['id']);
                    $meta_value = [];
                    $podcastTags = "";
                    $categoryTags = "";
                    foreach ($meta_data as $key => $meta_val) {
                        $meta_value[$meta_val->meta_type][] = $meta_val->meta_name;
                    }
                    if (isset($meta_value['podcast_tag'])) {
                        $podcastTags = implode(',', $meta_value['podcast_tag']);
                    }
                    if (isset($meta_value['podcast_category'])) {
                        $categoryTags = implode(',', $meta_value['podcast_category']);
                    }
                    $meta_val = $podcast;

                    $meta_val->podcast_tags = $podcastTags;
                    $meta_val->podcast_category = $categoryTags;

                    $newarray[] = $meta_val;
                }
            }
              $html = View::make('admin.podcast_table',['podcasts' => $newarray]);

              $response = $html->render();
              return response()->json([
                  'status' => 'success',
                  'html' => $response
              ]);
    }

}