<?php
use Illuminate\Support\Arr;

//activate
if (! function_exists('activate_collection_addtocart_addon')) {
    function activate_collection_addtocart_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $collection_addtocart_addon_schema = (string) '
                {
                    "name": "Collection add-to-cart",
                    "settings": [
                      {
                        "type": "header",
                        "content": "Activation"
                      },
                      {
                        "type": "checkbox",
                        "id": "dbtfy_collection_addtocart",
                        "label": "Activate",
                        "default": false
                      }
                    ]
                  }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_collection_addtocart' ) ) === false ) {
                    if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                        $updated_schema    = substr_replace( $schema , ",".$collection_addtocart_addon_schema."]" , $pos );
                        $update_schema_settings = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'config/settings_schema.json', 'value' => $updated_schema] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update schema on Collection add-to-cart addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on Collection add-to-cart addon throws exception');
            }

            // add snippet
            try{
                $collection_addtocart_snippet = (string) '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}
                {%- if settings.dbtfy_collection_addtocart -%}
                {%- unless emptyState -%}
                <div class="dbtfy dbtfy-collection_addtocart">
                  <div id="CollectionAddtocart">
                    <form id="ca-form-{{ section.id}}-{{product.id}}" autocomplete="off" action="/cart/add" method="post" class="add-to-cart__form ca-form {% if sold_out %}variant-soldout{% else %}variant-available{% endif %}" enctype="multipart/form-data">
                      <select class="btn btn-outline-buy btn--small full ca-select {% if sold_out %}disabled{% endif %}" name="id" {% if sold_out %}disabled="disabled"{% endif %} {% if product.has_only_default_variant %}style="display:none"{% endif %}>
                        <option disabled="disabled" {% unless product.has_only_default_variant %}selected="selected"{% endunless %} hidden="hidden">
                          {% if sold_out %}
                          {{ "products.product.sold_out" | t }}
                          {% else %}
                          {{ "products.product.add_to_cart" | t }}
                          {% endif %}
                        </option>
                        {% for variant in product.variants %}
                        {% if variant.available %}
                        <option value="{{ variant.id }}" {% if product.has_only_default_variant %}selected="selected"{% endif %}>{{ variant.title | escape }} - {{ variant.price | money }}</option>
                        {% else %}
                        <option value="{{ variant.id }}" disabled="disabled">{{ variant.title | escape }} - {{ "products.product.sold_out" | t }}</option>
                        {% endif %}
                        {% endfor %}
                      </select>
                      <button id="ca-button-{{ section.id}}-{{product.id}}" name="add" type="submit" class="btn btn-outline-buy btn--small full ca-button add-to-cart {% if sold_out %}disabled{% endif %}" {% if sold_out %}disabled="disabled"{% endif %} {% unless product.has_only_default_variant %}style="display:none"{% endunless %}>
                        {% if sold_out %}
                        {{ "products.product.sold_out" | t }}
                        {% else %}
                        {{ "products.product.add_to_cart" | t }}
                        {% endif %}
                      </button>
                    </form>
                  </div>
                </div>
                {%- endunless -%}
                {%- endif -%}';

                $collection_addtocart_snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $collection_addtocart_snippet);

               $create_trustbadge_snippet = $shop->api()->request(
                            'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-collection-addtocart.liquid', 'value' => $collection_addtocart_snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add collection_addtocart throws client exception');
            }
            catch(\Exception $e){
                logger('add collection_addtocart throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-collection-addtocart */{% if settings.dbtfy_collection_addtocart %}.dbtfy-collection_addtocart{.ca-form{margin-top:$spacer-sm;}.ca-button{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}.ca-select{text-align-last: center;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;background-image:none!important;&.disabled{@include button($colorBuy, $colorButtonText, outline);}option{text-transform:initial;}}}.ca-loading{@include display-flexbox;@include justify-content(center);@include align-items(center);&:after{content:"\f110";@include fontAwesome;@include animation(fa-spin 2s infinite linear);color:$colorSecondary;}}{% endif %}/* end-dbtfy-collection-addtocart */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-collection-addtocart' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);

                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on collection_addtocart addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on collection_addtocart addon throws exception');
            }

            // add include
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-grid-item.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , '{% include "dbtfy-collection-addtocart" %}' ) ) === false ) {
                      $new_prod_template = str_replace('<a href="{{ product_link }}"', '{% include "dbtfy-collection-addtocart" %} <a href="{{ product_link }}"', $product_template);
                      $update_prod_template = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'snippets/product-grid-item.liquid', 'value' => $new_prod_template] ]
                      );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update collection_addtocart on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update collection_addtocart on trustbadge addon throws exception');
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-collection-addtocart */ function themeCollectionAddtocart(){ {%- if settings.dbtfy_collection_addtocart -%} var _0x9258=["\x2E\x63\x61\x2D\x73\x65\x6C\x65\x63\x74","\x2E\x63\x61\x2D\x62\x75\x74\x74\x6F\x6E","\x2E\x67\x72\x69\x64\x2D\x70\x72\x6F\x64\x75\x63\x74","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x2D\x77\x72\x61\x70\x70\x65\x72","\x63\x61\x2D\x6C\x6F\x61\x64\x69\x6E\x67","\x63\x6C\x69\x63\x6B","\x66\x69\x6E\x64","\x63\x6C\x6F\x73\x65\x73\x74","\x62\x74\x6E\x2D\x2D\x62\x75\x79","\x61\x64\x64\x43\x6C\x61\x73\x73","\x62\x74\x6E\x2D\x6F\x75\x74\x6C\x69\x6E\x65\x2D\x62\x75\x79","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x61\x6A\x61\x78\x43\x61\x72\x74\x2E\x61\x66\x74\x65\x72\x43\x61\x72\x74\x4C\x6F\x61\x64","\x6F\x6E","\x62\x6F\x64\x79","\x63\x68\x61\x6E\x67\x65","\x6E\x65\x78\x74","\x74\x72\x69\x67\x67\x65\x72","\x23\x70\x72\x6F\x64\x75\x63\x74\x52\x65\x63\x6F\x6D\x6D\x65\x6E\x64\x61\x74\x69\x6F\x6E\x73\x53\x65\x63\x74\x69\x6F\x6E","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x72\x65\x63\x6F\x6D\x6D\x65\x6E\x64\x61\x74\x69\x6F\x6E\x73"];function CollectionAddtocart(){var _0x1182x2=$(_0x9258[0]),_0x1182x3=$(_0x9258[1]),_0x1182x4=$(_0x9258[2]),_0x1182x5=$(_0x9258[3]),_0x1182x6=_0x9258[4];_0x1182x3[_0x9258[13]](_0x9258[5],function(){var _0x1182x7,_0x1182x2=$(this),_0x1182x3=_0x1182x2[_0x9258[7]](_0x1182x4)[_0x9258[6]](_0x1182x5);_0x1182x7= _0x1182x3,_0x1182x2[_0x9258[11]](_0x9258[10])[_0x9258[9]](_0x9258[8]),_0x1182x7[_0x9258[9]](_0x1182x6),$(_0x9258[14])[_0x9258[13]](_0x9258[12],function(_0x1182x2,_0x1182x3){_0x1182x7[_0x9258[11]](_0x1182x6)})}),_0x1182x2[_0x9258[13]](_0x9258[15],function(){var _0x1182x2=$(this)[_0x9258[16]]();setTimeout(function(){_0x1182x2[_0x9258[17]](_0x9258[5])},0)})}function checkProductRecommendation(_0x1182x3){var _0x1182x7;$(_0x9258[18])[0]?(_0x1182x7= 1,function _0x1182x2(){$(_0x9258[19])[0]?_0x1182x3():setTimeout(function(){10== _0x1182x7?_0x1182x3():(_0x1182x7++,_0x1182x2())},100)}()):_0x1182x3()}checkProductRecommendation(CollectionAddtocart) {%- endif -%} } /* end-dbtfy-collection-addtocart */';


                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , '/* start-register-collection-addtocart */' ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-collection-addtocart */themeCollectionAddtocart();/* end-register-collection-addtocart */', $theme_js_content);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }

                $theme_js_content1 = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';
                $replace_code= '/* start-dbtfy-addons */';
                if( ( $pos = strpos( $theme_js_content1 , '/* start-dbtfy-collection-addtocart */' ) ) === false ) {
                    $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content1);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update js on cookie_box addon throws client exception');
            }
            catch(\Exception $e){
                logger('update js on cookie_box addon throws exception');
            }

        }
    }
}

