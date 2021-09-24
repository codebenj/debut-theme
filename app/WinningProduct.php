<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WinningProduct extends Model
{
    protected $table = 'winning_products';
    protected $fillable = [
        'name',
        'price',
        'cost',
        'profit',
        'aliexpresslink',
        'facebookadslink',
        'googletrendslink',
        'youtubelink',
        'competitorlink',
        'age',
        'gender',
        'placement',
        'saturationlevel',
        'image'
    ];

    public function scopeGetByAddOnsPlan($query, $plan, $request, $isBetaTester)
    {
        $products = [];
        if ( isset($plan) && ! empty( $plan ) ) {
            $saturation_level = $plan == 'Master' || $isBetaTester ? 'gold' : (
                $plan == 'Hustler' ? 'silver' : 'bronze'
            );
            $query->where('saturationlevel', $saturation_level);
        }

        $query->orderBy('id', 'desc');

        if ( isset( $request->limit ) && ! empty( $request->limit ) ) {
            return $query->limit( $request->limit )->get();
        }

        return $query->paginate(24);
    }

    public function scopeFilter($query, $plan, $request, $shop)
    {

        $category = $request->query('category') == 'all' ? '' : $request->query('category');
        $profit = $request->query('profit') == 'all' ? '' : $request->query('profit');
        $saturation = $request->query('saturation');

        if (! empty( $saturation  ))
        {
            $query->where('saturationlevel', 'like', '%' . $saturation . '%');
        }

        if (isset( $request['q'] ) && ! empty( $request['q'] ))
        {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request['q'] . '%');
                $q->orWhere('aliexpresslink', 'like', '%' . $request['q'] . '%');
                $q->orWhere('price', 'like', '%' . $request['q'] . '%');
            });
        }

        if ( ! empty( $category ) )
        {
            $query->where('category', 'like', '%' . $category . '%');
        }

        if ( ! empty( $profit ) )
        {
            $profit_data = explode('-', $profit);
            if ( count( $profit_data ) >= 2 )
            {
              $min = $profit_data[0];
              $max = $profit_data[1];
              $query->whereBetween('profit', [(int)$min, (int)$max]);
            } else {
              $query->where('profit', '>=', (int)$profit);
            }
        }

        // If plan is not master and not a beta tester
        if ( ! $shop->is_beta_tester ) {
            // set product limitation per plan
            if ( $plan == 'Hustler' ) {
                $query->where(function ($q) {
                    $q->where('saturationlevel', 'bronze');
                    $q->orWhere('saturationlevel', 'silver');
                });
            } else if ( $plan == 'Starter' ) {
                $query->where('saturationlevel', 'bronze');
            }
        }

        $query->orderBy('id', 'desc');

        return $query->paginate(24);
    }
}