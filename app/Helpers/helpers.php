<?php

use App\ChildStore;
use App\StoreThemes;
use App\MainSubscription;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use App\SubscriptionStripe;
use App\SubscriptionPaypal;
use App\StripePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Stripe\Exception\ApiErrorException;
use App\Jobs\ActiveCampaignJobV3;
use App\Constants\ActiveCampaignConstants as AC;


// remove dbtfy scripts when add-ons become == 0
if (! function_exists('no_addon_activate')) {
    function no_addon_activate($StoreThemes, $shop) {
        foreach ($StoreThemes as $theme) {
          $url = config('app.url');
          $JS_url = $url.'/js/dbtfy.js';

            // remove dbtfy-adons.js.liquid in theme.liquid
            try{
                $theme_file1_get = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body'] ;

                if(!isset($theme_file1_get['asset']['value']))
                {
                    continue;
                }
                else
                {
                    $theme_file1 = $theme_file1_get['asset']['value'];
                }

                $addon_js = "{{ 'dbtfy-addons.js' | asset_url }}";
                if( ( $pos1 = strrpos( $theme_file1 , $addon_js ) ) !== false ) {

                    $updated_theme1 = str_replace( '{%- if content_for_header contains "debutify" -%}<script src="'.$addon_js.'" defer="defer"></script>{%- endif -%} <!-- Header hook for plugins ================================================== -->' , '<!-- Header hook for plugins ================================================== -->' , $theme_file1 );

                    $updated_theme1 = str_replace( '<script src="{{ \'dbtfy-addons.js\' | asset_url }}" defer="defer"></script>' , '' , $updated_theme1 );

                    logger('Remove debutify-addons.js called for: ' . $shop->name);

                    sleep(5);

                    $updated_theme_file = $shop->api()->request(
                      'PUT',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                      ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme1] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Remove debutify-addons js theme lquid file throws client exception');
            }
            catch(\Exception $e){
                logger('Remove debutify-addons js theme lquid file throws exception: ' . $e->getMessage());
            }

            // remove dbtfy-addons.js.liquid asset
            try{
              $delete_debutify_addon = $shop->api()->request(
                  'DELETE',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
              );
            }
                catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Delete debutify-addons js throws client exception');
            }
            catch(\Exception $e){
                logger('Delete debutify-addons js throws exception');
            }

            // remove dbtfy-js in theme.liquid
            try{
                $theme_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strrpos( $theme_file , '/js/dbtfy.js') ) !== false ) {
                    $updated_theme = str_replace( '<script src="'.$JS_url.'" async defer></script></head>' , '</head>' , $theme_file );

                    $updated_theme_file = $shop->api()->request(
                      'PUT',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                      ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add JS file throws client exception');
            }
            catch(\Exception $e){
                logger('add JS file throws exception');
            }

            // remove dbtfy.js in theme.js.liquid
            try{
                $themeJS_file = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                      ['asset' => ['key' => 'assets/theme.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';
                if( ( $jsPos = strpos( $themeJS_file , $JS_url  ) ) !== false ) {
                    $updated_themeJS = str_replace( $themejs , ' ' , $themeJS_file );
                    $updated_themeJS_file = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                  logger('add JS file throws client exception');
            }
            catch(\Exception $e){
                  logger('add JS file throws exception');
            }
        }

        // Removing script tag as well
        deleteScriptTag($shop);
    }
}

// remove dbtfy scripts when add-ons become == 0
if (! function_exists('no_addon_activate_curl')) {
    function no_addon_activate_curl($StoreThemes, $shop) {
        foreach ($StoreThemes as $theme) {

            if($theme->version != '2.0.2')
            {
                continue;
            }

            $url = config('app.url');
            $JS_url = $url.'/js/dbtfy.js';

            $addon_js = "{{ 'dbtfy-addons.js' | asset_url }}";

            // remove dbtfy-adons.js.liquid in theme.liquid
            try{
                //logger('Came in to no_addon_activate_curl');
                $theme_file1 = getThemeFileCurl($shop, $theme, 'layout/theme.liquid') ?? '';

                if( ( $pos1 = strrpos( $theme_file1 , "{{ 'dbtfy-addons.js' | asset_url }}" ) ) !== false ) {
                    $updated_theme1 = str_replace( '{%- if content_for_header contains "debutify" -%}<script src="'.$addon_js.'" defer="defer"></script>{%- endif -%} <!-- Header hook for plugins ================================================== -->' , '<!-- Header hook for plugins ================================================== -->' , $theme_file1 );

                    $updated_theme1 = str_replace( '<script src="{{ \'dbtfy-addons.js\' | asset_url }}" defer="defer"></script>' , '' , $theme_file1 );

                    $updated_theme_file = putThemeFileCurl($shop, $theme, $updated_theme1, 'layout/theme.liquid');
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Remove debutify-addons js theme lquid file throws client exception');
            }
            catch(\Exception $e){
                logger('Remove debutify-addons js theme lquid file throws exception');
            }

            // remove dbtfy-addons.js.liquid asset
            try{
              $delete_debutify_addon = deleteThemeFilesCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid');
            }
                catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Delete debutify-addons js throws client exception');
            }
            catch(\Exception $e){
                logger('Delete debutify-addons js throws exception');
            }

            // remove dbtfy-js in theme.liquid
            try{
                $theme_file = getThemeFileCurl($shop, $theme, 'layout/theme.liquid');

                if( ( $pos = strrpos( $theme_file , '/js/dbtfy.js') ) !== false ) {
                    $updated_theme = str_replace( '<script src="'.$JS_url.'" async defer></script></head>' , '</head>' , $theme_file );

                    $updated_theme_file = putThemeFileCurl($shop, $theme, $updated_theme, 'layout/theme.liquid');
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add JS file throws client exception');
            }
            catch(\Exception $e){
                logger('add JS file throws exception');
            }

            // remove dbtfy.js in theme.js.liquid
            try{
                $themeJS_file = getThemeFileCurl($shop, $theme, 'assets/theme.js.liquid') ?? '';

                $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';
                if( ( $jsPos = strpos( $themeJS_file , $JS_url  ) ) !== false ) {
                    $updated_themeJS = str_replace( $themejs , ' ' , $themeJS_file );
                    $updated_themeJS_file = putThemeFileCurl($shop, $theme, $updated_themeJS, 'assets/theme.js.liquid');
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                  logger('add JS file throws client exception');
            }
            catch(\Exception $e){
                  logger('add JS file throws exception');
            }
        }

        // Removing script tag as well
        deleteScriptTag($shop);
    }
}

// add dbtfy-addons.js.liquid
if (! function_exists('add_debutify_JS')) {
    function add_debutify_JS($StoreThemes, $shop) {
        $url = config('app.url');
        $JS_url = $url.'/js/dbtfy.js';

        foreach ($StoreThemes as $theme) {
            // add dbtfy-addons.js.liquid asset
            $check_addon = false;

            $dbtfy_addons = (string) "/* start-dbtfy-addons *//* start-register */$(document).ready(function(){ var sections = new theme.Sections(); });/* end-register */";
            try {
                /* Add all addon JS */
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register */" ) ) === false ) {
                    try {
                        $create_trustbadge_snippet = $shop->api()->request(
                            'PUT',
                            '/admin/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $dbtfy_addons] ]
                        );

                    }catch(\GuzzleHttp\Exception\ClientException $e){
                        logger('add all addon js throws client exception');
                    }
                    catch(\Exception $e){
                        logger('add all addon js throws exception');
                    }
                    $check_addon = true;
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add JS file code throws client exception');
                try {
                    $create_trustbadge_snippet = $shop->api()->request(
                        'PUT',
                        '/admin/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $dbtfy_addons] ]
                    );
                    $check_addon = true;
                }
                catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('add all addon js throws client exception in catch');
                }
                catch(\Exception $e){
                    logger('add all addon js throws exception in catch');
                }
            }
            catch(\Exception $e){
                logger('add JS file code throws exception');
                try {
                    $create_trustbadge_snippet = $shop->api()->request(
                        'PUT',
                        '/admin/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $dbtfy_addons] ]
                    );
                    $check_addon = true;
                }
                catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('add all addon js throws client exception in catch');
                }
                catch(\Exception $e){
                    logger('add all addon js throws exception in catch');
                }
            }

            // add dbtfy-addons.js.liquid in theme.liquid
            $theme_file = "";
            $addon_js = "{{ 'dbtfy-addons.js' | asset_url }}";
            if($check_addon){
                try {
                    logger("dbtify-addon ".$addon_js);
                    $theme_file = $shop->api()->request(
                        'GET',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'layout/theme.liquid'] ]
                    )['body']['asset']['value'] ?? '';
                    if( ( $jsPos = strpos( $theme_file , $addon_js ) ) === false ) {
                        if( ( $pos = strrpos( $theme_file , '<!-- Header hook for plugins ================================================== -->' ) ) !== false ) {

                            $updated_theme = str_replace( '<!-- Header hook for plugins ================================================== -->' , '{%- if content_for_header contains "debutify" -%}<script src="{{ \'dbtfy-addons.js\' | asset_url }}" defer="defer"></script>{%- endif -%} <!-- Header hook for plugins ================================================== -->' , $theme_file );
                            $updated_theme_file = $shop->api()->request(
                                  'PUT',
                                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                                  ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                              );
                        }
                    }
                }
                catch(\GuzzleHttp\Exception\ClientException $e){
                    logger('add debutify JS file theme.liquid throws client exception');
                    if( ( $jsPos = strpos( $theme_file , $addon_js ) ) === false ) {
                        if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
                            $updated_theme = str_replace( '</head>' , '<script src="'.$addon_js.'" defer="defer"></script></head>' , $theme_file );
                            $updated_theme_file = $shop->api()->request(
                                  'PUT',
                                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                                  ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                              );
                        }
                    }
                }
                    catch(\Exception $e){
                    logger('add JS file theme.liquid throws exception');
                }
            }
        }
    }
}

