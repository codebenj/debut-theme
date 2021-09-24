<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Module;

class Step extends Model
{
    protected $table = 'steps';
    public function module()
	{
	    return $this->belongsTo(Module::class);
	}
}
