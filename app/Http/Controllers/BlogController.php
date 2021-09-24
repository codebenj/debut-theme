<?php
namespace App\Http\Controllers;

use App\AdminUser;
use App\Blog;
use App\BlogMeta;
use App\Meta;
use App\Podcasts;
use App\User;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Redirect;
use Storage;
use URL;
use View;
use App\Rules\RecaptchaValidator;

class BlogController extends Controller {
	public function __construct() {
		$this->middleware('auth:admin', ['except' => ['blog', 'blogdetail', 'blogs_by', 'search_blogs', 'sync_subscriber_email', 'update_blog_meta', 'feed_generate', 'post_sitemap', 'category_sitemap', 'post_tag_sitemap', 'feed_sitemap_main']]);
		$nbShops = number_format(((int) User::where('password', '!=', '')->count()) + 43847);
		$this->updateStatus();
		View::share(['nbShops' => $nbShops]);
	}

	private function updateStatus() {
		$blogs = Blog::all();

        foreach ($blogs as $key => $blog) {
            $auto_publish_at = Carbon::parse($blog->auto_publish_at);
			$dateTime = Carbon::parse($blog->auto_publish_at .' '. $blog->auto_publish_time);

			// Set to active if status is draft and auto publish has date and is past
			if (!$blog->status && ($blog->auto_publish_at && $blog->auto_publish_time)) {
				if ($dateTime->isPast()) {
					$blog->auto_publish_at = null;
					$blog->auto_publish_time = null;
					$blog->status = 1;
				} else {
					$blog->status = 0;
				}
			}
			
			$blog->save();
        }
	}

	// show on landing page on front end
	public function blog(Request $request) {
		if ($request->ajax()) {
			
			$blog = Blog::getBlogsOrderBY($request);
			// return response()->json($blog);

			$html = View::make('landing.blogs-result',['blogs' => $blog]);
			$response = $html->render();

			return response()->json([
				'status' => 'success',
				'html' => $response
			]);

		} else {
			$blog = Blog::getBlogsOrderBY($request);
			$all_tags_and_cat = Meta::get_all_blog_meta_in_array();
			$most_popular_posts = Blog::where('most_popular', 1)->orderBy('created_at', 'desc')->get();
			$picked_by_editors = Blog::where('picked_by_editors', 1)->orderBy('created_at', 'desc')->get();
			$featured_collection = $most_popular_posts->zip($picked_by_editors);
			$get_all_blog_meta_categories = Meta::get_all_blog_meta_categories_sitemap();
			return view('landing.blog', ['featured_posts' => $featured_collection, 'blogs' => $blog, 'all_tags_and_cat' => $all_tags_and_cat, 'get_all_blog_meta_categories'=>$get_all_blog_meta_categories ,'page_title' => 'Blog']);
		}
	}
	// show on landing page on front end

	// get data category and tags slug
	public function blogs_by(Request $request, $slug) {

		if ($request->is('blog/author/*')) {
			$search_by = 'blog_author';
			$page_title = "Author";
			$blog = Blog::getBlogsByAuthor($search_by, $slug);
			$tag_category_name['meta_name'] = ucwords(str_replace("-", " ", $slug));
			if(isset($tag_category_name['meta_name'])){
				$meta_name = "Author " . $tag_category_name['meta_name'] . " | Debutify Blog";
			}else{
				return redirect()->route('blog');
			}
			
		} elseif ($request->is('blog/category/*')) {
			$search_by = 'blog_category';
			$page_title = "Category";
			$blog = Blog::getBlogsByMeta($search_by, $slug);
			$tag_category_name = Meta::get_cat_tag_name_by_slug($slug);
			if(isset($tag_category_name->meta_name)){
				$meta_name = "Category " . ucwords($tag_category_name->meta_name) . " | Debutify Blog";
			}else{
				return redirect()->route('blog');
			}
			
		} else {
			$search_by = 'blog_tag';
			$page_title = "Tag";
			$blog = Blog::getBlogsByMeta($search_by, $slug);
			$tag_category_name = Meta::get_cat_tag_name_by_slug($slug);
			if(isset($tag_category_name->meta_name)){
				$meta_name = "Tag " . ucwords($tag_category_name->meta_name) . " | Debutify Blog";
			}else{
				return redirect()->route('blog');
			}
		}
		$all_tags_and_cat = Meta::get_all_blog_meta_in_array();
		$get_all_blog_meta_categories = Meta::get_all_blog_meta_categories_sitemap();

		return view('landing.blog', ['blogs' => $blog, 'seo_title' => $meta_name, 'all_tags_and_cat' => $all_tags_and_cat, 'page_title' => $page_title, 'tag_category_name' => $tag_category_name,'get_all_blog_meta_categories'=>$get_all_blog_meta_categories]);

	}
	// get data category and tags slug

