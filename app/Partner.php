<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'logo',
        'name',
        'description',
        'link',
        'offer_description',
        'featured',
        'slug',
        'categories',
        'page_heading',
        'page_subheading',
        'seo_title',
        'seo_description',
        'supported_countries',
        'documentation_link',
        'images',
        'short_description',
        'about_link',
        'popular'
    ];

	//add new partner
    public static function addPartner($request) {
    	$blog = self::updateOrCreate([
    		'name' => $request->p_name,
    		'logo' => $request->image_path_logo,
    		'description' => $request->p_description,
    		'link' => $request->p_link,
    		'offer_description' => $request->p_offer_description,
    		'slug' => $request->slug,
    		'categories' => $request->categories,
    		'page_heading' => $request->page_heading,
    		'page_subheading' => $request->page_subheading,
    		'seo_title' => $request->seo_title,
    		'seo_description' => $request->seo_description,
    		'supported_countries' => $request->supported_countries,
            'documentation_link' => $request->documentation_link,
            'images' => $request->images,
            'short_description' => $request->short_description,
            'about_link' => $request->about_link,
            'popular' => $request->popular? $request->popular:0,
    	]);

    	return $blog;
    }

    // get partner by id
    public static function getpartnerbyid($id){
    	return self::where('id', $id)->first();
    }

    //edit partner
    public static function updatePartner($request){
        $podcast = self::where(['id' => $request->partner_id])->update([
            'name' => $request->p_name,
            'logo' => $request->image_path,
            'slug' => $request->slug,
            'description' => $request->p_description,
            'link' => $request->p_link,
            'offer_description' => $request->p_offer_description,
            'categories' => $request->categories,
    		'page_heading' => $request->page_heading,
    		'page_subheading' => $request->page_subheading,
    		'seo_title' => $request->seo_title,
    		'seo_description' => $request->seo_description,
    		'supported_countries' => $request->supported_countries,
            'documentation_link' => $request->documentation_link,
            'images' => $request->images,
            'short_description' => $request->short_description,
            'about_link' => $request->about_link,
            'popular' => $request->popular? $request->popular:0,
        ]);
        return $podcast;

    }

    public function getCategoriesAttribute($value)
    {
        if ($value == null) {
            return array();
        }

        return json_decode($value);
    }

    public function setCategoriesAttribute($value)
    {
        $this->attributes['categories'] = json_encode($value);
    }

    public function getSupportedCountriesAttribute($value)
    {
        if ($value == null) {
            return array();
        }

        return json_decode($value);
    }

    public function setSupportedCountriesAttribute($value)
    {
        $this->attributes['supported_countries'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        if ($value == null) {
            return array();
        }

        return json_decode($value);
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }
}