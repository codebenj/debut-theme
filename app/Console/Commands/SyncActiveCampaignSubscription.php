<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;

class SyncActiveCampaignSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activecampaign:sync-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize active campaign contact subscription';

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
        $this->info("SyncActiveCampaignSubscription Started");
        $activeCampaign = new ActiveCampaignJobV3();
        $dateStart  = '2021-06-03 00:00:00';
        $query = User::where('created_at', '>=', $dateStart)
            ->where(function($query) {
                return $query->where('alladdons_plan', 'Freemium')
                    ->orWhere('alladdons_plan', '')
                    ->orWhereNull('alladdons_plan');
            });

        $updatedSubscription = 0;
        $totalCount = $query->count();
        $this->info("Found {$totalCount} Freemium subscriptions");

        $query->each(function($shop) use(&$updatedSubscription, $activeCampaign) {
            $this->comment("Synchronizing {$shop->email}");

            $retries = 0;
            $shouldRetry = true;

            while ($shouldRetry && $retries < 5) {
                try {
                    $activeCampaign->sync([
                        'email' => $shop->email,
                        'fieldValues' => [
                            ['field' => AC::FIELD_SUBSCRIPTION, 'value' => 'Freemium'],
                        ]
                    ]);

                    $updatedSubscription++;
                    $shouldRetry = false;
                    sleep(2);
                } catch(\Exception $e) {
                    echo $e->getMessage();
                    $shouldRetry = true;
                    $retries++;
                    $this->error("Failed (Tried: {$retries} time(s), Retrying in 5 seconds)");
                    sleep(5);
                }
            }
        });

        $this->info("Updated {$updatedSubscription}/{$totalCount} subscriptions");

        if ($updatedSubscription != $totalCount) {
            $failedCount = $totalCount - $updatedSubscription;
            $this->warn("{$failedCount} failed to update. Please try re-running the command");
        }
    }
}
