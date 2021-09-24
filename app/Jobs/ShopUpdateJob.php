<?php

namespace App\Jobs;

use Exception;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Jobs\ProcessShopifyStoreUpdate;
use App\Jobs\ProcessShopifyStorePause;
use App\Jobs\ProcessShopifyStoreClose;

class ShopUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string $shopDomain The shop's myshopify domain
     * @param object $webhook    The webhook data (JSON decoded)
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger("Shop update job logs begin");
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $shopData = json_decode(json_encode($this->data), true);
        $shop = User::withTrashed()->where('name', $this->shopDomain)->first();

        if (empty($shop)) {
            logger("Shop not found in DB: " . $this->shopDomain);
            return;
        }

        $shop->shopify_raw = json_encode($this->data);
        $shop->save();
        $mainSubscription = $shop->mainSubscription;

        // Subscription cancel on store close
        if ($shopData['plan_name'] == 'cancelled' || $shopData['plan_name'] == 'frozen') {
            dispatch(new ProcessShopifyStoreClose($mainSubscription, $shopData, $shop));
        } elseif ($shopData['plan_name'] == 'paused') {
            dispatch(new ProcessShopifyStorePause($mainSubscription, $shopData, $shop));
        } else {
            dispatch(new ProcessShopifyStoreUpdate($shop->email, $mainSubscription, $shopData, $shop));
        }

        try {
            logger('Database shop update logs begin');
            $shop->email = $this->data->email;
            $shop->name = $this->data->myshopify_domain;
            $shop->custom_domain = $this->data->domain;
            $shop->shop_update = 1;
            $shop->save();
        } catch (Exception $e) {
            logger($e->getMessage());
        }
    }
}