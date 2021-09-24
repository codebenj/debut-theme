<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RenameDebutifyAppText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:rename-debutify-app-text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Debutify App text in the database';

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
     * @return int
     */
    public function handle()
    {
        $faqs = \App\FrequentlyAskedQuestion::all();

        $faqs->each(function ($faq) {
            $faq->title = str_replace(["Debutify App", "Debutify app"], "Debutify Theme Manager", $faq->title);
            $faq->content = str_replace(["Debutify App", "Debutify app"], "Debutify Theme Manager", $faq->content);
            $faq->save();
        });
    }
}
