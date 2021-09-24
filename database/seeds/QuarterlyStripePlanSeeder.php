<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class QuarterlyStripePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $starterPriceQuarterly = '';
        $hustlerPriceQuarterly = '';
        $guruPriceQuarterly = '';
        
        if (config('env-variables.STRIPE_MODE') == 'sandbox') {
            // for test stripe payment
            $starterPriceQuarterly = 'price_1J7KT2ASWvrhmMEEDSo7Ise5';
            $hustlerPriceQuarterly = 'price_1J7KRRASWvrhmMEESGOEf0TP';
            $guruPriceQuarterly = 'price_1J7KOWASWvrhmMEENyiixCum';
        }
        else if (config('env-variables.STRIPE_MODE') == 'live') {
            // for live stripe payment
            $starterPriceQuarterly = 'price_1J7JZEASWvrhmMEE2ThDW3Pl';
            $hustlerPriceQuarterly = 'price_1J7JXkASWvrhmMEEAi5PDToP';
            $guruPriceQuarterly = 'price_1J7JTaASWvrhmMEEMYOitYU5';
        }

        DB::table('stripe_plans')->where('name', 'starterPriceQuarterly')->update(['stripe_plan' => $starterPriceQuarterly]);
        DB::table('stripe_plans')->where('name', 'hustlerPriceQuarterly')->update(['stripe_plan' => $hustlerPriceQuarterly]);
        DB::table('stripe_plans')->where('name', 'guruPriceQuarterly')->update(['stripe_plan' => $guruPriceQuarterly]);
    }
}
