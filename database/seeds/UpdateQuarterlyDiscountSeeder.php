<?php

use Illuminate\Database\Seeder;

class UpdateQuarterlyDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paypalStarterPlanQuarterly = '';
        $paypalHustlerPlanQuarterly = '';
        $paypalMasterPlanQuarterly = '';

        // computed 15% quarterly discounted price
        $starterPriceQuarterly = 48.45;
        $hustlerPriceQuarterly = 119.85;
        $masterPriceQuarterly = 247.35;

        // Values from this stripe api keys 
        // STRIPE_KEY=pk_test_AQRVQZ2JpFsVleLGLq3KBZas00dJrtmbod
        // STRIPE_SECRET=sk_test_HLDa5WECPCkZK3CXqmH8vqwQ
        // Edit the values and set your new plans quarterly ID from live stripe 
        $starterPlanQuarterly = 'plan_JgaL1rCIo2oklG';
        $hustlerPlanQuarterly = 'plan_JgaJ1crCSi5NX4';
        $masterPlanQuarterly = 'plan_JgaFrB35WngWSl';

        //Paypal
        if (config('env-variables.PAYPAL_MODE') == 'live') { 
            // Paypal Live - set your new plans quarterly ID from paypal live
            $paypalStarterPlanQuarterly = 'P-4K4308464G6198626MDIESBQ';
            $paypalHustlerPlanQuarterly = 'P-18J89008VC044491KMDIEROY';
            $paypalMasterPlanQuarterly = 'P-89M67034D2660431CMDIEQVA';
        }
        else {
            // Paypal sandbox - quarterly IDs
            $paypalStarterPlanQuarterly = 'P-12H88061WS210080BMDIE52I';
            $paypalHustlerPlanQuarterly = 'P-1BS097396V6211805MDIE6EA';
            $paypalMasterPlanQuarterly = 'P-7R335417YS625282WMDIE6PI';
        }

        // insert to table
        DB::table('stripe_plans')->insert([
            [
                'cost' => $starterPriceQuarterly,
                'stripe_plan' => $starterPlanQuarterly,
                'paypal_plan' => $paypalStarterPlanQuarterly,
                'name' => 'starterPriceQuarterly21Jun2021',
                'slug' => 'starterPriceQuarterly21Jun2021',
                'description' => '$48.45/quarter for 3 addons',
                'plan_name' => 'Starter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost' => $hustlerPriceQuarterly,
                'stripe_plan' => $hustlerPlanQuarterly,
                'paypal_plan' => $paypalHustlerPlanQuarterly,
                'name' => 'hustlerPriceQuarterly21Jun2021',
                'slug' => 'hustlerPriceQuarterly21Jun2021',
                'description' => '$119.85/quarter for all addons!',
                'plan_name' => 'Hustler',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'cost' => $masterPriceQuarterly,
                'stripe_plan' => $masterPlanQuarterly,
                'paypal_plan' => $paypalMasterPlanQuarterly,
                'name' => 'masterPriceQuarterly21Jun2021',
                'slug' => 'masterPriceQuarterly21Jun2021',
                'description' => '$247.35/quarter for all addons!',
                'plan_name' => 'Master',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
