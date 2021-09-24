<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestion extends Model
{
    protected $fillable = [
        'title',
        'content',
        'categories'
    ];

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
}
