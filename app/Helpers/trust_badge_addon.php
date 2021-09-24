<?php

// activate
if (! function_exists('activate_trustbadge_addon')) {
    function activate_trustbadge_addon($StoreThemes, $shop) {
        foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $trustbadge_addon_schema = (string) '{
                    "name": "Trust badges",
                    "settings": [
                      {
                        "type": "header",
                        "content": "Activation"
                      },
                      {
                        "type": "checkbox",
                        "id": "dbtfy_trust_badge",
                        "label": "Activate",
                        "default": false
                      },
                      {
                        "type": "header",
                        "content": "Settings"
                      },
                      {
                        "type": "checkbox",
                        "id": "dbtfy_trust_badge_product",
                        "label": "Show on product page",
                        "default": true
                      },
                      {
                        "type": "checkbox",
                        "id": "dbtfy_trust_badge_cart",
                        "label": "Show on cart page\/drawer",
                        "default": true
                      },
                      {
                        "type": "checkbox",
                        "id": "dbtfy_trust_badge_background",
                        "label": "Show background color",
                        "default": true
                      },
                      {
                        "type": "checkbox",
                        "id": "dbtfy_trust_badge_text_small",
                        "label": "Small text",
                        "default": false
                      },
                      {
                        "type": "image_picker",
                        "id": "dbtfy_trust_badge_image",
                        "label": "Image",
                        "info": "Leave empty for default icons"
                      },
                      {
                        "type": "text",
                        "id": "dbtfy_trust_badge_text",
                        "label": "Text",
                        "default": "Guaranteed safe & secure checkout"
                      },
                      {
                        "type": "select",
                        "id": "dbtfy_trust_badge_text_position",
                        "label": "Text position",
                        "default": "under",
                        "options": [
                          {
                            "label": "Above",
                            "value": "above"
                          },
                          {
                            "label": "Under",
                            "value": "under"
                          }
                        ]
                      },
                      {
                        "type": "select",
                        "id": "dbtfy_trust_badge_width",
                        "label": "Image width",
                        "default": "600",
                        "options": [
                          {
                            "label": "Extra Small",
                            "value": "200"
                          },
                          {
                            "label": "Small",
                            "value": "300"
                          },
                          {
                            "label": "Medium",
                            "value": "400"
                          },
                          {
                            "label": "Large",
                            "value": "500"
                          },
                          {
                            "label": "Extra Large",
                            "value": "600"
                          }
                        ]
                      }
                    ]
                }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_trust_badge' ) ) === false ) {
                    if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                        $updated_schema    = substr_replace( $schema , ",".$trustbadge_addon_schema."]" , $pos );

                        $update_schema_settings = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'config/settings_schema.json', 'value' => $updated_schema] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on trustbadge addon throws exception');
            }


            // add snippet
            try{
                $trustbadge_snippet = (string) '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}
{% assign valid_badge = false %}
{% if position == "product" and settings.dbtfy_trust_badge_product %}
  {% assign valid_badge = true %}
{% endif %}
{% if position == "cart" and settings.dbtfy_trust_badge_cart %}
  {% assign valid_badge = true %}
{% endif %}
{%- if settings.dbtfy_trust_badge and valid_badge -%}
<div class="dbtfy dbtfy-trust_badge">
  <div id="TrustBadge" class="{% if settings.dbtfy_trust_badge_background %}background-trust_badge{% endif %} text-{{ settings.dbtfy_trust_badge_text_position }}-trust_badge">
    <div class="container-trust_badge text-center">
      {% unless settings.dbtfy_trust_badge_text == blank %}
        <p class="text-trust_badge {% if settings.dbtfy_trust_badge_text_small %} small{% endif %}">{{ settings.dbtfy_trust_badge_text }}</p>
      {% endunless %}
      {% if settings.dbtfy_trust_badge_image %}
        <div class="image-wrapper-trust_badge">
          {% assign image_size = settings.dbtfy_trust_badge_width | append: "x" %}
          <img class="image-trust_badge lazyload" src="{{ settings.dbtfy_trust_badge_image | img_url: image_size }}"
               srcset="{{ settings.dbtfy_trust_badge_image | img_url: image_size }} 1x, {{ settings.dbtfy_trust_badge_image | img_url: image_size, scale: 2 }} 2x"
               alt="{{ settings.dbtfy_trust_badge_image.alt }}">
        </div>
      {% else %}
        {% include "payment-icons" %}
      {% endif %}
    </div>
  </div>
</div>
{%- endif -%}';
                $trustbadge_snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $trustbadge_snippet);

                $create_trustbadge_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-trust-badge.liquid', 'value' => $trustbadge_snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add trustbadge throws client exception');
            }
            catch(\Exception $e){
                logger('add trustbadge throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-trust-badge */ {% if settings.dbtfy_trust_badge %}.dbtfy-trust_badge{.container-trust_badge{@include display-flexbox();@include flex-direction(column)}.background-trust_badge{border-radius:$borderRadius;background-color:$colorDefault;padding:$gutter-sm;#CartDrawer &{background-color:$colorDrawerDefault}}& + *{margin-top:$spacer}.ajaxcart__note + &{margin-top:$spacer}.cart__row &{margin-top:$spacer}.image-wrapper-trust_badge{line-height:0}.payment-icons-list{margin-bottom:-$spacer-sm}.text-trust_badge{margin-bottom:$spacer-sm;&.small{font-size:$baseFontSize-sm}}.text-under-trust_badge{.text-trust_badge{order:1;margin-top:$spacer-sm;margin-bottom:0}}}{% endif %}/* end-dbtfy-trust-badge */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-trust-badge' ) ) === false ) {
                        $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);

                        $add_styles = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                        );
                }
            }
                catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on trustbadge addon throws exception');
            }

            // add include product
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-template.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , 'dbtfy-trust-badge' ) ) === false ) {
                    if( ( $pos = strrpos( $product_template , '{% unless product.description == blank or section.settings.show_description == false %}' ) ) !== false ) {
                        $new_prod_template = str_replace('{% unless product.description == blank or section.settings.show_description == false %}', '{% include "dbtfy-trust-badge", position: "product" %}{% unless product.description == blank or section.settings.show_description == false %}', $product_template);
                        $update_prod_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update product_template on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update product_template on trustbadge addon throws exception');
            }

            // add include ajax
            try{
                $ajax_cart_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/ajax-cart-template.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $ajax_cart_template , 'dbtfy-trust-badge' ) ) === false ) {
                    if( ( $pos = strrpos( $ajax_cart_template , '{% endraw %}{% endif %}{% raw %}' ) ) !== false ) {
                        $new_ajax_cart_temp = str_replace("{% endraw %}{% endif %}{% raw %}", "{% endraw %}{% endif %}{% raw %} {% endraw %}{% include 'dbtfy-trust-badge', position: 'cart' %}{% raw %}", $ajax_cart_template);
                        $update_ajax_cart_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'snippets/ajax-cart-template.liquid', 'value' => $new_ajax_cart_temp] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update ajax cart template on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update ajax cart template on trustbadge addon throws exception');
            }

            // add include cart
            try{
                $cart_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'templates/cart.liquid'] ]
                )['body']['asset']['value'] ?? '';
        $cart_data = '{{ content_for_additional_checkout_buttons }}</div>
          {% endif %}';
                if( ( $pos = strpos( $cart_template, 'dbtfy-trust-badge' ) ) === false ) {
                    if( ( $pos = strpos( $cart_template, $cart_data ) ) !== false ) {
                    	$replc_data =$cart_data.'{% include "dbtfy-trust-badge", position: "cart" %}';
                        $new_cart_template = str_replace($cart_data, $replc_data, $cart_template);
                        $updated_cart_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'templates/cart.liquid', 'value' => $new_cart_template] ]

                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update cart_template on trustbadge throws client exception');
            }
            catch(\Exception $e){
                logger('update cart_template on trustbadge throws exception');
            }

        }
    }
}

