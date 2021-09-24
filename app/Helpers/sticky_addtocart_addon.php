<?php
//activate
if (! function_exists('activate_sticky_addtocart_addon')) {
    function activate_sticky_addtocart_addon($StoreThemes, $shop) {
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
    "name": "Sticky add-to-cart",
    "settings": [
      {
        "type": "header",
        "content": "Activation"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sticky_addtocart",
        "label": "Activate",
        "default": false
      },
      {
        "type": "header",
        "content": "Settings"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sticky_addtocart_reviews",
        "label": "Show star ratings",
        "default": false
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sticky_addtocart_animation",
        "label": "Enable add-to-cart animation",
        "default": false,
        "info": "Requires [Add-to-cart animation](\/admin\/apps\/debutify\/app)"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sticky_addtocart_inventory",
        "label": "Show Inventory quantity",
        "default": false,
        "info": "Requires [Inventory quantity](\/admin\/apps\/debutify\/app)"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sticky_addtocart_countdown",
        "label": "Show Sales countdown",
        "default": false,
        "info": "Requires [Sales countdown](\/admin\/apps\/debutify\/app)"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_sticky_addtocart_mobile",
        "label": "Enable simplified mobile display",
        "default": false
      },
      {
        "type": "select",
        "id": "dbtfy_sticky_addtocart_wrapper",
        "label": "Wrapper type",
        "default": "wrapper-fluid",
        "options": [
          {
            "value": "wrapper",
            "label": "Default"
          },
          {
            "value": "wrapper-fluid",
            "label": "Full"
          }
        ]
      },
      {
        "type": "select",
        "id": "dbtfy_sticky_addtocart_position",
        "label": "Position",
        "default": "top",
        "options": [
          {
            "value": "top",
            "label": "Top"
          },
          {
            "value": "bottom",
            "label": "Bottom"
          }
        ]
      }
    ]
  }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_sticky_addtocart' ) ) === false ) {
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
{%- if settings.dbtfy_sticky_addtocart -%}
{%- if template.name == "product" -%}
<div class="dbtfy dbtfy-sticky_addtocart"
     data-position="{{ settings.dbtfy_sticky_addtocart_position }}">

  <div id="stickyAddToCart" class="animated {{ settings.dbtfy_sticky_addtocart_position }}-sticky_addtocart {% if settings.dbtfy_sticky_addtocart_mobile %} mobile-sticky_addtocart{% endif %}" style="display:none;">
    <div class="{{ settings.dbtfy_sticky_addtocart_wrapper }}">
      <div class="grid grid--small container-sticky_addtocart">

        <div class="grid__item image-wrapper-sticky_addtocart">
          {% if product.images.size >= 1 %}
            <img class="hide image-empty-sticky_addtocart image-sticky_addtocart" src="">
            {% if product.has_only_default_variant %}
              {% assign image = featured_image %}
              <img class="image-sticky_addtocart image-sticky_addtocart-{{ variant.id }}" src="{{ image | img_url: "65x65", crop: "center" }}"
                   srcset="{{ image | img_url: "65x65", crop: "center" }} 1x, {{ image | img_url: "65x65", crop: "center", scale: 2 }} 2x">
            {% else %}
              {% for variant in product.variants %}
                {% if variant.image %}
                  {% assign image = variant.image %}
                {% else %}
                  {% assign image = featured_image %}
                {% endif %}
                <img class="image-sticky_addtocart image-sticky_addtocart-{{ variant.id }} {% unless variant == current_variant %}hide{% endunless %}" src="{{ image | img_url: "65x65", crop: "center" }}"
                     srcset="{{ image | img_url: "65x65", crop: "center" }} 1x, {{ image | img_url: "65x65", crop: "center", scale: 2 }} 2x">
              {% endfor %}
            {% endif %}
          {% endif %}
        </div>

        <div class="grid__item text-wrapper-sticky_addtocart">
          <h5 class="title-sticky_addtocart">{{ product.title }}</h5>
          {% unless product.has_only_default_variant %}
          <a class="text-link variant-sticky_addtocart"></a>
          {% endunless %}
        </div>

        <div class="grid__item extra-wrapper-sticky_addtocart small--hide medium--hide">
          {% if settings.dbtfy_sticky_addtocart_inventory and settings.dbtfy_inventory_quantity %}
            {% include "dbtfy-inventory-quantity" %}
          {% endif %}
          {% if settings.dbtfy_sticky_addtocart_countdown and settings.dbtfy_sales_countdown %}
            {% include "dbtfy-sales-countdown" %}
          {% endif %}
        </div>

        <div class="grid__item price-wrapper-sticky_addtocart">
          <span class="price-sticky_addtocart"></span>
          {% if settings.dbtfy_sticky_addtocart_reviews %}
          <div class="small--hide">
            {% include "review-badge", badge_template: "product" %}
          </div>
          {% endif %}
        </div>

        <div class="grid__item button-wrapper-sticky_addtocart">
          <button class="btn btn--primary btn--buy btn--sticky_addtocart {% if settings.dbtfy_sticky_addtocart_animation %}btn--addtocart_animation{% endif %}" {% unless current_variant.available %} disabled="disabled"{% endunless %}>
            <span class="btn__text">
              {% if section.settings.button_cart_icon %}
              <span class="fas fa-shopping-{{ settings.cart_icon }} button-cart-icon"></span>
              <span class="fas fa-clock button-soldout-icon"></span>
              {% endif %}
              <span class="btn__add-to-cart-text btn-text-sticky_addtocart">
                {% if current_variant.available %}
                {{ "products.product.add_to_cart" | t }}
                {% else %}
                {{ "products.product.sold_out" | t }}
                {% endif %}
              </span>
            </span>
          </button>
        </div>

      </div>
    </div>
  </div>
</div>
{%- endif -%}
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

                $create_trustbadge_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-sticky-addtocart.liquid', 'value' => $snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add Addtocart_animation throws client exception');
            }
            catch(\Exception $e){
                logger('add Addtocart_animation throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-sticky-addtocart */{% if settings.dbtfy_sticky_addtocart %}.dbtfy-sticky_addtocart{#stickyAddToCart{position:fixed;background-color:$colorBody;width:100%;z-index:$zindexOverBody + 1;padding-top:$gutter-sm/2;padding-bottom:$gutter-sm/2;left:0;right:0;-webkit-animation-duration:$transitionDuration!important;animation-duration:$transitionDuration!important;@include screen($small){&>div{padding-left:$gutter-sm/2;padding-right:$gutter-sm/2}}&.top-sticky_addtocart{@include screenUp($small){top:0;@include shadow($shadowBottom)}@include screen($small){top:$heightHeaderMobile;border-bottom:$borders}}&.bottom-sticky_addtocart{bottom:0;@include shadow($shadowTop)}}body.sticky-header &{#stickyAddToCart{&.top-sticky_addtocart{@include screenUp($small){border-bottom:$borders;top:$heightHeader;@include shadow(none)}}}}.mobile-sticky_addtocart{@include screen($small){.image-wrapper-sticky_addtocart,.text-wrapper-sticky_addtocart,.price-wrapper-sticky_addtocart{display:none}.button-wrapper-sticky_addtocart{@include flex(100%);max-width:100%} }}.grid{@include screen($small){margin-left:-$gutter-sm/2}}.grid__item{width:inherit;@include screen($small){padding-left:$gutter-sm/2}}.container-sticky_addtocart{@include display-flexbox();@include align-items(center)}.image-wrapper-sticky_addtocart{line-height:0}.text-wrapper-sticky_addtocart{overflow:hidden;@include flex(3);@include display-flexbox();@include flex-wrap(wrap)}.extra-wrapper-sticky_addtocart{@include flex(auto)}.price-wrapper-sticky_addtocart{text-align:right;@include screenUp($small){@include flex(1)}}.button-wrapper-sticky_addtocart{text-align:right;max-width:50%}.image-sticky_addtocart{width:$heightInput;height:$heightInput;@include screen($small){width:$heightInputSmall;height:$heightInputSmall}}.title-sticky_addtocart{margin-bottom:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;width:100%;@include screen($small){font-size:$baseFontSize-sm}}.variant-sticky_addtocart{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;cursor:pointer;text-align:left;@include screen($small){font-size:$baseFontSize-sm}span + span:before{content:"/"}}.price-wrapper{margin:0;padding:0;border:0;@include justify-content(flex-end);@include screen($small){background-color:transparent;display:block;.price-compare,.product-single__price{font-size:$baseFontSize-sm!Important;display:block;margin:0}.dbtfy-discount_saved{display:none}}}.review-badge{white-space:nowrap}.btn--sticky_addtocart{width:100%;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;@include screen($small){@include buttonSmall}}.dbtfy-inventory_quantity{.InventoryQuantity{margin-bottom:0}}.dbtfy-sales_countdown{.SalesCountdown{margin-bottom:0;background-color:transparent;padding:0;text-align:left}}}.announcement-container{z-index:$zindexOverBody}.btn-top.btn-top-visible{.template-product.scroll-sticky_addtocart &{bottom:$gutter+$heightInput+$gutter-sm;@include screen($small){bottom:$gutter-sm+$heightInputSmall+$gutter-sm}}}{% if settings.dbtfy_sticky_addtocart_position == "bottom" %}.template-product{padding-bottom:$heightInput+$gutter-sm;@include screen($small){padding-bottom:$heightInputSmall+$gutter-sm}}{% endif %}{% endif %}/* end-dbtfy-sticky-addtocart */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-sticky-addtocart' ) ) === false ) {
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

            // add include
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-template.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , 'dbtfy-sticky-addtocart' ) ) === false ) {
                    if( ( $pos = strrpos( $product_template , '</div><!-- /.grid -->' ) ) !== false ) {

                        $new_prod_template = preg_replace('/<\/div>\s+<\/div><!-- \/\.grid -->/', '{% include "dbtfy-sticky-addtocart" %}</div>

      </div><!-- /.grid -->', $product_template);

                        $update_prod_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update dbtfy-sticky-addtocart on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('dbtfy-sticky-addtocart: ' . $e->getMessage());
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-sticky-addtocart */function themeStickyAddtocart() { {% if settings.dbtfy_sticky_addtocart %} var _0x6d52=["\x70\x6F\x73\x69\x74\x69\x6F\x6E","\x64\x61\x74\x61","\x2E\x64\x62\x74\x66\x79\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x2E\x62\x74\x6E\x2D\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x2E\x76\x61\x72\x69\x61\x6E\x74\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x2E\x69\x6D\x61\x67\x65\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x2E\x69\x6D\x61\x67\x65\x2D\x65\x6D\x70\x74\x79\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x61\x64\x64\x2D\x74\x6F\x2D\x63\x61\x72\x74\x20\x2E\x62\x74\x6E\x2D\x2D\x61\x64\x64\x2D\x74\x6F\x2D\x63\x61\x72\x74","\x23\x73\x74\x69\x63\x6B\x79\x41\x64\x64\x54\x6F\x43\x61\x72\x74","\x74\x6F\x70","\x6F\x66\x66\x73\x65\x74","\x6F\x75\x74\x65\x72\x48\x65\x69\x67\x68\x74","\x68\x74\x6D\x6C","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x70\x72\x69\x63\x65","\x66\x61\x64\x65\x49\x6E\x44\x6F\x77\x6E","\x66\x61\x64\x65\x4F\x75\x74\x55\x70","","\x66\x61\x64\x65\x49\x6E\x55\x70","\x66\x61\x64\x65\x4F\x75\x74\x44\x6F\x77\x6E","\x73\x63\x72\x6F\x6C\x6C\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x6A\x73\x2D\x64\x72\x61\x77\x65\x72\x2D\x6F\x70\x65\x6E","\x68\x61\x73\x43\x6C\x61\x73\x73","\x23\x43\x61\x72\x74\x44\x72\x61\x77\x65\x72","\x62\x74\x6E\x2D\x2D\x6C\x6F\x61\x64\x69\x6E\x67","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x6D\x69\x6E\x2D\x77\x69\x64\x74\x68","\x63\x73\x73","\x65\x6D\x70\x74\x79","\x74\x65\x78\x74","\x6F\x70\x74\x69\x6F\x6E\x3A\x73\x65\x6C\x65\x63\x74\x65\x64","\x66\x69\x6E\x64","\x2E\x73\x69\x6E\x67\x6C\x65\x2D\x6F\x70\x74\x69\x6F\x6E\x2D\x73\x65\x6C\x65\x63\x74\x6F\x72\x5F\x5F\x72\x61\x64\x69\x6F\x3A\x63\x68\x65\x63\x6B\x65\x64\x20\x2B\x20\x6C\x61\x62\x65\x6C","\x3C\x73\x70\x61\x6E\x3E","\x3C\x2F\x73\x70\x61\x6E\x3E","\x61\x70\x70\x65\x6E\x64","\x65\x61\x63\x68","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x66\x6F\x72\x6D\x5F\x5F\x69\x6E\x70\x75\x74\x2C\x2E\x73\x69\x6E\x67\x6C\x65\x2D\x6F\x70\x74\x69\x6F\x6E\x2D\x72\x61\x64\x69\x6F","\x63\x6C\x6F\x6E\x65","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x6D\x65\x74\x61\x20\x2E\x70\x72\x69\x63\x65\x2D\x77\x72\x61\x70\x70\x65\x72","\x2E\x70\x72\x69\x63\x65\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74","\x73\x63\x72\x6F\x6C\x6C\x54\x6F\x70","\x73\x68\x6F\x77","\x61\x64\x64\x43\x6C\x61\x73\x73","\x62\x6F\x64\x79","\x68\x69\x64\x65","\x73\x63\x72\x6F\x6C\x6C","\x63\x6C\x69\x63\x6B","\x6F\x75\x74\x65\x72\x57\x69\x64\x74\x68","\x74\x72\x69\x67\x67\x65\x72","\x6F\x6E","\x2E\x70\x72\x69\x63\x65\x2D\x77\x72\x61\x70\x70\x65\x72","\x61\x6E\x69\x6D\x61\x74\x65","\x64\x6F\x63\x75\x6D\x65\x6E\x74\x45\x6C\x65\x6D\x65\x6E\x74","\x63\x68\x61\x6E\x67\x65","\x76\x61\x6C","\x23\x50\x72\x6F\x64\x75\x63\x74\x53\x65\x6C\x65\x63\x74","\x2E\x69\x6D\x61\x67\x65\x2D\x73\x74\x69\x63\x6B\x79\x5F\x61\x64\x64\x74\x6F\x63\x61\x72\x74\x2D","\x66\x69\x6C\x74\x65\x72","\x2E\x6C\x61\x79\x6F\x75\x74\x2D\x74\x68\x75\x6D\x62\x6E\x61\x69\x6C","\x73\x72\x63","\x61\x74\x74\x72","\x2E\x61\x63\x74\x69\x76\x65\x2D\x74\x68\x75\x6D\x62\x20\x69\x6D\x67","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x74\x68\x75\x6D\x62\x6E\x61\x69\x6C\x73\x20\x2E\x73\x6C\x69\x63\x6B\x2D\x63\x75\x72\x72\x65\x6E\x74\x20\x69\x6D\x67","\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x70\x68\x6F\x74\x6F\x73\x20\x3E\x20\x2E\x70\x72\x6F\x64\x75\x63\x74\x2D\x73\x69\x6E\x67\x6C\x65\x5F\x5F\x70\x68\x6F\x74\x6F\x2D\x2D\x66\x6C\x65\x78\x2D\x77\x72\x61\x70\x70\x65\x72\x3A\x66\x69\x72\x73\x74\x2D\x63\x68\x69\x6C\x64\x20\x69\x6D\x67","\x3A\x64\x69\x73\x61\x62\x6C\x65\x64","\x69\x73","\x64\x69\x73\x61\x62\x6C\x65\x64","\x70\x72\x6F\x70"];function StickyAddtocart(){var _0xa5f0x2=$(_0x6d52[2])[_0x6d52[1]](_0x6d52[0]),_0xa5f0x3=$(_0x6d52[3]),_0xa5f0x4=$(_0x6d52[4]),_0xa5f0x5=$(_0x6d52[5]),_0xa5f0x6=$(_0x6d52[6]),_0xa5f0x7=$(_0x6d52[7]),_0xa5f0x8=$(_0x6d52[8]),_0xa5f0x9=_0xa5f0x7[_0x6d52[10]]()[_0x6d52[9]]+ _0xa5f0x7[_0x6d52[11]](),_0xa5f0xa=!1;$(_0x6d52[13])[_0x6d52[12]]();if(_0x6d52[9]== _0xa5f0x2){var _0xa5f0xb=_0x6d52[14],_0xa5f0xc=_0x6d52[15],_0xa5f0xd=_0x6d52[16]}else {_0xa5f0xb= _0x6d52[17],_0xa5f0xc= _0x6d52[18],_0xa5f0xd= _0x6d52[19]};function _0xa5f0xe(){$(_0x6d52[22])[_0x6d52[21]](_0x6d52[20])?(_0xa5f0x3[_0x6d52[24]](_0x6d52[23]),_0xa5f0x3[_0x6d52[26]](_0x6d52[25],_0x6d52[16])):setTimeout(_0xa5f0xe,100)}function _0xa5f0xf(){_0xa5f0x4[_0x6d52[27]](),$(_0x6d52[36])[_0x6d52[35]](function(){var _0xa5f0x2=$(this);if(!(_0xa5f0x8= _0xa5f0x2[_0x6d52[30]](_0x6d52[29])[_0x6d52[28]]())){var _0xa5f0x8=_0xa5f0x2[_0x6d52[30]](_0x6d52[31])[_0x6d52[28]]()};_0xa5f0x4[_0x6d52[34]](_0x6d52[32]+ _0xa5f0x8+ _0x6d52[33])})}function _0xa5f0x10(){var _0xa5f0x2=$(_0x6d52[38])[_0x6d52[37]]();$(_0x6d52[39])[_0x6d52[12]](_0xa5f0x2)}$(window)[_0x6d52[45]](function(){$(window)[_0x6d52[40]]()> _0xa5f0x9?(_0xa5f0x8[_0x6d52[42]](_0xa5f0xb)[_0x6d52[41]](),$(_0x6d52[43])[_0x6d52[42]](_0xa5f0xd),_0xa5f0xa= !0):_0xa5f0xa&& (_0xa5f0x8[_0x6d52[24]](_0xa5f0xb)[_0x6d52[42]](_0xa5f0xc),$(_0x6d52[43])[_0x6d52[24]](_0xa5f0xd),_0xa5f0xa= !1,setTimeout(function(){_0xa5f0x8[_0x6d52[44]]()[_0x6d52[24]](_0xa5f0xc)},300))}),_0xa5f0x3[_0x6d52[49]](_0x6d52[46],function(){var _0xa5f0x2=$(this)[_0x6d52[47]]();$(this)[_0x6d52[26]](_0x6d52[25],_0xa5f0x2),$(this)[_0x6d52[42]](_0x6d52[23]),_0xa5f0x7[_0x6d52[48]](_0x6d52[46]),_0xa5f0xe()}),_0xa5f0x4[_0x6d52[46]](function(){$([document[_0x6d52[52]],document[_0x6d52[43]]])[_0x6d52[51]]({scrollTop:$(_0x6d52[50])[_0x6d52[10]]()[_0x6d52[9]]},800)}),_0xa5f0xf(),_0xa5f0x10(),$(_0x6d52[36])[_0x6d52[49]](_0x6d52[53],function(){setTimeout(function(){var _0xa5f0x2=$(_0x6d52[55])[_0x6d52[54]]();$(_0x6d52[13])[_0x6d52[28]]();if(_0xa5f0xf(),_0xa5f0x10(),_0xa5f0x5[_0x6d52[42]](_0x6d52[44]),_0xa5f0x2){_0xa5f0x5[_0x6d52[57]](_0x6d52[56]+ _0xa5f0x2)[_0x6d52[24]](_0x6d52[44])}else {if($(_0x6d52[58])[0]){if(!(_0xa5f0x8= $(_0x6d52[61])[_0x6d52[60]](_0x6d52[59]))){var _0xa5f0x8=$(_0x6d52[62])[_0x6d52[60]](_0x6d52[59])}}else {if(!(_0xa5f0x8= $(_0x6d52[63])[_0x6d52[60]](_0x6d52[59]))){_0xa5f0x8= $(_0x6d52[62])[_0x6d52[60]](_0x6d52[59])}};_0xa5f0x6[_0x6d52[60]](_0x6d52[59],_0xa5f0x8)[_0x6d52[24]](_0x6d52[44])};_0xa5f0x7[_0x6d52[65]](_0x6d52[64])?_0xa5f0x3[_0x6d52[67]](_0x6d52[66],!0)[_0x6d52[42]](_0x6d52[66]):_0xa5f0x3[_0x6d52[67]](_0x6d52[66],!1)[_0x6d52[24]](_0x6d52[66])},10)})}StickyAddtocart() {% endif %} };/* end-dbtfy-sticky-addtocart */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-sticky-addtocart */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-sticky-addtocart */sections.register("product-template", themeStickyAddtocart);/* end-register-sticky-addtocart */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content1 , '/* start-dbtfy-sticky-addtocart */' ) ) === false ) {
                        $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content1);

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
if (! function_exists('deactivate_sticky_addtocart_addon')) {
    function deactivate_sticky_addtocart_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_sticky_addtocart_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
              if (stripos($obj['name'], 'Sticky add-to-cart') !== false) {
                  return false;
              }
              return true;
            });

            if(str_contains($schema,'Sticky add-to-cart')){
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

            $trustbadge_Style = (string) '/* start-dbtfy-sticky-addtocart */';
            $end = (string) '/* end-dbtfy-sticky-addtocart */';
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

            if(str_contains($theme_style_content,'.dbtfy-sticky_addtocart')){
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
                ['asset' => ['key' => 'snippets/dbtfy-sticky-addtocart.liquid'] ]
            );

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/product-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-sticky-addtocart')){
                $value  =  explode('{% include "dbtfy-sticky-addtocart" %}',$product_template,2);

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

                $trustbadge_js = (string) '/* start-dbtfy-sticky-addtocart */';
                $end_js = (string) '/* end-dbtfy-sticky-addtocart */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-sticky-addtocart */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-sticky-addtocart */')){
                        $trustbadge_js1 = (string) '/* start-register-sticky-addtocart */';
                        $end_js = (string) '/* end-register-sticky-addtocart */';
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
                logger('add sticky_addtocart throws client exception');
            }
            catch(\Exception $e){
                logger('add sticky_addtocart throws exception');
            }

        }
    }
}



