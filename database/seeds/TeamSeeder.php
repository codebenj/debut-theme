<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->insert([
            ['name' => 'Corporate', 'icon_path' => 'images/landing/icon-corporate.svg'],
            ['name' => 'Customer Support', 'icon_path' => 'images/landing/icon-support.svg'],
            ['name' => 'Development', 'icon_path' => 'images/landing/icon-development.svg'],
            ['name' => 'Marketing', 'icon_path' => 'images/landing/icon-marketing.svg'],
        ]);
    }
}
