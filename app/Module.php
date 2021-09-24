<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Step;

class Module extends Model
{
    protected $table = 'modules';

    public function steps() 
	{
	    return $this->hasMany(Step::class);
	}
}
