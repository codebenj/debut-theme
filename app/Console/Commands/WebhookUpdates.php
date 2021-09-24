<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class WebhookUpdates extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'shop:WebhookUpdate';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Update shop webhooks where needed';

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
        try{
            $shops = User::whereNull('deleted_at')->orderBy('id', 'DESC')->get();
            foreach ($shops as $key=>$shop) {
                try{
                    $webhooks = getShopWebhooksCurl($shop);

                    if(isset($webhooks['errors'])){
                        continue;
                    }

                    $shop_webhooks = array();
                    if(!empty($webhooks))
                    {
                        foreach($webhooks as $webhook){
                            if(isset($webhook['topic']) && !empty($webhook['topic'])){
                                $shop_webhooks[] = $webhook['topic'];
                            }
                        }
                    }

                    // adding app uninstalled webhook
                    if(!in_array('app/uninstalled', $shop_webhooks)){
                        $json_data = json_encode(
                            array('webhook' =>
                                array(
                                    'topic' => 'app/uninstalled',
                                    'address' => config('env-variables.SHOPIFY_WEBHOOK_1_ADDRESS'),
                                    'format' => 'json'
                                )
                            )
                        );
                        addShopWebhooksCurl($shop, $json_data);
                        $this->info("Webhook added ::: app/uninstalled ::: for " . $shop->name);
                        logger('app uninstalled webhook added');
                    }

                    // adding app theme delete webhook
                    if(!in_array('themes/delete', $shop_webhooks)){
                        $json_data = json_encode(
                            array('webhook' =>
                                array(
                                    'topic' => 'themes/delete',
                                    'address' => config('env-variables.SHOPIFY_WEBHOOK_2_ADDRESS'),
                                    'format' => 'json'
                                )
                            )
                        );
                        addShopWebhooksCurl($shop, $json_data);
                        $this->info("Webhook added ::: themes/delete ::: for " . $shop->name);
                    }

                    // adding app theme update
                    if(!in_array('themes/update', $shop_webhooks)){
                        $json_data = json_encode(
                            array('webhook' =>
                                array(
                                    'topic' => 'themes/update',
                                    'address' => config('env-variables.SHOPIFY_WEBHOOK_3_ADDRESS'),
                                    'format' => 'json'
                                )
                            )
                        );
                        addShopWebhooksCurl($shop, $json_data);
                        $this->info("Webhook added ::: themes/update ::: for " . $shop->name);
                    }

                    // adding app theme create
                    if(!in_array('themes/create', $shop_webhooks)){
                        $json_data = json_encode(
                            array('webhook' =>
                                array(
                                    'topic' => 'themes/create',
                                    'address' => config('env-variables.SHOPIFY_WEBHOOK_4_ADDRESS'),
                                    'format' => 'json'
                                )
                            )
                        );
                        addShopWebhooksCurl($shop, $json_data);
                        $this->info("Webhook added ::: themes/create ::: for " . $shop->name);
                    }

                    // adding app shop update
                    if(!in_array('shop/update', $shop_webhooks)){
                        $json_data = json_encode(
                            array('webhook' =>
                                array(
                                    'topic' => 'shop/update',
                                    'address' => config('env-variables.SHOPIFY_WEBHOOK_5_ADDRESS'),
                                    'format' => 'json'
                                )
                            )
                        );
                        addShopWebhooksCurl($shop, $json_data);
                        $this->info("Webhook added ::: shop/update ::: for " . $shop->name);
                    }
                }
                catch(\Exception $e){
                    $this->error( 'Shop error: ' . $shop->name . ' -> ' . $e->getMessage() );
                }

            }
            $this->info( '************** shopify webhook update complete ***************');
        }
        catch(\Exception $e){
            $this->error( 'shopify_webhook:update ' . $e->getMessage() );
        }
    }
}
