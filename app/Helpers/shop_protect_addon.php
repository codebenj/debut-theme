<?php
//activate
if (! function_exists('activate_shop_protect_addon')) {
    function activate_shop_protect_addon($StoreThemes, $shop) {
        foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '{
                  "name": "Shop protect",
                  "settings": [
                    {
                      "type": "header",
                      "content": "Activation"
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_shop_protect",
                      "label": "Activate",
                      "default": false
                    },
                    {
                      "type": "header",
                      "content": "Settings"
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_shop_protect_image",
                      "label": "Disable images copy",
                      "default": true
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_shop_protect_drag",
                      "label": "Disable images drag & drop",
                      "default": true
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_shop_protect_text_product",
                      "label": "Disable product text copy",
                      "default": true
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_shop_protect_text_article",
                      "label": "Disable article text copy",
                      "default": true
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_shop_protect_collection",
                      "label": "Disable best selling collections",
                      "default": true,
                      "info": "Make sure your collections are not sorted by best selling. [Edit collection sorting](\/admin\/collections)"
                    }
                  ]
                }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_shop_protect' ) ) === false ) {
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
                logger('update schema on shop protect throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on shop protect addon throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-shop-protect */{% if settings.dbtfy_shop_protect %}.dbtfy-shop_protect-text{-webkit-touch-callout:none;-webkit-user-select:none;-khtml-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}{% endif %}/* end-dbtfy-shop-protect */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-shop-protect' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);

                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on shop protect addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on shop protect addon throws exception');
            }

            // add js addon
            try{
              $script = (string)'/* start-dbtfy-shop-protect */function themeShopProtect() { {% if settings.dbtfy_shop_protect %} var protect_image = {{ settings.dbtfy_shop_protect_image }}; var protect_drag = {{ settings.dbtfy_shop_protect_image }}; var protect_product_text = {{ settings.dbtfy_shop_protect_text_product }}; var protect_article_text = {{ settings.dbtfy_shop_protect_text_article }}; var protect_collection = {{ settings.dbtfy_shop_protect_collection }}; var _0xc7eb=["\x63\x6F\x6E\x74\x65\x78\x74\x6D\x65\x6E\x75","\x6F\x6E","\x69\x6D\x67","\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74","\x6D\x6F\x75\x73\x65\x64\x6F\x77\x6E","\x64\x62\x74\x66\x79\x2D\x73\x68\x6F\x70\x5F\x70\x72\x6F\x74\x65\x63\x74\x2D\x74\x65\x78\x74","\x61\x64\x64\x43\x6C\x61\x73\x73","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x64\x65\x74\x61\x69\x6C\x73","\x2E\x61\x72\x74\x69\x63\x6C\x65\x2D\x73\x65\x63\x74\x69\x6F\x6E\x2C\x20\x2E\x62\x6C\x6F\x67\x2D\x73\x65\x63\x74\x69\x6F\x6E","\x72\x65\x6D\x6F\x76\x65","\x23\x73\x6F\x72\x74\x42\x79\x20\x6F\x70\x74\x69\x6F\x6E\x5B\x76\x61\x6C\x75\x65\x3D\x27\x62\x65\x73\x74\x2D\x73\x65\x6C\x6C\x69\x6E\x67\x27\x5D","\x3F\x73\x6F\x72\x74\x5F\x62\x79\x3D\x62\x65\x73\x74\x2D\x73\x65\x6C\x6C\x69\x6E\x67","\x73\x65\x61\x72\x63\x68","\x6C\x6F\x63\x61\x74\x69\x6F\x6E","\x2F\x63\x6F\x6C\x6C\x65\x63\x74\x69\x6F\x6E\x73","\x72\x65\x70\x6C\x61\x63\x65","\x63\x6C\x69\x63\x6B","\x69\x6D\x67\x5B\x64\x61\x74\x61\x2D\x6D\x66\x70\x2D\x73\x72\x63\x5D"];function ShopProtect(){function _0x72fcx2(){protect_image&& $(_0xc7eb[2])[_0xc7eb[1]](_0xc7eb[0],function(_0x72fcx2){return !1})}function _0x72fcx3(){protect_drag&& $(_0xc7eb[2])[_0xc7eb[4]](function(_0x72fcx2){_0x72fcx2[_0xc7eb[3]]()})}setTimeout(function(){_0x72fcx2(),_0x72fcx3()},1e3),protect_product_text&& $(_0xc7eb[7])[_0xc7eb[6]](_0xc7eb[5]),protect_article_text&& $(_0xc7eb[8])[_0xc7eb[6]](_0xc7eb[5]),protect_collection&& ($(_0xc7eb[10])[_0xc7eb[9]](),_0xc7eb[11]== window[_0xc7eb[13]][_0xc7eb[12]]&& window[_0xc7eb[13]][_0xc7eb[15]](_0xc7eb[14])),$(_0xc7eb[17])[_0xc7eb[16]](function(){_0x72fcx2(),_0x72fcx3()})}ShopProtect() {% endif %} }; /* end-dbtfy-shop-protect */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-shop-protect */" ) ) === false ) {
                    $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-shop-protect */themeShopProtect();/* end-register-shop-protect */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-shop-protect */' ) ) === false ) {
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
if (! function_exists('deactivate_shop_protect_addon')) {
    function deactivate_shop_protect_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_shop_protect_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Shop protect') !== false) {
                  return false;
              }
              return true;
            });

            if(str_contains($schema,'Shop protect')){
                $value = json_encode(array_values($json));
                $updated_schema = $value;
                $update_schema_settings = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json', 'value' => $updated_schema] ]
                );
            }

            // remove scss
            $theme_style_content = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
            )['body']['asset']['value'] ?? '';

            $trustbadge_Style = (string) '/* start-dbtfy-shop-protect */';
            $end = (string) '/* end-dbtfy-shop-protect */';
            $string = ' ' . $theme_style_content;
            $ini = strpos($string, $trustbadge_Style);
            if ($ini == 0) {
              $parsed = '';
            }else{
              $ini += strlen($trustbadge_Style);
              $len = strpos($string, $end, $ini) - $ini;
              $parsed = substr($string, $ini, $len);
            }
            $values = $trustbadge_Style.''.$parsed.''.$end;

            if(str_contains($theme_style_content,'dbtfy-shop_protect-text')){
                $value = str_replace($values, " ", $theme_style_content);
                $new_theme_styles = (string) $value;

                $update_styles = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                );
            }

            // remove snippet
            try{
                $delete_trustbadge_snippet = $shop->api()->request(
                    'DELETE',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-shop-protect.liquid'] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add Addtocart_animation throws client exception');
            }
            catch(\Exception $e){
                logger('add Addtocart_animation throws exception');
            }

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'layout/theme.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-shop-protect')){
                $value  =  explode("{% include 'dbtfy-shop-protect' %}",$product_template,2);
                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                } else{
                    $value = (string) $product_template;
                }
                $new_prod_template = (string) $value;
                $update_prod_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid', 'value' => $new_prod_template] ]
                );
            }

            // remove js addon
            try{
               $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $trustbadge_js = (string) '/* start-dbtfy-shop-protect */';
                $end_js = (string) '/* end-dbtfy-shop-protect */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-shop-protect */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-shop-protect */')){
                        $trustbadge_js1 = (string) '/* start-register-shop-protect */';
                        $end_js = (string) '/* end-register-shop-protect */';
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
                logger('remove shop_protect throws client exception');
            }
            catch(\Exception $e){
                logger('remove shop_protect throws exception');
            }
        }
    }
}



