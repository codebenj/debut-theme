<?php
//activate
if (! function_exists('activate_addtocart_animation_addon')) {
    function activate_addtocart_animation_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '{
                  "name": "Add-to-cart animation",
                  "settings": [
                    {
                      "type": "header",
                      "content": "Activation"
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_addtocart_animation",
                      "label": "Activate",
                      "default": false
                    },
                    {
                      "type": "header",
                      "content": "Settings"
                    },
                    {
                      "type": "select",
                      "id": "dbtfy_addtocart_animation_type",
                      "label": "Animation type",
                      "default": "shake",
                      "options": [
                        {
                          "value": "bounce",
                          "label": "Bounce"
                        },
                        {
                          "value": "flash",
                          "label": "Flash"
                        },
                        {
                          "value": "pulse",
                          "label": "Pulse"
                        },
                        {
                          "value": "shake",
                          "label": "Shake"
                        },
                        {
                          "value": "jello",
                          "label": "Jello"
                        }
                      ]
                    },
                    {
                      "type": "select",
                      "id": "dbtfy_addtocart_animation_speed",
                      "label": "Animation speed",
                      "default": "",
                      "options": [
                        {
                          "value": "slow",
                          "label": "Slow"
                        },
                        {
                          "value": "",
                          "label": "Default"
                        },
                        {
                          "value": "fast",
                          "label": "Fast"
                        },
                        {
                          "value": "faster",
                          "label": "Faster"
                        }
                      ]
                    },
                    {
                      "type": "range",
                      "id": "dbtfy_addtocart_animation_interval",
                      "label": "Interval time (seconds)",
                      "min": 5,
                      "max": 20,
                      "step": 1,
                      "default": 6
                    }
                  ]
                }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_addtocart_animation' ) ) === false ) {
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

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-addtocart-animation */{% if settings.dbtfy_addtocart_animation %}.btn--addtocart_animation{&.animated.slow{-webkit-animation-duration:2s!important;animation-duration:2s!important}&.animated.fast{-webkit-animation-duration:.8s!important;animation-duration:.8s!important}&.animated.faster{-webkit-animation-duration:.5s!important;animation-duration:.5s!important}.js-drawer-open &,&.disabled,&.btn--loading,.variant-soldout &{animation:none!important}}{% endif %}/* end-dbtfy-addtocart-animation */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-addtocart-animation' ) ) === false ) {
                      $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);

                      $add_styles = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                      );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on Addtocart_animation addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on Addtocart_animation addon throws exception');
            }

            // add js addon
            try{
              $script = (string)'/* start-dbtfy-addtocart-animation */function themeAddtocartAnimation() { {% if settings.dbtfy_addtocart_animation %} var animation = "animated {{ settings.dbtfy_addtocart_animation_type }} {{ settings.dbtfy_addtocart_animation_speed }}"; var intervalTime = {{settings.dbtfy_addtocart_animation_interval}}000; {% case settings.dbtfy_addtocart_animation_speed %} {% when "slow" %} var animTime = 2000; {% when "" %} var animTime = 1000; {% when "fast" %} var animTime = 800; {% when "faster" %} var animTime = 500; {% endcase %} var _0x2ed9=["\x2E\x62\x74\x6E\x2D\x2D\x61\x64\x64\x74\x6F\x63\x61\x72\x74\x5F\x61\x6E\x69\x6D\x61\x74\x69\x6F\x6E","\x61\x64\x64\x43\x6C\x61\x73\x73","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x62\x74\x6E\x2D\x2D\x61\x64\x64\x74\x6F\x63\x61\x72\x74\x5F\x61\x6E\x69\x6D\x61\x74\x69\x6F\x6E","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x61\x64\x64\x2D\x74\x6F\x2D\x63\x61\x72\x74\x20\x2E\x62\x74\x6E\x2D\x2D\x61\x64\x64\x2D\x74\x6F\x2D\x63\x61\x72\x74"];function AddtocartAnimation(){var _0x8bfax2=$(_0x2ed9[0]);setInterval(function(){_0x8bfax2[_0x2ed9[1]](animation),setTimeout(function(){_0x8bfax2[_0x2ed9[2]](animation)},animTime)},intervalTime)}$(_0x2ed9[4])[_0x2ed9[1]](_0x2ed9[3]),AddtocartAnimation() {% endif %} }; /* end-dbtfy-addtocart-animation */';


                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-addtocart-animation */" ) ) === false ) {
                    $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-addtocart-animation */sections.register("product-template", themeAddtocartAnimation);/* end-register-addtocart-animation */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-addtocart-animation */' ) ) === false ) {
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
if (! function_exists('deactivate_addtocart_animation_addon')) {
    function deactivate_addtocart_animation_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'] ?? '';

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_addtocart_animation_addon_child($shop, $theme);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'];
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Add-to-cart animation') !== false) {
                  return false;
              }
              return true;
            });

            if(str_contains($schema,'Add-to-cart animation')){
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

            // old style
            $styles = (string) '/*================ _Addtocart_animation ================*/ .btn--add-to-cart{&.animated.slow {-webkit-animation-duration: 2s!important;animation-duration: 2s!important;}&.animated.fast { -webkit-animation-duration: .8s!important;animation-duration: .8s!important;}&.animated.faster {-webkit-animation-duration: .5s!important;animation-duration: .5s!important;}.js-drawer-open &, &.disabled{animation: none!important;} }';
            $trustbadge_Style2 = (string) '/*================ _Addtocart_animation ================*/';
            $end2 = (string) '&.disabled{animation: none!important;} }';
            $string2 = ' ' . $theme_style_content;
            $ini2 = strpos($string2, $trustbadge_Style2);
            if ($ini2 == 0) {
              $parsed2 = '';
            }else{
              $ini2 += strlen($trustbadge_Style2);
              $len2 = strpos($string2, $end2, $ini2) - $ini2;
              $parsed2 = substr($string2, $ini2, $len2);
            }

            // old style
            $trustbadge_Style3 = (string) '/*================ start-dbtfy-Addtocart_animation ================*/';
            $end3 = (string) '/*================ end-dbtfy-Addtocart_animation ================*/';
            $string3 = ' ' . $theme_style_content;
            $ini3 = strpos($string3, $trustbadge_Style3);
            if ($ini3 == 0) {
              $parsed3 = '';
            }else{
              $ini3 += strlen($trustbadge_Style3);
              $len3 = strpos($string3, $end3, $ini3) - $ini3;
              $parsed3 = substr($string3, $ini3, $len3);
            }

            // new style
            $trustbadge_Style = (string) '/* start-dbtfy-addtocart-animation */';
            $end = (string) '/* end-dbtfy-addtocart-animation */';
            $string = ' ' . $theme_style_content;
            $ini = strpos($string, $trustbadge_Style);
            if ($ini == 0) {
              $parsed = '';
            }else{
              $ini += strlen($trustbadge_Style);
              $len = strpos($string, $end, $ini) - $ini;
              $parsed = substr($string, $ini, $len);
            }

            // result
            if($parsed3){
                $values = $trustbadge_Style3.''.$parsed3.''.$end3;
            }
            else if($parsed2){
                $values = $trustbadge_Style2.''.$parsed2.''.$end2;
            }else{
              if($parsed){
                  $values = $trustbadge_Style.''.$parsed.''.$end;
              }else{
                  $values = $styles;
              }
            }

            if(str_contains($theme_style_content,'btn--add-to-cart')){
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
                    ['asset' => ['key' => 'snippets/dbtfy-addtocart-animation.liquid'] ]
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
                ['asset' => ['key' => 'snippets/product-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-addtocart-animation')){
                $value  =  explode('{% include "dbtfy-addtocart-animation" %}',$product_template,2);
                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                } else{
                    $value = (string) $product_template;
                }
                $new_prod_template = (string) $value;
                $update_prod_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                );
            }

            // remove js addon
            try{
               $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $trustbadge_js = (string) '/* start-dbtfy-addtocart-animation */';
                $end_js = (string) '/* end-dbtfy-addtocart-animation */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-addtocart-animation */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-addtocart-animation */')){
                        $trustbadge_js1 = (string) '/* start-register-addtocart-animation */';
                        $end_js = (string) '/* end-register-addtocart-animation */';
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
                logger('Remove addtocart_animation throws client exception');
            }
            catch(\Exception $e){
                logger('Remove addtocart_animation throws exception');
            }
        }
    }
}