// deactivate
if (! function_exists('deactivate_collection_addtocart_addon')) {
    function deactivate_collection_addtocart_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_collection_addtocart_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            if(str_contains($schema,'Collection add-to-cart')){
                $json = json_decode($schema, true);
                $json = array_filter($json, function ($obj) {
                  if (stripos($obj['name'], 'Collection add-to-cart') !== false) {
                      return false;
                  }
                  return true;
                });
                $value = json_encode(array_values($json));
                $updated_schema =  $value;
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


            // new style
            $trustbadge_Style = (string) '/* start-dbtfy-collection-addtocart */';
            $end = (string) '/* end-dbtfy-collection-addtocart */';
            $string = ' ' . $theme_style_content;
            $ini = strpos($string, $trustbadge_Style);

            if ($ini == 0) {
                $parsed = '';
            }
            else{
                $ini += strlen($trustbadge_Style);
                $len = strpos($string, $end, $ini) - $ini;
                $parsed = substr($string, $ini, $len);
            }
            $values = $trustbadge_Style.''.$parsed.''.$end;

            if(str_contains($theme_style_content,'/* start-dbtfy-collection-addtocart */')){
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
                ['asset' => ['key' => 'snippets/dbtfy-collection-addtocart.liquid'] ]
            );

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/product-grid-item.liquid'] ]
            )['body']['asset']['value'] ?? '';


            if(str_contains($product_template,'{% include "dbtfy-collection-addtocart" %}')){
                logger('Remove logger 2');
                $value  =  explode('{% include "dbtfy-collection-addtocart" %}',$product_template,2);

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
                    ['asset' => ['key' => 'snippets/product-grid-item.liquid', 'value' => $new_prod_template] ]
                );
            }

            sleep(5);

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/product-grid-item.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'{% include "dbtfy-collection-addtocart", type: "image" %}')){
                $value  =  explode('{% include "dbtfy-collection-addtocart", type: "image" %}',$product_template,2);

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
                    ['asset' => ['key' => 'snippets/product-grid-item.liquid', 'value' => $new_prod_template] ]
                );
            }

            // remove js addon
            try{
              $theme_js_content = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
              )['body']['asset']['value'] ?? '';
  
              $trustbadge_js = (string) '/* start-dbtfy-collection-addtocart */';
              $end_js = (string) '/* end-dbtfy-collection-addtocart */';
              $string_js = ' ' . $theme_js_content;
              $ini_js = strpos($string_js, $trustbadge_js);
              if ($ini_js == 0) {
                  $parsed_js = '';
              }else{
                  $ini_js += strlen($trustbadge_js);
                  $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
                  $parsed_js = substr($string_js, $ini_js, $len_js);
              }
              $value_js = $trustbadge_js.''.$parsed_js.''.$end_js;
              if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-collection-addtocart */')){
                $value = str_replace($value_js, " ", $theme_js_content);
                $new_theme_js = (string) $value;
                /* Remove another code */
                if(str_contains($new_theme_js,'/* start-register-collection-addtocart */')){
                  $trustbadge_js1 = (string) '/* start-register-collection-addtocart */';
                  $end_js = (string) '/* end-register-collection-addtocart */';
                  $string_js = ' ' . $new_theme_js;
                  $ini_js = strpos($string_js, $trustbadge_js1);
                  if ($ini_js == 0) {
                      $parsed_js = '';
                  }else{
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
                } else{
                  $update_js = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                  );
                }
              }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add collection_addtocart throws client exception');
            }
            catch(\Exception $e){
                logger('add collection_addtocart throws exception');
            }

            // remove js register
            try{
              $theme_js_content = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
              )['body']['asset']['value'];
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add collection_addtocart throws client exception');
            }
            catch(\Exception $e){
                logger('add collection_addtocart throws exception');
            }

        }
    }
}



