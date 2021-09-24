<?php

use Illuminate\Database\Seeder;

class PaypalPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plansArr = [];
        if (config('env-variables.PAYPAL_MODE') == 'live') {
            $plansArr = [
                'starterPriceMonthly' => ['paypal_plan_name' => 'starterPriceMonthly21Jun2021', 'cost' => '19.00', 'paypal_plan' => 'P-1YE793661T274833GMDIEV4Q'],
                'starterPriceQuarterly'  => ['paypal_plan_name' => 'starterPriceQuarterly21Jun2021', 'cost' => '48.45', 'paypal_plan' => 'P-4K4308464G6198626MDIESBQ'],
                'starterPriceAnnually'  => ['paypal_plan_name' => 'starterPriceAnnually21Jun2021', 'cost' => '114.00', 'paypal_plan' => 'P-7DS706836U4843301MDIEVLA'],

                'hustlerPriceMonthly'  => ['paypal_plan_name' => 'hustlerPriceMonthly21Jun2021', 'cost' => '47.00', 'paypal_plan' => 'P-0E611137UK111735NMDIEUYA'],
                'hustlerPriceQuarterly'  => ['paypal_plan_name' => 'hustlerPriceQuarterly21Jun2021', 'cost' => '119.85', 'paypal_plan' => 'P-18J89008VC044491KMDIEROY'],
                'hustlerPriceAnnually'  => ['paypal_plan_name' => 'hustlerPriceAnnually21Jun2021', 'cost' => '282.00', 'paypal_plan' => 'P-6J594358U94734948MDIEUHI'],

                'guruPriceMonthly'  => ['paypal_plan_name' => 'masterPriceMonthly21Jun2021', 'cost' => '97.00', 'paypal_plan' => 'P-06123586JB487251NMDIETSY'],
                'guruPriceQuarterly'  => ['paypal_plan_name' => 'masterPriceQuarterly21Jun2021', 'cost' => '247.35', 'paypal_plan' => 'P-89M67034D2660431CMDIEQVA'],
                'guruPriceAnnually'  => ['paypal_plan_name' => 'masterPriceAnnually21Jun2021', 'cost' => '582.00', 'paypal_plan' => 'P-2FW52311PC872284AMDIES5Q'],
             ];
        } else {
           $plansArr = [
                'starterPriceMonthly' => ['paypal_plan_name' => 'starterPriceMonthly21Jun2021', 'cost' => '19.00', 'paypal_plan' => 'P-42U55001A5291883PMDIE3RI'],
                'starterPriceQuarterly'  => ['paypal_plan_name' => 'starterPriceQuarterly21Jun2021', 'cost' => '48.45', 'paypal_plan' => 'P-12H88061WS210080BMDIE52I'],
                'starterPriceAnnually'  => ['paypal_plan_name' => 'starterPriceAnnually21Jun2021', 'cost' => '114.00', 'paypal_plan' => 'P-0S194460KE903560DMDIE4CA'],

                'hustlerPriceMonthly'  => ['paypal_plan_name' => 'hustlerPriceMonthly21Jun2021', 'cost' => '47.00', 'paypal_plan' => 'P-7N308654UF285000LMDIE4NA'],
                'hustlerPriceQuarterly'  => ['paypal_plan_name' => 'hustlerPriceQuarterly21Jun2021', 'cost' => '119.85', 'paypal_plan' => 'P-1BS097396V6211805MDIE6EA'],
                'hustlerPriceAnnually'  => ['paypal_plan_name' => 'hustlerPriceAnnually21Jun2021', 'cost' => '282.00', 'paypal_plan' => 'P-08G34742739039204MDIE42A'],

                'guruPriceMonthly'  => ['paypal_plan_name' => 'masterPriceMonthly21Jun2021', 'cost' => '97.00', 'paypal_plan' => 'P-5AN10757GX523903KMDIE5EY'],
                'guruPriceQuarterly'  => ['paypal_plan_name' => 'masterPriceQuarterly21Jun2021', 'cost' => '247.35', 'paypal_plan' => 'P-7R335417YS625282WMDIE6PI'],
                'guruPriceAnnually'  => ['paypal_plan_name' => 'masterPriceAnnually21Jun2021', 'cost' => '582.00', 'paypal_plan' => 'P-49P858431R7694622MDIE5OY'],
             ];
        }

        foreach($plansArr as $key => $plan) {
            \App\StripePlan::where('name', $key)->update($plan);
        }
    }
}
