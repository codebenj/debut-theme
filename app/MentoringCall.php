<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentoringCall extends Model
{
    protected $table = 'mentoringcalls';

    public function scopeSetLimit( $query, $request ) {

        if ( isset( $request->limit ) && ! empty( $request->limit ) ) {
            $query->limit( $request->limit );
        }

        return $query;
    }
}
