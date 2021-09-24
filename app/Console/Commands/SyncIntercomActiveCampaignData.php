<?php

namespace App\Console\Commands;

use App\User;
use Exception;
use Illuminate\Console\Command;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;
use Intercom\IntercomClient;

class SyncIntercomActiveCampaignData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activecampaign-intercom:sync {batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Intercom and Active Campaign Data from Debutify database';

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
        $this->info("Intercom and ActiveCampaign Data Synchronization Started");
        $batch =$this->argument('batch');
        $multiplier = 10000;
        $max = $batch * $multiplier;
        $min = $max - $multiplier;
        $this->info("Executing command for {$min}-{$max} users");
        $activeCampaign = new ActiveCampaignJobV3();
        $query = User::skip($min)
            ->take($multiplier)
            ->whereNull('deleted_at')
            ->where('password', '!=', '')
            ->latest()
            ->get();
        $updatedCount = 0;
        $totalCount = $query->count();
        $this->info("Total of {$totalCount} shops remaining to be synced.");

        $query->each(function($shop, $key) use(&$updatedCount, $activeCampaign) {
            $this->comment("#{$key} Synchronizing {$shop->name}");

            $retries = 0;
            $shouldRetry = true;

            while ($shouldRetry && $retries < 2) {
                usleep(500000);

                try {
                    $shopData = getShopCurl($shop);

                    if (!$shopData) {
                        throw new Exception("Cannot fetch shop data (Domain {$shop->name})\n");
                    }

                    if ($shop->trial_days > 0) {
                        $subscription ='Trial';
                    } else if ($shop->alladdons_plan == 'Freemium' || $shop->alladdons_plan == '' || $shop->alladdons_plan == null) {
                        $subscription = 'Freemium';
                    } else {
                        $subscription = $shop->alladdons_plan;
                    }

                    $activeCampaignContact = $activeCampaign->customSync([
                        'email' => $shopData['email'],
                        'firstName' => getName($shopData['shop_owner'], 'first'),
                        'lastName' => getName($shopData['shop_owner'], 'last'),
                        'phone' => $shopData['phone'],
                        'fieldValues' => [
                            ['field' => AC::FIELD_ID, 'value' => $shopData['id']],
                            ['field' => AC::FIELD_PAYPAL_EMAIL, 'value' => $shop->paypalSubscription()->active()->first() ? $shop->paypalSubscription()->active()->first()->paypal_email : ''],
                            ['field' => AC::FIELD_APP_STATUS, 'value' => 'Installed'],
                            ['field' => AC::FIELD_WEBSITE, 'value' => $shopData['myshopify_domain']],
                            ['field' => AC::FIELD_COMPANY, 'value' => $shopData['domain']],
                            ['field' => AC::FIELD_COUNTRY, 'value' => $shopData['country_name']],
                            ['field' => AC::FIELD_CITY, 'value' => $shopData['city']],
                            ['field' => AC::FIELD_ZIP, 'value' => $shopData['zip']],
                            ['field' => AC::FIELD_ADDRESS_LINE_1, 'value' => $shopData['address1']],
                            ['field' => AC::FIELD_ADDRESS_LINE_2, 'value' => $shopData['address2']],
                            ['field' => AC::FIELD_PROVINCE, 'value' => $shopData['province']],
                            ['field' => AC::FIELD_LANGUAGE, 'value' => $shopData['primary_locale']],
                            ['field' => AC::FIELD_STORE_NAME, 'value' => $shopData['name']],
                        ]
                    ]);

                    $activeCampaignSubscription = collect($activeCampaignContact['fieldValues'])->first(function($fieldValues) {
                        return $fieldValues['field'] == AC::FIELD_SUBSCRIPTION;
                    })['value'];

                    if ($activeCampaignSubscription != $subscription) {
                        $message = "Subscription mismatch for {$shop->name} (App: {$subscription}, AC: {$activeCampaignSubscription})";
                        $this->warn($message);
                        logger($message);
                        logger($shop);

                        $activeCampaign->sync([
                            'email' => $shopData['email'],
                            'fieldValues' => [
                                ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $subscription],
                            ]
                        ]);
                    }

                    $client = new IntercomClient(config('env-variables.INTERCOM_TOKEN'));
                    $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopData['id']];
                    $contact = $client->contacts->search([
                        'pagination' => ['per_page' => 1],
                        'query' => $query,
                        'sort' => ['field' => 'name', 'order' => 'ascending'],
                    ]);
                
                    if ($contact->total_count) {
                        $client->contacts->update($contact->data[0]->id, [
                            'custom_attributes' => [
                                'First Name' => getName($shopData['shop_owner'], 'first'),
                                'Last Name' => getName($shopData['shop_owner'], 'last'),
                                'Paypal Email' => $shop->paypalSubscription()->active()->first() ? $shop->paypalSubscription()->active()->first()->paypal_email : '',
                                'App Status' => 'Installed',
                                'Subscription' => $subscription,
                                'Theme Billing' => $shop->sub_plan,
                                'Store Website' => $shopData['domain'],
                                'Store Shopify' => $shopData['myshopify_domain'],
                                'Store Name' => $shopData['name'],
                                'Country' => $shopData['country_name'],
                                'City' => $shopData['city'],
                                'ZIP' => $shopData['zip'],
                                'Address Line 1' => $shopData['address1'],
                                'Address Line 2' => $shopData['address2'],
                                'Province' => $shopData['province'],
                                'Language' => $shopData['primary_locale'],
                            ],
                        ]);
                    }

                    $shop->shop_id = $shopData['id'];
                    $shop->active_campaign_and_intercom_synced = true;
                    $shop->save();
                    $updatedCount++;
                    $shouldRetry = false;
                } catch(\Exception $e) {
                    echo $e->getMessage();
                    $shouldRetry = true;
                    $retries++;
                    $this->error("Failed (Tried: {$retries} time(s))");
                }
            }
        });


        $this->info("Updated {$updatedCount}/{$totalCount}");

        if ($updatedCount != $totalCount) {
            $failedCount = $totalCount - $updatedCount;
            $this->warn("{$failedCount} failed to update. Please try re-running the command");
        }
    }
}
