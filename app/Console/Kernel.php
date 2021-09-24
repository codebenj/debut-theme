<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ThemeCreated::class,
        Commands\InvoiceDelete::class,
        Commands\ThemeDeleted::class,
        Commands\StripeinvoiceUpdate::class,
        Commands\TrialDaysUpdate::class,
        Commands\MentoringUpdate::class,
        Commands\ImpactPartner::class,
        // Commands\UpdateShopSubscriptions::class,
        // Commands\Shopupdate::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        $schedule->command('trialdays:update')->daily();
        $schedule->command('theme:deleted')->dailyAt('01:00');
        $schedule->command('invoice:deleted')->dailyAt('02:00');
        $schedule->command('invoice:update')->dailyAt('03:00');
        $schedule->command('mentoring:update')->dailyAt('04:00');
        $schedule->command('sitemap:generate')->weekly();
        $schedule->command('impactPartner:update')->hourly();
        // $schedule->command('update:addonanalytics')->daily();
        // $schedule->command('shop:subscriptions')->daily();
        // $schedule->command('theme:created')->everyFiveMinutes();
        // $schedule->command('shop:updated')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(){
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
