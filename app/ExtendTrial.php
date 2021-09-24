<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtendTrial extends Model
{
    //

    protected $fillable = [
        'name',
        'description',
        'extend_trial_days' ];

    public static function store_extend_feature($request){
    	$extend_feature = self::updateOrCreate([
            'name' => $request->feature_name,
            'description' => $request->feature_description,
            'extend_trial_days' =>$request->extend_days,
        ]);
        return $extend_feature;
    }

    public static function getFeatureByID($id){
            return self::where('id',$id)->first();
    }

    public static function update_extend_feature($request, $id){
            $extend_feature = self::updateOrCreate( ['id' => $id], [
            'name' => $request->feature_name,
            'description' => $request->feature_description,
            'extend_trial_days' => $request->extend_days,
        ]);
    }

    

}
