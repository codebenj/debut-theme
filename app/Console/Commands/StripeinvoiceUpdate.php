<?php

namespace App\Console\Commands;

use App\AddOns;
use App\ChildStore;
use App\StoreThemes;
use Illuminate\Console\Command;
use App\SubscriptionStripe;
use App\User;

class StripeinvoiceUpdate extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'invoice:update';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update stripe invoice';

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
      logger("stripe update");
      \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
      $shops = User::whereNull('deleted_at')->get();
      foreach ($shops as $key=>$shop) {
          try{
              $subscriptions = SubscriptionStripe::where('user_id',$shop->id)->whereNull('ends_at')->orderBy('id', 'desc')->first();
              if($subscriptions){
                  $stripeSubscription =  \Stripe\Subscription::retrieve($subscriptions->stripe_id);
                  if($stripeSubscription->status== 'unpaid'){
                      if($shop->alladdons_plan == 'Master'){
                          $storeCount = ChildStore::where('user_id', $shop->id)->count();
                          if($storeCount > 0){
                              $childStores = ChildStore::where('user_id', $shop->id)->get();
                              foreach ($childStores as $key => $childStore) {
                                  $shops = User::where('name', $childStore->store)->first();
                                  if($shops){
                                      $this->delete_all_addon($shops, 'child');
                                  }
                              }
                              ChildStore::where('user_id', $shop->id)->delete();
                          }
                      }

                      $this->delete_all_addon($shop, 'master');
                      //delete shop addons from themes
                      $shop->license_key=null;
                      $shop->sub_trial_ends_at=0;
                      $shop->trial_days=0;
                      $shop->alladdons_plan='Freemium';
                      $shop->sub_plan='';
                      $shop->all_addons=0;
                      $shop->master_account = null;

                      $shop->save();
                      if ($shop->subscription('main')) {
                        $shop->subscription('main')->cancelNow();
                      }
                      if($shop->script_tags){
                          deleteScriptTagCurl($shop);
                      }
                  }
              }
          } catch(\Stripe\Exception\CardException $e) {
              $body = $e->getJsonBody();
              logger("invoice:update command Stripe error: " . json_encode($body['error']));
          } catch (\Stripe\Exception\ApiErrorException $e) {
              $body = $e->getJsonBody();
              logger("invoice:update command Stripe error: " . json_encode($body['error']));
          } catch (\Stripe\Exception\RateLimitException $e) {
              $body = $e->getJsonBody();
              logger("invoice:update command Stripe error: " . json_encode($body['error']));
          } catch (\Stripe\Exception\InvalidRequestException $e) {
              $body = $e->getJsonBody();
              logger("invoice:update command Stripe error: " . json_encode($body['error']));
          } catch (\Stripe\Exception\AuthenticationException $e) {
              $body = $e->getJsonBody();
              logger("invoice:update command Stripe error: " . json_encode($body['error']));
          } catch (\Stripe\Exception\ApiConnectionException $e) {
              $body = $e->getJsonBody();
              logger("invoice:update command Stripe error: " . json_encode($body['error']));
          } catch (\Exception $e) {
              logger("invoice:update command Exception error: " . $e->getMessage());
          }
      }
  }

    // Delete all addons function as in themeController
    public function delete_all_addon($shops, $action){
        $StoreTheme = StoreThemes::where('user_id', $shops->id)->where('status', 1)->get();
        $addons = AddOns::where('user_id', $shops->id)->where('status', 1)->get();
        $checkaddon = 1;
        $update_addon= 0;
        foreach ($addons as $addon) {
            $this->deactive_addons($shops,$StoreTheme,$addon->global_id, $checkaddon, $update_addon);
            no_addon_activate_curl($StoreTheme, $shops);
            $addon->status = 0;
            $addon->shedule_time = 0;
            $addon->save();
        }
    }

    // deactivate addon function
    public function deactive_addons($shop,$StoreThemes,$addon_id,$checkaddon,$update_addon){
        if($StoreThemes){
            // remove dbtfy scripts (function in helper.php)
            if($checkaddon == 1){
                no_addon_activate($StoreThemes, $shop);
            }

            // uninstall add-ons
            switch ($addon_id) {
                case 1:
                    deactivate_trustbadge_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 2:
                    deactivate_liveview_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 3:
                    deactivate_cookibox_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 4:
                    deactivate_deliverytime_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 5:
                    deactivate_addtocart_animation_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 6:
                    deactivate_salespop_addon($StoreThemes, $shop, $checkaddon);
                    break;
                // case 7:
                //     deactivate_instagramfeed_addon($StoreThemes, $shop, $checkaddon);
                //     break;
                case 8:
                    deactivate_producttabs_addon($StoreThemes, $shop, $checkaddon, $update_addon);
                    break;
                case 9:
                    deactivate_chatbox_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 10:
                    deactivate_faqepage_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 11:
                    deactivate_sticky_addtocart_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 12:
                    deactivate_product_video_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 13:
                    deactivate_shop_protect_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 14:
                    deactivate_mega_menu_addon($StoreThemes, $shop, $checkaddon, $update_addon);
                    break;
                case 15:
                    deactivate_newsletter_popup_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 16:
                    deactivate_collection_addtocart_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 17:
                    deactivate_upsell_popup_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 18:
                    deactivate_discount_saved_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 19:
                    deactivate_sales_countdown_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 20:
                    deactivate_inventory_quantity_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 21:
                    deactivate_linked_options_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 22:
                    deactivate_cart_countdown_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 23:
                    deactivate_colorswatches_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 24:
                    deactivate_cart_discount_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 25:
                    deactivate_upsell_bundles_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 26:
                    deactivate_skip_cart_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 27:
                    deactivate_smart_search_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 28:
                    deactivate_quick_view_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 29:
                    deactivate_cart_goal_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 30:
                    deactivate_pricing_table_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 31:
                    deactivate_wish_list_addon($StoreThemes, $shop, $checkaddon);
                    break;
                case 32:
                    deactivate_quantity_breaks_addon($StoreThemes, $shop, $checkaddon);
                    break;
            }
        }
    }
}
