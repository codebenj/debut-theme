<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function teamMembers()
    {
        return $this->hasMany('App\TeamMember');
    }
}
