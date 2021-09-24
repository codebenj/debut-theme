<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\ProcessThemeAction;

class ThemesUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
    * Shop's myshopify domain
    *
    * @var string
    */
    public $shopDomain;

    /**
    * The webhook data
    *
    * @var object
    */
    public $data;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
    * Execute the job.
    *
    * @return [type]
    */
    public function handle()
    {
        logger("ThemesUpdateJob started");
        dispatch(new ProcessThemeAction('update', $this->shopDomain, $this->data));
        logger("ThemesUpdateJob ended");
    }
}
