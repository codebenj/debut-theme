<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Constants\ActiveCampaignConstants as AC;
use App\Jobs\ActiveCampaignJobV3;

class ActiveCampaignMissingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:ActiveCampaignMissingData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Active Campaign Missing Data';

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
        $this->info("Active Campaign Missing Data Command Started");
		$activeCampaign = new ActiveCampaignJobV3();
        $dateStart  = '2020-08-25 00:00:00';
        $shops = User::whereNull('deleted_at')->where('created_at', '>', $dateStart)->get();

        foreach ($shops as $shop) {
            try {
                sleep(1);
                $shopData = getShopCurl($shop);

                if (!$shopData) {
                    continue;
                }

                if ($shop->trial_days > 0) {
                    $subscription ='Trial';
                } else if ($shop->alladdons_plan == 'Freemium' || $shop->alladdons_plan == '') {
                    $subscription = 'Freemium';
                } else {
                    $subscription = $shop->alladdons_plan;
                }

                $contact = $activeCampaign->sync([
                    'email' => $shopData['email'],
                    'firstName' => getName($shopData['shop_owner'], 'first'),
                    'lastName' => getName($shopData['shop_owner'], 'last'),
                    'phone' => $shopData['phone'],
                    'fieldValues' => [
                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $subscription],
                        ['field' => AC::FIELD_COMPANY, 'value' => $shopData['domain']],
                        ['field' => AC::FIELD_APP_STATUS, 'value' => 'Installed'],
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

                $this->info('Active Campaign Updated: ' . $shop->name);
            } catch(\Exception $e) {
                $this->error($e->getMessage());
            }
        }

        $this->info("");
        $this->info("");
        $this->info("Active Campaign Data Update from: " . $dateStart . ' till now.');
    } 
}