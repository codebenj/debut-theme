<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\StoreThemes;
class ThemeCreated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:created';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Theme Created';

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
        $store_themes = StoreThemes::where('status', 1)->get();
        foreach ($store_themes as $key => $theme) {
            $shop = User::whereNull('deleted_at')->where('id', $theme->user_id)->first();
            if($shop){
                logger($shop->name);
                $JS_url = 'http://dev.debutify.com/js/dbtfy.js';
        // remove dbtfy-js in theme.liquid
            try{

                $theme_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body'];

                if(isset($theme_file['asset']))
                {
                    $theme_file = $theme_file['asset']['value'];
                }  else {
                    logger("Didn't receive asset data.");
                    return;
                }

                if( ( $pos = strrpos( $theme_file , $JS_url) ) !== false ) {
                    $updated_theme = str_replace( '<script src="'.$JS_url.'" async defer></script>' , '' , $theme_file );
                    logger('Remove http JS file '.$theme->shopify_theme_id);
                    $updated_theme_file = $shop->api()->request(
                      'PUT',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                      ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Remove http JS file throws client exception');
            }
            catch(\Exception $e){
                logger('Remove http JS file throws exception');
            }
        }
    }
        // $store_themes = StoreThemes::where('status', 0)->get();

        // foreach ($store_themes as $key => $theme) {
        //     $shop = User::whereNull('deleted_at')->where('id', $theme->user_id)->first();

        //     $updateStoreTheme = StoreThemes::find($theme->id);
        //     //$updateStoreTheme->status = 1;
        //    if($shop){
        //     //return $this->getTheme($shop,$theme,$updateStoreTheme);
        //         try {
        //             $schema = $shop->api()->request(
        //                                     'GET',
        //                                     '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                     ['asset' => ['key' => 'config/settings_schema.json'] ]
        //                                 )->body->asset->value;

        //             if( ( $pos = strrpos( $schema , 'debutify' ) ) !== false || ( $pos = strrpos( $schema , 'Debutify' ) ) !== false ) {
        //                     $updateStoreTheme->status = 1;
        //                     $updateStoreTheme->save();
        //                      logger('theme create shop'.$shop->name);
        //             }else{
        //                 $updateStoreTheme->delete();
        //                 logger('theme Delete shop'.$shop->name);
        //             }
        //         } catch(\GuzzleHttp\Exception\ClientException $e){
        //                 logger('theme created chron throws exception');
        //                // sleep(30);
        //               //  $this->getTheme($shop,$theme,$updateStoreTheme);
        //         }
        //    }
        // }

        // $store_themes = StoreThemes::where('status', 1)->get();
        // foreach ($store_themes as $key => $theme) {
        //     $shop = User::whereNull('deleted_at')->where('id', $theme->user_id)->first();
        //     if($shop){
        //         $activated_addons = AddOns::where('user_id',$shop->id)->where('status',1)->count();
        //         if($activated_addons > 0)
        //         {
        //             $url = config('app.url');
        //             $JS_url = $url.'/js/dbtfy.js';
        //             try {
        //                 $theme_file = $shop->api()->request(
        //                                             'GET',
        //                                             '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                             ['asset' => ['key' => 'layout/theme.liquid'] ]
        //                                         )->body->asset->value;

        //                 if( ( $jsPos = strpos( $theme_file , '/js/dbtfy.js' ) ) === false ) {
        //                     if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
        //                         $updated_theme = str_replace( '</head>' , '<script src="'.$JS_url.'" async defer></script></head>' , $theme_file );

        //                         $updated_theme_file = $shop->api()->request(
        //                                                 'PUT',
        //                                                 '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                 ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
        //                                             );
        //                     }
        //                 }
        //             }
        //             catch(\GuzzleHttp\Exception\ClientException $e){
        //                     logger('add JS file throws client exception');
        //                     sleep(15);
        //                     try{
        //                     $theme_file = $shop->api()->request(
        //                                                 'GET',
        //                                                 '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                 ['asset' => ['key' => 'layout/theme.liquid'] ]
        //                                             )->body->asset->value;

        //                     if( ( $jsPos = strpos( $theme_file , '/js/dbtfy.js') ) === false ) {
        //                         if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
        //                             $updated_theme = str_replace( '</head>' , '<script src="'.$JS_url .'" async defer></script></head>' , $theme_file );

        //                             $updated_theme_file = $shop->api()->request(
        //                                                     'PUT',
        //                                                     '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                     ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
        //                                                 );
        //                         }
        //                     }
        //                 }catch(\GuzzleHttp\Exception\ClientException $e){
        //                     logger('add JS file throws client exception1');
        //                  }
        //                 catch(\Exception $e){
        //                     logger('add JS file throws client exception2');
        //                 }
        //             }
        //             catch(\Exception $e){
        //                     logger('add JS file throws exception');
        //                     sleep(15);
        //                     $theme_file = $shop->api()->request(
        //                                                 'GET',
        //                                                 '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                 ['asset' => ['key' => 'layout/theme.liquid'] ]
        //                                             )->body->asset->value;

        //                     if( ( $jsPos = strpos( $theme_file , '/js/dbtfy.js' ) ) === false ) {
        //                         if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
        //                             $updated_theme = str_replace( '</head>' , '<script src="'.$JS_url .'" async defer></script></head>' , $theme_file );

        //                             $updated_theme_file = $shop->api()->request(
        //                                                     'PUT',
        //                                                     '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                     ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
        //                                                 );
        //                         }
        //                     }
        //             }

        //             // Add JS on theme.js
        //             try{
        //                 $themeJS_file = $shop->api()->request(
        //                                             'GET',
        //                                             '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                             ['asset' => ['key' => 'assets/theme.js.liquid'] ]
        //                                         )->body->asset->value;

        //                // $JS_url = "'https://debutify.com/storage/js/debutify.js'";
        //                 $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';

        //                 if( ( $jsPos = strpos( $themeJS_file , '/js/dbtfy.js'  ) ) === false ) {
        //                         $updated_themeJS = str_replace( $themeJS_file , $themeJS_file.$themejs , $themeJS_file );

        //                         $updated_themeJS_file = $shop->api()->request(
        //                                                 'PUT',
        //                                                 '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                 ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
        //                                             );
        //                 }
        //             }
        //             catch(\GuzzleHttp\Exception\ClientException $e){
        //                     logger('Update theme.js file throws client exception');
        //                     sleep(15);
        //                     try{
        //                     $themeJS_file = $shop->api()->request(
        //                                                 'GET',
        //                                                 '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                 ['asset' => ['key' => 'assets/theme.js.liquid'] ]
        //                                             )->body->asset->value;

        //                    // $JS_url = "'https://debutify.com/storage/js/debutify.js'";
        //                     $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';

        //                     if( ( $jsPos = strpos( $themeJS_file , '/js/dbtfy.js'  ) ) === false ) {
        //                             $updated_themeJS = str_replace( $themeJS_file , $themeJS_file.$themejs , $themeJS_file );

        //                             $updated_themeJS_file = $shop->api()->request(
        //                                                     'PUT',
        //                                                     '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                     ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
        //                                                 );
        //                     }
        //                 }catch(\GuzzleHttp\Exception\ClientException $e){
        //                     logger('Update theme.js file throws client exception1');
        //                  }
        //                 catch(\Exception $e){
        //                     logger('Update theme.js file throws client exception2');
        //                 }
        //             }
        //             catch(\Exception $e){
        //                     logger('Update theme.js file throws exception');
        //                     sleep(15);
        //                     $themeJS_file = $shop->api()->request(
        //                                                 'GET',
        //                                                 '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                 ['asset' => ['key' => 'assets/theme.js.liquid'] ]
        //                                             )->body->asset->value;

        //                     //$JS_url = "'https://debutify.com/storage/js/debutify.js'";
        //                     $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';

        //                     if( ( $jsPos = strpos( $themeJS_file , '/js/dbtfy.js' ) ) === false ) {
        //                             $updated_themeJS = str_replace( $themeJS_file , $themeJS_file.$themejs , $themeJS_file );

        //                             $updated_themeJS_file = $shop->api()->request(
        //                                                     'PUT',
        //                                                     '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
        //                                                     ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
        //                                                 );
        //                     }
        //             }
        //         }
        //     }
        // }
    }

    public function getTheme($shop,$theme,$updateStoreTheme)
    {
        try {
                $schema = $shop->api()->request(
                                        'GET',
                                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                                        ['asset' => ['key' => 'config/settings_schema.json'] ]
                                    )['body'];
                if (isset($schema['asset'])) {
                    $schema = $schema['asset']['value'];
                }
                if( ( $pos = strrpos( $schema , 'debutify' ) ) !== false || ( $pos = strrpos( $schema , 'Debutify' ) ) !== false ) {
                        $updateStoreTheme->save();
                            logger('theme create shop'.$shop->name);
                }else{
                    $updateStoreTheme->delete();
                    logger('theme Delete shop'.$shop->name);
                }
            } catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('theme created chron throws exception');
                   // sleep(30);
                  //  $this->getTheme($shop,$theme,$updateStoreTheme);
            }
    }
}
