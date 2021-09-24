<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddOnsReport extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $casts = ['stores_update_info' => 'array'];
    protected $fillable = ['stores_update_info', 'all_active_addons', 'plan_wise_active_addons', 'top_used_colors', 'report_generate_date'];

    /**
     * Get the decoded add active addons data.
     *
     * @param string $value
     * @return array
     */
    public function getAllActiveAddonsAttribute($value) {
        return json_decode($value);
    }

    /**
     * Get the decoded plan wise active addons data.
     *
     * @param string $value
     * @return array
     */
    public function getPlanWiseActiveAddonsAttribute($value) {
        return json_decode($value);
    }

    /**
     * Get the decoded top used colors data.
     *
     * @param string $value
     * @return array
     */
    public function getTopUsedColorsAttribute($value) {
        return json_decode($value);
    }

    /**
     * Store AddOns report data in storage
     *
     * @param reports_array
     * @return boolean
     */
    
    public function store($reports_array) {
        return $this->create($reports_array);
    }
}
