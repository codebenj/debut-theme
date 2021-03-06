<?php
//activate
if (! function_exists('activate_inventory_quantity_addon')) {
    function activate_inventory_quantity_addon($StoreThemes, $shop) {
        foreach ($StoreThemes as $theme) {

            // Update schema file
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '
{
    "name": "Inventory quantity",
    "settings": [
      {
        "type": "header",
        "content": "Activation"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_inventory_quantity",
        "label": "Activate",
        "default": true
      },
      {
        "type": "header",
        "content": "Text Settings"
      },
      {
        "type": "text",
        "id": "dbtfy_inventory_quantity_icon",
        "label": "Icon",
        "default": "stopwatch",
        "info": "Enter the name of any free solid icons on [FontAwesome](https:\/\/fontawesome.com\/icons?d=gallery&s=solid&m=free)"
      },
      {
        "type": "text",
        "id": "dbtfy_inventory_quantity_prefix",
        "label": "Prefix",
        "default": "Only"
      },
      {
        "type": "text",
        "id": "dbtfy_inventory_quantity_suffix",
        "label": "Suffix",
        "default": "left in stock"
      },
      {
        "type": "header",
        "content": "Quantity Settings"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_inventory_quantity_temp",
        "label": "Show random quantities",
        "default": true,
        "info": "Uncheck to show real inventory"
      },
      {
        "type": "range",
        "id": "dbtfy_inventory_quantity_min",
        "label": "Min quantity",
        "min": 1,
        "max": 99,
        "step": 1,
        "default": 3
      },
      {
        "type": "range",
        "id": "dbtfy_inventory_quantity_max",
        "label": "Max quantity",
        "min": 1,
        "max": 99,
        "step": 1,
        "default": 14
      }
    ]
  }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_inventory_quantity' ) ) === false ) {
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

            // add snippet
            try{
                $snippet = (string) '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}
{%- if settings.dbtfy_inventory_quantity -%}
<div class="dbtfy dbtfy-inventory_quantity"
     data-min="{{ settings.dbtfy_inventory_quantity_min }}"
     data-max="{{ settings.dbtfy_inventory_quantity_max }}"
     data-temp="{{ settings.dbtfy_inventory_quantity_temp }}">
  <div id="InventoryQuantity" class="InventoryQuantity" style="display:none">
    {% unless settings.dbtfy_inventory_quantity_icon == "" %}
    <span class="fas fa-{{ settings.dbtfy_inventory_quantity_icon }} fa-fw"></span>
    {% endunless %}
    <span class="quantity-text">{{ settings.dbtfy_inventory_quantity_prefix }}</span>

    {% if settings.dbtfy_inventory_quantity_temp %}
    <strong class="quantity-item-temp"></strong>
    {% else %}
      {% for variant in product.variants %}
        {% if variant.inventory_quantity > 0 and variant.inventory_management == "shopify" %}
        <strong class="quantity-item quantity-item-{{ variant.id }}" style="display:none;">
          {{ variant.inventory_quantity }}
        </strong>
        {% endif %}
      {% endfor %}
    {% endif %}
    <span class="quantity-text">{{ settings.dbtfy_inventory_quantity_suffix }}</span>
  </div>
</div>
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

                $create_trustbadge_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-inventory-quantity.liquid', 'value' => $snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add inventory_quantity throws client exception');
            }
            catch(\Exception $e){
                logger('add inventory_quantity throws exception');
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-inventory-quantity */ function themeInventoryQuantity(container) { {% if settings.dbtfy_inventory_quantity %} var _0xedcb=["\x2E\x64\x62\x74\x66\x79\x2D\x69\x6E\x76\x65\x6E\x74\x6F\x72\x79\x5F\x71\x75\x61\x6E\x74\x69\x74\x79","\x74\x65\x6D\x70","\x64\x61\x74\x61","\x6D\x69\x6E","\x6D\x61\x78","\x74\x6F\x4C\x6F\x77\x65\x72\x43\x61\x73\x65","\x74\x72\x69\x6D","\x74\x65\x78\x74","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x64\x65\x74\x61\x69\x6C\x73\x20\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x74\x69\x74\x6C\x65","\x66\x69\x6E\x64","\x2E\x71\x75\x61\x6E\x74\x69\x74\x79\x2D\x69\x74\x65\x6D\x2D\x74\x65\x6D\x70","\x73\x74\x6F\x72\x65\x64\x51\x75\x61\x6E\x74\x69\x74\x79\x2D","\x67\x65\x74\x49\x74\x65\x6D","","\x72\x61\x6E\x64\x6F\x6D","\x66\x6C\x6F\x6F\x72","\x76\x61\x6C","\x23\x50\x72\x6F\x64\x75\x63\x74\x53\x65\x6C\x65\x63\x74\x20\x6F\x70\x74\x69\x6F\x6E\x3A\x73\x65\x6C\x65\x63\x74\x65\x64","\x2E\x49\x6E\x76\x65\x6E\x74\x6F\x72\x79\x51\x75\x61\x6E\x74\x69\x74\x79","\x2E\x71\x75\x61\x6E\x74\x69\x74\x79\x2D\x69\x74\x65\x6D","\x3A\x64\x69\x73\x61\x62\x6C\x65\x64","\x69\x73","\x2E\x62\x74\x6E\x2D\x2D\x61\x64\x64\x2D\x74\x6F\x2D\x63\x61\x72\x74","\x68\x69\x64\x65","\x73\x68\x6F\x77","\x2E\x71\x75\x61\x6E\x74\x69\x74\x79\x2D\x69\x74\x65\x6D\x2D","\x73\x65\x74\x49\x74\x65\x6D","\x63\x68\x61\x6E\x67\x65","\x6F\x6E","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x66\x6F\x72\x6D\x5F\x5F\x69\x6E\x70\x75\x74\x2C\x2E\x73\x69\x6E\x67\x6C\x65\x2D\x6F\x70\x74\x69\x6F\x6E\x2D\x72\x61\x64\x69\x6F"];function InventoryQuantity(){var _0x7105x2=$(_0xedcb[0]),_0x7105x3=_0x7105x2[_0xedcb[2]](_0xedcb[1]),_0x7105x4=_0x7105x2[_0xedcb[2]](_0xedcb[3]),_0x7105x5=_0x7105x2[_0xedcb[2]](_0xedcb[4]),_0x7105x6=$(container),_0x7105x7=_0x7105x6[_0xedcb[9]](_0xedcb[8])[_0xedcb[7]]()[_0xedcb[6]]()[_0xedcb[5]](),_0x7105x8=_0x7105x6[_0xedcb[9]](_0xedcb[10]),_0x7105x9=sessionStorage[_0xedcb[12]](_0xedcb[11]+ _0x7105x7)|| _0xedcb[13];if(_0x7105x9){_0x7105x5= sessionStorage[_0xedcb[12]](_0xedcb[11]+ _0x7105x7)};if(_0x7105x9){if(_0x7105x9== _0x7105x4){var _0x7105xa=_0x7105x4}else {_0x7105xa= _0x7105x5- 1}}else {_0x7105xa= Math[_0xedcb[15]](Math[_0xedcb[14]]()* (_0x7105x5- _0x7105x4+ 1))+ _0x7105x4};function _0x7105xb(){var _0x7105x2=_0x7105x6[_0xedcb[9]](_0xedcb[17])[_0xedcb[16]](),_0x7105x4=_0x7105x6[_0xedcb[9]](_0xedcb[18]),_0x7105x5=_0x7105x6[_0xedcb[9]](_0xedcb[19]);_0x7105x6[_0xedcb[9]](_0xedcb[22])[_0xedcb[21]](_0xedcb[20])?_0x7105x4[_0xedcb[23]]():_0x7105x3?_0x7105x4[_0xedcb[24]]():_0x7105x6[_0xedcb[9]](_0xedcb[25]+ _0x7105x2)[0]?(_0x7105x5[_0xedcb[23]](),_0x7105x6[_0xedcb[9]](_0xedcb[25]+ _0x7105x2)[_0xedcb[24]](),_0x7105x4[_0xedcb[24]]()):_0x7105x4[_0xedcb[23]]()}_0x7105x8[_0xedcb[7]](_0x7105xa),sessionStorage[_0xedcb[26]](_0xedcb[11]+ _0x7105x7,_0x7105xa),_0x7105xb(),_0x7105x6[_0xedcb[9]](_0xedcb[29])[_0xedcb[28]](_0xedcb[27],function(){_0x7105xb()})}InventoryQuantity() {% endif %} } /* end-dbtfy-inventory-quantity */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-inventory-quantity */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-inventory-quantity */sections.register("product-template", themeInventoryQuantity);/* end-register-inventory-quantity */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-inventory-quantity */' ) ) === false ) {
                        $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }
            }catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update js on cookie_box addon throws client exception');
            }
            catch(\Exception $e){
                logger('update js on cookie_box addon throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-inventory-quantity */{% if settings.dbtfy_inventory_quantity %}.dbtfy-inventory_quantity{.InventoryQuantity{margin-bottom:$spacer}}{% endif %}/* end-dbtfy-inventory-quantity */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-inventory-quantity' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);
                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on inventory_quantity addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on inventory_quantity addon throws exception');
            }

            // add include
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-template.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , 'dbtfy-inventory-quantity' ) ) === false ) {
                  if( ( $pos = strrpos( $product_template , '{% include "dbtfy-live-view" %}' ) ) !== false ) {
                      $new_prod_template = str_replace('{% include "dbtfy-live-view" %}', '{% include "dbtfy-inventory-quantity" %}{% include "dbtfy-live-view" %}', $product_template);
                      $update_prod_template = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                      );
                  }
                  elseif( ( $pos = strrpos( $product_template , '{% include "dbtfy-delivery-time" %}' ) ) !== false ) {
                      $new_prod_template = str_replace('{% include "dbtfy-delivery-time" %}', '{% include "dbtfy-inventory-quantity" %}{% include "dbtfy-delivery-time" %}', $product_template);
                      $update_prod_template = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                      );
                  }
                  elseif( ( $pos = strrpos( $product_template , '<meta itemprop="priceCurrency" content="{{ shop.currency }}">' ) ) !== false ) {
                      $new_prod_template = str_replace('<meta itemprop="priceCurrency" content="{{ shop.currency }}">', '{% include "dbtfy-inventory-quantity" %}<meta itemprop="priceCurrency" content="{{ shop.currency }}">', $product_template);
                      $update_prod_template = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                      );
                  }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update dbtfy-inventory-quantity on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update dbtfy-inventory-quantity on trustbadge addon throws exception');
            }

        }
    }
}