if (! function_exists('deactivate_shop_protect_addon_curl')) {
    function deactivate_shop_protect_addon_curl($theme, $shop) {

        // remove schema
        $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

        $json = json_decode($schema, true);
        $json = array_filter($json, function ($obj) {
          if (stripos($obj['name'], 'Shop protect') !== false) {
              return false;
          }
          return true;
        });

        if(str_contains($schema,'Shop protect')){
            $value = json_encode(array_values($json));
            $updated_schema = $value;
            $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
        }

        // remove scss
        $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid') ?? '';

        $trustbadge_Style = (string) '/* start-dbtfy-shop-protect */';
        $end = (string) '/* end-dbtfy-shop-protect */';
        $string = ' ' . $theme_style_content;
        $ini = strpos($string, $trustbadge_Style);
        if ($ini == 0) {
          $parsed = '';
        }else{
          $ini += strlen($trustbadge_Style);
          $len = strpos($string, $end, $ini) - $ini;
          $parsed = substr($string, $ini, $len);
        }
        $values = $trustbadge_Style.''.$parsed.''.$end;

        if(str_contains($theme_style_content,'dbtfy-shop_protect-text')){
            $value = str_replace($values, " ", $theme_style_content);
            $new_theme_styles = (string) $value;

            $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
        }

        // remove snippet
        try{
            $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-shop-protect.liquid');
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            logger('add Addtocart_animation throws client exception');
        }
        catch(\Exception $e){
            logger('add Addtocart_animation throws exception');
        }

        // remove include
        $product_template = getThemeFileCurl($shop, $theme, 'layout/theme.liquid') ?? '';

        if(str_contains($product_template,'dbtfy-shop-protect')){
            $value  =  explode("{% include 'dbtfy-shop-protect' %}",$product_template,2);
            if(isset($value[0]) && isset($value[1])){
                $value = $value[0].' '.$value[1];
            } else{
                $value = (string) $product_template;
            }
            $new_prod_template = (string) $value;
            $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'layout/theme.liquid');
        }

        // remove js addon
        try{
           $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

            $trustbadge_js = (string) '/* start-dbtfy-shop-protect */';
            $end_js = (string) '/* end-dbtfy-shop-protect */';
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
            if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-shop-protect */')){
                $value = str_replace($value_js, " ", $theme_js_content);
                $new_theme_js = (string) $value;
                if(str_contains($new_theme_js,'/* start-register-shop-protect */')){
                    $trustbadge_js1 = (string) '/* start-register-shop-protect */';
                    $end_js = (string) '/* end-register-shop-protect */';
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
            logger('remove shop_protect throws client exception');
        }
        catch(\Exception $e){
            logger('remove shop_protect throws exception');
        }
    }
}
?>
