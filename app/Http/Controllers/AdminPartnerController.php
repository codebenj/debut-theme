<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Partner;
use App\User;
use View;
use File;
use Storage;
use Illuminate\Http\Request;

class AdminPartnerController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:admin', ['except' => ['partner']]);
		$nbShops = ((int)User::where('password', '!=', '')->count()) + 43847;
		View::share(['nbShops' => $nbShops, ]);

	}

    // show partner in admin
	public function partners(Request $request)
	{
		$roles = json_decode(Auth::user()->user_role, 1);
		if (!isset($roles) || empty($roles) || !in_array('partners', $roles))
		{
			echo "You don't have permission to view integrations.";
			die;
		}
		$partners = Partner::orderBy('id', 'desc')->get();
		return view('admin.admin_partner', ['partners' => $partners]);
	}

	// add new partner
	public function addnewpartner(){
		$roles = json_decode(Auth::user()->user_role, 1);
		if (!isset($roles) || empty($roles) || !in_array('partners', $roles))
		{
			echo "You don't have permission to add integration.";
			die;
		}
		return view('admin.add_partner');
	}

	// save new partner
	public function save_new_partner(Request $request){
		$validator = Validator::make($request->all(), [
			'p_name' => 'required',
			'slug' => 'required|unique:partners',
			'categories' => 'sometimes|required|array',
			'p_logo' => 'mimes:jpeg,jpg,png,gif|max:20000',
			'page_heading' => 'nullable',
			'page_subheading' => 'nullable',
			'seo_title' => 'nullable',
			'seo_description' => 'nullable',
			'supported_countries' => 'sometimes|required|array',
			'documentation_link' => 'nullable',
			'about_link' => 'nullable',
			'short_description' => 'nullable',
			'popular' => 'in:0,1,'.null,
		]);

		if ($request->missing('categories')) {
            $request->categories = [];
        }

		if ($request->missing('supported_countries')) {
            $request->request->add(['supported_countries' => []]);
        } else {
			$countriesData = [];

			if( is_array($request->input('supported_countries')) && count($request->input('supported_countries')) ) {
				foreach ($request->input('supported_countries') as $country) {
					if (count($this->getCountries($country))) {
						array_push($countriesData, $this->getCountries($country, true)[0]);
					}
				}
			}

			$request->merge(['supported_countries' => $countriesData]);
		}
		
		if ($request->has('image_title')) {
			$images = [];

			if( is_array($request->input('image_title'))) {
				foreach ($request->input('image_title') as $imageTitleKey => $imageTitleValue) {
					if (gettype($request->image_file[$imageTitleKey]) == 'string') {
						$image_path = $request->image_file[$imageTitleKey];
					} else {
						$image_path = url('storage/'.$request->file('image_file')[$imageTitleKey]->store('admin_partner', 'public'));
					}
					
					array_push($images, [
						'title' => $request->input('image_title')[$imageTitleKey],
						'description' => $request->input('image_desc')[$imageTitleKey],
						'image_path' => $image_path,
					]);
				}
			}

			$request->images = $images;
        } else {
			$request->images = [];
		}

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)
			->withInput();
		}

		$podcast = Partner::addPartner($request);
		$request->session()->flash('status', 'Integration added successfully');
		return redirect()->route('partners');
	}

	// delete partner
	public function deletepartner(Request $request, $id){
		$roles = json_decode(Auth::user()->user_role, 1);
		if (!isset($roles) || empty($roles) || !in_array('partners', $roles))
		{
			echo "You don't have permission to integrations.";
			die;
		}
		$partner = Partner::find($id);
		if ($partner)
		{
			$partner->delete();
		}
		$request->session()
		->flash('status', 'Integration deleted successfully.');
		return redirect()->route('partners');
	}

	//upload logo
	public function upload_image(Request $request){
		if ($request->has('p_logo'))
		{
			$path_to_delete = str_replace(config('app.url') . '/', "", $request->get('last_used'));
			if (File::exists($path_to_delete))
			{
				unlink($path_to_delete);
			}
			$file = $request->file('p_logo');
			$file = is_array($file) ? $file[0] : $file;

			$filename = 'debutify-' . time() . '.' . $file->getClientOriginalExtension();

			$path = $file->storeAs('admin_partner', $filename, 'public');
			$url = config('app.url') . '/storage/' . $path;
			return response()->json(['success' => true, 'url' => $url]);
		}
		return response()->json(['success' => false, 'url' => ""]);
	}

	// edit partner
	public function showpartner(Request $request, $id){
		$roles = json_decode(Auth::user()->user_role, 1);
		if (!isset($roles) || empty($roles) || !in_array('partners', $roles))
		{
			echo "You don't have permission to integrations.";
			die;
		}
        $partner = Partner::getpartnerbyid($id);
		return view('admin.edit_partner', ['partner' => $partner]);
	}

	// save update partner
	public function edit_partner(Request $request, $id){
		$validator = Validator::make($request->all(), [
			'p_name' => 'required',
			'slug' => 'required|unique:partners,id,'.$id,
			'p_logo' => 'mimes:jpeg,jpg,png,gif|max:20000',
			'categories' => 'sometimes|required|array',
			'page_heading' => 'nullable',
			'page_subheading' => 'nullable',
			'seo_title' => 'nullable',
			'seo_description' => 'nullable',
			'supported_countries' => 'sometimes|required|array',
			'documentation_link' => 'nullable',
			'about_link' => 'nullable',
			'short_description' => 'nullable',
			'popular' => 'in:0,1,'.null,
		]);

		if ($request->missing('categories')) {
            $request->categories = [];
        }

		if ($request->missing('supported_countries')) {
            $request->supported_countries = [];
        } else {
			$countriesData = [];

			if( is_array($request->input('supported_countries')) && count($request->input('supported_countries')) ) {
				foreach ($request->input('supported_countries') as $country) {
					if (count($this->getCountries($country))) {
						array_push($countriesData, $this->getCountries($country, true)[0]);
					}
				}
			}
			
			$request->supported_countries = $countriesData;
		}

		if ($request->has('image_title')) {
			$images = [];

			if( is_array($request->input('image_title'))) {
				foreach ($request->input('image_title') as $imageTitleKey => $imageTitleValue) {
					if (gettype($request->image_file[$imageTitleKey]) == 'string') {
						$image_path = $request->image_file[$imageTitleKey];
					} else {
						$image_path = url('storage/'.$request->file('image_file')[$imageTitleKey]->store('admin_partner', 'public'));
					}
					
					array_push($images, [
						'title' => $request->input('image_title')[$imageTitleKey],
						'description' => $request->input('image_desc')[$imageTitleKey],
						'image_path' => $image_path,
					]);
				}
			}

			$request->images = $images;
        } else {
			$request->images = [];
		}

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)
			->withInput();
		}

		$partner = Partner::find($id);

        if ($partner)
        {
            $url = $request->get('last_used');
            $request
                ->request
                ->add(['image_path' => $url, 'partner_id' => $id]);
            $blog = Partner::updatePartner($request);

        }

        $request->session()->flash('status', 'Integration updated successfully.');
        return redirect()->route('partners');

	}

	// search partner
	public function search_partner(Request $request){

		$partners = Partner::where(function ($query) use ($request){
                if($request->query('query') != ''){
                	 $query->where('name', 'like', '%' . $request->query('query') . '%')
                       ->orWhere('description', 'like', '%'.$request->query('query').'%') 
                       ->orWhere('offer_description', 'like', '%'.$request->query('query').'%'); 
                }
            })->orderBy('id', 'desc')->paginate(50);

        $data['html'] = view('admin.partner_table', compact('partners'))->render();

        echo json_encode($data);
        die;

	}

	public function partnerCategories(Request $request)
	{
		$partners = Partner::where('categories', 'like', '%'.$request->input('query').'%')->take(20)->latest()->get();
        $categories = array();
        $transformedCategories = array();

        $partners->each(function($item, $key) use ($request, &$categories) {
            foreach ($item->categories as $category) {
                if (str_contains($category, $request->input('query')) && !in_array($category, $categories)) {
                    array_push($categories, $category);
                }
            }
        });

        foreach ($categories as $category) {
            array_push($transformedCategories, [
                'text' => $category,
                'value' => $category
            ]);
        }

        return $transformedCategories;
	}

	public function countries(Request $request)
	{
		return $this->getCountries($request->input('query'));
	}

	private function getCountries($search, $fullData = false)
	{
		$countries = json_decode(File::get(public_path('json/countries.json')), true);
		$result = [];

		foreach ($countries as $country) {
			if (str_contains(strtolower($country['name']), strtolower($search))) {
				array_push($result, $fullData ? $country : [
					'text' => $country['name'],
					'value' => $country['name']
				]);
			}
		}

		return $result;
	}
}
