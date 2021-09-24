<?php

use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulesArr = [
            44 => [
                'course_id' => 18,
                'title' => 'Beginner Facebook Ads Course'
            ],
            45 => [
                'course_id' => 19,
                'title' => 'Beginner Google Course'
            ],
            46 => [
                'course_id' => 20,
                'title' => 'Beginner Product Research Course'
            ],
            47 => [
                'course_id' => 21,
                'title' => 'Beginner Shopify Course'
            ],
            48 => [
                'course_id' => 22,
                'title' => 'Facebook Ads Advanced Course'
            ],
            49 => [
                'course_id' => 23,
                'title' => 'Google Ads Advanced Course'
            ],
            50 => [
                'course_id' => 24,
                'title' => 'Product Research Advanced Course'
            ],
            51 => [
                'course_id' => 25,
                'title' => 'Live Case Studies'
            ],
            52 => [
                'course_id' => 26,
                'title' => 'Productivity Apps Advanced Course'
            ],
            53 => [
                'course_id' => 27,
                'title' => 'Shopify Store Advanced Course'
            ],
            54 => [
                'course_id' => 28,
                'title' => 'Youtube Ads Advanced Course'
            ]
        ];

        foreach($modulesArr as $key => $module) {
            \App\Module::updateOrCreate(['id' => $key], $module);
        }
    }
}
