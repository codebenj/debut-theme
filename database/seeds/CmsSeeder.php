<?php

use Illuminate\Database\Seeder;
use App\Cms;


class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $addons_array = [
        	0 => [
        		'title' => 'announcement_top_bar',
        		'content' => '✨ Debutify is the <a class="text-white d-inline download-cta" data-cta-tracking="cta-1" data-target="#downloadModal" data-toggle="modal" href="javascript:void(0)">Best High-Converting Shopify theme of 2021!</a>',
        	],
        ];

        foreach ($addons_array as $key => $value) {
            Cms::truncate();
        	$updateAddon = Cms::updateOrCreate(['title' => $value['title']],[
				'title' => $value['title'],		
				'content' => $value['content'],		
			]);
        }
    }
}