	// single blog detail page in frontend
	public function blogdetail(Request $request, $slug) {
		$blog = Blog::orderBy('id', 'desc')->limit(5)
			->get(); // recent blogs
		$blog_detail = Blog::getBlogDetailBySlug($slug, $request->boolean('preview'));
		if (!$blog_detail) {
			return redirect()->route('blog');
		}

		$seo_description = $blog_detail->meta_description;
		$seo_title = $blog_detail->title;
		$seo_feature_image = $blog_detail->feature_image;
		$seo_url = $slug;
		$latest_podcast = Podcasts::orderBy('id', 'desc')->select('slug', 'title', 'podcast_widget')
			->limit(1)
			->get(); // get podcast
		$all_tags_and_cat = Meta::get_all_blog_meta_in_array();
		$latest_blog_same_cat = [];
		if ($blog_detail->id && isset($blog_detail->categories[0]['slug']) && !empty($blog_detail->categories[0]['slug'])) {
			$latest_blog_same_cat = Blog::getBlogDetailByCategory('blog_category', $blog_detail->categories[0]['slug'], $blog_detail->id);
		}
		if (isset($blog_detail->id) && !empty($blog_detail->id)) {
            $blog_prev_next = Blog::getNextPrevLink($blog_detail->id);
        }
		list($width, $height) = ['', ''];
		if (isset($blog_detail->feature_image) && $blog_detail->feature_image != '') {
			list($width, $height) = @getimagesize($blog_detail->feature_image);
		}
		$author = $blog_detail->currentauthUser ? $blog_detail->currentauthUser['name'] : '';
		$schema_data = array(
			'slug' => $blog_detail->slug,
			'created_at' => date(DATE_ISO8601, strtotime($blog_detail->blog_publish_date)),
			'updated_at' => date(DATE_ISO8601, strtotime($blog_detail->blog_publish_date)),
			'width' => $width,
			'height' => $height,
			'author' => str_replace(" ", "-", $author),
			'author_name' => $author,
			'author_image' => $blog_detail->currentauthUser ? $blog_detail->currentauthUser['profile_image'] : '',
			'base_url' => Route('blog'),
            'description' => 'BLOG',
		);
		$view_data = array(
			'blog_detail' => $blog_detail,
			'seo_description' => $seo_description,
			'blogs' => $blog,
			'seo_description' => $seo_description,
			'seo_feature_image' => $seo_feature_image,
			'seo_title' => $seo_title,
			'all_tags_and_cat' => $all_tags_and_cat,
			'latest_podcast' => $latest_podcast,
			'latest_blog_same_cat' => $latest_blog_same_cat,
			'schema_data' => $schema_data,
			'seo_url' => $seo_url,
            'blog_prev_next'=>$blog_prev_next ?? '',
		);
		return view('landing.single-blog', $view_data);
	}
	// single blog detail page in frontend

	//  admin section show blog list
	public function blogs($any = null) {
		$roles = json_decode(Auth::user()->user_role, 1);
		if (!isset($roles) || empty($roles) || !in_array('blogs', $roles)) {
			echo "You don't have permission to blogs.";
			die;
		}
		if ($any == null) {
			$blogs = Blog::orderBy('id', 'desc')->get();
		} elseif ($any == 'most-popular') {
			$blogs = Blog::where('most_popular', 1)->orderBy('id', 'desc')->get();
		} elseif ($any == 'picked-by-editors') {
			$blogs = Blog::where('picked_by_editors', 1)->orderBy('id', 'desc')->get();
		} else {
			$blogs = Blog::orderBy('id', 'desc')->get();
		}
		$newarray = [];
		foreach ($blogs as $key => $blog) {
			$meta_data = Blog::get_tag_and_category_meta($blog['id']);
			$meta_value = [];
			$blogTags = "";
			$categoryTags = "";
			foreach ($meta_data as $key => $meta_val) {
				$meta_value[$meta_val->meta_type][] = $meta_val->meta_name;
			}
			if (isset($meta_value['blog_tag'])) {
				$blogTags = implode(',', $meta_value['blog_tag']);
			}
			if (isset($meta_value['blog_category'])) {
				$categoryTags = implode(',', $meta_value['blog_category']);
			}
			$meta_val = $blog;

			$meta_val->blog_tags = $blogTags;
			$meta_val->blog_category = $categoryTags;

			$newarray[] = $meta_val;
			# code...

		}

		return view('admin.blogs', ['blogs' => $newarray]);
	}
	//  admin section show blog list