// add dbtfy.js script on theme.liquid & theme.js.liquid
if (! function_exists('addServerJS')) {
    function addServerJS($StoreThemes, $shop) {
        $url = config('app.url');
        $JS_url = $url.'/js/dbtfy.js';
        foreach ($StoreThemes as $theme) {

            // add dbtfy.js on theme.liquid
            try {
                $theme_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';
                if( ( $jsPos = strpos( $theme_file , '/js/dbtfy.js') ) === false ) {
                    if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
                        $updated_theme = str_replace( '</head>' , '<script src="'.$JS_url.'" async defer></script></head>' , $theme_file );

                        $updated_theme_file = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add JS file throws client exception');
                sleep(5);
                $theme_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $jsPos = strpos( $theme_file , '/js/dbtfy.js'  ) ) === false ) {
                    if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
                        $updated_theme = str_replace( '</head>' , '<script src="'.$JS_url .'" async defer></script></head>' , $theme_file );
                        $updated_theme_file = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                        );
                    }
                }
            }
            catch(\Exception $e){
                logger('add JS file throws exception');
                sleep(5);
                $theme_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $jsPos = strpos( $theme_file , '/js/dbtfy.js' ) ) === false ) {
                    if( ( $pos = strrpos( $theme_file , '</head>' ) ) !== false ) {
                        $updated_theme = str_replace( '</head>' , '<script src="'.$JS_url .'" async defer></script></head>' , $theme_file );

                        $updated_theme_file = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                        );
                    }
                }
            }

            // add dbtfy.js on theme.js
            try{
                $themeJS_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';

                if( ( $jsPos = strpos( $themeJS_file , '/js/dbtfy.js'  ) ) === false ) {
                    $updated_themeJS = str_replace( $themeJS_file , $themeJS_file.$themejs , $themeJS_file );

                    $updated_themeJS_file = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Update theme.js file throws client exception');
                sleep(10);
                $themeJS_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';

                if( ( $jsPos = strpos( $themeJS_file , '/js/dbtfy.js'  ) ) === false ) {
                    $updated_themeJS = str_replace( $themeJS_file , $themeJS_file.$themejs , $themeJS_file );

                    $updated_themeJS_file = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
                    );
                }
            }
            catch(\Exception $e){
                logger('Update theme.js file throws exception');
                sleep(10);
                $themeJS_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';

                if( ( $jsPos = strpos( $themeJS_file , '/js/dbtfy.js' ) ) === false ) {
                    $updated_themeJS = str_replace( $themeJS_file , $themeJS_file.$themejs , $themeJS_file );

                    $updated_themeJS_file = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
                    );
                }
            }

        }
    }
}



