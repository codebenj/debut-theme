<?php

use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coursesArr = [
           18 => [
              "title" => "Beginner Facebook Ads Course",
              "description" => "Beginner Facebook Ads Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1624838504.jpeg",
              "plans" => "hustler,master"
           ],
           19 => [
              "title" => "Beginner Google Course",
              "description" => "Beginner Google Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1624838861.jpeg",
              "plans" => "hustler,master"
           ],
           20 => [
              "title" => "Beginner Product Research Course",
              "description" => "Beginner Product Research Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1624839192.jpeg",
              "plans" => "hustler,master"
           ],
           21 => [
              "title" => "Beginner Shopify Course",
              "description" => "Beginner Shopify Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138195.jpeg",
              "plans" => "hustler,master"
           ],
           22 => [
              "title" => "Facebook Ads Advanced Course",
              "description" => "Facebook Ads Advanced Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138230.jpeg",
              "plans" => "master"
           ],
           23 => [
              "title" => "Google Ads Advanced Course",
              "description" => "Google Ads Advanced Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138256.jpeg",
              "plans" => "master"
           ],
           24 => [
              "title" => "Product Research Advanced Course",
              "description" => "Product Research Advanced Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138306.jpeg",
              "plans" => "master"
           ],
           25 => [
              "title" => "Live Case Studies",
              "description" => "Live Case Studies",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138283.jpeg",
              "plans" => "master"
           ],
           26 => [
              "title" => "Productivity Apps Advanced Course",
              "description" => "Productivity Apps Advanced Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138334.jpeg",
              "plans" => "master"
           ],
           27 => [
              "title" => "Shopify Store Advanced Course",
              "description" => "Shopify Store Advanced Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138356.jpeg",
              "plans" => "master"
           ],
           28 => [
              "title" => "Youtube Ads Advanced Course",
              "description" => "Youtube Ads Advanced Course",
              "image" => config('env-variables.APP_URL') . "/storage/courses/course_1626138386.jpeg",
              "plans" => "master"
           ]
        ];

        foreach($coursesArr as $key => $course) {
            \App\Course::updateOrCreate(['id' => $key], $course);
        }
    }
}