	//  admin section show single blog and edit
	public function showblog(Request $request, $id) {
		$roles = json_decode(Auth::user()->user_role, 1);

		if (!isset($roles) || empty($roles) || !in_array('blogs', $roles)) {
			echo "You don't have permission to blogs.";
			die;
		}
		$blog = Blog::getBlogByID($id);
		$meta_data = Blog::get_tag_and_category_meta($id);
		// dd($deals);
		$meta_value = [];
		$blogTags = [];
		$categoryTags = [];

		foreach ($meta_data as $key => $value) {
			$meta_value[$value->meta_type][] = $value->meta_name;
		}
		if (isset($meta_value['blog_tag'])) {
			$blogTags = $meta_value['blog_tag'];
		}
		if (isset($meta_value['blog_category'])) {
			$categoryTags = $meta_value['blog_category'];
		}
		$author_detail = AdminUser::select('id', 'name')->get();
		return view('admin.editblog', ['blog' => $blog, 'blog_tag' => $blogTags, 'blog_category' => $categoryTags, 'author_detail' => $author_detail]);
	}
	//  admin section show single blog and edit

	// get all blog and category meta data
	public function get_all_blog_meta(Request $request) {
		$all_data = Meta::where(function ($query) use ($request) {
			if ($request->query('query') != '') {
				$query->where('meta_name', 'like', '%' . $request->query('query') . '%');
				$query->where('meta_type', 'like', '%' . $request->query('type') . '%');
			}
		})
			->orderBy('id', 'desc')
			->get();
		$data = [];
		foreach ($all_data as $key => $value) {
			if ($request->query('type') == 'blog_category') {
				$data[] = ['text' => $value->meta_name, 'value' => $value->meta_name];
			} else {
				$data[] = ['text' => $value->meta_name, 'value' => $value->meta_name];
			}
		}
		return response()
			->json($data);

	}
	// get all blog and category meta data

	//  admin section add blog form
	public function addblog(Request $request) {
		$roles = json_decode(Auth::user()->user_role, 1);

		if (!isset($roles) || empty($roles) || !in_array('blogs', $roles)) {
			echo "You don't have permission to blogs.";
			die;
		}
		$author_detail = AdminUser::select('id', 'name')->get();
		return view('admin.addblog', ['author_detail' => $author_detail]);
	}
	//  admin section add blog form

