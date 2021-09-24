<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
class TrialDaysUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trialdays:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trial days update';

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
     * @return mixed
     */
    public function handle()
    {
        logger("Trail Days update cron");
        $shops = User::where('trial_days', '>', 0)->get();
        foreach ($shops as $key=>$shop) {
          setTrialDays($shop);
        }

        // remove from beta user
        $shopArr = User::where('is_beta_tester', 1)->where('trial_days', 0)->select('id', 'name', 'email', 'is_beta_tester', 'trial_days')->get();
        foreach ($shopArr as $shop) {
            remove_from_beta_user($shop->id, $shop->email, $shop->name, 0);
        }
    }
}
