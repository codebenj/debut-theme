<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExtendTrialRequest extends Model
{
    //
    protected $fillable = [
        'user_id',
        'extend_trials_id',
        'extend_trial_proof_image',
        'extend_trial_status'
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public static function ExtendUserRequest($request, $id, $image_url)
    {
        $extend_feature = self::updateOrCreate([
            'extend_trials_id' => $request->extend_feature_id,
            'user_id' => $id,
        ],
        [
            'extend_trial_proof_image' => $image_url,
            'extend_trial_status' => 'pending'
        ]);
    }

    public function scopeStatus($query, $status)
    {
        if (isset($status) && ! empty($status))
        {
            $query->where('extend_trial_status', $status);
        }

        return $query;
    }
}