// deactivate
if (! function_exists('deactivate_trustbadge_addon')) {
    function deactivate_trustbadge_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_trustbadge_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            if(str_contains($schema,'Trust badges')){
                $json = json_decode($schema, true);
                $json = array_filter($json, function ($obj) {
                  if (stripos($obj['name'], 'Trust badges') !== false) {
                      return false;
                  }
                  return true;
                });
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
            $styles = (string) '/*================ _Trust_badge ================*/ .dbtfy-trust_badge {.container-trust_badge{@include display-flexbox();@include flex-direction(column);} .background-trust_badge{border-radius: $borderRadius;background-color: $colorDefault;padding: $gutter-sm;#CartDrawer &{background-color: $colorDrawerDefault;}}& + * {margin-top: $spacer;}.ajaxcart__note + & {margin-top: $spacer;}.cart__row & {margin-top: $spacer;}.image-wrapper-trust_badge{line-height: 0;}.payment-icons-list {margin-bottom: -$spacer-sm;}.text-trust_badge {margin-bottom: $spacer-sm;&.small {font-size: $baseFontSize-sm;}}.text-under-trust_badge{.text-trust_badge{order:1;margin-top: $spacer-sm;margin-bottom: 0px;}}}';
            $trustbadge_Style2 = (string) '/*================ _Trust_badge ================*/';
            $end2 = (string) '&.small{ font-size: $baseFontSize-sm; } } }';
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
            $trustbadge_Style3 = (string) '/*================ start-dbtfy-Trust_badge ================*/';
            $end3 = (string) '/*================ end-dbtfy-Trust_badge ================*/';
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
            $trustbadge_Style = (string) '/* start-dbtfy-trust-badge */';
            $end = (string) '/* end-dbtfy-trust-badge */';
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
            } else if($parsed2){
                $values = $trustbadge_Style2.''.$parsed2.''.$end2;
            } else{
                if($parsed){
                    $values = $trustbadge_Style.''.$parsed.''.$end;
                } else{
                    $values = $styles;
                }
            }

            if(str_contains($theme_style_content,'dbtfy-trust_badge')){
                $value = str_replace($values, " ", $theme_style_content);
                $new_theme_styles = (string) $value;

                $update_styles = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                );
            }

            // remove snippet
            $delete_trustbadge_snippet = $shop->api()->request(
                'DELETE',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/dbtfy-trust-badge.liquid'] ]
            );

            // remove include product
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/product-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-trust-badge')){
                $value  =  explode('{% include "dbtfy-trust-badge", position: "product" %}',$product_template,2);

                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                }
                else {
                    $value = (string) $product_template;
                }

                $new_prod_template = (string) $value;

                $update_prod_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                );
            }

            // remove include ajax
            $ajax_cart_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/ajax-cart-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($ajax_cart_template,'dbtfy-trust-badge')){
                if(str_contains($ajax_cart_template,'{% if settings.dbtfy_trust_badge_cart %}')){
                  $value  =  explode("{% endraw %}{% if settings.dbtfy_trust_badge_cart %}{% include 'dbtfy-trust-badge', position: 'cart' %}{% endif %}{% raw %}",$ajax_cart_template,2);
                } else{
                  $value  =  explode("{% endraw %}{% include 'dbtfy-trust-badge', position: 'cart' %}{% raw %}",$ajax_cart_template,2);
                }

                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                } else{
                    $value = (string) $ajax_cart_template;
                }

                $new_ajax_cart_temp = (string) $value;
                $update_ajax_cart_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/ajax-cart-template.liquid', 'value' => $new_ajax_cart_temp] ]
                );
            }

            // remove include cart
            $cart_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'templates/cart.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($cart_template,'dbtfy-trust-badge')){
                if(str_contains($cart_template,'{% if settings.dbtfy_trust_badge_cart %}')){
                  $value  =  explode('{% if settings.dbtfy_trust_badge_cart %}{% include "dbtfy-trust-badge", position: "cart" %}{% endif %}',$cart_template,2);
                } else{
                  $value  =  explode('{% include "dbtfy-trust-badge", position: "cart" %}',$cart_template,2);
                }

                if(isset($value[0])){
                    $value = $value[0].' '.$value[1];
                } else{
                    $value = (string) $cart_template;
                }

                $new_cart_template = (string) $value;
                $update_cart_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'templates/cart.liquid', 'value' => $new_cart_template] ]
                );
            }
        }
    }
}