// remove server dbtfy.js
if (! function_exists('removeServerJS')) {
    function removeServerJS($StoreThemes, $shop) {
        $url = config('app.url');
        $JS_url = $url.'/js/dbtfy.js';
        foreach ($StoreThemes as $theme) {
            try{
                $theme_file = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strrpos( $theme_file , '/js/dbtfy.js') ) !== false ) {
                    $updated_theme = str_replace( '<script src="'.$JS_url.'" async defer></script>' , '' , $theme_file );

                    $updated_theme_file = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'layout/theme.liquid', 'value' => $updated_theme] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add JS file throws client exception');
            }
            catch(\Exception $e){
                logger('add JS file throws exception');
            }

            sleep(3);

            try{
                $themeJS_file = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                      ['asset' => ['key' => 'assets/theme.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $themejs = (string) 'function appendScript(filepath){ if($(\' head script[src="'.$JS_url.'"] \').length > 0){ return; } var ele = document.createElement("script");ele.setAttribute("defer", "defer");ele.setAttribute("src", filepath);$("head").append(ele);} appendScript("'.$JS_url.'");';
                if( ( $jsPos = strpos( $themeJS_file , $JS_url  ) ) !== false ) {
                    $updated_themeJS = str_replace( $themejs , '' , $themeJS_file );
                    $updated_themeJS_file = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.js.liquid', 'value' => $updated_themeJS] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                  logger('add JS file throws client exception');
            }
            catch(\Exception $e){
                  logger('add JS file throws exception');
            }
        }
    }
}



//get shop data by custom call when shop/user is not logged in
if (! function_exists('getShopCurl')) {
    function getShopCurl($shop){
        try{
            $apiKey = config('shopify-app.api_key');
            $apiVersion = config('shopify-app.api_version');
            $token = $shop->password;
            $shopUrl = $shop->name;

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/shop.json';

            $shopcurl = curl_init();
            curl_setopt($shopcurl, CURLOPT_URL, $url);
            curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
            curl_setopt($shopcurl, CURLOPT_HEADER, 1);
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec ($shopcurl);
            curl_close ($shopcurl);
            list($header, $body) = explode("\r\n\r\n", $response, 2);
            $shop = json_decode($body, true)['shop'];
            return $shop;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}



//get shop settings schema by custom call when shop/user is not logged in
if (! function_exists('getThemeFileCurl')) {
    function getThemeFileCurl($shop, $theme, $file){
        try{
            $apiKey = config('shopify-app.api_key');
            $apiVersion = config('shopify-app.api_version');
            $token = $shop->password;
            $shopUrl = $shop->name;

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/themes/'.$theme->shopify_theme_id.'/assets.json?asset[key]='.$file;

            //logger($url);

            $shopcurl = curl_init();
            curl_setopt($shopcurl, CURLOPT_URL, $url);
            curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
            curl_setopt($shopcurl, CURLOPT_HEADER, 1);
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec ($shopcurl);
            curl_close ($shopcurl);
            list($header, $body) = explode("\r\n\r\n", $response, 2);
            return json_decode($body, true)['asset']['value'];
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}



//put shop settings schema by custom call when shop/user is not logged in
if (! function_exists('putThemeFileCurl')) {
    function putThemeFileCurl($shop, $theme, $updated_schema, $file){
        try{
            $apiKey = config('shopify-app.api_key');
            $apiVersion = config('shopify-app.api_version');
            $token = $shop->password;
            $shopUrl = $shop->name;

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/themes/'.$theme->shopify_theme_id.'/assets.json';

            $data_json=json_encode(
                array('asset' =>
                    array(
                        'key' => $file, 'value' => $updated_schema
                    )
                )
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_json)));
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}



//put shop style by custom call when shop/user is not logged in
if (! function_exists('deleteThemeFilesCurl')) {
    function deleteThemeFilesCurl($shop, $theme, $file){
        try {
            $apiKey = config('shopify-app.api_key');
            $apiVersion = config('shopify-app.api_version');
            $token = $shop->password;
            $shopUrl = $shop->name;

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/themes/'.$theme->shopify_theme_id.'/assets.json?asset[key]='.$file;

            $shopcurl = curl_init();
            curl_setopt($shopcurl, CURLOPT_URL, $url);
            curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
            curl_setopt($shopcurl, CURLOPT_HEADER, 1);
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec ($shopcurl);
            curl_close ($shopcurl);
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}



//get shop's registered webhooks
if (! function_exists('getShopWebhooksCurl')) {
    function getShopWebhooksCurl($shop){
        try{
            $apiKey = config('shopify-app.api_key');
            $apiVersion = config('shopify-app.api_version');
            $token = $shop->password;
            $shopUrl = $shop->name;

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/webhooks.json';

            $shopcurl = curl_init();
            curl_setopt($shopcurl, CURLOPT_URL, $url);
            curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
            curl_setopt($shopcurl, CURLOPT_HEADER, 1);
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec ($shopcurl);
            curl_close ($shopcurl);
            list($header, $body) = explode("\r\n\r\n", $response, 2);
            $shop = json_decode($body, true);
            if(isset($shop['webhooks'])){
                $shop = $shop['webhooks'];
            }

            return $shop;
        }
        catch(Exception $e)
        {
            return $e->getMessage();
        }
    }
}


//put shop settings schema by custom call when shop/user is not logged in
if (! function_exists('addShopWebhooksCurl')) {
    function addShopWebhooksCurl($shop, $webhook){
        try{
            $apiKey = config('shopify-app.api_key');
            $apiVersion = config('shopify-app.api_version');
            $token = $shop->password;
            $shopUrl = $shop->name;

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/webhooks.json';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($webhook)));
            curl_setopt($ch, CURLOPT_VERBOSE, 0);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS,$webhook);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        catch(Exception $e)
        {
            return false;
        }
    }
}

// check if store owner allowed script tags
if (! function_exists('scriptTagPermission')) {
    function scriptTagPermission($shop) {

        $url = config('app.url');
        $tag_url = $url.'/js/debutify_script_tags.js';

        $script_tags = $shop->api()->request(
            'GET',
            'admin/api/script_tags.json'
        )['body'];

        if(isset($script_tags['script_tags'])) {
            return true;
        }

        $apiKey = config('shopify-app.api_key');
        $scopes = config('shopify-app.api_scopes');
        $redirectUri = config('shopify-app.api_redirect');
        $token = $shop->password;
        $shopUrl = $shop->name;

        $installUrl = "https://" . $shopUrl . "/admin/oauth/authorize?client_id=" . $apiKey . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirectUri);

        header('Location: ' . $installUrl);
        die();
    }
}


// redirect link for reauthentication
if (! function_exists('scriptTagPermissionRedirectURL')) {
    function scriptTagPermissionRedirectURL($shop) {

        $apiKey = config('shopify-app.api_key');
        $scopes = config('shopify-app.api_scopes');
        $redirectUri = config('shopify-app.api_redirect');
        $token = $shop->password;
        $shopUrl = $shop->name;

        $installUrl = "https://" . $shopUrl . "/admin/oauth/authorize?client_id=" . $apiKey . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirectUri);

        return $installUrl;
    }
}



// add script tag for addons
if (! function_exists('addScriptTag')) {
    function addScriptTag($shop) {
        $url = config('app.url');
        $tag_url = $url.'/js/debutify_script_tags.js';
        $starter_tag_url = $url.'/js/debutify_starter_script_tags.js';
        $hustler_tag_url = $url.'/js/debutify_hustler_script_tags.js';

        // dont install script tags for free users or where trial is expired
        if($shop->alladdons_plan != 'Starter' && $shop->alladdons_plan != 'Hustler' && $shop->alladdons_plan != 'Master' && $shop->trial_days < 1 ) {
            return true;
        }

        $script_tags = $shop->api()->request(
            'GET',
            'admin/api/script_tags.json'
        )['body'] ?? '';

        if($shop->alladdons_plan == 'Starter') {
            $has_tags = false;

            if(isset($script_tags['script_tags'])) {
                $script_tags = $script_tags['script_tags'];
                foreach ($script_tags as $script_tag) {
                    if(stripos($script_tag->src, 'debutify_starter_script_tags') !== false) {
                        $has_tags = true;
                    }

                    if(stripos($script_tag->src, 'debutify_script_tags') !== false) {
                        try{
                            $script_tags = $shop->api()->request(
                                'DELETE',
                                'admin/api/script_tags/' . $script_tag->id . '.json'
                            )['body'];
                        }
                        catch(\Exception $e){
                            logger('script tag delete exception');
                        }
                    }

                    if(stripos($script_tag->src, 'debutify_hustler_script_tags') !== false) {
                        try{
                            $script_tags = $shop->api()->request(
                                'DELETE',
                                'admin/api/script_tags/' . $script_tag->id . '.json'
                            )['body'];
                        }
                        catch(\Exception $e){
                            logger('script tag delete exception');
                        }
                    }


                }
            }

            if(!$has_tags){
                try {
                    $script_tag_data = array(
                        "script_tag" => array(
                            "cache" => true,
                            "event" => "onload",
                            "src" => $starter_tag_url
                        )
                    );
                    $add_script_tag = $shop->api()->request(
                        'POST',
                        "/admin/api/script_tags.json",
                        $script_tag_data
                    );
                }
                catch(\Exception $e) {
                    logger('Script tag adding exception: ' . $e->getMessage() );
                }
            }
        }elseif ($shop->alladdons_plan == 'Hustler') {
            $has_tags = false;

            if(isset($script_tags['script_tags'])) {
                $script_tags = $script_tags['script_tags'];
                foreach ($script_tags as $script_tag) {
                    if(stripos($script_tag->src, 'debutify_hustler_script_tags') !== false) {
                        $has_tags = true;
                    }

                    if(stripos($script_tag->src, 'debutify_script_tags') !== false) {
                        try{
                            $script_tags = $shop->api()->request(
                                'DELETE',
                                'admin/api/script_tags/' . $script_tag->id . '.json'
                            )['body'];
                        }
                        catch(\Exception $e){
                            logger('script tag delete exception');
                        }
                    }

                    if(stripos($script_tag->src, 'debutify_starter_script_tags') !== false) {
                        try{

                            $script_tags = $shop->api()->request(
                                'DELETE',
                                'admin/api/script_tags/' . $script_tag->id . '.json'
                            )['body'];
                        }
                        catch(\Exception $e){
                            logger('script tag delete exception');
                        }
                    }


                }
            }

            if(!$has_tags){
                try {
                    $script_tag_data = array(
                        "script_tag" => array(
                            "cache" => true,
                            "event" => "onload",
                            "src" => $hustler_tag_url
                        )
                    );
                    $add_script_tag = $shop->api()->request(
                        'POST',
                        "/admin/api/script_tags.json",
                        $script_tag_data
                    );
                }
                catch(\Exception $e) {
                    logger('Script tag adding exception: ' . $e->getMessage() );
                }
            }

        }
        else {
            $has_tags = false;
            if(isset($script_tags['script_tags'])) {
                $script_tags = $script_tags['script_tags'];
                foreach ($script_tags as $script_tag) {
                    if(stripos($script_tag->src, 'debutify_script_tags') !== false) {
                        $has_tags = true;
                    }

                    if(stripos($script_tag->src, 'debutify_starter_script_tags') !== false) {
                        try{
                            $script_tags = $shop->api()->request(
                                'DELETE',
                                'admin/api/script_tags/' . $script_tag->id . '.json'
                            )['body'];
                        }
                        catch(\Exception $e){
                            logger('script tag delete exception');
                        }
                    }
                    if(stripos($script_tag->src, 'debutify_hustler_script_tags') !== false) {
                        try{
                            $script_tags = $shop->api()->request(
                                'DELETE',
                                'admin/api/script_tags/' . $script_tag->id . '.json'
                            )['body'];
                        }
                        catch(\Exception $e){
                            logger('script tag delete exception');
                        }
                    }

                }
            }

            if(!$has_tags){
                try {
                    $script_tag_data = array(
                        "script_tag" => array(
                            "cache" => true,
                            "event" => "onload",
                            "src" => $tag_url
                        )
                    );
                    $add_script_tag = $shop->api()->request(
                        'POST',
                        "/admin/api/script_tags.json",
                        $script_tag_data
                    );
                }
                catch(\Exception $e) {
                    logger('Script tag adding exception: ' . $e->getMessage() );
                }
            }
        }
    }
}

// add script tag for addons curl
if (! function_exists('addScriptTagCurl')) {
    function addScriptTagCurl($shop, $child = false) {

        // dont install script tags for free users or where trial is expired
        if(!$child && $shop->alladdons_plan != 'Starter' && $shop->alladdons_plan != 'Hustler' && $shop->alladdons_plan != 'Master' && $shop->trial_days < 1)
        {
            return true;
        }

        $apiKey = config('shopify-app.api_key');
        $apiVersion = config('shopify-app.api_version');
        $token = $shop->password;
        $shopUrl = $shop->name;

        $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags.json';
        $response = commonCurlRequest($url,"GET",$query= null,['Content-Type: application/json'],'Get script tag data Curl Error');

        if(isset($response['script_tags']))
        {

            $scriptTags = $response['script_tags'];
            $appUrl = config('app.url');

            if($shop->alladdons_plan == 'Starter')
            {
                processTags($apiKey, $apiVersion,$token,$shopUrl,'debutify_starter_script_tags',$scriptTags, $appUrl.'/js/debutify_starter_script_tags.js');
            }
            elseif ($shop->alladdons_plan == 'Hustler')
            {
                processTags($apiKey, $apiVersion,$token,$shopUrl,'debutify_hustler_script_tags',$scriptTags, $appUrl.'/js/debutify_hustler_script_tags.js');
            }
            else
            {
                processTags($apiKey, $apiVersion,$token,$shopUrl,'debutify_script_tags',$scriptTags, $appUrl.'/js/debutify_script_tags.js');
            }
        }
        return;
    }
}



if (! function_exists('processTags')) {
    function processTags($apiKey, $apiVersion,$token,$shopUrl,$currentTag,$scriptTags, $scriptTagUrl) {

        $hasTags = false;

        if(isset($scriptTags)) {
            foreach ($scriptTags as $scriptTag) {

                if(stripos($scriptTag['src'],$currentTag) !== false) {
                    $hasTags = true;
                }
                else if(stripos($scriptTag['src'], $currentTag) !== true) {

                    $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags/' . $scriptTag['id'] . '.json';
                    commonCurlRequest($url,'DELETE',$query= null,['Content-Type: application/json'],'Delete script tag Curl Error');
                }
            }
        }

        if(!$hasTags) {

            $query = [
                "script_tag" => [
                    "event" => "onload",
                    "src" => $scriptTagUrl
                    ]
                ];

            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags.json';

            return commonCurlRequest($url,"POST",$query,[],'Add script tag Curl Error');
        }
        return;
    }
}


 // common function to make curl requests
if (! function_exists('commonCurlRequest')) {
    function commonCurlRequest($url, $method, $query=null, $headers=[], $loggerMessage=null) {

        try{
            // Configure cURL
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, TRUE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($curl, CURLOPT_MAXREDIRS, 3);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_VERBOSE, 0);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            if (in_array($method, array('POST', 'PUT'))) {
                if (is_array($query)) $query = http_build_query($query);
                curl_setopt ($curl, CURLOPT_POSTFIELDS, $query);
            }

            // Send request and capture any errors
            $response = curl_exec($curl);
            $errorMessage = curl_error($curl);
            curl_close($curl);

            if(!empty($errorMessage)) {
                return ['error' => $errorMessage];
            }

            list($header, $body) = explode("\r\n\r\n", $response, 2);
            $result = json_decode($body, true);
            return $result;

        }
        catch(\GuzzleHttp\Exception\ClientException $e) {
            logger($loggerMessage.' :' . $e->getMessage());
            return ['error' => $errorMessage];
        }
        catch(\Exception $e) {
            logger($loggerMessage.' :'  . $e->getMessage() );
            return ['error' => $errorMessage];
        }
    }
}

// delete script tag for addons
if (! function_exists('deleteScriptTag')) {
    function deleteScriptTag($shop) {

        $script_tags = $shop->api()->request(
            'GET',
            'admin/api/script_tags.json'
        );
        if(isset($script_tags['body']['script_tags'])) {
            $script_tags = $script_tags['body']['script_tags'];
            foreach ($script_tags as $script_tag) {
                if(stripos($script_tag->src, 'debutify_script_tags') !== false) {
                    try{
                        $script_tags = $shop->api()->request(
                            'DELETE',
                            'admin/api/script_tags/' . $script_tag->id . '.json'
                        )['body'];
                    }catch(\GuzzleHttp\Exception\ClientException $e){
                        logger('script tag delete exception');
                    }
                    catch(\Exception $e){
                        logger('script tag delete exception');
                    }
                }

                if(stripos($script_tag->src, 'debutify_starter_script_tags') !== false) {
                    try{
                        $script_tags = $shop->api()->request(
                            'DELETE',
                            'admin/api/script_tags/' . $script_tag->id . '.json'
                        )['body'];
                    }catch(\GuzzleHttp\Exception\ClientException $e){
                        logger('script tag delete exception');
                    }
                    catch(\Exception $e){
                        logger('script tag delete exception');
                    }
                }
            }
        }
        else {
            deleteScriptTagCurl($shop);
        }
    }
}


// delete script tag for addons curl
if (! function_exists('deleteScriptTagCurl')) {
    function deleteScriptTagCurl($shop) {

        $apiKey = config('shopify-app.api_key');
        $apiVersion = config('shopify-app.api_version');
        $token = $shop->password;
        $shopUrl = $shop->name;

        try{
            $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags.json';

            $shopcurl = curl_init();
            curl_setopt($shopcurl, CURLOPT_URL, $url);
            curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
            curl_setopt($shopcurl, CURLOPT_HEADER, 1);
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec ($shopcurl);
            curl_close ($shopcurl);
            list($header, $body) = explode("\r\n\r\n", $response, 2);
            $shop = json_decode($body, true);
            $script_tags = $shop['script_tags'];
        }
        catch(Exception $e){
            return false;
        }

        foreach ($script_tags as $script_tag) {
            if(stripos($script_tag['src'], 'debutify_script_tags') !== false) {
                try{

                    $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags/' . $script_tag['id'] . '.json';

                    $shopcurl = curl_init();
                    curl_setopt($shopcurl, CURLOPT_URL, $url);
                    curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
                    curl_setopt($shopcurl, CURLOPT_HEADER, 1);
                    curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec ($shopcurl);
                    curl_close ($shopcurl);

                }
                catch(\Exception $e){
                    logger('script tag delete exception');
                }
            }

            if(stripos($script_tag['src'], 'debutify_starter_script_tags') !== false) {
                try{

                    $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags/' . $script_tag['id'] . '.json';

                    $shopcurl = curl_init();
                    curl_setopt($shopcurl, CURLOPT_URL, $url);
                    curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
                    curl_setopt($shopcurl, CURLOPT_HEADER, 1);
                    curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec ($shopcurl);
                    curl_close ($shopcurl);

                }
                catch(\Exception $e){
                    logger('script tag delete exception');
                }
            }

            if(stripos($script_tag['src'], 'debutify_hustler_script_tags') !== false) {
                try{

                    $url = 'https://'.$apiKey.':'.$token.'@'.$shopUrl.'/admin/api/'.$apiVersion.'/script_tags/' . $script_tag['id'] . '.json';

                    $shopcurl = curl_init();
                    curl_setopt($shopcurl, CURLOPT_URL, $url);
                    curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
                    curl_setopt($shopcurl, CURLOPT_HEADER, 1);
                    curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
                    $response = curl_exec ($shopcurl);
                    curl_close ($shopcurl);

                }
                catch(\Exception $e){
                    logger('script tag delete exception');
                }
            }

        }
    }
}


// add debutify tag script condition in code
if (! function_exists('addScriptTagCondition')) {
    function addScriptTagCondition($shop, $condition_text, $string_code, $newAdd = false) {
        $return_string = $string_code;
        if($shop->script_tags) {

            if($newAdd){
                $value = str_replace($condition_text , '{%- if content_for_header contains "debutify" -%} '. $condition_text.' {%- endif -%} ', $string_code);
                $return_string = (string) $value;
            }
            else{
                if(str_contains($string_code, $condition_text)) {
                    $value = str_replace($condition_text , '
                        ' . $condition_text . '
                        {%- if content_for_header contains "debutify" -%}
                        ', $string_code);
                    $value .= '
                    {%- endif -%}';
                    $return_string = (string) $value;
                }
            }

        }
        return $return_string;
    }
}

if (!function_exists('setTrialDays')) {
    function setTrialDays(User $shop, $trial_days = null, $initialSetup = false) {
        if ($shop->trial_ends_at == null && $shop->sub_trial_ends_at == 0 && !$initialSetup) {
            return;
        }

        $current_date = new DateTime();
        $formatted_current_date = $current_date->format('Y-m-d');
        if ($trial_days != null) {
            // Manually set user's trial_ends_at && trial_days
            $trial_ends_at = date('Y-m-d', strtotime($formatted_current_date.' + '.$trial_days.' days'));
            $shop->trial_ends_at = $trial_ends_at;

            if ($trial_days > 0) {
                $shop->sub_trial_ends_at = 1;
                $shop->trial_check = 0;
                $shop->license_key = Hash::make(Str::random(12));

            } else {
                $shop->license_key = null;
                $shop->alladdons_plan = 'Freemium';

                if ($shop->script_tags) {
                    deleteScriptTagCurl($shop);
                }
            }
        } else {
            // Automatically set trial_days based on user's trial_ends_at
            $trial_ends_at = new DateTime($shop->trial_ends_at);
            $formatted_trial_ends_at = $trial_ends_at->format('Y-m-d');

            if ($formatted_current_date < $formatted_trial_ends_at) {
                $shop->sub_trial_ends_at = 1;
                $shop->license_key = Hash::make(Str::random(12));
                $diff_trial = strtotime($formatted_current_date) - strtotime($formatted_trial_ends_at);
                $trial_days = abs(round($diff_trial / 86400));
            } else {
                $shop->sub_trial_ends_at = 0;
                $shop->license_key = null;
                $trial_days = 0;

                if ($shop->script_tags){
                    deleteScriptTagCurl($shop);
                }
            }
        }

        $shop->trial_days = $trial_days;
        $shop->save();
        if ($shop->script_tags)
        {
            addScriptTagCurl($shop);
        }
    }
}

// Pause subscription for webhooks
if (!function_exists('pauseSubscription')) {
    function pauseSubscription($shop){
        logger('Enter pause subscription function');
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $next_month_date = strtotime("next Month");
        $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
        try {
            $subscription_stripe = \Stripe\Subscription::retrieve($subscription->stripe_id);
        } catch (ApiErrorException $e) {}
        if(isset($subscription->stripe_id) && !empty($subscription->stripe_id)){
            try {
                $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                    'pause_collection' => [
                        'behavior' => 'mark_uncollectible',
                    ],
                ]);
            } catch (ApiErrorException $e) {
                logger('Error message: ' . $e);
            }

            if(isset($sub->id) && !empty($sub->id) && isset($sub->billing_cycle_anchor)){

                $shop->is_paused = 1;
                $data_pause = ['plan_name' => $shop->alladdons_plan, 'sub_plan' => $shop->sub_plan];
                $shop->pause_subscription =  serialize($data_pause);
                $shop->save();
                app('App\Http\Controllers\ThemeController')->pause_all_addon($shop, 'master');
            }
        }
    }
}

// Unpause subscription for webhooks
if (!function_exists('unpauseSubscription')) {
    function unpauseSubscription($shop){
        logger('Unpause Subscrition function');
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $activeCampaign = new ActiveCampaignJobV3();
        $plan = unserialize($shop->pause_subscription);
        $subscription = SubscriptionStripe::where('user_id',$shop->id)->orderBy('id', 'desc')->first();
        if(isset($subscription->stripe_id) && !empty($subscription->stripe_id)) {
            try {
                $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                    'pause_collection' => '',
                ]);
            } catch (ApiErrorException $e) {}
            if (isset($sub->id) && !empty($sub->id)) {
                app('App\Http\Controllers\ThemeController')->unpause_all_addon($shop, 'master');
                $shop->all_addons = 1;
                $shop->alladdons_plan = $plan['plan_name'];
                $shop->sub_plan = $plan['sub_plan'];
                $license_key = Hash::make(Str::random(12));
                $shop->license_key = $license_key;
                $shop->is_paused = 0;
                $shop->pause_subscription = null;
                if ($shop->script_tags) {
                    addScriptTag($shop);
                }
                $shop->save();
                $contact = $activeCampaign->sync([
                    'email' => $shop->email
                ]);
                $contactTag = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_SHOPIFY_STORE_PAUSED);

                if ($contactTag) {
                    $untag = $activeCampaign->untag($contactTag['id']);
                }
            }
            logger("You've unpaused subscription successfully.");
        }
    }
}


// cancel subscription function
if (!function_exists('cancelSubscription')) {
    function cancelSubscription($shop, $callFetchInitialData = true)
    {
        if ($callFetchInitialData) {
            app('App\Http\Controllers\ThemeController')->fetchInitialData();
        }

         $plan = $shop->alladdons_plan;
        $StoreTheme = StoreThemes::where('user_id', $shop->id)->where('status', 1)->get();

        if ($shop->alladdons_plan == 'Master') {
            $shop->master_account = null;
            $store_count = ChildStore::where('user_id', $shop->id)->count();
            if ($store_count > 0) {
                $child_stores = ChildStore::where('user_id', $shop->id)->get();
                foreach ($child_stores as $key => $child_store) {
                    $shops = User::where('name', $child_store->store)->first();
                    if ($shops) {
                        app('App\Http\Controllers\ThemeController')->delete_all_addon($shops, 'child');
                    }
                }
                $child_store_d = ChildStore::where('user_id', $shop->id)->delete();
            }
        }
        //delete shop addons from themes
        app('App\Http\Controllers\ThemeController')->delete_all_addon($shop, 'master');

        if ($callFetchInitialData) {
            try {
                logger("cancel all subscription");

                $stripeSubs = SubscriptionStripe::where('user_id',$shop->id)->where('stripe_status','active')->get();

                if ($stripeSubs) {
                    foreach ($stripeSubs as $singleStripeSub) {
                        cancelStripeSubscription($singleStripeSub);
                    }
                }

                logger("cancel all stripe subscription completed");

                if ($shop->subscription('main')) {
                    $shop->subscription('main')->cancelNow();
                }
            } catch (Exception $e) {
                $e->getMessage();
            }

            \Cookie::queue(\Cookie::forget('discount-code'));
            logger("Your subscription has been cancelled.");
        }
    }
}
if(!function_exists('isCurrentSubscriptionDiscounted')) {
    function isCurrentSubscriptionDiscounted()
    {
        $mainSub = \App\MainSubscription::where('user_id', auth()->user()->id)->first();
        if ($mainSub->payment_platform == \App\MainSubscription::PAYMENT_PLATFORM_STRIPE) {
            try {
                $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                $sub_id = SubscriptionStripe::where('user_id', auth()->user()->id)
                    ->where('stripe_status', 'active')
                    ->first('stripe_id');
                $stripe_subs = $stripe->subscriptions->retrieve($sub_id->stripe_id);
                return str_contains($stripe_subs->discount->coupon->id, 'ONEMONTHFREECANCEl');
            } catch (\Stripe\Error\Card $e) {
                logger("Since it's a decline, \Stripe\Error\Card will be caught");
                return "invalid coupon code";
            } catch (\Stripe\Error\RateLimit $e) {
                logger("Too many requests made to the API too quickly");
                return "invalid coupon code";
            } catch (\Stripe\Error\InvalidRequest $e) {
                logger("Invalid parameters were supplied to Stripe's API");
                return "invalid coupon code";
            } catch (\Stripe\Error\Authentication $e) {
                logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                return "invalid coupon code";
            } catch (\Stripe\Error\ApiConnection $e) {
                logger("Network communication with Stripe failed");
                return "invalid coupon code";
            } catch (\Stripe\Error\Base $e) {
                logger("Display a very generic error to the user, and maybe send yourself an email");
                return "invalid coupon code";
            } catch (Exception $e) {
                logger("Something else happened, completely unrelated to Stripe");
                logger($e->getMessage());
                return "invalid coupon code";
            }

        }
        return false;
    }
}
if (!function_exists('getSubscription')) {
    function getSubscription(User $user){
        try{
            $mainSub = $user->mainSubscription->payment_platform;
            if($mainSub=="paypal")
            {
                return $user->paypalSubscription;
            }
            if($mainSub=="stripe")
            {
                return $user->stripeSubscription;
            }
        }catch (Exception $e){
            return null;
        }
    }
}
if(!function_exists('getPaypalUrl')) {
    function getPaypalUrl($url){
        $paypalUrl =  config('env-variables.PAYPAL_MODE')=='live' ? config('env-variables.PAYPAL_LIVE_URL') : config('env-variables.PAYPAL_SANDBOX_URL');
        $paypalUrl = trim($paypalUrl);
        if(substr($paypalUrl,-1,1)=="/")
        {
            $paypalUrl = rtrim($paypalUrl);
        }
        $url = trim($url);
        if(substr($url,1,1)=="/")
        {
            $url = ltrim($url);
        }
        return $paypalUrl."/".$url;
    }
}
if(!function_exists('getPaypalAccessToken')) {
    function getPaypalAccessToken($clientId,$clientSecret)
    {
        if (Cache::has('paypal_token')){
            logger("paypal_token added in cache 1 -------------------". Cache::get('paypal_token'));
            return Cache::get('paypal_token');
        }

        $curl = curl_init();
        $generateBase64 = base64_encode($clientId.':'.$clientSecret);

        curl_setopt_array($curl, array(
            CURLOPT_URL => getPaypalUrl('v1/oauth2/token'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic $generateBase64",
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        if($response)
        {
            logger("paypal_token added in cache 2 ----". json_encode($response));
            $responseDecode = json_decode($response);
            Cache::put('paypal_token', $responseDecode->access_token, ($responseDecode->expires_in - 600));
            return $responseDecode->access_token;
        }
    }
}
if(!function_exists('getPaypalHttpClient')){
    function getPaypalHttpClient(){
        $paypalClient = "";
        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $paypalClient = Http::withToken(getPaypalAccessToken(config('env-variables.PAYPAL_SANDBOX_CLIENT_ID'),config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET')));
        }
        if(config('env-variables.PAYPAL_MODE')=='live'){
            $paypalClient = Http::withToken(getPaypalAccessToken(config('env-variables.PAYPAL_LIVE_CLIENT_ID'),config('env-variables.PAYPAL_LIVE_CLIENT_SECRET')));
        }
        logger("paypal_token added in cache 3 ----". json_encode($paypalClient));
        return $paypalClient;
    }
}
if(!function_exists('getPaymentPlatform')){
    function getPaymentPlatform(){
        $stripe_payment = new App\SubscriptionStripe();
        $paypal_payment = new App\SubscriptionPaypal();
        $current_sub_platform = getSubscription(Auth::user());
        if($current_sub_platform)
        {
            if($current_sub_platform instanceof $stripe_payment)
            {
                return 'stripe';
            }
            if($current_sub_platform instanceof $paypal_payment)
            {
                return 'paypal';
            }
        }
        return null;
    }
}
if(!function_exists('cancelStripeSubscription')){
    function cancelStripeSubscription(SubscriptionStripe $stripe_subscription){
        logger('Subscription Stripe data before cancellation. '.json_encode($stripe_subscription));
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
        try {
            $stripeResponse = $stripe->subscriptions->cancel($stripe_subscription->stripe_id);
            $stripe_subscription->stripe_status = $stripeResponse->status;
            $stripe_subscription->save();
        }
        catch(\Stripe\Error\Card $e) {
            logger("Since it's a decline, \Stripe\Error\Card will be caught");
            return "invalid coupon code";
        } catch (\Stripe\Error\RateLimit $e) {
            logger("Too many requests made to the API too quickly");
            return "invalid coupon code";
        } catch (\Stripe\Error\InvalidRequest $e) {
            logger("Invalid parameters were supplied to Stripe's API");
            return "invalid coupon code";
        } catch (\Stripe\Error\Authentication $e) {
            logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
            return "invalid coupon code";
        } catch (\Stripe\Error\ApiConnection $e) {
            logger("Network communication with Stripe failed");
            return "invalid coupon code";
        } catch (\Stripe\Error\Base $e) {
            logger("Display a very generic error to the user, and maybe send yourself an email");
            return "invalid coupon code";
        } catch (Exception $e) {
            logger("Something else happened, completely unrelated to Stripe");
            return "invalid coupon code";
        }
        logger('Subscription Stripe data after cancellation. '.json_encode($stripe_subscription));
    }
}
if(!function_exists('isSubscriptionEndingSoon')){
    function isSubscriptionEndingSoon($noOfDays){
        $payment_platform = getPaymentPlatform();
        $today = Carbon\Carbon::today();
        $checkExpiryDate = $today->copy()->addDays((int) $noOfDays);
        if($payment_platform == \App\MainSubscription::PAYMENT_PLATFORM_STRIPE){
            $stripeSub = SubscriptionStripe::where('user_id',Auth::user()->id)->where('stripe_status','active')->first();
            if($stripeSub){
                try {
                    $stripe = new \Stripe\StripeClient(config('services.stripe.secret'));
                    $stripeResponse = $stripe->subscriptions->retrieve($stripeSub->stripe_id);
                    $endDate = \Carbon\Carbon::createFromTimestamp($stripeResponse->current_period_end);
                    return (($endDate >= $today) && ($endDate <= $checkExpiryDate));
                }
                catch(\Stripe\Error\Card $e) {
                    logger("Since it's a decline, \Stripe\Error\Card will be caught");
                    return "invalid coupon code";
                } catch (\Stripe\Error\RateLimit $e) {
                    logger("Too many requests made to the API too quickly");
                    return "invalid coupon code";
                } catch (\Stripe\Error\InvalidRequest $e) {
                    logger("Invalid parameters were supplied to Stripe's API");
                    return "invalid coupon code";
                } catch (\Stripe\Error\Authentication $e) {
                    logger("Authentication with Stripe's API failed(maybe you changed API keys recently)");
                    return "invalid coupon code";
                } catch (\Stripe\Error\ApiConnection $e) {
                    logger("Network communication with Stripe failed");
                    return "invalid coupon code";
                } catch (\Stripe\Error\Base $e) {
                    logger("Display a very generic error to the user, and maybe send yourself an email");
                    return "invalid coupon code";
                } catch (Exception $e) {
                    logger("Something else happened, completely unrelated to Stripe");
                    logger($e->getMessage());
                    return "invalid coupon code";
                }
            }
        }
        if($payment_platform == \App\MainSubscription::PAYMENT_PLATFORM_PAYPAL){
            $paypalSub = SubscriptionPaypal::where('user_id',Auth::user()->id)->where('paypal_status','ACTIVE')->first();
            if($paypalSub){
              try{
                  $sub_id = $paypalSub->paypal_id;
                  $paypalUrl = getPaypalUrl("v1/billing/subscriptions/${sub_id}");
                  $paypalResponse = fetchPaypalSubscriptionStatus($sub_id);
                  $endDate = \Carbon\Carbon::parse(@$paypalResponse['response']['billing_info']['next_billing_time']);
                  return (($endDate >= $today) && ($endDate <= $checkExpiryDate));
              }
              catch (Exception $e) {
                  logger("Something else happened, completely unrelated to Paypal");
                  logger($e->getMessage());
                  return "invalid coupon code";
              }
            }
        }
        return false;
    }

    if (!function_exists('getName')) {
        function getName($name, $part)
        {
            $name = trim($name);
            $lastName = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
            $firstName = trim( preg_replace('#'.preg_quote($lastName,'#').'#', '', $name ) );

            if ($part === 'first') {
                return $firstName;
            }

            if ($part === 'last') {
                return $lastName;
            }

            return '';
        }
    }
}

// add AC tag using shop curl
if(!function_exists('addactive_campaign_event_curl')) {
    function addactive_campaign_event_curl($shop,$Subscription, $app, $tags, $api_action=''){
        $shopData = getShopCurl($shop);
        $shop_owner = $shopData['shop_owner'];
        $shop_owner_name = explode(" ", $shop_owner);
        $shop_owner = $shopData['shop_owner'];
        $shop_owner_name = explode(" ", $shop_owner);
        $post = array(
          'email'                    => $shopData['email'],
          'first_name'               => $shop_owner_name[0],
          'last_name'                => $shop_owner_name[1],
          'phone'                    => $shopData['phone'],
          'field[1,0]'               => $Subscription, //Subscription
          'field[6,0]'               => $shopData['domain'], // Company
          'field[7,0]'               => 'Installed', //App Status
          'field[9,0]'               => $shopData['country_name'], //country
          'field[10,0]'              => $shopData['city'], //city
          'field[11,0]'              => $shopData['zip'], //zip
          'field[12,0]'              => $shopData['address1'], //Address line 1
          'field[13,0]'              => $shopData['address2'], //Address line 2
          'field[14,0]'              => $shopData['province'], //Province
          'field[15,0]'              => $shopData['primary_locale'], //Language
          'field[16,0]'              => $shopData['name'], //Store name
          'tags'                     => $tags, //tags
      );
        logger(json_encode($post));
      if(empty($api_action) || $api_action == ''){
          $api_action = 'contact_edit';
        }
      //ActiveCampaignJob::dispatch($shop->email, $app, $post, $api_action);
    }


}

if (!function_exists('ifAnyPaypalSubscriptionPaused')) {
    function ifAnyPaypalSubscriptionPaused()
    {
        $shop = auth()->user();
        $pausedSubscription = SubscriptionPaypal::where('user_id',$shop->id)->orderBy('id','desc')->first();
        if($pausedSubscription && $pausedSubscription->paypal_status=="SUSPENDED"){
            return true;
        }
        return false;
    }
}
// Fetch Subscription from paypal
if (!function_exists('fetchPaypalSubscriptionStatus')) {
    function fetchPaypalSubscriptionStatus($sub_id){
        $clientId= "";
        $clientSecret = "";

        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $clientId= config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET');
        }
        if(config('env-variables.PAYPAL_MODE')=='live'){
            $clientId= config('env-variables.PAYPAL_LIVE_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_LIVE_CLIENT_SECRET');
        }

        $url = getPaypalUrl("v1/billing/subscriptions/${sub_id}");
        $aceessToken = getPaypalAccessToken($clientId,$clientSecret);
        $shopcurl = curl_init();
        curl_setopt($shopcurl, CURLOPT_URL, $url);
        curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $aceessToken"));
        curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
        curl_setopt($shopcurl, CURLOPT_HEADER, 0);
        curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($shopcurl);
        $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
        logger("Response from fetchPaypalSubscriptionStatus curl call ". json_encode($response));
        curl_close ($shopcurl);
        return [
            'response' => json_decode($response, true),
            'statusCode' => $paypalResponse
        ];
    }
}

// Fetch Subscription from paypal
if (!function_exists('fetchPaypalPlan')) {
    function fetchPaypalPlan($sub_id){
        $clientId= "";
        $clientSecret = "";

        if(config('env-variables.PAYPAL_MODE')=='sandbox')
        {
            $clientId= config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET');
        }

        if(config('env-variables.PAYPAL_MODE')=='live')
        {
            $clientId= config('env-variables.PAYPAL_LIVE_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_LIVE_CLIENT_SECRET');
        }

        $url = getPaypalUrl("v1/billing/plans/${sub_id}");
        $aceessToken = getPaypalAccessToken($clientId,$clientSecret);

        $shopcurl = curl_init();
        curl_setopt($shopcurl, CURLOPT_URL, $url);
        curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $aceessToken"));
        curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
        curl_setopt($shopcurl, CURLOPT_HEADER, 0);
        curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($shopcurl);
        $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
        logger("Response from fetchPaypalPlan curl call ". json_encode($response));
        curl_close ($shopcurl);
        return [
            'response' => json_decode($response, true),
            'statusCode' => $paypalResponse
        ];
    }
}


// Pause Subscription from paypal
if (!function_exists('pausePaypalSubscription')) {
    function pausePaypalSubscription($sub_id){
        $clientId= "";
        $clientSecret = "";
        $url = getPaypalUrl("v1/billing/subscriptions/${sub_id}/suspend");

        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $clientId= config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET');
        }
        if((config('env-variables.PAYPAL_MODE')=='live')){
            $clientId= config('env-variables.PAYPAL_LIVE_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_LIVE_CLIENT_SECRET');
        }

        $aceessToken = getPaypalAccessToken($clientId,$clientSecret);

        $shopcurl = curl_init();
        curl_setopt($shopcurl, CURLOPT_URL, $url);
        curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $aceessToken"));
        curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
        curl_setopt($shopcurl, CURLOPT_HEADER, false);
        curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($shopcurl, CURLOPT_POSTFIELDS,'{"reason":"Customer Requested Pausing Current Subscription"}');
        $response = curl_exec($shopcurl);
        $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
        logger("Response from pausePaypalSubscription curl call ". json_encode($response));
        curl_close ($shopcurl);
        return [
            'statusCode' => $paypalResponse
        ];
    }
}


// Pause Subscription from paypal
if (!function_exists('unPausePaypalSubscription')) {
    function unPausePaypalSubscription($sub_id){
        $clientId= "";
        $clientSecret = "";
        $url = getPaypalUrl("v1/billing/subscriptions/${sub_id}/activate");

        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $clientId= config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET');
        }
        if((config('env-variables.PAYPAL_MODE')=='live')){
            $clientId= config('env-variables.PAYPAL_LIVE_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_LIVE_CLIENT_SECRET');
        }

        $aceessToken = getPaypalAccessToken($clientId,$clientSecret);

        $shopcurl = curl_init();
        curl_setopt($shopcurl, CURLOPT_URL, $url);
        curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $aceessToken"));
        curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
        curl_setopt($shopcurl, CURLOPT_HEADER, false);
        curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($shopcurl, CURLOPT_POSTFIELDS,'{"reason":"Customer Requested Reactivating Subscription"}');
        $response = curl_exec($shopcurl);
        $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
        logger("Response from unPausePaypalSubscription curl call ". json_encode($response));
        curl_close ($shopcurl);
        return [
            'statusCode' => $paypalResponse
        ];
    }
}


// Cancel Paypal Subscription
if (!function_exists('cancelPaypalSubscription')) {
    function cancelPaypalSubscription($sub_id, $count = 0){
        logger("helpers/cancelPaypalSubscription started for subscription id ".$sub_id . ' - step5: upselltesting cancelPaypalSubscription');

        $clientId= "";
        $clientSecret = "";
        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $clientId= config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET');
        }
        if((config('env-variables.PAYPAL_MODE')=='live')){
            $clientId= config('env-variables.PAYPAL_LIVE_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_LIVE_CLIENT_SECRET');
        }
        $checkStatusOfSubs = fetchPaypalSubscriptionStatus($sub_id);
        logger("helpers/cancelPaypalSubscription checkStatusOfSubs ".json_encode($checkStatusOfSubs) . ' - step6: upselltesting cancelPaypalSubscription');
        if(@$checkStatusOfSubs['statusCode'] == 200 && @$checkStatusOfSubs['response']['status'] != 'CANCELLED' ){

            $aceessToken = getPaypalAccessToken($clientId,$clientSecret);

            $url = getPaypalUrl("v1/billing/subscriptions/${sub_id}/cancel");
            logger('paypal response URL '.$url);
            $shopcurl = curl_init();
            curl_setopt($shopcurl, CURLOPT_URL, $url);
            curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $aceessToken"));
            curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
            curl_setopt($shopcurl, CURLOPT_HEADER, 1);
            curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($shopcurl, CURLOPT_POSTFIELDS,'{"reason": "Not satisfied with the service"}');
            $response = curl_exec ($shopcurl);
            $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);

            if($paypalResponse != 204) {
                sleep(5);
                $paypalResponse = getPaypalHttpClient()
                ->withHeaders([
                   'Content-Type'=>'application/json',
                   'Accept-Encoding'=>'gzip, deflate, br',
                   'Connection'=>'keep-alive',
                ])->post(getPaypalUrl("v1/billing/subscriptions/${sub_id}/cancel"),['reason'=>'No_comment'])->status();
                logger('paypal response status '.$paypalResponse);

                if($paypalResponse != 204 && $count <= 2) {
                    $count++;
                    cancelPaypalSubscription($sub_id, $count);
                }
            }

            logger("Response from cancelPaypalSubscription curl call ". json_encode($response). ' - step7: upselltesting cancelPaypalSubscription');
            curl_close ($shopcurl);
            logger('paypal response status '.$paypalResponse);
            logger("helpers/cancelPaypalSubscription ended ". json_encode($response));
            return [
                'statusCode' => $paypalResponse
            ];
        } 
        else if(@$checkStatusOfSubs['statusCode'] == 200 && @$checkStatusOfSubs['response']['status'] == 'CANCELLED' ) {
            logger("helpers/cancelPaypalSubscription ended. Plan paypal_id " . $sub_id." was already cancelled on Paypal but was not updated in our DB.");
            return [
                'statusCode' => 204
            ];
        }
        else {
            logger("helpers/cancelPaypalSubscription ended  - step8: upselltesting cancelPaypalSubscription". "false");
            return [
                'statusCode' => false
            ];
        }
    }
}

// Refund Paypal Subscription
if (!function_exists('refundPaypalSubscription')) {
    function refundPaypalSubscription($sub_id){
        logger("helpers/refundPaypalSubscription started for subscription id ".$sub_id . ' - step17: upselltesting refundPaypalSubscription');

        $clientId= "";
        $clientSecret = "";
        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $clientId= config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_ID');
        }
        if((config('env-variables.PAYPAL_MODE')=='live')){
            $clientId= config('env-variables.PAYPAL_LIVE_CLIENT_ID');
            $clientSecret =config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET');
        }

        $last_date = Carbon\Carbon::yesterday()->format('Y-m-d');
        $current_date = Carbon\Carbon::now()->addDay()->format('Y-m-d');
        $checkStatusOfSubs = fetchPaypalSubscriptionStatus($sub_id);
        logger("helpers/refundPaypalSubscription checkStatusOfSubs ".json_encode($checkStatusOfSubs));
        if(@$checkStatusOfSubs['statusCode'] == 200){
            $subs_transaction = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${sub_id}/transactions?start_time=${last_date}T00:00:00.940Z&end_time=${current_date}T00:00:00.940Z"))->json();

            if($subs_transaction) {
                $transactionId = $subs_transaction['transactions'][0]['id'];
                $aceessToken = getPaypalAccessToken($clientId,$clientSecret);

                $url = getPaypalUrl("v2/payments/captures/${transactionId}/refund");
                logger('paypal response URL '.$url);
                $shopcurl = curl_init();
                curl_setopt($shopcurl, CURLOPT_URL, $url);
                curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer $aceessToken"));
                curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
                curl_setopt($shopcurl, CURLOPT_HEADER, 1);
                curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec ($shopcurl);
                $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
                logger("Response from refundPaypalSubscription curl call ". json_encode($response) . ' - step18: upselltesting refundPaypalSubscription');
                curl_close ($shopcurl);
                logger('paypal response status '.$paypalResponse);
                logger("helpers/refundPaypalSubscription ended ". json_encode($response));
                return [
                    'statusCode' => $paypalResponse
                ];
            } else {
                logger("helpers/refundPaypalSubscription ended  - step19: upselltesting refundPaypalSubscription". "false");
                return [
                    'statusCode' => false
                ];
            }
        } else {
            logger("helpers/refundPaypalSubscription ended  - step20: upselltesting refundPaypalSubscription". "false");
            return [
                'statusCode' => false
            ];
        }
    }
}

// Check User outstanding balance for Paypal Subscription
if (!function_exists('check_user_outstanding_balance')) {
    function check_user_outstanding_balance($shop) {
        $subscription = $shop->paypalSubscription()->active()->first();
        if($subscription) {
            $subsId = $subscription->paypal_id;
            $activePaypalBilling = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subsId}"))->json();

            $billing_info = $activePaypalBilling['billing_info'];
            if($billing_info['failed_payments_count'] > 0 && $billing_info['outstanding_balance']['value'] > 0) {
                return true;
            }
            return false;
        }
        return false;
    }
}

