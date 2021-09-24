<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('frequently_asked_questions')->insert([
            [
                'title' => 'Why Is Debutify Free?',
                'content' => 'Because it was about time someone created a more than "decent" free Shopify theme! There are more than 1 000 000+ Shopify stores, and only 10 basic free themes offered by Shopify, that\'s nonsense. Debutify theme will forever be free and awesome!'
            ],
            [
                'title' => 'What Is Debutify App?',
                'content' => 'Debutify is much more than a traditional shopify theme. On our app, you will be able to automatically download our free theme in one-click and have access to powerful integrated features.'
            ],
            [
                'title' => 'What Permission Is Debutify App Accessing?',
                'content' => 'We only access the "manage store permission" to be able to download Debutify theme and Add-Ons to your store. We do not have access to any of your customer\'s data.'
            ],
            [
                'title' => 'What Are Debutify Add-Ons?',
                'content' => 'Add-On are simple yet powerful features that can be added to your store in Debutify App. They are completely integrated into your Debutify theme: Doesn\'t affect page load speed (like a typical Shopify App) and automatically matches your theme style and settings.'
            ],
            [
                'title' => 'Can I swap Add-Ons?',
                'content' => 'Yes! If you don\'t like an Add-On, you can uninstall it and pick another one.'
            ],
            [
                'title' => 'Will Add-Ons slow down my website?',
                'content' => 'No! Unlike Shopify apps, our Add-Ons have almost no impact on page load speed.'
            ],
            [
                'title' => 'Can I change plan later?',
                'content' => 'Yes! You can upgrade or downgrade plan at any time in Debutify App.'
            ],
            [
                'title' => 'Is there regular updates?',
                'content' => 'Yes! We are constantly improving and updating our theme and Add-Ons based on your feedback!'
            ]
        ]);
    }
}