	//  admin section add new blog form action
	public function newblog(Request $request) {
		$get_data = $request->all();
		$blog_slug = Str::slug($get_data['blog_slug'], '-');
		$validator = Validator::make($request->all(), [
			'title' => 'required|unique:blogs,title',
			'feature_image' => 'mimes:jpeg,jpg,png,gif|max:20000',
			'description' => 'required',
			'blog_slug' => 'unique:blogs,slug,' . $blog_slug,
			'alt_Text' => 'nullable',
			'status' => 'required|boolean',
			'auto_publish_at' => 'nullable',
			'auto_publish_time' => 'nullable',
			'most_popular' => 'nullable',
			'picked_by_editors' => 'nullable'
		]);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)->withInput();
		}
		$blog = Blog::addBlog($request);
		self::save_blog_meta($blog->id, $request);

		$request->session()
			->flash('status', 'Blog added successfully');
		return redirect()
			->route('blogs');
	}
	//  admin section add new blog form action

	// admin section save tag and category if create new blog
	public static function save_blog_meta($blog_id, $request) {
		if (isset($blog_id) && !empty($blog_id) && isset($request->blog_tags) && !empty($request->blog_tags)) {

			if (isset($request->blog_tags) && !empty($request->blog_tags)) {
				$newArray = $request->blog_tags;
				BlogMeta::where('blog_id', '=', $blog_id)->delete();
				foreach ($newArray as $key => $value) {
					$metatags = Meta::updateOrCreate(['meta_name' => $value, 'meta_type' => 'blog_tag']);
					if ($metatags->id) {
						$metatag = BlogMeta::updateOrCreate(['blog_id' => $blog_id, 'meta_id' => $metatags->id]);
					}
				}
			}

			if (isset($request->blog_categories) && !empty($request->blog_categories)) {
				$newArray = $request->blog_categories;
				foreach ($newArray as $key => $value) {
					$metacategory = Meta::updateOrCreate(['meta_name' => $value, 'meta_type' => 'blog_category']);
					if ($metacategory->id) {
						$metacategories = BlogMeta::updateOrCreate(['blog_id' => $blog_id, 'meta_id' => $metacategory->id]);

					}
				}
			}

		}

	}

	// admin section upload drag and drop image
	public function uploadimage(Request $request) {
		if ($request->has('feature_image')) {

			$path_to_delete = str_replace(config('app.url') . '/', "", $request->get('last_used'));
			if (File::exists($path_to_delete)) {
				unlink($path_to_delete);
			}
			$file = $request->file('feature_image');
			$file = is_array($file) ? $file[0] : $file;
			$filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();

			$path = $file->storeAs('blog', $filename, 'public');
			$url = config('app.url') . '/storage/' . $path;
			return response()->json(['success' => true, 'url' => $url]);
		}
		return response()->json(['success' => false, 'url' => ""]);
	}

	// admin section edit blog form action
	public static function editblog(Request $request, $id) {
		$get_data = $request->all();
		$blog_slug = Str::slug($get_data['blog_slug'], '-');

		$validator = Validator::make($request->all(), [
			'title' => 'required|unique:blogs,title,' . $id,
			'feature_image' => 'mimes:jpeg,jpg,png,gif|max:20000',
			'description' => 'required',
			'blog_slug' => 'unique:blogs,slug,' . $id,
			'alt_Text' => 'nullable',
			'status' => 'required|boolean',
			'auto_publish_at' => 'nullable',
			'auto_publish_time' => 'nullable',
			'most_popular' => 'nullable',
			'picked_by_editors' => 'nullable'
		]);

		if ($validator->fails()) {
			return redirect()
				->back()
				->withErrors($validator)->withInput();
		}
		$blog = blog::find($id);

		if ($blog) {

			$url = $request->get('last_used');
			$slug = Str::slug($request->title, '-');

			$request
				->request
				->add(['image_path' => $url, 'blog_id' => $id, 'slug' => $slug]);

			if ($request->boolean('status')) {
				$request->auto_publish_at = null;
				$request->auto_publish_time = null;
			}			

			$blog = Blog::updateBlog($request);
			self::save_blog_meta($id, $request);

		}

		$request->session()
			->flash('status', 'Blog updated successfully');
		return redirect()
			->route('blogs');
	}
	// admin section edit blog form action

	//  admin section delete blog
	public function deleteblog(Request $request, $id) {
		$roles = json_decode(Auth::user()->user_role, 1);
		
		if (!isset($roles) || empty($roles) || !in_array('blogs', $roles)) {
			echo "You don't have permission to blogs.";
			die;
		}
		$podcast = Blog::find($id);
		if ($podcast) {
			$podcast->delete();
		}
		$request->session()
			->flash('status', 'Podcast deleted successfully');
		return redirect()
			->route('blogs');
	}
	//  admin section delete blog

	// this route for import csv to blog data do not delete this
	public function get_all_blogs(Request $request) {

		if (!empty($request->all())) {

			$file = $request->filename2;
			$row = 0;
			$col = 0;
			$results = [];
			$handle = @fopen($file, "r");
			if ($handle) {
				while (($row = fgetcsv($handle, 4096)) !== false) {
					if (empty($fields)) {
						$fields = $row;
						continue;
					}
					foreach ($row as $k => $value) {
						$results[$col][$fields[$k]] = $value;
					}
					$col++;
					unset($row);
				}
				if (!feof($handle)) {
					echo "Error: unexpected fgets() failn";
				}
				fclose($handle);
			}

			foreach ($results as $key => $result) {

				$image_url = "";

				if (!empty($result['Image Featured'])) {

					$url = $result['Image Featured'];
					$contents = file_get_contents($url);
					$name = substr($url, strrpos($url, '/') + 1);
					$file_name = 'blog/debutify-' . time() . '-' . $name;
					$image_upload = Storage::disk('public')->put($file_name, $contents);
					if ($image_upload) {
						$image_url = URL::to('/') . '/storage/' . $file_name;
					}

				}

				$blog = Blog::updateOrCreate(['title' => $result['Title'], 'description' => $result['Content'], 'feature_image' => $image_url, 'author_id' => 27, 'blog_publish_date' => "2020-10-13"]);

				if (!empty($result['Tags'])) {
					$array_tag = explode('|', $result['Tags']);
					if (isset($blog->id) && !empty($blog->id)) {
						foreach ($array_tag as $key => $value) {
							$metatags = Meta::updateOrCreate(['meta_name' => $value, 'meta_type' => 'blog_tag']);
							if ($metatags->id) {
								$metatag = BlogMeta::updateOrCreate(['blog_id' => $blog->id, 'meta_id' => $metatags->id]);
							}
						}
					}
				}

				if (!empty($result['Categories'])) {
					$array_category = explode('|', $result['Categories']);
					if (isset($blog->id) && !empty($blog->id)) {
						foreach ($array_category as $key => $value) {
							$metacategory = Meta::updateOrCreate(['meta_name' => $value, 'meta_type' => 'blog_category']);
							if ($metacategory->id) {
								$metatag = BlogMeta::updateOrCreate(['blog_id' => $blog->id, 'meta_id' => $metacategory->id]);
							}
						}
					}
				}

			}
		}
		return view('admin.csv_to_array');

	}

	// this route for import csv to blog data do not delete this

	// front end search blog
	public function search_blogs(Request $request) {
		$term = $request->all();
		$search_data = Blog::join('blog_metas', 'blog_metas.blog_id', '=', 'blogs.id')->select('blogs.*')->where(function ($query) use ($term) {
			$query->when(!empty($term['s']), function($query) use ($term) {
				return $query->where('blogs.title', 'like', '%' . $term['s'] . '%');
			})->when(isset($term['search_by_category']) && $term['search_by_category'] != null, function($query) use ($term) {
				return $query->where('meta_id', '=', $term['search_by_category']);
			})->when(isset($term['search_by_tag']) && $term['search_by_tag'] != null, function($query) use ($term) {
				return $query->where('meta_id', '=', $term['search_by_tag']);
			})->when(isset($term['search_title']) && $term['search_title'] != null, function($query) use ($term) {
				return $query->where(function($query) use ($term) {
					return $query->where('blogs.title', 'like', '%' . $term['search_title'] . '%')
						->orWhere('blogs.description', 'like', '%' . $term['search_title'] . '%');
				});
			});
		})->orderBy('id', 'DESC')
			->groupBy('blogs.id')
			->paginate(8);

		$term_search = "";
		if (isset($term['search_title']) && $term['search_title'] != null) {
			$term_search = $term['search_title'];
		}
		if ($request->get('s') != null) {
			// $term = $request->get('s');
			$term_search = $term['s'];
		}
		$all_tags_and_cat = Meta::get_all_blog_meta_in_array();
		$get_all_blog_meta_categories = Meta::get_all_blog_meta_categories_sitemap();

		if ($request->ajax()) {
			$html = View::make('landing.blogs-result',['blogs' => $search_data]);
			$response = $html->render();

			return response()->json([
				'status' => 'success',
				'html' => $response
			]);
		}

		return view('landing.blog', ['blogs' => $search_data, 'all_tags_and_cat' => $all_tags_and_cat,'get_all_blog_meta_categories'=>$get_all_blog_meta_categories, 'page_title' => 'Search Results', 'result_count' => count($search_data), 'term_search_value' => $term_search, 'seo_title' => 'You searched for ' . $term_search . ' | Debutify', 'search_field_value' => $term]);
	}
	
	public function sync_subscriber_email(Request $request) {
		$validatedData = $request->validate([
			'email' => 'required|email',
			'g-recaptcha-response' => ['required', new RecaptchaValidator]
		]);
		$activeCampaign = new ActiveCampaignJobV3();
		
		try {
			$contact = $activeCampaign->findContactViaEmail($request->input('email'));

			if ($contact) {
				return response()->json([
					'success' => 0,
					'message' => 'You are Already Subscribed',
				]);
			}

			$contact = $activeCampaign->create(['email' => $request->input('email')]);
			$updateListStatus = $activeCampaign->updateListStatus([
				'list' => AC::LIST_MASTERLIST,
				'contact' => $contact['id'],
				'status' => AC::LIST_SUBSCRIBE
			]);
			$tag = $activeCampaign->tag($contact['id'], AC::TAG_SOURCE_NEWSLETTER);

			return response()->json([
				'success' => 1,
				'message' => 'You are Subscribed!'
			]);
		} catch(\Exception $e) {
			return response()->json([
				'success' => 0,
				'message' => 'You are Already Subscribed'
			]);
		}
	}
	
	//temprary script for wordpress data migration
	public function update_blog_meta() {
		// Meta::truncate();
		//   BlogMeta::truncate();
		//   Blog::truncate();
		//    $row = 1;
		if (($handle = fopen("https://debutify.anilgautam.xyz/blogs_imagepath.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$title = $data[0];
				$image_url = $data[1];
				$id = $data[2];
				if ($id > 178) {
					$image_path = str_replace("https://debutify.anilgautam.xyz", "https://debutify.com", $data[1]);

					$update_data = [
						'feature_image' => $image_path,
					];
					# print_r($update_data);
					$blog = Blog::select('id')->where('title', $title)->get()->toArray();
					if (isset($blog[0]['id'])) {
						// echo "updating for ".$blog[0]['id']; echo "<br>";
						// echo "updated from". $data[1];echo "<br>";
						// echo "updated to ".$image_path;echo "<br>";
						Blog::where('id', $blog[0]['id'])->update($update_data);
					}

				}
			}
			fclose($handle);
		}
// die("STOP");
		if (($handle = fopen("https://debutify.anilgautam.xyz/sql.csv", "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$title = $data[0];
				$slug_url = $data[1];
				$slug = rtrim(str_replace("https://debutify.com/blog/", "", $slug_url), '/');
				$num = count($data);
				$meta_description = $data[2];
				$description = $data[4];
				$post_title = $data[5];
				if (strlen($slug) > 10) {
					$update_data = [
						'meta_description' => $meta_description,
						'slug' => $slug,
						'author_id' => 27,
						// 'blog_publish_date'=>'2020-10-13'
					];
					# print_r($update_data);
					$blog = Blog::select('id')->where('title', trim($data[0]))->get()->toArray();
					if (isset($blog[0]['id'])) {
						Blog::where('id', $blog[0]['id'])->update($update_data);
					} else {
						// $blog = new Blog;
						// $blog->description = $description;
						// $blog->slug = $slug;
						// $blog->title = $title;
						// $blog->author_id = 27;
						// $blog->blog_publish_date = '2020-10-13';
						// $blog->meta_description = $meta_description;
						// $blog->save();

					}
				}
			}
			fclose($handle);
		}
		$row = 0;
		$col = 0;
		$results = [];
		$handle = @fopen("https://debutify.anilgautam.xyz/posts_exported.csv", "r");
		if ($handle) {
			while (($row = fgetcsv($handle, 4096)) !== false) {
				if (empty($fields)) {
					$fields = $row;
					continue;
				}
				foreach ($row as $k => $value) {
					$results[$col][$fields[$k]] = $value;
				}
				$col++;
				unset($row);
			}
			if (!feof($handle)) {
				echo "Error: unexpected fgets() failn";
			}
			fclose($handle);
		}

		// print_r($results);
		foreach ($results as $key => $result) {

			$image_url = "";

			if (!empty($result['Image Featured'])) {

				// $url = $result['Image Featured'];
				// $contents = file_get_contents($url);
				// $name = substr($url, strrpos($url, '/') + 1);
				// $file_name = 'blog/debutify-' . time() . '-' . $name;
				// $image_upload = Storage::disk('public')->put($file_name, $contents);
				// if ($image_upload)
				// {
				//     $image_url = URL::to('/') . '/storage/' . $file_name;
				// }

			}

			// foreach ($results as $key => $result)
			// {
			// # print_r($update_data);
			$blog = Blog::select('id')->where('title', trim($result['Title']))->get()->toArray();

			// print_r($blog);die;
			if (isset($blog[0]['id'])) {
				$c_update = date("Y-m-d H:i:s", strtotime($result['Date']));
				$year = date("Y", strtotime($result['Date']));
				if ($year > 2010) {

					Blog::where('id', $blog[0]['id'])->update([
						'blog_publish_date' => $result['Date'],
						'created_at' => $c_update,
						'updated_at' => $c_update]);
				}
				$blog_id = $blog[0]['id'];
				// echo $blog_id;
				if (!empty($result['Tags'])) {
					$array_tag = explode('|', $result['Tags']);
					if (isset($blog_id) && !empty($blog_id)) {
						foreach ($array_tag as $key => $value) {

							$metatags = Meta::updateOrCreate(['meta_name' => $value, 'meta_type' => 'blog_tag']);
							if ($metatags->id) {
								$metatag = BlogMeta::updateOrCreate(['blog_id' => $blog_id, 'meta_id' => $metatags->id]);
							}
						}
					}
				}

				if (!empty($result['Categories'])) {
					$array_category = explode('|', $result['Categories']);
					if (isset($blog_id) && !empty($blog_id)) {
						foreach ($array_category as $key => $value) {

							$metacategory = Meta::updateOrCreate(['meta_name' => $value, 'meta_type' => 'blog_category']);
							if ($metacategory->id) {
								$metatag = BlogMeta::updateOrCreate(['blog_id' => $blog_id, 'meta_id' => $metacategory->id]);
							}
						}
					}
				}
			}
		}

	}

	//generate xml feed
	public function feed_generate() {
		$blog = Blog::orderBy('id', 'desc')->get();
		return Response()->view('landing.blog_feed', ['blogs' => $blog, 'page_title' => 'Blog'])->header('Content-Type', 'application/rss+xml')->header('charset', 'utf-8');
	}

	//generate post_sitemap feed
	public function post_sitemap() {
		$blog = Blog::orderBy('id', 'desc')->get();
		return Response()->view('landing.sitemap', ['blogs' => $blog, 'type' => 'blog_post'])->header('Content-Type', 'application/xml')->header('charset', 'utf-8');
	}

	//generate category_sitemap feed
	public function category_sitemap() {
		$all_tags_and_cat = Meta::get_all_blog_meta_categories_sitemap();
		return Response()->view('landing.sitemap', ['blogs' => $all_tags_and_cat, 'page_title' => 'category'])->header('Content-Type', 'application/xml')->header('charset', 'utf-8');
	}
	//generate category_sitemap feed
	public function post_tag_sitemap() {
		$all_tags_and_cat = Meta::get_all_blog_meta_tags_sitemap();
		return Response()->view('landing.sitemap', ['blogs' => $all_tags_and_cat, 'page_title' => 'tags'])->header('Content-Type', 'application/xml')->header('charset', 'utf-8');
	}

	//generate category_sitemap feed
	public function feed_sitemap_main() {
		return Response()->view('landing.sitemap-index')->header('Content-Type', 'application/xml')->header('charset', 'utf-8');
	}

	// feed_sitemap_main
	// post_sitemap
	// category_sitemap
	// post_tag_sitemap
	public function ajax_search_blog(Request $request){

	 			$blogs = Blog::where(function ($query) use($request) {
                if($request->query('query') != ''){
                  $query->where('title', 'like', '%' . $request->query('query') . '%')
                       ->orWhere('meta_description', 'like', '%'.$request->query('query').'%') 
                       ->orWhere('description', 'like', '%'.$request->query('query').'%') 
                       ->orWhere('feature_image', 'like', '%'.$request->query('query').'%') ;
                }
              })->orderBy('id', 'desc')
              ->paginate(50); 
              $newarray = [];
              if(is_array($blogs) && count($blogs) > 0) {
				foreach ($blogs as $key => $blog) {
					$meta_data = Blog::get_tag_and_category_meta($blog['id']);
					$meta_value = [];
					$blogTags = "";
					$categoryTags = "";
					foreach ($meta_data as $key => $meta_val) {
						$meta_value[$meta_val->meta_type][] = $meta_val->meta_name;
					}
					if (isset($meta_value['blog_tag'])) {
						$blogTags = implode(',', $meta_value['blog_tag']);
					}
					if (isset($meta_value['blog_category'])) {
						$categoryTags = implode(',', $meta_value['blog_category']);
					}
					$meta_val = $blog;

					$meta_val->blog_tags = $blogTags;
					$meta_val->blog_category = $categoryTags;

					$newarray[] = $meta_val;
					# code...

				}
			}
              $html = View::make('admin.blog_table',['blogs' => $newarray]);

              $response = $html->render();
              return response()->json([
                  'status' => 'success',
                  'html' => $response
              ]); 
    }

}
