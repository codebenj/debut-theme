<?php

namespace App\Console\Commands;

use App\MainSubscription;
use App\SubscriptionStripe;
use App\User;
use Illuminate\Console\Command;

class PopulateMainSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populateMainSubscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will populate main_subscriptions table in the database with subscription data for all existing users.';

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
        $users = User::all();
        foreach ($users as $user) {
            $mainSub = MainSubscription::where('user_id',$user->id)->first();
            if($mainSub == null){
                if ($user->mainSubscription) {
                    continue;
                }
                $subscription = SubscriptionStripe::where('user_id',$user->id)->orderBy('id', 'desc')->first();
                $mainSubscription = new MainSubscription;
                $mainSubscription->user_id = $user->id;
                if ($subscription) {
                    $mainSubscription->payment_platform = MainSubscription::PAYMENT_PLATFORM_STRIPE;
                    $mainSubscription->subscription_id = $subscription->id;
                }
                $mainSubscription->stripe_customer_id = $user->stripe_id;
                $mainSubscription->save();
            }
        }
        return 0;
    }
}
