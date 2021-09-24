<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SubscriptionPaypal;

class PopulatePaypalEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paypal:populate-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate missing paypal email';

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
        echo "PopulatePaypalEmail started...\n";
        $query = SubscriptionPaypal::where('paypal_email', '')->orWhereNull('paypal_email');
        $updatedSubscription = 0;
        $totalCount = $query->count();
        echo "Found {$totalCount} PayPal subscription with no email attached\n";

        $query->get()->each(function($subscription) use(&$updatedSubscription) {
            $retries = 0;
            $shouldRetry = true;

            while ($shouldRetry && $retries < 5) {
                try {
                    echo "Updating {$subscription->paypal_id}";
                    $subscriptionResponse = getPaypalHttpClient()
                        ->get(getPaypalUrl("v1/billing/subscriptions/{$subscription->paypal_id}"))
                        ->json();
    
                    if (!isset($subscriptionResponse['subscriber'])) {
                        logger(json_encode($subscriptionResponse, true));
                    }
    
                    $subscription->update([
                        'paypal_email' => $subscriptionResponse['subscriber']['email_address'],
                    ]);
    
                    echo " - Done\n";
                    $updatedSubscription++;
                    $shouldRetry = false;
                    sleep(2);
                } catch(\Exception $e) {
                    $shouldRetry = true;
                    $retries++;
                    echo " - Failed (Tried: {$retries} time(s), Retrying in 5 seconds) \n";
                    sleep(5);
                }
            }
        });

        echo "Updated {$updatedSubscription}/{$totalCount} PayPal emails\n";

        if ($updatedSubscription != $totalCount) {
            $failedCount = $totalCount - $updatedSubscription;
            echo "{$failedCount} failed to update. Please try re-running the command\n";
        }
    }
}