// deactivate on child store
if (! function_exists('deactivate_addtocart_animation_addon_child')) {
  function deactivate_addtocart_animation_addon_child($shop, $theme) {

      $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json');
      if(!$schema)
      {
        return false;
      }

      $json = json_decode($schema, true);
      $json = array_filter($json, function ($obj) {
        if (stripos($obj['name'], 'Add-to-cart animation') !== false) {
          return false;
        }
        return true;
      });

      if(str_contains($schema,'Add-to-cart animation')){
        $value = json_encode(array_values($json));
        $updated_schema = $value;
        putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
      }

      $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid');

      // old style
      $styles = (string) '/*================ _Addtocart_animation ================*/ .btn--add-to-cart{&.animated.slow {-webkit-animation-duration: 2s!important;animation-duration: 2s!important;}&.animated.fast { -webkit-animation-duration: .8s!important;animation-duration: .8s!important;}&.animated.faster {-webkit-animation-duration: .5s!important;animation-duration: .5s!important;}.js-drawer-open &, &.disabled{animation: none!important;} }';
      $trustbadge_Style2 = (string) '/*================ _Addtocart_animation ================*/';
      $end2 = (string) '&.disabled{animation: none!important;} }';
      $string2 = ' ' . $theme_style_content;
      $ini2 = strpos($string2, $trustbadge_Style2);
      if ($ini2 == 0) {
        $parsed2 = '';
      }else{
        $ini2 += strlen($trustbadge_Style2);
        $len2 = strpos($string2, $end2, $ini2) - $ini2;
        $parsed2 = substr($string2, $ini2, $len2);
      }

            // old style
      $trustbadge_Style3 = (string) '/*================ start-dbtfy-Addtocart_animation ================*/';
      $end3 = (string) '/*================ end-dbtfy-Addtocart_animation ================*/';
      $string3 = ' ' . $theme_style_content;
      $ini3 = strpos($string3, $trustbadge_Style3);
      if ($ini3 == 0) {
        $parsed3 = '';
      }else{
        $ini3 += strlen($trustbadge_Style3);
        $len3 = strpos($string3, $end3, $ini3) - $ini3;
        $parsed3 = substr($string3, $ini3, $len3);
      }

            // new style
      $trustbadge_Style = (string) '/* start-dbtfy-addtocart-animation */';
      $end = (string) '/* end-dbtfy-addtocart-animation */';
      $string = ' ' . $theme_style_content;
      $ini = strpos($string, $trustbadge_Style);
      if ($ini == 0) {
        $parsed = '';
      }else{
        $ini += strlen($trustbadge_Style);
        $len = strpos($string, $end, $ini) - $ini;
        $parsed = substr($string, $ini, $len);
      }


      if($parsed3){
        $values = $trustbadge_Style3.''.$parsed3.''.$end3;
      }
      else if($parsed2){
        $values = $trustbadge_Style2.''.$parsed2.''.$end2;
      }else{
        if($parsed){
          $values = $trustbadge_Style.''.$parsed.''.$end;
        }else{
          $values = $styles;
        }
      }

      if(str_contains($theme_style_content,'btn--add-to-cart')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;
        $styleUpdate = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
      }

      deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-addtocart-animation.liquid');

      $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-template.liquid');

      if(str_contains($product_template,'dbtfy-addtocart-animation')){
        $value  =  explode('{% include "dbtfy-addtocart-animation" %}',$product_template,2);
        if(isset($value[0]) && isset($value[1])){
          $value = $value[0].' '.$value[1];
        } else{
          $value = (string) $product_template;
        }
        $new_prod_template = (string) $value;

        putThemeFileCurl($shop, $theme, $new_prod_template, 'snippets/product-template.liquid');
      }

            // remove js addon
      try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid');
       if ($theme_js_content == null)
       {
        $theme_js_content = '';
      }
      $trustbadge_js = (string) '/* start-dbtfy-addtocart-animation */';
      $end_js = (string) '/* end-dbtfy-addtocart-animation */';
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
      if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-addtocart-animation */')){
        $value = str_replace($value_js, " ", $theme_js_content);
        $new_theme_js = (string) $value;
        if(str_contains($new_theme_js,'/* start-register-addtocart-animation */')){
          $trustbadge_js1 = (string) '/* start-register-addtocart-animation */';
          $end_js = (string) '/* end-register-addtocart-animation */';
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
      logger('Remove addtocart_animation throws client exception');
    }
    catch(\Exception $e){
      logger('Remove addtocart_animation throws exception');
    }

  }
}
?>
