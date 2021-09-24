<?php

if (! function_exists('activate_salespop_addon')) {
    function activate_salespop_addon($StoreThemes, $shop) {
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
    "name": "Sales pop",
    "settings": [
      {
        "type": "header",
        "content": "Activation"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sales_pop",
        "label": "Activate",
        "default": false
      },
      {
        "type": "header",
        "content": "Notification settings"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sales_pop_mobile",
        "label": "Hide on mobile"
      },
      {
        "type": "collection",
        "id": "dbtfy_sales_pop_collection",
        "label": "Collection",
        "info": "Leave empty for all products"
      },
      {
        "type": "range",
        "id": "dbtfy_sales_pop_timeago",
        "label": "Max time ago (hours)",
        "min": 1,
        "max": 96,
        "step": 1,
        "default": 30
      },
      {
        "type": "range",
        "id": "dbtfy_sales_pop_display",
        "label": "Display time (seconds)",
        "min": 3,
        "max": 10,
        "step": 1,
        "default": 4
      },
      {
        "type": "range",
        "id": "dbtfy_sales_pop_interval",
        "label": "Interval time (seconds)",
        "min": 5,
        "max": 20,
        "step": 1,
        "default": 6
      },
      {
        "type": "header",
        "content": "Text settings"
      },
      {
        "type": "textarea",
        "id": "dbtfy_sales_pop_name",
        "label": "Names",
        "default": "Someone",
        "info": "Comma-separated"
      },
      {
        "type": "textarea",
        "id": "dbtfy_sales_pop_city",
        "label": "Cities",
        "info": "Comma-separated",
        "default": "Montreal Canada"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_purchase",
        "label": "Purchased",
        "default": "has purchased"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_emoji",
        "label": "Purchase emoji",
        "default": "👏",
        "info": "Copy & paste an [Emoji](https://www.emojicopy.com/)"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_prefix",
        "label": "Time prefix"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_suffix",
        "label": "Time suffix",
        "default": "ago"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_icony",
        "label": "Verified icon",
        "default": "check-circle"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_verified",
        "label": "Verified text",
        "default": "Verified"
      },
      {
        "type": "header",
        "content": "Translations"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_minute",
        "label": "Minute",
        "default": "minute"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_minutes",
        "label": "Minutes",
        "default": "minutes"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_hour",
        "label": "Hour",
        "default": "hour"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_hours",
        "label": "Hours",
        "default": "hours"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_day",
        "label": "Day",
        "default": "day"
      },
      {
        "type": "text",
        "id": "dbtfy_sales_pop_days",
        "label": "Days",
        "default": "days"
      }
    ]
  }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_sales_pop' ) ) === false ) {
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
{%- if settings.dbtfy_sales_pop -%}
<div class="dbtfy dbtfy-sales_pop"
     data-display-time="{{settings.dbtfy_sales_pop_display}}000"
     data-interval-time="{{settings.dbtfy_sales_pop_interval}}000"
     data-time-ago="{{settings.dbtfy_sales_pop_timeago | times: 60}}">
  {% unless settings.dbtfy_sales_pop_collection == blank %}
    {% assign salespop_collection = collections[settings.dbtfy_sales_pop_collection] %}
  {% else %}
    {% assign salespop_collection = collections.all %}
  {% endunless %}
  <div id="SalesPop" class="animated faster {% if settings.dbtfy_sales_pop_mobile %}small--hide{% endif %}" style="display:none;">
    <div class="container-sales_pop">
      <div class="item-wrapper-sales_pop">
        {% for product in salespop_collection.products limit:100 %}
          <div class="item-sales_pop" style="display:none;">
            <div class="image-wrapper-sales_pop">
              <a href="{{ product.url }}" class="image-link-sales_pop">
                <img class="image-sales_pop" src="{{ product | img_url: "65x65", crop: "center" }}"
                     srcset="{{ product | img_url: "65x65", crop: "center" }} 1x, {{ product | img_url: "65x65", crop: "center", scale: 2 }} 2x">
              </a>
            </div>
            <div class="text-wrapper-sales_pop">
              <div class="name-wrapper-sales_pop">
                <span class="name-sales_pop"></span>
                <small class="city-wrapper-sales_pop">
                  (<small class="city-sales_pop"></small>)
                </small>
              </div>
              <div class="purchased-wrapper-sales_pop">
                <small class="purchased-sales_pop">{{ settings.dbtfy_sales_pop_purchase }}</small>
                <a href="{{ product.url }}" class="link-sales_pop">{{ product.title }}</a>
                <small>{{ settings.dbtfy_sales_pop_emoji }}</small>
              </div>
              <div class="time-wrapper-sales_pop">
                <small>{{ settings.dbtfy_sales_pop_prefix }}</small>
                <small class="time-sales_pop"></small>
                <small>{{ settings.dbtfy_sales_pop_suffix }}</small>
                <small class="fas fa-{{ settings.dbtfy_sales_pop_icony }}"></small>
                <small>{{ settings.dbtfy_sales_pop_verified }}</small>
              </div>
            </div>
          </div>
        {% endfor %}
      </div>
      <button class="btn btn-square-small btn-close-sales_pop">
        <span class="fas fa-times"></span>
      </button>
    </div>
  </div>
</div>
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

              $create_trustbadge_snippet = $shop->api()->request(
                'PUT',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/dbtfy-sales-pop.liquid', 'value' => $snippet] ]
              );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                // logger(json_encode($e));
                logger('add sales_pop throws client exception');
            }
            catch(\Exception $e){
                logger('add sales_pop throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-sales-pop */{% if settings.dbtfy_sales_pop %}.dbtfy-sales_pop{#SalesPop{padding:$gutter-sm/2;position:fixed;background:$colorBody;bottom:$gutter;left:$gutter;top:auto!important;right:auto!important;width:320px;z-index:$zindexOverBody;@include shadow($shadow);@include RadiusCircle;@include transition($transitions);@include screen($small){bottom:0;left:0;right:0;width:100%;border-radius:0}&:hover{.btn-close-sales_pop{opacity:1;@include hovers}}.template-product.scroll-sticky_addtocart &{bottom:$gutter+$heightInput+$gutter-sm;@include screen($small){bottom:$heightInputSmall+$gutter-sm}}}.container-sales_pop{@include display-flexbox();@include align-items(center)}.item-wrapper-sales_pop{@include flex(1);min-width:0}.item-sales_pop{@include display-flexbox()}.image-wrapper-sales_pop{line-height:0;@include flex-shrink(0)}.image-link-sales_pop{display:block}.image-sales_pop{@include RadiusCircle;width:$heightInput;height:$heightInput}.text-wrapper-sales_pop{padding-left:$gutter-sm/2;overflow:hidden;@include display-flexbox();@include flex-direction(column);@include justify-content(center);&>div{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;line-height:1.1}}.name-sales_pop{color:$colorSecondary}.city-wrapper-sales_pop{opacity:$opacity-link-hover}.link-sales_pop{@include linkStyle;font-size:$baseFontSize-sm}.time-wrapper-sales_pop{opacity:$opacity-link-hover}.btn-close-sales_pop{opacity:0;@include flex-shrink(0);@include screen($small){opacity:1}}}{% endif %}/* end-dbtfy-sales-pop */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-sales-pop' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);
                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on sales_pop addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on sales_pop addon throws exception');
            }

            // add include
            try{
                  $product_template = $shop->api()->request(
                      'GET',
                      '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                      ['asset' => ['key' => 'layout/theme.liquid'] ]
                  )['body']['asset']['value'] ?? '';
                if( ( $pos = strpos( $product_template , 'dbtfy-sales-pop' ) ) === false ) {

                    if( ( $pos = strrpos( $product_template , '</body>' ) ) !== false ) {
                        $new_prod_template = str_replace('</body>', '{% include "dbtfy-sales-pop" %} </body>', $product_template);
                        $update_prod_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'layout/theme.liquid', 'value' => $new_prod_template] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update sales_pop on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update sales_pop on trustbadge addon throws exception');
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-sales-pop */function themeSalesPop() { {% if settings.dbtfy_sales_pop %} var names = "{{ settings.dbtfy_sales_pop_name | strip_newlines }}".split(","); var cities = "{{ settings.dbtfy_sales_pop_city | strip_newlines }}".split(","); var minute = " {{ settings.dbtfy_sales_pop_minute}}"; var minutes = " {{ settings.dbtfy_sales_pop_minutes}}"; var hour = " {{ settings.dbtfy_sales_pop_hour}}"; var hours = " {{ settings.dbtfy_sales_pop_hours}}"; var day = " {{ settings.dbtfy_sales_pop_day}}"; var days = " {{ settings.dbtfy_sales_pop_days}}"; var _0xb4c2=["\x2E\x64\x62\x74\x66\x79\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70","\x64\x69\x73\x70\x6C\x61\x79\x2D\x74\x69\x6D\x65","\x64\x61\x74\x61","\x69\x6E\x74\x65\x72\x76\x61\x6C\x2D\x74\x69\x6D\x65","\x74\x69\x6D\x65\x2D\x61\x67\x6F","\x66\x61\x64\x65\x49\x6E\x55\x70","\x66\x61\x64\x65\x4F\x75\x74\x44\x6F\x77\x6E","\x23\x53\x61\x6C\x65\x73\x50\x6F\x70","\x2E\x69\x74\x65\x6D\x2D\x77\x72\x61\x70\x70\x65\x72\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70","\x2E\x62\x74\x6E\x2D\x63\x6C\x6F\x73\x65\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70","\x2E\x74\x69\x6D\x65\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70","\x2E\x6E\x61\x6D\x65\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70","\x2E\x63\x69\x74\x79\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70","\x61\x64\x64\x43\x6C\x61\x73\x73","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x68\x69\x64\x65","\x61\x70\x70\x65\x6E\x64\x54\x6F","\x2E\x69\x74\x65\x6D\x2D\x77\x72\x61\x70\x70\x65\x72\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70\x20\x20\x3E\x20\x2E\x69\x74\x65\x6D\x2D\x73\x61\x6C\x65\x73\x5F\x70\x6F\x70\x3A\x66\x69\x72\x73\x74","\x70\x6F\x70\x43\x6C\x6F\x73\x65\x64","\x72\x61\x6E\x64\x6F\x6D","\x6C\x65\x6E\x67\x74\x68","\x66\x6C\x6F\x6F\x72","\x74\x65\x78\x74","\x73\x68\x6F\x77","\x73\x68\x75\x66\x66\x6C\x65\x43\x68\x69\x6C\x64\x72\x65\x6E","\x66\x6E","\x67\x65\x74","\x63\x68\x69\x6C\x64\x72\x65\x6E","\x73\x6F\x72\x74","\x65\x6D\x70\x74\x79","\x65\x61\x63\x68","\x74\x72\x75\x65","\x73\x65\x74\x49\x74\x65\x6D","\x63\x6C\x69\x63\x6B","\x73\x68\x6F\x70\x69\x66\x79\x3A\x73\x65\x63\x74\x69\x6F\x6E\x3A\x6C\x6F\x61\x64","\x72\x65\x6D\x6F\x76\x65\x49\x74\x65\x6D","\x6F\x6E"];function SalesPop(){var _0x118cx2=$(_0xb4c2[0]),_0x118cx3=_0x118cx2[_0xb4c2[2]](_0xb4c2[1]),_0x118cx4=_0x118cx2[_0xb4c2[2]](_0xb4c2[3]),_0x118cx5=_0x118cx2[_0xb4c2[2]](_0xb4c2[4]),_0x118cx6=1e3,_0x118cx7=_0x118cx4+ _0x118cx3+ _0x118cx6,_0x118cx8=_0xb4c2[5],_0x118cx9=_0xb4c2[6],_0x118cxa=$(_0xb4c2[7]),_0x118cxb=$(_0xb4c2[8]),_0x118cxc=$(_0xb4c2[9]),_0x118cxd=$(_0xb4c2[10]),_0x118cxe=$(_0xb4c2[11]),_0x118cxf=$(_0xb4c2[12]);function _0x118cx10(){_0x118cxa[_0xb4c2[14]](_0x118cx8)[_0xb4c2[13]](_0x118cx9),setTimeout(function(){_0x118cxa[_0xb4c2[14]](_0x118cx9)[_0xb4c2[15]](),$(_0xb4c2[17])[_0xb4c2[16]](_0xb4c2[8])[_0xb4c2[15]]()},_0x118cx6)}function _0x118cx11(){var _0x118cx2,_0x118cx4;sessionStorage[_0xb4c2[18]]|| (_0x118cx4= names[Math[_0xb4c2[21]](Math[_0xb4c2[19]]()* names[_0xb4c2[20]])],_0x118cxe[_0xb4c2[22]](_0x118cx4),_0x118cx2= cities[Math[_0xb4c2[21]](Math[_0xb4c2[19]]()* cities[_0xb4c2[20]])],_0x118cxf[_0xb4c2[22]](_0x118cx2),function(){if((_0x118cx4= Math[_0xb4c2[21]](Math[_0xb4c2[19]]()* _0x118cx5))<= 1){var _0x118cx2=minute,_0x118cx4=1}else {if(_0x118cx4< 60){_0x118cx2= minutes}else {if(_0x118cx4< 120){_0x118cx4= Math[_0xb4c2[21]](_0x118cx4/ 60);_0x118cx2= hour}else {if(_0x118cx4< 1440){_0x118cx4= Math[_0xb4c2[21]](_0x118cx4/ 60);_0x118cx2= hours}else {if(_0x118cx4< 2880){_0x118cx4= Math[_0xb4c2[21]](_0x118cx4/ 60/ 24);_0x118cx2= day}else {_0x118cx4= Math[_0xb4c2[21]](_0x118cx4/ 60/ 24);_0x118cx2= days}}}}};_0x118cxd[_0xb4c2[22]](_0x118cx4+ _0x118cx2)}(),$(_0xb4c2[17])[_0xb4c2[23]](),_0x118cxa[_0xb4c2[23]]()[_0xb4c2[13]](_0x118cx8),setTimeout(function(){_0x118cx10()},_0x118cx3))}$[_0xb4c2[25]][_0xb4c2[24]]= function(){$[_0xb4c2[30]](this[_0xb4c2[26]](),function(_0x118cx2,_0x118cx4){var _0x118cx3=$(_0x118cx4),_0x118cx5=_0x118cx3[_0xb4c2[27]]();_0x118cx5[_0xb4c2[28]](function(){return 0.5- Math[_0xb4c2[19]]()}),_0x118cx3[_0xb4c2[29]](),_0x118cx5[_0xb4c2[16]](_0x118cx3)})},_0x118cxb[_0xb4c2[24]](),setTimeout(function(){_0x118cx11();setInterval(_0x118cx11,_0x118cx7)},_0x118cx4),_0x118cxc[_0xb4c2[33]](function(){sessionStorage[_0xb4c2[32]](_0xb4c2[18],_0xb4c2[31]),_0x118cx10()})}$(document)[_0xb4c2[36]](_0xb4c2[34],function(){sessionStorage[_0xb4c2[35]](_0xb4c2[18])}),SalesPop() {% endif %} };/* end-dbtfy-sales-pop */';

              // add js register
              $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-sales-pop */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-sales-pop */themeSalesPop();/* end-register-sales-pop */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-sales-pop */' ) ) === false ) {
                    $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content);

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
if (! function_exists('deactivate_salespop_addon')) {
    function deactivate_salespop_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_salespop_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Sales pop') !== false) {
                  return false;
              }
              return true;
            });

            if(str_contains($schema,'Sales pop')){
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

            $styles = (string) '/*================ _Sales_pop ================*/ .dbtfy-sales_pop{ #SalesPop{position:fixed;background: $colorBody;bottom: $gutter;left: $gutter;top:auto !important;right:auto !important;width:350px;padding: $gutter-sm;z-index:$zindexOverBody;@include shadow($shadow);@include RadiusCircle;@include screen($small){ bottom:0px;left:0px;right:0px;width:100%;border-radius:0;} &:hover{.btn-close-sales_pop{opacity:1; @include hovers;} }}.container-sales_pop{@include display-flexbox(); @include align-items(center);}.item-wrapper-sales_pop{@include flex(1);min-width:0;}.item-sales_pop{@include display-flexbox();}.image-wrapper-sales_pop{line-height:0;@include flex-shrink(0);}.image-link-sales_pop{display:block;}.image-sales_pop{@include RadiusCircle;@include screen($small){width:70px;height:70px; }}.text-wrapper-sales_pop{padding-left:$gutter-sm;overflow: hidden;@include display-flexbox();@include flex-direction(column);}.text-sales_pop{margin-bottom:0;line-height: 1;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}.link-wrapper-sales_pop{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;color: $colorSecondary;}.link-sales_pop{@include linkStyle;}.time-wrapper-sales_pop{ padding-top: $spacer-xs;font-size: $baseFontSize-sm;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}.btn-close-sales_pop{opacity:0;@include flex-shrink(0);@include screen($small){opacity:1;}}.animated.fast { -webkit-animation-duration: .8s!important;animation-duration: .8s!important;}.animated.faster {-webkit-animation-duration: .5s!important;animation-duration: .5s!important;}}';
            $trustbadge_Style2 = (string) '/*================ _Sales_pop ================*/';
            $end2 = (string) 'animation-duration: .5s!important;}}';
            $string2 = ' ' . $theme_style_content;
            $ini2 = strpos($string2, $trustbadge_Style2);

            if ($ini2 == 0) {
              $parsed2 = '';
            }else{
              $ini2 += strlen($trustbadge_Style2);
              $len2 = strpos($string2, $end2, $ini2) - $ini2;
              $parsed2 = substr($string2, $ini2, $len2);
            }
            $trustbadge_Style = (string) '/* start-dbtfy-sales-pop */';
            $end = (string) '/* end-dbtfy-sales-pop */';
            $string = ' ' . $theme_style_content;
            $ini = strpos($string, $trustbadge_Style);

            if ($ini == 0) {
              $parsed = '';
            }else{
              $ini += strlen($trustbadge_Style);
              $len = strpos($string, $end, $ini) - $ini;
              $parsed = substr($string, $ini, $len);
            }

            $trustbadge_Style3 = (string) '/*================ start-dbtfy-Sales_pop ================*/';
            $end3 = (string) '/*================ end-dbtfy-Sales_pop ================*/';
            $string3 = ' ' . $theme_style_content;
            $ini3 = strpos($string3, $trustbadge_Style3);
            if ($ini3 == 0) {
              $parsed3 = '';
            }else{
              $ini3 += strlen($trustbadge_Style3);
              $len3 = strpos($string3, $end3, $ini3) - $ini3;
              $parsed3 = substr($string3, $ini3, $len3);
            }
            if($parsed3){
                $values = $trustbadge_Style3.''.$parsed3.''.$end3;
            }else if($parsed2){
                $values = $trustbadge_Style2.''.$parsed2.''.$end2;
            }else{
              if($parsed){
                $values = $trustbadge_Style.''.$parsed.''.$end;
              }else{
                $values = $styles;
              }
            }
            if(str_contains($theme_style_content,'dbtfy-sales_pop')){
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
                ['asset' => ['key' => 'snippets/dbtfy-sales-pop.liquid'] ]
            );

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'layout/theme.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,"dbtfy-sales-pop")){
                $value  =  explode('{% include "dbtfy-sales-pop" %}',$product_template,2);

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

                $trustbadge_js = (string) '/* start-dbtfy-sales-pop */';
                $end_js = (string) '/* end-dbtfy-sales-pop */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-sales-pop */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-sales-pop */')){
                        $trustbadge_js1 = (string) '/* start-register-sales-pop */';
                        $end_js = (string) '/* end-register-sales-pop */';
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
                logger('add sales_pop throws client exception');
            }
            catch(\Exception $e){
                logger('add sales_pop throws exception');
            }

        }
    }
}