if (! function_exists('deactivate_trustbadge_addon_curl')) {
    function deactivate_trustbadge_addon_curl($theme, $shop) {

        // remove schema
        $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

        if(str_contains($schema,'Trust badges')){
            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Trust badges') !== false) {
                  return false;
              }
              return true;
            });
            $value = json_encode(array_values($json));
            $updated_schema = $value;
            $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
        }

        // remove scss
        $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid') ?? '';

        // old style
        $styles = (string) '/*================ _Trust_badge ================*/ .dbtfy-trust_badge {.container-trust_badge{@include display-flexbox();@include flex-direction(column);} .background-trust_badge{border-radius: $borderRadius;background-color: $colorDefault;padding: $gutter-sm;#CartDrawer &{background-color: $colorDrawerDefault;}}& + * {margin-top: $spacer;}.ajaxcart__note + & {margin-top: $spacer;}.cart__row & {margin-top: $spacer;}.image-wrapper-trust_badge{line-height: 0;}.payment-icons-list {margin-bottom: -$spacer-sm;}.text-trust_badge {margin-bottom: $spacer-sm;&.small {font-size: $baseFontSize-sm;}}.text-under-trust_badge{.text-trust_badge{order:1;margin-top: $spacer-sm;margin-bottom: 0px;}}}';
        $trustbadge_Style2 = (string) '/*================ _Trust_badge ================*/';
        $end2 = (string) '&.small{ font-size: $baseFontSize-sm; } } }';
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
        $trustbadge_Style3 = (string) '/*================ start-dbtfy-Trust_badge ================*/';
        $end3 = (string) '/*================ end-dbtfy-Trust_badge ================*/';
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
        $trustbadge_Style = (string) '/* start-dbtfy-trust-badge */';
        $end = (string) '/* end-dbtfy-trust-badge */';
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
        } else if($parsed2){
            $values = $trustbadge_Style2.''.$parsed2.''.$end2;
        } else{
            if($parsed){
                $values = $trustbadge_Style.''.$parsed.''.$end;
            } else{
                $values = $styles;
            }
        }

        if(str_contains($theme_style_content,'dbtfy-trust_badge')){
            $value = str_replace($values, " ", $theme_style_content);
            $new_theme_styles = (string) $value;

            $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
        }

        // remove snippet
        $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-trust-badge.liquid');

        // remove include product
        $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-template.liquid');

        if(str_contains($product_template,'dbtfy-trust-badge')){
            $value  =  explode('{% include "dbtfy-trust-badge", position: "product" %}',$product_template,2);

            if(isset($value[0]) && isset($value[1])){
                $value = $value[0].' '.$value[1];
            }
            else {
                $value = (string) $product_template;
            }

            $new_prod_template = (string) $value;

            $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'snippets/product-template.liquid');
        }

        // remove include ajax
        $ajax_cart_template = getThemeFileCurl($shop, $theme, 'snippets/ajax-cart-template.liquid') ?? '';

        if(str_contains($ajax_cart_template,'dbtfy-trust-badge')){
            if(str_contains($ajax_cart_template,'{% if settings.dbtfy_trust_badge_cart %}')){
              $value  =  explode("{% endraw %}{% if settings.dbtfy_trust_badge_cart %}{% include 'dbtfy-trust-badge', position: 'cart' %}{% endif %}{% raw %}",$ajax_cart_template,2);
            } else{
              $value  =  explode("{% endraw %}{% include 'dbtfy-trust-badge', position: 'cart' %}{% raw %}",$ajax_cart_template,2);
            }

            if(isset($value[0]) && isset($value[1])){
                $value = $value[0].' '.$value[1];
            } else{
                $value = (string) $ajax_cart_template;
            }

            $new_ajax_cart_temp = (string) $value;
            $update_ajax_cart_template = putThemeFileCurl($shop, $theme, $new_ajax_cart_temp, 'snippets/ajax-cart-template.liquid');
        }

        // remove include cart
        $cart_template = getThemeFileCurl($shop, $theme, 'templates/cart.liquid') ?? '';

        if(str_contains($cart_template,'dbtfy-trust-badge')){
            if(str_contains($cart_template,'{% if settings.dbtfy_trust_badge_cart %}')){
              $value  =  explode('{% if settings.dbtfy_trust_badge_cart %}{% include "dbtfy-trust-badge", position: "cart" %}{% endif %}',$cart_template,2);
            } else{
              $value  =  explode('{% include "dbtfy-trust-badge", position: "cart" %}',$cart_template,2);
            }

            if(isset($value[0])){
                $value = $value[0].' '.$value[1];
            } else{
                $value = (string) $cart_template;
            }

            $new_cart_template = (string) $value;
            $update_cart_template = putThemeFileCurl($shop, $theme, $new_cart_template, 'templates/cart.liquid');
        }
    }
}
?>
