<?php

use Illuminate\Database\Seeder;
use App\Taxes;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Taxes::where('region', 'Alberta')->update(['region_code' => 'AB']);
		Taxes::where('region', 'British Columbia')->update(['region_code' => 'BC']);
		Taxes::where('region', 'Manitoba')->update(['region_code' => 'MB']);
		Taxes::where('region', 'New-Brunswick')->update(['region_code' => 'NB']);
		Taxes::where('region', 'Newfoundland and Labrador')->update(['region_code' => 'NL']);
		Taxes::where('region', 'Northwest Territories')->update(['region_code' => 'NT']);
		Taxes::where('region', 'Nova Scotia')->update(['region_code' => 'NS']);
		Taxes::where('region', 'Nunavut')->update(['region_code' => 'NU']);
		Taxes::where('region', 'Ontario')->update(['region_code' => 'ON']);
		Taxes::where('region', 'Prince Edward Island')->update(['region_code' => 'PE']);
		Taxes::where('region', 'Quebec')->update(['region_code'	=> 'QC']);
		Taxes::where('region', 'Saskatchewan')->update(['region_code' => 'SK']);
		Taxes::where('region', 'Yukon')->update(['region_code' => 'YT']);
    }
}