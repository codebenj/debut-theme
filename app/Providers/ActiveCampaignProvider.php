<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ActiveCampaignProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    protected $defer = true;
    
    public function register()
    {
        $this->app->singleton('ActiveCampaign',  function($app) {
            $config = $app['config']['services']['activecampaign'];
            return new \ActiveCampaign($config['url'], $config['key']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [\ActiveCampaign::class];
    }
}
