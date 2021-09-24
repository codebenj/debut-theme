<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Constants\ActiveCampaignConstants as AC;
use App\Jobs\ActiveCampaignJobV3;

class Shopupdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:updated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shop updated';

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
        logger("Shop update cron");
		$activeCampaign = new ActiveCampaignJobV3();
        $shops = User::whereNull('deleted_at')->get();

        foreach ($shops as $key => $shop) {
            $shopData = $shop->api()->request(
                'GET',
                '/admin/api/shop.json',
                []
            )['body'];

            if (isset($shopData['shop'])) {
                $shopData = $shopData['shop'];
            } else {
                logger("Didn't receive shop data.");
                return;
            }

            try {
                $address = array('line1' => $shopData['address1'], 'city' => $shopData['city'], 'country' => $shopData['country_name'], 'line2' => $shopData['address2'], 'postal_code' => $shopData['zip'], 'state' => $shopData['province']);
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
                $stripe_cust = \Stripe\Customer::retrieve($shop->stripe_id);

                if ($stripe_cust) {
                    if($shop->stripe_id) {
                        \Stripe\Customer::update(
                            $shop->stripe_id,
                            [
                                'email' => $shopData['email'],
                                'description' => $shop->name,
                                'name' => $shopData['shop_owner'],
                                'address' => $address,
                                'phone' => $shopData['phone']
                            ]
                        );
                    }
                }
            } catch (\Stripe\Exception\CardException $e) {
                $body = $e->getJsonBody();
                logger("Stripe error: " . json_encode($body['error']));
            } catch (\Stripe\Exception\RateLimitException $e) {
                $body = $e->getJsonBody();
                logger("Stripe error: " . json_encode($body['error']));
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                $body = $e->getJsonBody();
                logger("Stripe error: " . json_encode($body['error']));
            } catch (\Stripe\Exception\AuthenticationException $e) {
                $body = $e->getJsonBody();
                logger("Stripe error: " . json_encode($body['error']));
            } catch (\Stripe\Exception\ApiConnectionException $e) {
                $body = $e->getJsonBody();
                logger("Stripe error: " . json_encode($body['error']));
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $body = $e->getJsonBody();
                logger("Stripe error: " . json_encode($body['error']));
            } catch (\Exception $e) {
                $body = $e->getMessage();
                logger("Stripe error: " . $body);
            }

            if ($shop->trial_days > 0) {
                $subscription ='Trial';
            } else if ($shop->alladdons_plan == 'Freemium' || $shop->alladdons_plan == '') {
                $subscription = 'Freemium';
            } else {
                $subscription = $shop->alladdons_plan;
            }

            // Synchronize AC Contact Details
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
            
            $shop->email = $shopData['email'];
            $shop->name = $shopData['myshopify_domain'];
            $shop->custom_domain = $shopData['domain'];
            $shop->shop_update = 0;
            $shop->save(); 
        }
    }
}
