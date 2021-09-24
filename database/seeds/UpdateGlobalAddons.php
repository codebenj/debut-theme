<?php

use Illuminate\Database\Seeder;

class UpdateGlobalAddons extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $globalAddons = \App\GlobalAddons::get();

        foreach($globalAddons as $key => $addon) {
            $title = $addon->title;
            \App\GlobalAddons::where('id', $addon->id)->update([
                'title' => $this->camelCase($title)
            ]);
        }
    }

    public function camelCase($string) {

        $parts = explode('-', $string);
        $parts = array_map('ucwords', $parts);
        $string = ucwords(implode('-', $parts));

        return $string;
    }
}
