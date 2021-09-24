<?php
//activate
if (! function_exists('activate_skip_cart_addon')) {
    function activate_skip_cart_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '
  {
    "name": "Skip cart",
    "settings": [
      {
        "type": "header",
        "content": "Activation"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_skip_cart",
        "label": "Activate",
        "default": false
      }
    ]
  }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_skip_cart' ) ) === false ) {
                    if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                        $updated_schema    = substr_replace( $schema , ",".$liveview_addon_schema."]" , $pos );
                        $update_schema_settings = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'config/settings_schema.json', 'value' => $updated_schema] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on live view addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on live view addon throws exception');
            }

            // add js addon
            try{
              $script = (string)'/* start-dbtfy-skip-cart */function themeSkipCart() { {% if settings.dbtfy_skip_cart %} var _0x4e47=["\x2F\x63\x68\x65\x63\x6B\x6F\x75\x74","\x63\x61\x72\x74\x54\x79\x70\x65","\x73\x65\x74\x74\x69\x6E\x67\x73","\x50\x4F\x53\x54","\x2F\x63\x61\x72\x74\x2F\x61\x64\x64\x2E\x6A\x73","\x73\x65\x72\x69\x61\x6C\x69\x7A\x65","\x6A\x73\x6F\x6E","\x66\x75\x6E\x63\x74\x69\x6F\x6E","\x61\x73\x73\x69\x67\x6E","\x6C\x6F\x63\x61\x74\x69\x6F\x6E","\x61\x6A\x61\x78","\x63\x6C\x69\x63\x6B","\x75\x70\x73\x65\x6C\x6C\x2D\x74\x61\x72\x67\x65\x74\x2D\x69\x64","\x64\x61\x74\x61","\x5B\x64\x61\x74\x61\x2D\x75\x70\x73\x65\x6C\x6C\x2D\x74\x61\x72\x67\x65\x74\x2D\x69\x64\x5D","\x63\x6C\x6F\x73\x65\x73\x74","\x23\x55\x70\x73\x65\x6C\x6C\x50\x6F\x70\x75\x70\x2D","\x2E\x65\x6D\x70\x74\x79\x2D\x75\x70\x73\x65\x6C\x6C\x5F\x70\x6F\x70\x75\x70","\x73\x6B\x69\x70\x4E\x65\x78\x74","\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74","\x66\x6F\x72\x6D","\x74\x72\x75\x65","\x73\x65\x74\x49\x74\x65\x6D","\x6F\x6E","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x66\x6F\x72\x6D\x20\x2E\x62\x74\x6E\x2D\x2D\x61\x64\x64\x2D\x74\x6F\x2D\x63\x61\x72\x74","\x72\x65\x6D\x6F\x76\x65\x49\x74\x65\x6D"];function SkipCart(){var _0x277cx2=_0x4e47[0];theme[_0x4e47[2]][_0x4e47[1]];function _0x277cx3(_0x277cx4,_0x277cx5){$[_0x4e47[10]]({type:_0x4e47[3],url:_0x4e47[4],data:$(_0x277cx4)[_0x4e47[5]](),dataType:_0x4e47[6],success:function(_0x277cx4){setTimeout(function(){_0x4e47[7]== typeof _0x277cx5?_0x277cx5():window[_0x4e47[9]][_0x4e47[8]](_0x277cx5)},150)}})}$(_0x4e47[24])[_0x4e47[23]](_0x4e47[11],function(_0x277cx4){var _0x277cx5=$(this),_0x277cx6=_0x277cx5[_0x4e47[15]](_0x4e47[14])[_0x4e47[13]](_0x4e47[12]),_0x277cx7=$(_0x4e47[16]+ _0x277cx6),_0x277cx8=$(_0x4e47[17]);_0x277cx7[0]|| _0x277cx8[0]?sessionStorage[_0x4e47[18]]?(_0x277cx4[_0x4e47[19]](),_0x277cx3(_0x277cx5[_0x4e47[15]](_0x4e47[20]),_0x277cx2)):sessionStorage[_0x4e47[22]](_0x4e47[18],_0x4e47[21]):(_0x277cx4[_0x4e47[19]](),_0x277cx3(_0x277cx5[_0x4e47[15]](_0x4e47[20]),_0x277cx2))})}sessionStorage[_0x4e47[25]](_0x4e47[18]),SkipCart() {% endif %} }; /* end-dbtfy-skip-cart */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-skip-cart */" ) ) === false ) {
                    $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-skip-cart */sections.register("product-template", themeSkipCart);/* end-register-skip-cart */', $theme_js_content);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }

                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';
                $replace_code= '/* start-dbtfy-addons */';
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-skip-cart */' ) ) === false ) {
                    $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update js on shop_protect addon throws client exception');
            }
            catch(\Exception $e){
                logger('update js on shop_protect addon throws exception');
            }

        }
    }
}