if (! function_exists('deactivate_collection_addtocart_addon_curl')) {
    function deactivate_collection_addtocart_addon_curl($theme, $shop) {

        // remove schema
        $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json');

        if(str_contains($schema,'Collection add-to-cart')){
            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Collection add-to-cart') !== false) {
                  return false;
              }
              return true;
            });
            $value = json_encode(array_values($json));
            $updated_schema =  $value;
            $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
        }

        // remove scss
        $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid');

        // new style
        $trustbadge_Style = (string) '/* start-dbtfy-collection-addtocart */';
        $end = (string) '/* end-dbtfy-collection-addtocart */';
        $string = ' ' . $theme_style_content;
        $ini = strpos($string, $trustbadge_Style);

        if ($ini == 0) {
            $parsed = '';
        }
        else{
            $ini += strlen($trustbadge_Style);
            $len = strpos($string, $end, $ini) - $ini;
            $parsed = substr($string, $ini, $len);
        }
        $values = $trustbadge_Style.''.$parsed.''.$end;

        if(str_contains($theme_style_content,'/* start-dbtfy-collection-addtocart */')){
            $value = str_replace($values, " ", $theme_style_content);
            $new_theme_styles = (string) $value;

            $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
        }

        // remove snippet
        $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-collection-addtocart.liquid');

        // remove include
        $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-grid-item.liquid');


        if(str_contains($product_template,'{% include "dbtfy-collection-addtocart" %}')){
            logger('Remove logger 2');
            $value  =  explode('{% include "dbtfy-collection-addtocart" %}',$product_template,2);

            if(isset($value[0]) && isset($value[1])){
                $value = $value[0].' '.$value[1];
            }
            else{
                $value = (string) $product_template;
            }

            $new_prod_template = (string) $value;
            $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'snippets/product-grid-item.liquid');
        }

        sleep(5);

        // remove include
        $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-grid-item.liquid');

        if(str_contains($product_template,'{% include "dbtfy-collection-addtocart", type: "image" %}')){
            $value  =  explode('{% include "dbtfy-collection-addtocart", type: "image" %}',$product_template,2);

            if(isset($value[0]) && isset($value[1])){
                $value = $value[0].' '.$value[1];
            }
            else{
                $value = (string) $product_template;
            }

            $new_prod_template = (string) $value;
            $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'snippets/product-grid-item.liquid');
        }

        // remove js addon
        try{
          $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid');
          if ($theme_js_content == null)
            {
                $theme_js_content = '';
            }
          $trustbadge_js = (string) '/* start-dbtfy-collection-addtocart */';
          $end_js = (string) '/* end-dbtfy-collection-addtocart */';
          $string_js = ' ' . $theme_js_content;
          $ini_js = strpos($string_js, $trustbadge_js);
          if ($ini_js == 0) {
              $parsed_js = '';
          }else{
              $ini_js += strlen($trustbadge_js);
              $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
              $parsed_js = substr($string_js, $ini_js, $len_js);
          }
          $value_js = $trustbadge_js.''.$parsed_js.''.$end_js;
          if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-collection-addtocart */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            /* Remove another code */
            if(str_contains($new_theme_js,'/* start-register-collection-addtocart */')){
              $trustbadge_js1 = (string) '/* start-register-collection-addtocart */';
              $end_js = (string) '/* end-register-collection-addtocart */';
              $string_js = ' ' . $new_theme_js;
              $ini_js = strpos($string_js, $trustbadge_js1);
              if ($ini_js == 0) {
                  $parsed_js = '';
              }else{
                  $ini_js += strlen($trustbadge_js1);
                  $len_js = strpos($string_js, $end_js, $ini_js) - $ini_js;
                  $parsed_js = substr($string_js, $ini_js, $len_js);
              }
              $value_js = $trustbadge_js1.''.$parsed_js.''.$end_js;
              $value = str_replace($value_js, " ", $new_theme_js);
              $new_theme_js1 = (string) $value;
              $update_js = putThemeFileCurl($shop, $theme, $new_theme_js1, 'assets/dbtfy-addons.js.liquid');
            } else{
              $update_js = putThemeFileCurl($shop, $theme, $new_theme_js, 'assets/dbtfy-addons.js.liquid');
            }
          }
        }
        catch(\GuzzleHttp\Exception\ClientException $e){
            logger('add collection_addtocart throws client exception');
        }
        catch(\Exception $e){
            logger('add collection_addtocart throws exception');
        }

    }
}
?>