//deativate
if (! function_exists('deactivate_inventory_quantity_addon')) {
    function deactivate_inventory_quantity_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_inventory_quantity_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Inventory quantity') !== false) {
                  return false;
              }
              return true;
            });

            if(str_contains($schema,'Inventory quantity')){
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

            $trustbadge_Style = (string) '/* start-dbtfy-inventory-quantity */';
            $end = (string) '/* end-dbtfy-inventory-quantity */';
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

            if(str_contains($theme_style_content,'.dbtfy-inventory_quantity')){
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
                ['asset' => ['key' => 'snippets/dbtfy-inventory-quantity.liquid'] ]
            );

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/product-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-inventory-quantity')){
                $value  =  explode('{% include "dbtfy-inventory-quantity" %}',$product_template,2);

                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                }
                else{
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

                $trustbadge_js = (string) '/* start-dbtfy-inventory-quantity */';
                $end_js = (string) '/* end-dbtfy-inventory-quantity */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-inventory-quantity */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-inventory-quantity */')){
                        $trustbadge_js1 = (string) '/* start-register-inventory-quantity */';
                        $end_js = (string) '/* end-register-inventory-quantity */';
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
                logger('add inventory_quantity throws client exception');
            }
            catch(\Exception $e){
                logger('add inventory_quantity throws exception');
            }
        }
    }
}


