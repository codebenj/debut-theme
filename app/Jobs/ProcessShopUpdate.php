<?php

namespace App\Jobs;

use App\User;
use App\AddOns;
use App\StoreThemes;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessShopUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $shop;
    protected $theme_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $shop, $theme_id)
    {
        $this->shop = $shop;
        $this->theme_id = $theme_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger(json_encode($this->shop));
        logger(json_encode($this->theme_id));
            sleep(5);

            // install active add-ons on new theme
            $activated_addons = AddOns::where('user_id', $this->shop->id)->where('status', 1)->get();
            $delivery_addon_activated = 0;
            $update_addon = 0;
            foreach ($activated_addons as $key=>$addon) {
                $this->active_addons($addon->global_id, $this->theme_id, $update_addon, $key);
            }
    }
    public function active_addons($addon_id, $themes_id, $update_addon, $key){
        $shop = $this->shop;
        $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('shopify_theme_id', $themes_id)->where('status', 1)->get();
        $delivery_addon_activated = AddOns::where('user_id',$shop->id)->where('global_id', 4)->where('status',1)->count();
        $addon_count = AddOns::where('user_id', $shop->id)->where('status', 1)->count();
        $StoreThemes=[];

        foreach ($StoreTheme as $theme) {
            try{
                $get_theme = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'.json'
                )['body']['theme'];
                $StoreThemes[] = $theme;
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on live view addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on live view addon throws exception');
            }
        }

        if($StoreThemes){
            // add dbtfy scripts (function in helper.php)
            if($key == 0){
              add_debutify_JS($StoreThemes, $shop);
              sleep(2);
              addScriptTag($shop);
              sleep(2);
              removeServerJS($StoreThemes, $shop);
            }

            // activate add-ons
            switch ($addon_id) {
                case 1:
                    activate_trustbadge_addon($StoreThemes, $shop);
                    break;
                case 2:
                    activate_liveview_addon($StoreThemes, $shop, $delivery_addon_activated);
                    break;
                case 3:
                    activate_cookibox_addon($StoreThemes, $shop);
                    break;
                case 4:
                    activate_deliverytime_addon($StoreThemes, $shop);
                    break;
                case 5:
                    activate_addtocart_animation_addon($StoreThemes, $shop);
                    break;
                case 6:
                    activate_salespop_addon($StoreThemes, $shop);
                    break;
                case 7:
                    activate_instagramfeed_addon($StoreThemes, $shop);
                    break;
                case 8:
                    if($update_addon == 1){}else{
                      activate_producttab_addon($StoreThemes, $shop);
                    }
                    break;
                case 9:
                    activate_chatbox_addon($StoreThemes, $shop);
                    break;
                case 10:
                    activate_faqepage_addon($StoreThemes, $shop);
                    break;
                case 11:
                    activate_sticky_addtocart_addon($StoreThemes, $shop);
                    break;
                case 12:
                    activate_product_video_addon($StoreThemes, $shop);
                    break;
                case 13:
                    activate_shop_protect_addon($StoreThemes, $shop);
                    break;
                case 14:
                    if($update_addon == 1){}else{
                      activate_mega_menu_addon($StoreThemes, $shop);
                    }
                    break;
                case 15:
                    activate_newsletter_popup_addon($StoreThemes, $shop);
                    break;
                case 16:
                    activate_collection_addtocart_addon($StoreThemes, $shop);
                    break;
                case 17:
                    activate_upsell_popup_addon($StoreThemes, $shop);
                    break;
                case 18:
                    activate_discount_saved_addon($StoreThemes, $shop);
                    break;
                case 19:
                    activate_sales_countdown_addon($StoreThemes, $shop);
                    break;
                case 20:
                    activate_inventory_quantity_addon($StoreThemes, $shop);
                    break;
                case 21:
                    activate_linked_options_addon($StoreThemes, $shop);
                    break;
                case 22:
                    activate_cart_countdown_addon($StoreThemes, $shop);
                    break;
            }
        }
    }
}
