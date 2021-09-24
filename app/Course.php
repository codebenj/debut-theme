<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Module;
use App\Step;

class Course extends Model
{
    protected $table = 'courses';

    public function modules() 
	{
	    return $this->hasMany(Module::class)->orderBy('position');
	}

	public function steps()
	{
	    return $this->hasManyThrough('App\Step', 'App\Module')->orderBy('steps.position','desc');
	}

	public function scopeGetCourse($query, $request) {
			$query->orderBy('id', 'desc');
			if ( isset( $request->limit ) && ! empty( $request->limit ) ) {
				$query->limit( $request->limit )->get();
			} else {
				$query->paginate(24);
			}
			return $query;
	}
}