// PayPal capture outstanding balance
if (!function_exists('paypal_capture_outstanding_balance')) {
    function paypal_capture_outstanding_balance($sub_id, $outstanding_balance_arr){
        $paypalClient = '';
        logger("helpers/paypal_capture_outstanding_balance started for subscription id ".$sub_id);
        if(config('env-variables.PAYPAL_MODE')=='sandbox'){
            $paypalClient = getPaypalAccessToken(config('env-variables.PAYPAL_SANDBOX_CLIENT_ID'), config('env-variables.PAYPAL_SANDBOX_CLIENT_SECRET'));
        }
        if((config('env-variables.PAYPAL_MODE')=='live')){
            $paypalClient = getPaypalAccessToken(config('env-variables.PAYPAL_LIVE_CLIENT_ID'), config('env-variables.PAYPAL_LIVE_CLIENT_SECRET'));
        }

        $body = [
            'note' => 'Charging as the balance reached the limit',
            'capture_type' => 'OUTSTANDING_BALANCE',
            'amount' => $outstanding_balance_arr
        ];

        $url = getPaypalUrl("v1/billing/subscriptions/${sub_id}/capture");
        logger('paypal capture_outstanding_balance URL '.$url);
        $shopcurl = curl_init();
        curl_setopt($shopcurl, CURLOPT_URL, $url);
        curl_setopt($shopcurl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization: Bearer ${paypalClient}"));
        curl_setopt($shopcurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($shopcurl, CURLOPT_VERBOSE, 0);
        curl_setopt($shopcurl, CURLOPT_HEADER, 1);
        curl_setopt($shopcurl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($shopcurl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($shopcurl, CURLOPT_POSTFIELDS, json_encode($body));
        $response = curl_exec ($shopcurl);
        $paypalResponse = curl_getinfo($shopcurl, CURLINFO_RESPONSE_CODE);
        logger("Response from paypal_capture_outstanding_balance curl call ". json_encode($response));
        curl_close ($shopcurl);
        logger('paypal_capture_outstanding_balance response status '.$paypalResponse);

        list($header, $body) = explode("\r\n\r\n", $response, 2);
        $responseArr = json_decode($body, true);

        return [
            'status' => $paypalResponse,
            'message' => isset($responseArr['details'][0]['description'])
                            ? $responseArr['details'][0]['description']
                            : "An error occurred with PayPal, please try again in a few minutes"
        ];
    }
}

//shopsubsription
if (! function_exists('isPayPalSubscriptionApprovalPending'))
{
    function isPayPalSubscriptionApprovalPending()
    {
        $shop = auth()->user();

        $paymentPlatform = getPaymentPlatform();

        if ($paymentPlatform == 'paypal')
        {
            $subscription = $shop->paypalSubscription()->active()->first();

            if ($subscription && isset($subscription->paypal_id))
            {
                $paypalSubId = $subscription->paypal_id;
                $getPaypalSubscription = fetchPaypalSubscriptionStatus($paypalSubId);
                if (@$getPaypalSubscription['statusCode'] == 200)
                {
                    if (@$getPaypalSubscription['response']['status'] == 'APPROVAL_PENDING')
                    {
                        $links = $getPaypalSubscription['response']['links'];
                        $approveLink = array_filter($links, function ($link) {
                            return $link['rel'] == "approve";
                        });
                        return ['route' => array_values($approveLink)[0]['href']];
                    }
                }
            }
        }

        return false;
    }
}

if (!function_exists('setPlanActionTag')) {
    function setPlanActionTag($shop, $paymentCycle) {
        try {
            $upgradePlanList = [
                'Starter' => 0,
                'Hustler' => 1,
                'Master' => 2
            ];

            $activeCampaign = new ActiveCampaignJobV3();
            $contact = $activeCampaign->sync([
                'email' => $shop->email,
                'fieldValues' => [
                        ['field' => AC::FIELD_SUBSCRIPTION, 'value' => $paymentCycle]
                    ]
            ]);

            if (
                ! array_key_exists( ucfirst($shop->alladdons_plan), $upgradePlanList ) ||
                (
                    array_key_exists( ucfirst($shop->alladdons_plan), $upgradePlanList ) &&
                    $upgradePlanList[ucfirst($shop->alladdons_plan)] <= $upgradePlanList[ ucfirst($paymentCycle) ]
                )
            ) {
                $tagUpgraded = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_UPGRADED);
                $tagDowngraded = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_DOWNGRADED);

                if ($tagDowngraded) {
                    $untag = $activeCampaign->untag($tagDowngraded['id']);
                }
            } else {
                $tagDowngraded = $activeCampaign->tag($contact['id'], AC::TAG_EVENT_PLAN_DOWNGRADED);
                $tagUpgraded = $activeCampaign->getContactTag($contact['id'], AC::TAG_EVENT_PLAN_UPGRADED);

                if ($tagUpgraded) {
                    $untag = $activeCampaign->untag($tagUpgraded['id']);
                }
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}

if (!function_exists('intercomUpdate')) {
    function intercomUpdate($shopId, $data) {
        try {
            $client = new \Intercom\IntercomClient(config('env-variables.INTERCOM_TOKEN'));
            $query = ['field' => 'external_id', 'operator' => '=', 'value' => (string) $shopId];
            $contact = $client->contacts->search([
                'pagination' => ['per_page' => 1],
                'query' => $query,
                'sort' => ['field' => 'name', 'order' => 'ascending'],
            ]);

            if ($contact->total_count) {
                $client->contacts->update($contact->data[0]->id, $data);
            }
        } catch(\Exception $e) {
            logger("Intercom error: " . $e->getMessage());
        }
    }
}

if (!function_exists('remove_from_beta_user')) {
    function remove_from_beta_user($user_id, $user_email, $user_domain, $trial_days){
        try {
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        $current_date = new DateTime();
        $formatted_current_date = $current_date->format('Y-m-d');
        $trial_ends_at = date('Y-m-d', strtotime($formatted_current_date . ' + ' . $trial_days . ' days'));

        $subscription = SubscriptionStripe::where('user_id', $user_id)->orderBy('id', 'desc')->first();
        if (isset($subscription->stripe_id) && !empty($subscription->stripe_id)) {
            $stripe_subs = \Stripe\Subscription::retrieve($subscription->stripe_id);
            if (isset($stripe_subs->id) && !empty($stripe_subs->id) && $stripe_subs->status != 'canceled') {
                $sub = \Stripe\Subscription::update($subscription->stripe_id, [
                    'pause_collection' => '',
                ]);
            }
        }

        $paypal_subscription = SubscriptionPaypal::where('user_id', $user_id)->orderBy('id', 'desc')->first();
        if (isset($paypal_subscription->paypal_id) && !empty($paypal_subscription->paypal_id)) {
            $subId = $paypal_subscription->paypal_id;
            $paypal_subs = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}"))->json();
            if (isset($paypal_subs['id']) && !empty($paypal_subs['id']) && $paypal_subs['status'] != 'CANCELLED') {
                $unpauseSubscriptionResponse = getPaypalHttpClient()
                            ->withBody('{"reason":"Customer Requested Reactivating Subscription"}', 'application/json')
                            ->post(getPaypalUrl("v1/billing/subscriptions/${subId}/activate"))->status();

                if ($unpauseSubscriptionResponse == 204) {
                    $getPaypalSubscription = getPaypalHttpClient()->get(getPaypalUrl("v1/billing/subscriptions/${subId}"))->json();
                    SubscriptionPaypal::where('paypal_id', $subId)->update([
                        'paypal_status' => $getPaypalSubscription['status']
                    ]);
                }
            }
        }

        $user_plan = User::where('id', $user_id)->select('old_plan_meta')->get();
        $old_plan_name = "";
        if (isset($user_plan[0]->old_plan_meta)) {
            $old_plan = json_decode($user_plan[0]->old_plan_meta);
            if (isset($old_plan->plan_name)) {
                $old_plan_name = $old_plan->plan_name;
            }
        }

        $user_action = User::where('email', trim($user_email))->where('name', trim($user_domain))->update([
            'is_beta_tester' => 0,
            'trial_ends_at' => $trial_ends_at,
            'sub_trial_ends_at' => '',
            'trial_days' => $trial_days,
            'alladdons_plan' => $old_plan_name,

        ]);

        $shop = User::where('id', $user_id)->first();
        deleteScriptTagCurl($shop);
    } catch (\Exception $e) {
        logger('Remove beta user throws exception: ' . $e->getMessage() . ' for shop name ' . $user_domain);
    }
  }
}
