<?php

namespace App\Console\Commands;

use App\User;
use App\MainSubscription;
use App\SubscriptionPaypal;
use App\SubscriptionStripe;
use Illuminate\Console\Command;
use App\Jobs\ActiveCampaignJobV3;
use Illuminate\Support\Facades\Storage;
use App\Constants\ActiveCampaignConstants as AC;

class ActiveCampaignSyncThemeBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activecampaign:sync-themebilling';

    protected $failed_users = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronize Theme Billing field on Active Campaign';

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
        $this->info("ActiveCampaignSyncThemeBilling started.");

        $count = 0;

        $batch = 1000;

        User::withTrashed()->chunk($batch, function ($users) use (&$count, $batch)
        {
            $local_count = $count;

            $this->info("Syncing users from " . ($local_count+1) . " to " . ($local_count + (count($users) <= $batch  ? count($users) : $batch)));

            foreach ($users as $user)
            {
                if ($user->all_addons == 1)
                {
                    $cycle = null;

                    if (
                        optional($user->mainSubscription)->payment_platform == MainSubscription::PAYMENT_PLATFORM_STRIPE &&
                        optional($user->stripeSubscription)->stripe_status == SubscriptionStripe::ACTIVE
                    )
                    {
                        $cycle = optional(optional($user->stripeSubscription)->plan)->cycle;
                    }
                    elseif (
                        optional($user->mainSubscription)->payment_platform == MainSubscription::PAYMENT_PLATFORM_PAYPAL &&
                        optional($user->paypalSubscription)->paypal_status == SubscriptionPaypal::ACTIVE
                    )
                    {
                        $cycle = optional(optional($user->paypalSubscription)->plan)->cycle;
                    }

                    if ($cycle)
                    {
                        $this->info("Syncing User ID: {$user->id} Theme Billing: {$cycle}");

                        $this->syncActiveCampaign($user, [
                            [
                                'field' => AC::FIELD_THEME_BILLING, 'value' => $cycle
                            ]
                        ]);
                    }
                }
                else
                {
                    if ($user->deleted_at)
                    {
                        $this->info("Syncing Inactive User ID: {$user->id} APP STATUS, SUBSCRIPTION");

                        $this->syncActiveCampaign($user, [
                            [
                                'field' => AC::FIELD_APP_STATUS, 'value' => AC::FIELD_VALUE_APP_STATUS_UNINSTALLED,
                            ],
                            [
                                'field' => AC::FIELD_SUBSCRIPTION, 'value' => AC::FIELD_VALUE_SUBSCRIPTION_FREEMIUM,
                            ]
                        ]);
                    }
                }
            }

            $count += $batch;
        });

        if (count($this->failed_users))
        {
            $date = now()->unix();
            $file_log = "active_campaign/sync_theme_billing_failed_users-{$date}.log";
            $this->error("Writing user failed logs to {$file_log}");
            Storage::disk('local')->put($file_log, implode(",",$this->failed_users));
        }

        $this->info("ActiveCampaignSyncThemeBilling ended.");
    }

    private function syncActiveCampaign($user, $fields)
    {
        $activeCampaign = new ActiveCampaignJobV3;
        $retries = 0;
        $shouldRetry = true;

        while ($shouldRetry && $retries < 5)
        {
            try
            {
                $activeCampaign->sync([
                    'email' => $user->email,
                    'fieldValues' => $fields
                ]);

                $shouldRetry = false;
                sleep(1);
            }
            catch (\Throwable $th)
            {
                $this->error($th->getMessage());
                $shouldRetry = true;
                $retries++;

                $this->error("Failed (Tried: {$retries} time(s), Retrying in 5 seconds)");

                if ($retries >= 5)
                {
                    $this->failed_users[] = $user->id;
                }
                else
                {
                    sleep(2);
                }
            }
        }
    }
}