if (! function_exists('deactivate_inventory_quantity_addon_curl')) {
  function deactivate_inventory_quantity_addon_curl($theme, $shop) {

    // remove schema
    $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

    $json = json_decode($schema, true);
    $json = array_filter($json, function ($obj) {
      if (stripos($obj['name'], 'Inventory quantity') !== false) {
          return false;
      }
      return true;
    });

    if(str_contains($schema,'Inventory quantity')){
        $value = json_encode(array_values($json));
        $updated_schema = $value;
        $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid') ?? '';

    $trustbadge_Style = (string) '/* start-dbtfy-inventory-quantity */';
    $end = (string) '/* end-dbtfy-inventory-quantity */';
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

    if(str_contains($theme_style_content,'.dbtfy-inventory_quantity')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove snippet
    $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-inventory-quantity.liquid');

    // remove include
    $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-template.liquid');

    if(str_contains($product_template,'dbtfy-inventory-quantity')){
        $value  =  explode('{% include "dbtfy-inventory-quantity" %}',$product_template,2);

        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        }
        else{
            $value = (string) $product_template;
        }

        $new_prod_template = (string) $value;
        $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'snippets/product-template.liquid');
    }

    // remove js addon
    try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

        $trustbadge_js = (string) '/* start-dbtfy-inventory-quantity */';
        $end_js = (string) '/* end-dbtfy-inventory-quantity */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-inventory-quantity */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-inventory-quantity */')){
                $trustbadge_js1 = (string) '/* start-register-inventory-quantity */';
                $end_js = (string) '/* end-register-inventory-quantity */';
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
        logger('add inventory_quantity throws client exception');
    }
    catch(\Exception $e){
        logger('add inventory_quantity throws exception');
    }
  }
}
?>
