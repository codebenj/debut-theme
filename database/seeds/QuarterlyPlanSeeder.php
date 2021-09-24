<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuarterlyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stripe_plans')->insert([
            [
                'name' => 'starterPriceQuarterly',
                'slug' => 'starterPriceQuarterly',
                'stripe_plan' => 'price_1IVrqJASWvrhmMEE7p6nyt8h',
                'cost' => 51.30,
                'description' => '$51.30/quarter for 3 addons',
                'created_at' => now(),
                'updated_at' => now(),
                'plan_name' => 'Starter',
                'paypal_plan' => null,
            ],
            [
                'name' => 'hustlerPriceQuarterly',
                'slug' => 'hustlerPriceQuarterly',
                'stripe_plan' => 'price_1IVrrFASWvrhmMEEtfFPc38W',
                'cost' => 126.90,
                'description' => '$126.90/quarter for all addons!',
                'created_at' => now(),
                'updated_at' => now(),
                'plan_name' => 'Hustler',
                'paypal_plan' => null,
            ],
            [
                'name' => 'guruPriceQuarterly',
                'slug' => 'guruPriceQuarterly',
                'stripe_plan' => 'price_1IVrwRASWvrhmMEErO3xmciB',
                'cost' => 261.90,
                'description' => '$261.90/quarter for all addons!',
                'created_at' => now(),
                'updated_at' => now(),
                'plan_name' => 'Master',
                'paypal_plan' => null,
            ]
        ]);
    }
}
