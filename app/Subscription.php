<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
	protected $table = 'subscriptions';
	
	public function scopeActive($query) {
		return $query->whereNull('ends_at')->orderBy('id', 'desc');
	}

	public function scopeUser($query, $id) {
		if ( isset( $id ) && ! empty( $id ) ) {
			$query->where('user_id', $id);
		}

		return $query;
	}

	public function scopeStatus($query, $status) {
		if ( isset( $status ) && ! empty( $status ) ) {
			$query->where('stripe_status', $status);
		}

		return $query;
	}
}
