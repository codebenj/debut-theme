<?php

use Illuminate\Database\Seeder;

class QuarterlyPaypalPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (config('env-variables.PAYPAL_MODE') == 'live') {
            \App\StripePlan::where('name', 'starterPriceQuarterly')->update( ['paypal_plan'=> 'P-63T49283AY689170DMBKEF3Q']);
            \App\StripePlan::where('name', 'hustlerPriceQuarterly')->update( ['paypal_plan'=> 'P-4P39237797788322FMBKEG2A']);
            \App\StripePlan::where('name', 'guruPriceQuarterly')->update( ['paypal_plan'=> 'P-85G93656WS6312316MBKEHKY']);
        } else {
            \App\StripePlan::where('name', 'starterPriceQuarterly')->update( ['paypal_plan'=> 'P-3LD61445EB535531UMBJOKYA']);
            \App\StripePlan::where('name', 'hustlerPriceQuarterly')->update( ['paypal_plan'=> 'P-8LH04726E68702829MBJOLNQ']);
            \App\StripePlan::where('name', 'guruPriceQuarterly')->update( ['paypal_plan'=> 'P-5B245632LT551214FMBJOMAA']);
        }
    }
}
