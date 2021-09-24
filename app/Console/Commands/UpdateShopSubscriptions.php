<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\SubscriptionStripe;
use App\Taxes;

class UpdateShopSubscriptions extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'shop:subscriptions';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update canada shop subscriptions';

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
    $shops = User::whereNull('deleted_at')->get();

    foreach ($shops as $shop) {
      try{
        sleep(1);
        $shopData = getShopCurl($shop);

        $tax_rates = array();
        if($shopData['country_name'] == 'Canada'){

          $tax = Taxes::where('region',$shopData['province'])->first();
          if($tax){
            $tax_id = $tax->stripe_taxid;
          }else{
            $tax = Taxes::where('region','New-Brunswick')->first();
            $tax_id = $tax->stripe_taxid;
          }

          $tax_rates[] = $tax_id;
          $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
          if($subscription){
            try{
              \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

              $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);

              if (empty($subscription_stripe->default_tax_rates)) {
                $update_subscription = \Stripe\Subscription::update($subscription->stripe_id, [
                  'cancel_at_period_end' => false,
                  'items' => [
                    [
                      'id' => $subscription_stripe->items->data[0]->id,
                      'plan' => $subscription_stripe->plan->id,
                    ],
                  ],
                  'default_tax_rates' => $tax_rates,
                ]);

                $this->info('Tax updated for: ' . $shop->name);
                logger('Tax updated for: ' . $shop->name);
                sleep(1);
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
          }
        }
      }
      catch (\Exception $e) {
        error_log('*********** ' . $e->getMessage() . ' ***********');
      }
    }
    $this->info("all canada shops subscriptions taxes now up to date");
  }
}
