<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    protected $fillable = [
        'presenter', 'title', 'image', 'release_date', 'duration', 'webinar_link',
      ];
  
      public function admin_user()
      {
          return $this->belongsTo('App\AdminUser', 'presenter');
      }
}
