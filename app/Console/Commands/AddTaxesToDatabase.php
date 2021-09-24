<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Taxes;

class AddTaxesToDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:taxes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add stripe taxes to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // add taxes in database
        // dev
        // $taxes =  array (
        //     'Alberta' => 'txr_1GV9tHASWvrhmMEEmusbvngr',
        //     'British Columbia' => 'txr_1GV9yJASWvrhmMEEK2G7uuGD',
        //     'Manitoba' => 'txr_1GWDuIASWvrhmMEEEs4votVV',
        //     'New-Brunswick' => 'txr_1GW2AUASWvrhmMEET3efrWZ3',
        //     'Newfoundland and Labrador' => 'txr_1GXMO9ASWvrhmMEE48t6ugDT',
        //     'Northwest Territories' => 'txr_1GVJGMASWvrhmMEE5l961GUi',
        //     'Nova Scotia' => 'txr_1GXMPlASWvrhmMEEVGmbTK50',
        //     'Nunavut' => 'txr_1GXMQeASWvrhmMEE5yWiae2X',
        //     'Ontario' => 'txr_1GVJJTASWvrhmMEEyy0YWrHg',
        //     'Prince Edward Island' => 'txr_1GXMT5ASWvrhmMEERYIABVOU',
        //     'Quebec' => 'txr_1GW2BEASWvrhmMEE6WSLXvX1',
        //     'Saskatchewan' => 'txr_1GW2AlASWvrhmMEE3GaeIrVI',
        //     'Yukon' => 'txr_1GXMUSASWvrhmMEECkv0wp9A'
        // );

        // prod
        $taxes =  array (
            'Alberta' => 'txr_1GXonvASWvrhmMEEZg1VMhGC',
            'British Columbia' => 'txr_1GXooQASWvrhmMEErc5cuvfI',
            'Manitoba' => 'txr_1GXoosASWvrhmMEEMRx7pe7I',
            'New-Brunswick' => 'txr_1GXoqKASWvrhmMEE9jhaI4E0',
            'Newfoundland and Labrador' => 'txr_1GXor1ASWvrhmMEEDmtCtBst',
            'Northwest Territories' => 'txr_1GXorwASWvrhmMEE3IVOeZlH',
            'Nova Scotia' => 'txr_1GXosmASWvrhmMEEo9wGTcDD',
            'Nunavut' => 'txr_1GXotmASWvrhmMEEjD1PWFqG',
            'Ontario' => 'txr_1GXouGASWvrhmMEEmV4djEcU',
            'Prince Edward Island' => 'txr_1GXounASWvrhmMEEFZRhUg6v',
            'Quebec' => 'txr_1GXovKASWvrhmMEE7gY0zaM0',
            'Saskatchewan' => 'txr_1GXovjASWvrhmMEEwDpDAboh',
            'Yukon' => 'txr_1GXowGASWvrhmMEEUcdGAYER'
        );
        foreach ($taxes as $key => $tax) {
            $tax_percent = $this->addTaxes($key);
            $tax_exist = Taxes::where('region',$key)->count();
            if($tax_exist == 0){
                $newtax = new Taxes;
                $newtax->region = $key;
                $newtax->percent = $tax_percent;
                $newtax->stripe_taxid = $tax;
                $newtax->save();
            }else{
                $newtax = Taxes::where('region',$key)->first();
                $newtax->region = $key;
                $newtax->percent = $tax_percent;
                $newtax->stripe_taxid = $tax;
                $newtax->save();
            }
        }
    }

    public function addTaxes($default = 'New-Brunswick'){
        $taxes =  array (
            'Alberta' => 5,
            'British Columbia' => 12,
            'Manitoba' => 12,
            'New-Brunswick' => 15,
            'Newfoundland and Labrador' => 15,
            'Northwest Territories' => 5,
            'Nova Scotia' => 15,
            'Nunavut' => 5,
            'Ontario' => 13,
            'Prince Edward Island' => 15,
            'Quebec' => 14.975,
            'Saskatchewan' => 11,
            'Yukon' => 5
        );
        if(isset($taxes[$default])){
            return $taxes[$default];
        }
    }
}