if (! function_exists('deactivate_sticky_addtocart_addon_curl')) {
  function deactivate_sticky_addtocart_addon_curl($theme, $shop) {

    // remove schema
    $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

    $json = json_decode($schema, true);
    $json = array_filter($json, function ($obj) {
      if (stripos($obj['name'], 'Sticky add-to-cart') !== false) {
          return false;
      }
      return true;
    });

    if(str_contains($schema,'Sticky add-to-cart')){
        $value = json_encode(array_values($json));
        $updated_schema = $value;
        $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid') ?? '';

    $trustbadge_Style = (string) '/* start-dbtfy-sticky-addtocart */';
    $end = (string) '/* end-dbtfy-sticky-addtocart */';
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

    if(str_contains($theme_style_content,'.dbtfy-sticky_addtocart')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove snippet
    $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-sticky-addtocart.liquid');

    // remove include
    $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-template.liquid') ?? '';

    if(str_contains($product_template,'dbtfy-sticky-addtocart')){
        $value  =  explode('{% include "dbtfy-sticky-addtocart" %}',$product_template,2);

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

        $trustbadge_js = (string) '/* start-dbtfy-sticky-addtocart */';
        $end_js = (string) '/* end-dbtfy-sticky-addtocart */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-sticky-addtocart */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-sticky-addtocart */')){
                $trustbadge_js1 = (string) '/* start-register-sticky-addtocart */';
                $end_js = (string) '/* end-register-sticky-addtocart */';
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
        logger('add sticky_addtocart throws client exception');
    }
    catch(\Exception $e){
        logger('add sticky_addtocart throws exception');
    }
  }
}
?>