if (! function_exists('deactivate_salespop_addon_curl')) {
  function deactivate_salespop_addon_curl($theme, $shop) {

    // remove schema
    $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

    $json = json_decode($schema, true);
    $json = array_filter($json, function ($obj) {
      if (stripos($obj['name'], 'Sales pop') !== false) {
          return false;
      }
      return true;
    });

    if(str_contains($schema,'Sales pop')){
        $value = json_encode(array_values($json));
        $updated_schema = $value;
        $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid');

    $styles = (string) '/*================ _Sales_pop ================*/ .dbtfy-sales_pop{ #SalesPop{position:fixed;background: $colorBody;bottom: $gutter;left: $gutter;top:auto !important;right:auto !important;width:350px;padding: $gutter-sm;z-index:$zindexOverBody;@include shadow($shadow);@include RadiusCircle;@include screen($small){ bottom:0px;left:0px;right:0px;width:100%;border-radius:0;} &:hover{.btn-close-sales_pop{opacity:1; @include hovers;} }}.container-sales_pop{@include display-flexbox(); @include align-items(center);}.item-wrapper-sales_pop{@include flex(1);min-width:0;}.item-sales_pop{@include display-flexbox();}.image-wrapper-sales_pop{line-height:0;@include flex-shrink(0);}.image-link-sales_pop{display:block;}.image-sales_pop{@include RadiusCircle;@include screen($small){width:70px;height:70px; }}.text-wrapper-sales_pop{padding-left:$gutter-sm;overflow: hidden;@include display-flexbox();@include flex-direction(column);}.text-sales_pop{margin-bottom:0;line-height: 1;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}.link-wrapper-sales_pop{white-space: nowrap;overflow: hidden;text-overflow: ellipsis;color: $colorSecondary;}.link-sales_pop{@include linkStyle;}.time-wrapper-sales_pop{ padding-top: $spacer-xs;font-size: $baseFontSize-sm;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}.btn-close-sales_pop{opacity:0;@include flex-shrink(0);@include screen($small){opacity:1;}}.animated.fast { -webkit-animation-duration: .8s!important;animation-duration: .8s!important;}.animated.faster {-webkit-animation-duration: .5s!important;animation-duration: .5s!important;}}';
    $trustbadge_Style2 = (string) '/*================ _Sales_pop ================*/';
    $end2 = (string) 'animation-duration: .5s!important;}}';
    $string2 = ' ' . $theme_style_content;
    $ini2 = strpos($string2, $trustbadge_Style2);

    if ($ini2 == 0) {
      $parsed2 = '';
    }else{
      $ini2 += strlen($trustbadge_Style2);
      $len2 = strpos($string2, $end2, $ini2) - $ini2;
      $parsed2 = substr($string2, $ini2, $len2);
    }
    $trustbadge_Style = (string) '/* start-dbtfy-sales-pop */';
    $end = (string) '/* end-dbtfy-sales-pop */';
    $string = ' ' . $theme_style_content;
    $ini = strpos($string, $trustbadge_Style);

    if ($ini == 0) {
      $parsed = '';
    }else{
      $ini += strlen($trustbadge_Style);
      $len = strpos($string, $end, $ini) - $ini;
      $parsed = substr($string, $ini, $len);
    }

    $trustbadge_Style3 = (string) '/*================ start-dbtfy-Sales_pop ================*/';
    $end3 = (string) '/*================ end-dbtfy-Sales_pop ================*/';
    $string3 = ' ' . $theme_style_content;
    $ini3 = strpos($string3, $trustbadge_Style3);
    if ($ini3 == 0) {
      $parsed3 = '';
    }else{
      $ini3 += strlen($trustbadge_Style3);
      $len3 = strpos($string3, $end3, $ini3) - $ini3;
      $parsed3 = substr($string3, $ini3, $len3);
    }
    if($parsed3){
        $values = $trustbadge_Style3.''.$parsed3.''.$end3;
    }else if($parsed2){
        $values = $trustbadge_Style2.''.$parsed2.''.$end2;
    }else{
      if($parsed){
        $values = $trustbadge_Style.''.$parsed.''.$end;
      }else{
        $values = $styles;
      }
    }
    if(str_contains($theme_style_content,'dbtfy-sales_pop')){
      $value = str_replace($values, " ", $theme_style_content);
      $new_theme_styles = (string) $value;
      $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove snippet
    $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-sales-pop.liquid');

    // remove include
    $product_template = getThemeFileCurl($shop, $theme, 'layout/theme.liquid') ?? '';

    if(str_contains($product_template,"dbtfy-sales-pop")){
        $value  =  explode('{% include "dbtfy-sales-pop" %}',$product_template,2);

        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        }
        else {
            $value = (string) $product_template;
        }

        $new_prod_template = (string) $value;

        $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'layout/theme.liquid');
    }

    // remove js addon
    try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

        $trustbadge_js = (string) '/* start-dbtfy-sales-pop */';
        $end_js = (string) '/* end-dbtfy-sales-pop */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-sales-pop */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-sales-pop */')){
                $trustbadge_js1 = (string) '/* start-register-sales-pop */';
                $end_js = (string) '/* end-register-sales-pop */';
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
        logger('add sales_pop throws client exception');
    }
    catch(\Exception $e){
        logger('add sales_pop throws exception');
    }
  }
}
?>
