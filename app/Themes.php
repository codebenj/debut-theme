<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 */

class Themes extends Model
{
    /**
     * Custom scope (query builder method)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBetaTheme($query, $status = 1, $all = true) {
        if ( ! $status ) {
            $query->where('is_beta_theme', $status);
            $query->orWhereNull('is_beta_theme');
        } elseif ( ! $all ) {
            $query->where('is_beta_theme', $status);
        }
        return $query;
    }
}