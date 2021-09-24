<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreThemes extends Model {

    /**
     * Custom scope (query builder method)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected $fillable = [
        'theme_id'
    ];

    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    public function scopeLast($query) {
        return $query->orderby('id', 'desc')->first();
    }

    public function scopeDeleteTheme($query, $themeId) {
        if ( isset( $themeId ) && ! empty( $themeId ) ) {
            $query->where('shopify_theme_id', $themeId)->delete();
        }
        return $query;
    }

    public function scopeTheme($query, $themeId) {
        return $query->where('shopify_theme_id', $themeId);
    }

    public function scopeThemeName($query, $themeName) {
        if ( isset( $themeName ) && ! empty( $themeName ) ) {
            return $query->where('shopify_theme_name', $themeName);
        }
    }

    public function scopeIsBetaTheme($query, $status = 1) {
        if ( ! $status ) {
            $query->where('is_beta_theme', $status);
            $query->orWhereNull('is_beta_theme');
        }
        return $query;
    }

    public function scopeOrderByRole($query) {
        $query->orderBy('role', 'desc');
        $query->orderBy('id', 'desc');
        return $query;
    }

    public function scopeOrderByRoleAndLatest($query) {
        $query->orderBy('role', 'desc');
        $query->orderBy('shopify_theme_id', 'desc');
        return $query;
    }

}