// deactivate
if (! function_exists('deactivate_skip_cart_addon')) {
    function deactivate_skip_cart_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_skip_cart_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Skip cart') !== false) {
                  return false;
              }
              return true;
            });

            if(str_contains($schema,'Skip cart')){
                $value = json_encode(array_values($json));
                $updated_schema = $value;
                $update_schema_settings = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json', 'value' => $updated_schema] ]
                );
            }

            // remove js addon
            try{
               $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $trustbadge_js = (string) '/* start-dbtfy-skip-cart */';
                $end_js = (string) '/* end-dbtfy-skip-cart */';
                $string_js = ' ' . $theme_js_content;
                $ini_js = strpos($string_js, $trustbadge_js);
                if ($ini_js == 0) {
                    $parsed_js = '';
                } else{
                    $ini_js += strlen($trustbadge_js);
                    $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
                    $parsed_js = substr($string_js, $ini_js, $len_js);
                }
                $value_js = $trustbadge_js.''.$parsed_js.''.$end_js;
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-skip-cart */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-skip-cart */')){
                        $trustbadge_js1 = (string) '/* start-register-skip-cart */';
                        $end_js = (string) '/* end-register-skip-cart */';
                        $string_js = ' ' . $new_theme_js;
                        $ini_js = strpos($string_js, $trustbadge_js1);
                        if ($ini_js == 0) {
                            $parsed_js = '';
                        } else{
                            $ini_js += strlen($trustbadge_js1);
                            $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
                            $parsed_js = substr($string_js, $ini_js, $len_js);
                        }
                        $value_js = $trustbadge_js1.''.$parsed_js.''.$end_js;

                        $value = str_replace($value_js, " ", $new_theme_js);
                        $new_theme_js1 = (string) $value;
                        $update_js = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js1] ]
                        );
                    }
                    else{
                        $update_js = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('Remove skip_cart throws client exception');
            }
            catch(\Exception $e){
                logger('Remove skip_cart throws exception');
            }
        }
    }
}



if (! function_exists('deactivate_skip_cart_addon_curl')) {
    function deactivate_skip_cart_addon_curl($theme, $shop) {

        // remove schema
        $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

        $json = json_decode($schema, true);
        $json = array_filter($json, function ($obj) {
          if (stripos($obj['name'], 'Skip cart') !== false) {
              return false;
          }
          return true;
        });

        if(str_contains($schema,'Skip cart')){
            $value = json_encode(array_values($json));
            $updated_schema = $value;
            $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
        }

        // remove js addon
        try{
           $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

            $trustbadge_js = (string) '/* start-dbtfy-skip-cart */';
            $end_js = (string) '/* end-dbtfy-skip-cart */';
            $string_js = ' ' . $theme_js_content;
            $ini_js = strpos($string_js, $trustbadge_js);
            if ($ini_js == 0) {
                $parsed_js = '';
            } else{
                $ini_js += strlen($trustbadge_js);
                $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
                $parsed_js = substr($string_js, $ini_js, $len_js);
            }
            $value_js = $trustbadge_js.''.$parsed_js.''.$end_js;
            if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-skip-cart */')){
                $value = str_replace($value_js, " ", $theme_js_content);
                $new_theme_js = (string) $value;
                if(str_contains($new_theme_js,'/* start-register-skip-cart */')){
                    $trustbadge_js1 = (string) '/* start-register-skip-cart */';
                    $end_js = (string) '/* end-register-skip-cart */';
                    $string_js = ' ' . $new_theme_js;
                    $ini_js = strpos($string_js, $trustbadge_js1);
                    if ($ini_js == 0) {
                        $parsed_js = '';
                    } else{
                        $ini_js += strlen($trustbadge_js1);
                        $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
                        $parsed_js = substr($string_js, $ini_js, $len_js);
                    }
                    $value_js = $trustbadge_js1.''.$parsed_js.''.$end_js;

                    $value = str_replace($value_js, " ", $new_theme_js);
                    $new_theme_js1 = (string) $value;
                    $update_js = putThemeFileCurl($shop, $theme, $new_theme_js1, 'assets/dbtfy-addons.js.liquid');
                }
                else{
                    $update_js = putThemeFileCurl($shop, $theme, $new_theme_js, 'assets/dbtfy-addons.js.liquid');
                }
            }
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            logger('Remove skip_cart throws client exception');
        }
        catch(\Exception $e){
            logger('Remove skip_cart throws exception');
        }
    }
}
?>
