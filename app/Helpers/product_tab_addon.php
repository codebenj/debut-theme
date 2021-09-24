<?php
use Illuminate\Support\Arr;
if (! function_exists('activate_producttab_addon')) {
    function activate_producttab_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            // add schema - product template
            $liveview_addon_schema = (string) '
    "blocks" : [
      {
        "type": "description",
        "name": "Description",
        "limit": 1,
        "settings": [
          {
            "type": "text",
            "id": "dbtfy_product_tabs_icon",
            "label": "Icon",
            "default": "list",
            "info": "Enter the name of any free solid icons on [FontAwesome](https:\/\/fontawesome.com\/icons?d=gallery&s=solid&m=free)"
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_title",
            "label": "Title",
            "default": "Details",
            "info": "To hide the default description, uncheck the \"Show description\" box above."
          }
        ]
      },
      {
        "type": "reviews",
        "name": "Reviews",
        "limit": 1,
        "settings": [
          {
            "type": "checkbox",
            "id": "dbtfy_product_tabs_review",
            "label": "Show star ratings",
            "default": true
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_icon",
            "label": "Icon",
      			"default": "thumbs-up",
            "info": "Enter the name of any free solid icons on [FontAwesome](https:\/\/fontawesome.com\/icons?d=gallery&s=solid&m=free)"
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_title",
            "label": "Title",
            "default": "Reviews",
            "info": "To show your review widget in product tabs, go in \"Review app\" > \"Review widget\" and select the \"In product tabs\" position"
          }
        ]
      },
      {
        "type": "text",
        "name": "Text/Image/HTML",
        "settings": [
          {
            "type": "select",
            "id": "text_alignment",
            "label": "Text alignment",
            "default": "text-center",
            "options": [
              {
                "value": "",
                "label": "Left"
              },
              {
                "value": "text-center",
                "label": "Center"
              },
              {
                "value": "text-right",
                "label": "Right"
              }
            ]
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_icon",
            "label": "Icon",
            "info": "Enter the name of any free solid icons on [FontAwesome](https:\/\/fontawesome.com\/icons?d=gallery&s=solid&m=free)"
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_title",
            "label": "Title",
            "default": "Rich text"
          },
          {
            "type": "richtext",
            "id": "dbtfy_product_tabs_text",
            "label": "Text"
          },
          {
            "type": "image_picker",
            "id": "dbtfy_product_tabs_image",
            "label": "Image"
          },
          {
            "type": "html",
            "id": "dbtfy_product_tabs_html",
            "label": "HTML"
          },
          {
            "type": "header",
            "content": "Visibility settings"
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_type",
            "label": "Product type",
      			"info": "Comma-separated"
          },
          {
            "type": "text",
            "id": "dbtfy_product_tabs_tag",
            "label": "Product tag",
            "info": "Comma-separated"
          },
          {
            "type": "product",
            "id": "dbtfy_product_tabs_product",
            "label": "Product"
          },
          {
            "type": "collection",
            "id": "dbtfy_product_tabs_collection",
            "label": "Collection"
          }
        ]
      }
    ]';

        $new_code =',
      {
        "type": "header",
        "content": "Product tabs"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_product_tabs_first",
        "label": "Open first tab",
        "default": true
      }';


            // add section json
            try{
                $schema = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'sections/product-template.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $badgePos = strpos( $schema , 'dbtfy_product_tabs_title' ) ) === false ) {
                    if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                        $updated_schema    = substr_replace( $schema , $new_code."
                        	],".$liveview_addon_schema." } {% endschema %}" , $pos );

                        $update_schema_settings = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'sections/product-template.liquid', 'value' => $updated_schema] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add Product_tabs1 throws client exception');
            }
            catch(\Exception $e){
                logger('add Product_tabs2 throws exception');
            }

            // add section json
            try{
                $featured_schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'sections/featured-product.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $badgePos = strpos( $featured_schema , 'dbtfy_product_tabs_title' ) ) === false ) {
                    if( ( $pos = strrpos( $featured_schema , '],' ) ) !== false ) {
                        $updated_schema    = substr_replace( $featured_schema , $new_code.'
                        	],'.$liveview_addon_schema.',"presets": [
          {
            "name": "Featured product",
            "category": "Product"
          }
          ] } {% endschema %}' , $pos );

                        $update_featured_settings = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'sections/featured-product.liquid', 'value' => $updated_schema] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add Product_tabs1 featured section throws client exception');
            }
            catch(\Exception $e){
                logger('add Product_tabs2 featured section throws exception');
            }

            // add snippet
            try{
                $snippet = (string) '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}
{%- if section.blocks.size > 0 -%}
<div class="dbtfy dbtfy-product_tabs"
     data-sticky-header="{{settings.sticky_header}}"
     data-sticky-addtocart-position="{{settings.dbtfy_sticky_addtocart_position}}">

  <div id="ProductTabs">
    <!-- Blocks -->
    {% for block in section.blocks %}
    {% capture tab_start %}
    <div class="pt-item" {{ block.shopify_attributes }}>
      <div class="pt-header-wrapper pt-header-wrapper-{{ block.id }} {% if forloop.index == 1 and section.settings.dbtfy_product_tabs_first %}active{% endif %}">
        {% unless block.settings.dbtfy_product_tabs_icon == blank %}
        <span class="fas fa-{{ block.settings.dbtfy_product_tabs_icon }} fa-fw pt-icon"></span>
        {% endunless %}
        <span class="pt-header-title">{{ block.settings.dbtfy_product_tabs_title }}</span>
        {% if block.settings.dbtfy_product_tabs_review and block.type == "reviews" %}
        {% include "review-badge", badge_template: "product" %}
        {% endif %}
      </div>
      <div class="pt-content-wrapper">
        <div class="pt-content animated fast">
          {% endcapture %}
          {% capture tab_end %}
        </div>
      </div>
    </div>
    {% endcapture %}

    {% if block.type == "description" and product.description != blank %}
    {{ tab_start }}
    <div class="product-single__description rte" itemprop="description">
      {{ product.description }}
    </div>
    {{ tab_end }}
    {% endif %}

    {% if block.type == "reviews" and settings.review_widget == "review_widget_tab" %}
    {{ tab_start }}
    {% include "review-widget" %}
    {{ tab_end }}
    {% endif %}

    {% if block.type == "text" %}
    {% assign valid_tab = false %}

    <!-- type -->
    {% if block.settings.dbtfy_product_tabs_type != blank %}
    {% assign type_list = block.settings.dbtfy_product_tabs_type | split: "," %}
    {% for type in type_list %}
    {% if product.type contains type %}
    {% assign valid_tab = true %}
    {% endif %}
    {% endfor %}
    {% endif %}

    <!-- tag -->
    {% if block.settings.dbtfy_product_tabs_tag != blank %}
    {% assign tag_list = block.settings.dbtfy_product_tabs_tag | split: "," %}
    {% for tag in tag_list %}
    {% if product.tags contains tag %}
    {% assign valid_tab = true %}
    {% endif %}
    {% endfor %}
    {% endif %}

    <!-- product -->
    {% if block.settings.dbtfy_product_tabs_product != blank %}
    {% assign product_filter = block.settings.dbtfy_product_tabs_product %}
    {% if product.handle == product_filter %}
    {% assign valid_tab = true %}
    {% endif %}
    {% endif %}

    <!-- collection -->
    {% if block.settings.dbtfy_product_tabs_collection != blank %}
    {% for collection in product.collections %}
    {% if collection.handle == block.settings.dbtfy_product_tabs_collection %}
    {% assign valid_tab = true %}
    {% break %}
    {% endif %}
    {% endfor %}
    {% endif %}

    {% if block.settings.dbtfy_product_tabs_product == blank and block.settings.dbtfy_product_tabs_type == blank and block.settings.dbtfy_product_tabs_tag == blank and block.settings.dbtfy_product_tabs_collection == blank %}
    {% assign valid_tab = true %}
    {% endif %}

    {% if valid_tab %}
    {{ tab_start }}
    <div class="rte {{ block.settings.text_alignment }}">
      {% unless block.settings.dbtfy_product_tabs_text == blank %}
      {{ block.settings.dbtfy_product_tabs_text }}
      {% endunless %}

      {% if block.settings.dbtfy_product_tabs_image %}
      <div class="image-wrapper" style="padding-top:{{ 1 | divided_by: block.settings.dbtfy_product_tabs_image.aspect_ratio | times: 100}}%;">
        {% assign img_url = block.settings.dbtfy_product_tabs_image | img_url: "1x1" | replace: "_1x1.", "_{width}x." %}
        <img class="image lazyload"
             src="{{ block.settings.dbtfy_product_tabs_image | img_url: "300x300" }}"
             data-src="{{ img_url }}"
             data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
             data-aspectratio="{{ block.settings.dbtfy_product_tabs_image.aspect_ratio }}"
             data-sizes="auto"
             alt="{{ block.settings.dbtfy_product_tabs_image.alt | escape }}">
      </div>
      {% endif %}

      {% unless block.settings.dbtfy_product_tabs_html == blank %}
      {{ block.settings.dbtfy_product_tabs_html }}
      {% endunless %}
    </div>
    {{ tab_end }}
    {% endif %}

    {% endif %}
    {% endfor %}
  </div>
</div>
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

                $create_producttab_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-product-tabs.liquid', 'value' => $snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add product_tabs throws client exception');
            }
            catch(\Exception $e){
                logger('add product_tabs throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-product-tabs */.dbtfy-product_tabs{& + *{margin-top:$spacer}#ProductTabs{@include screen($small){margin-left:-$gutter-sm;margin-right:-$gutter-sm}}.pt-item{border-radius:$borderRadius;margin-bottom:$spacer;border:$borders;@include screen($small){border-radius:0;border-left:0;border-right:0;border-bottom:0;margin-bottom:0}&:last-child{margin-bottom:0;border-bottom:$borders}}.pt-header-wrapper{cursor:pointer;padding:$gutter-sm;@include hovers;@include transition($transitions);@include display-flexbox();@include align-items(center);&:after{@include fontAwesome;content:"\f067"}}.pt-header-wrapper.active{&:after{content:"\f068"}}.pt-header-title{margin-right:$spacer-sm;margin-bottom:0;@include accentFontStack;@include flex(auto)}.pt-icon{margin-right:$spacer-sm}.active .pt-header-title,.active .pt-icon{color:$colorSecondary}.pt-content-wrapper{display:none;padding:$gutter $gutter-sm;margin-bottom:0;border-top:$borders;background-color:$colorDefault;.rte{margin-bottom:0}}.pt-content{@include animated(heroContentIn)}.active + .pt-content-wrapper{display:block}.review-widget{border-top:0;&>*{border-top:0}}.review-badge{margin-left:auto;margin-right:$spacer-sm}#shopify-product-reviews{padding:0}#shopify-product-reviews .spr-container{padding:0}}/* end-dbtfy-product-tabs */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , '/* start-dbtfy-product-tabs */' ) ) === false ) {
                      $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);

                      $add_styles = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                      );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on Product_tabs addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on Product_tabs addon throws exception');
            }

            // add include
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/product-template.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , 'dbtfy-product-tabs' ) ) === false ) {
                    if( ( $pos = strrpos( $product_template , '{% if section.settings.social_sharing_products %}' ) ) !== false ) {
//
                        $new_prod_template = str_replace("{% if section.settings.social_sharing_products %}", '{% include "dbtfy-product-tabs" %} {% if section.settings.social_sharing_products %}', $product_template);
                        $new_prod_template = addScriptTagCondition($shop, '{% include "dbtfy-product-tabs" %}', $new_prod_template, true);
                        $update_prod_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'snippets/product-template.liquid', 'value' => $new_prod_template] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update Product_tabs on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update Product_tabs on trustbadge addon throws exception');
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-product-tabs */ function themeProductTabs(container) { var _0xc3e6=["\x2E\x64\x62\x74\x66\x79\x2D\x70\x72\x6F\x64\x75\x63\x74\x5F\x74\x61\x62\x73","\x73\x74\x69\x63\x6B\x79\x2D\x68\x65\x61\x64\x65\x72","\x64\x61\x74\x61","\x73\x74\x69\x63\x6B\x79\x2D\x61\x64\x64\x74\x6F\x63\x61\x72\x74\x2D\x70\x6F\x73\x69\x74\x69\x6F\x6E","\x2E\x70\x74\x2D\x69\x74\x65\x6D","\x2E\x70\x74\x2D\x68\x65\x61\x64\x65\x72\x2D\x77\x72\x61\x70\x70\x65\x72","\x66\x69\x6E\x64","\x6F\x75\x74\x65\x72\x48\x65\x69\x67\x68\x74","\x2E\x73\x69\x74\x65\x2D\x68\x65\x61\x64\x65\x72","\x77\x69\x64\x74\x68","\x74\x6F\x70","\x23\x73\x74\x69\x63\x6B\x79\x41\x64\x64\x54\x6F\x43\x61\x72\x74","\x6D\x61\x72\x67\x69\x6E\x42\x6F\x74\x74\x6F\x6D","\x63\x73\x73","\x61\x63\x74\x69\x76\x65","\x68\x61\x73\x43\x6C\x61\x73\x73","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x61\x64\x64\x43\x6C\x61\x73\x73","\x6F\x66\x66\x73\x65\x74","\x61\x6E\x69\x6D\x61\x74\x65","\x64\x6F\x63\x75\x6D\x65\x6E\x74\x45\x6C\x65\x6D\x65\x6E\x74","\x62\x6F\x64\x79","\x63\x6C\x69\x63\x6B","\x73\x68\x6F\x70\x69\x66\x79\x3A\x62\x6C\x6F\x63\x6B\x3A\x73\x65\x6C\x65\x63\x74","\x2E\x70\x74\x2D\x68\x65\x61\x64\x65\x72\x2D\x77\x72\x61\x70\x70\x65\x72\x2D","\x62\x6C\x6F\x63\x6B\x49\x64","\x64\x65\x74\x61\x69\x6C","\x6F\x6E","\x73\x68\x6F\x70\x69\x66\x79\x3A\x73\x65\x63\x74\x69\x6F\x6E\x3A\x6C\x6F\x61\x64"];function ProductTabs(){var _0xfa58x2=$(_0xc3e6[0]),_0xfa58x3=_0xfa58x2[_0xc3e6[2]](_0xc3e6[1]),_0xfa58x4=_0xfa58x2[_0xc3e6[2]](_0xc3e6[3]),_0xfa58x5=$(_0xc3e6[4]),_0xfa58x6=_0xc3e6[5],_0xfa58x7=$(container);_0xfa58x7[_0xc3e6[6]](_0xfa58x6)[_0xc3e6[22]](function(){var _0xfa58x2=$(this),_0xfa58x8=_0xfa58x7[_0xc3e6[6]](_0xfa58x6);if(_0xfa58x3){var _0xfa58x9=$(_0xc3e6[8])[_0xc3e6[7]]()}else {if(769< $(window)[_0xc3e6[9]]()){_0xfa58x9= null}else {_0xfa58x9= $(_0xc3e6[8])[_0xc3e6[7]]()}};if(_0xc3e6[10]== _0xfa58x4){var _0xfa58xa=$(_0xc3e6[11])[_0xc3e6[7]]()}else {_0xfa58xa= null};var _0xfa58xb=_0xfa58x5[_0xc3e6[13]](_0xc3e6[12]),_0xfa58xc=_0xfa58x9+ _0xfa58xa+ parseFloat(_0xfa58xb);_0xfa58x2[_0xc3e6[15]](_0xc3e6[14])?_0xfa58x2[_0xc3e6[16]](_0xc3e6[14]):(_0xfa58x8[_0xc3e6[16]](_0xc3e6[14]),_0xfa58x2[_0xc3e6[17]](_0xc3e6[14]),$([document[_0xc3e6[20]],document[_0xc3e6[21]]])[_0xc3e6[19]]({scrollTop:$(_0xfa58x2)[_0xc3e6[18]]()[_0xc3e6[10]]- _0xfa58xc},300))})}$(document)[_0xc3e6[27]](_0xc3e6[23],function(){$(_0xc3e6[24]+ event[_0xc3e6[26]][_0xc3e6[25]])[_0xc3e6[22]]()}),$(document)[_0xc3e6[27]](_0xc3e6[28],function(){ProductTabs()}),ProductTabs() }; /* end-dbtfy-product-tabs */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-product-tabs */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-product-tabs */sections.register("product-template", themeProductTabs);/* end-register-product-tabs */', $theme_js_content);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }
                sleep(5);
                logger('product tabs js called again');
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';
                $replace_code= '/* start-dbtfy-addons */';
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-product-tabs */' ) ) === false ) {
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


if (! function_exists('activate_producttab_addon_js')) {
  function activate_producttab_addon_js($StoreThemes, $shop) {
    foreach ($StoreThemes as $theme) {
      // add js addon
      try{
        $script= (string)'/* start-dbtfy-product-tabs */ function themeProductTabs(container) { var _0xc3e6=["\x2E\x64\x62\x74\x66\x79\x2D\x70\x72\x6F\x64\x75\x63\x74\x5F\x74\x61\x62\x73","\x73\x74\x69\x63\x6B\x79\x2D\x68\x65\x61\x64\x65\x72","\x64\x61\x74\x61","\x73\x74\x69\x63\x6B\x79\x2D\x61\x64\x64\x74\x6F\x63\x61\x72\x74\x2D\x70\x6F\x73\x69\x74\x69\x6F\x6E","\x2E\x70\x74\x2D\x69\x74\x65\x6D","\x2E\x70\x74\x2D\x68\x65\x61\x64\x65\x72\x2D\x77\x72\x61\x70\x70\x65\x72","\x66\x69\x6E\x64","\x6F\x75\x74\x65\x72\x48\x65\x69\x67\x68\x74","\x2E\x73\x69\x74\x65\x2D\x68\x65\x61\x64\x65\x72","\x77\x69\x64\x74\x68","\x74\x6F\x70","\x23\x73\x74\x69\x63\x6B\x79\x41\x64\x64\x54\x6F\x43\x61\x72\x74","\x6D\x61\x72\x67\x69\x6E\x42\x6F\x74\x74\x6F\x6D","\x63\x73\x73","\x61\x63\x74\x69\x76\x65","\x68\x61\x73\x43\x6C\x61\x73\x73","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x61\x64\x64\x43\x6C\x61\x73\x73","\x6F\x66\x66\x73\x65\x74","\x61\x6E\x69\x6D\x61\x74\x65","\x64\x6F\x63\x75\x6D\x65\x6E\x74\x45\x6C\x65\x6D\x65\x6E\x74","\x62\x6F\x64\x79","\x63\x6C\x69\x63\x6B","\x73\x68\x6F\x70\x69\x66\x79\x3A\x62\x6C\x6F\x63\x6B\x3A\x73\x65\x6C\x65\x63\x74","\x2E\x70\x74\x2D\x68\x65\x61\x64\x65\x72\x2D\x77\x72\x61\x70\x70\x65\x72\x2D","\x62\x6C\x6F\x63\x6B\x49\x64","\x64\x65\x74\x61\x69\x6C","\x6F\x6E","\x73\x68\x6F\x70\x69\x66\x79\x3A\x73\x65\x63\x74\x69\x6F\x6E\x3A\x6C\x6F\x61\x64"];function ProductTabs(){var _0xfa58x2=$(_0xc3e6[0]),_0xfa58x3=_0xfa58x2[_0xc3e6[2]](_0xc3e6[1]),_0xfa58x4=_0xfa58x2[_0xc3e6[2]](_0xc3e6[3]),_0xfa58x5=$(_0xc3e6[4]),_0xfa58x6=_0xc3e6[5],_0xfa58x7=$(container);_0xfa58x7[_0xc3e6[6]](_0xfa58x6)[_0xc3e6[22]](function(){var _0xfa58x2=$(this),_0xfa58x8=_0xfa58x7[_0xc3e6[6]](_0xfa58x6);if(_0xfa58x3){var _0xfa58x9=$(_0xc3e6[8])[_0xc3e6[7]]()}else {if(769< $(window)[_0xc3e6[9]]()){_0xfa58x9= null}else {_0xfa58x9= $(_0xc3e6[8])[_0xc3e6[7]]()}};if(_0xc3e6[10]== _0xfa58x4){var _0xfa58xa=$(_0xc3e6[11])[_0xc3e6[7]]()}else {_0xfa58xa= null};var _0xfa58xb=_0xfa58x5[_0xc3e6[13]](_0xc3e6[12]),_0xfa58xc=_0xfa58x9+ _0xfa58xa+ parseFloat(_0xfa58xb);_0xfa58x2[_0xc3e6[15]](_0xc3e6[14])?_0xfa58x2[_0xc3e6[16]](_0xc3e6[14]):(_0xfa58x8[_0xc3e6[16]](_0xc3e6[14]),_0xfa58x2[_0xc3e6[17]](_0xc3e6[14]),$([document[_0xc3e6[20]],document[_0xc3e6[21]]])[_0xc3e6[19]]({scrollTop:$(_0xfa58x2)[_0xc3e6[18]]()[_0xc3e6[10]]- _0xfa58xc},300))})}$(document)[_0xc3e6[27]](_0xc3e6[23],function(){$(_0xc3e6[24]+ event[_0xc3e6[26]][_0xc3e6[25]])[_0xc3e6[22]]()}),$(document)[_0xc3e6[27]](_0xc3e6[28],function(){ProductTabs()}),ProductTabs() }; /* end-dbtfy-product-tabs */';

          // add js register
          $theme_js_content = $shop->api()->request(
              'GET',
              '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
              ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
          )['body']['asset']['value'] ?? '';

          if( ( $pos = strpos( $theme_js_content , "/* start-register-product-tabs */" ) ) === false ) {
                  $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-product-tabs */sections.register("product-template", themeProductTabs);/* end-register-product-tabs */', $theme_js_content);

              $add_js = $shop->api()->request(
                  'PUT',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
              );
          }
          sleep(5);
          logger('product tabs js called again');
          $theme_js_content = $shop->api()->request(
              'GET',
              '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
              ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
          )['body']['asset']['value'] ?? '';
          $replace_code= '/* start-dbtfy-addons */';
          if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-product-tabs */' ) ) === false ) {
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
if (! function_exists('deactivate_producttabs_addon')) {
    function deactivate_producttabs_addon($StoreThemes, $shop, $checkaddon, $update_addon) {
        foreach ($StoreThemes as $theme) {
          if($update_addon == 1){
            logger("Update");
          }
            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_data.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_producttabs_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schemas = $schema_get['asset']['value'] ?? '';
            }

            $original_schemas = $schemas;

            if(str_contains($schemas,'product-template')){
                $json = json_decode($schemas, true);
                if(Arr::has($json, ['current.sections.product-template.blocks', 'current.sections.product-template.block_order'])) {
                    $json = Arr::except($json, ['current.sections.product-template.blocks', 'current.sections.product-template.block_order']);
                    $value = json_encode($json);
                    $updated_schema = $value;

                    $update_schema_settings = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'config/settings_data.json', 'value' => $updated_schema] ]
                    );
                    $schemas = $updated_schema;
                }
            }

            // remove data schema of featured product
            if(str_contains($schemas,'featured-product')){
                $json = json_decode($schemas, true);

                $product_sections = array_keys(
                    array_filter($json['current']['sections'], function($v) {
                      return $v['type'] === 'featured-product';
                    })
                );

                foreach($product_sections as $id){
                    if(Arr::has($json, ["current.sections.$id.blocks", "current.sections.$id.block_order"])) {
                        $json = Arr::except($json, ["current.sections.$id.blocks", "current.sections.$id.block_order"]);
                        $value = json_encode($json);
                        $updated_schema = $value;
                        logger('updated_schema='.$updated_schema);
                        $update_schema_settings = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'config/settings_data.json', 'value' => $updated_schema] ]
                        );
                    }
                }
            }

            // remove new code 1
            $new_code =',
      {
        "type": "header",
        "content": "Product tabs"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_product_tabs_first",
        "label": "Open first tab",
        "default": true
      },
      {
        "type": "select",
        "id": "dbtfy_product_tabs_size",
        "label": "Size",
        "default": "small",
        "options": [
          {
            "value": "small",
            "label": "Small"
          },
          {
            "value": "large",
            "label": "Large"
          }
        ]
      }';

      // remove new code 2
      $new_code2 =',
      {
        "type": "header",
        "content": "Product tabs"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_product_tabs_first",
        "label": "Open first tab",
        "default": true
      }';

            // remove schema of product template
            $schema = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'sections/product-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            // new code
            if(str_contains($schema,'Product tabs')){
            $product_template_liquid = (string) ',
    "blocks" : [';
            }
            // old code
            else {
              $product_template_liquid = (string) ',"blocks" : [';
            }

            $end_of_file = (string) ' } {% endschema %}';
            $strings = ' ' . $schema;
            $inis = strpos($strings, $product_template_liquid);

            if ($inis == 0) {
                $parseds = '';
            } else{
                $inis += strlen($product_template_liquid);
                $lens = strpos($strings, $end_of_file, $inis) - $inis;
                $parseds = substr($strings, $inis, $lens);
            }

            $valuess = $product_template_liquid.''.$parseds;

            if(str_contains($schema,'dbtfy_product_tabs_title')){
                // new code
                if(str_contains($schema,'Product tabs')){
                  $value_n = str_replace($valuess, "", $schema);
                  // new code 1
                  if(str_contains($schema,'dbtfy_product_tabs_size')){
                    $value = str_replace($new_code, "", $value_n);
                  } else{
                    // new code 2
                    $value = str_replace($new_code2, "", $value_n);
                  }
                }
                // old code
                else {
                  $value = str_replace($valuess, "", $schema);
                }

                if($parseds ==''){
                   $value = explode($product_template_liquid,$schema,2);
                   if(isset($value[0])){
                        $value = $value[0];
                    } else{
                        $value = (string) $schema;
                    }
                }
                $new_template_liquid = (string) $value;
                $update_template_liquid = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'sections/product-template.liquid', 'value' => $new_template_liquid] ]
                );
            }


            // remove schema of featured product template
            $featured_schema = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'sections/featured-product.liquid'] ]
            )['body']['asset']['value'] ?? '';

            // new code
            if(str_contains($featured_schema,'Product tabs')){
            $featured_templat_liquid = (string) ',
    "blocks" : [';
            }
            // old code
            else {
              $featured_templat_liquid = (string) ',"blocks" : [';
            }

            $end_of_settings = (string) ',"presets": [';
            $strings = ' ' . $featured_schema;
            $inis = strpos($strings, $featured_templat_liquid);

            if ($inis == 0) {
                $parsedsf = '';
            } else{
                $inis += strlen($featured_templat_liquid);
                $lens = strpos($strings, $end_of_settings, $inis) - $inis;
                $parsedsf = substr($strings, $inis, $lens);
            }

            $valuesf = $featured_templat_liquid.''.$parsedsf;

            if(str_contains($featured_schema,'dbtfy_product_tabs_title')){
                // new code
                if(str_contains($featured_schema,'Product tabs')){
                  $value_N = str_replace($valuesf, "", $featured_schema);
                  // new code 1
                  if(str_contains($featured_schema,'dbtfy_product_tabs_size')){
                    $value = str_replace($new_code, "", $value_N);
                  } else{
                    // new code 2
                    $value = str_replace($new_code2, "", $value_N);
                  }
                }
                // old code
                else {
                  $value = str_replace($valuesf, "", $featured_schema);
                }

                if($parsedsf ==''){
                    $value = explode($featured_templat_liquid,$featured_schema,2);
                    if(isset($value[0])){
                        $value = $value[0];
                    } else{
                        $value = (string) $featured_schema;
                    }
                }
                $new_featured_liquid = (string) $value;
                $update_template_liquid = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'sections/featured-product.liquid', 'value' => $new_featured_liquid] ]
                );
            }

            $theme_style_content = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
            )['body']['asset']['value'] ?? '';

            // old style

            $styles = (string) '/*================ _Product_tabs ================*/ .dbtfy-product_tabs {& + * {margin-top: $spacer;}#ProductTabs {@include screen($small) {margin-left: -$gutter-sm;margin-right: -$gutter-sm;}}.item-product_tabs {border-radius: $borderRadius;margin-bottom: $spacer;border: $borders;@include screen($small) {border-radius: 0;border-left: 0;border-right: 0;border-bottom:0;margin-bottom:0;}&:last-child {margin-bottom: 0;border-bottom: $borders;}}.header-wrapper-product_tabs {padding: $gutter;cursor: pointer;@include hovers;@include transition($transitions);@include display-flexbox();@include justify-content(space-between);@include align-items(center);@include screen($small) {padding: $gutter $gutter-sm;}&:after {@include fontAwesome;content: "\f067";}}.header-wrapper-product_tabs.active{&:after {content: "\f068";}}.header-title-product_tabs {margin-right: $spacer-sm;margin-bottom: 0px;}.active .header-title-product_tabs {color: $colorSecondary;}.content-wrapper-product_tabs {padding: $gutter;padding-top:0px;display: none;margin-bottom: 0px;@include screen($small) {padding: $gutter $gutter-sm;padding-top:0px;}.rte{margin-bottom: 0px; }}.active + .content-wrapper-product_tabs {display: block;}.review-widget {border-top: 0;& > * {border-top: 0;}}#shopify-product-reviews {padding: 0;}#shopify-product-reviews .spr-container {padding: 0;}}';
            $trustbadge_Style2 = (string) '/*================ _Product_tabs ================*/';
            $end2 = (string) '.spr-container{padding:0; }}';
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
            $trustbadge_Style3 = (string) '/*================ start-dbtfy-Product_tabs ================*/';
            $end3 = (string) '/*================ end-dbtfy-Product_tabs ================*/';
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
            $trustbadge_Style = (string) '/* start-dbtfy-product-tabs */';
            $end = (string) '/* end-dbtfy-product-tabs */';
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
                }else{
                    $values = $styles;
                }
            }

            if(str_contains($theme_style_content,'.product-tabs-section')){
                $value = str_replace($values, " ", $theme_style_content);
                $new_theme_styles = (string) $value;

                $update_styles = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                );
            } else if(str_contains($theme_style_content,'dbtfy-product_tabs')){
                $value = str_replace($values, " ", $theme_style_content);
                $new_theme_styles = (string) $value;

                $update_styles = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                );
            }

            // remove sections
            $delete_product_section = $shop->api()->request(
                'DELETE',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'sections/dbtfy-product-tabs.liquid'] ]
            );

            // remove snippet
            $delete_product_snippet = $shop->api()->request(
                'DELETE',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/dbtfy-product-tabs.liquid'] ]
            );

            // remove section include
            $product_liquid = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'templates/product.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_liquid,'dbtfy-product-tabs')){
                $value  =  explode("{% section 'dbtfy-product-tabs' %}",$product_liquid,2);

                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                } else{
                  $value = (string) $product_liquid;
                }

                $new_prod_liquid = (string) $value;

                $update_prod_liquid = $shop->api()->request(
                  'PUT',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'templates/product.liquid', 'value' => $new_prod_liquid] ]
                );
            }

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'snippets/product-template.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-product-tabs')){
                $str = '{%- if content_for_header contains "debutify" -%} {% include "dbtfy-product-tabs" %} {%- endif -%}';
                if( str_contains($product_template, $str  ) ){
                    $value  =  explode($str, $product_template,2);
                }else{
                    $value  =  explode('{% include "dbtfy-product-tabs" %}',$product_template,2);
                }

//                $value  =  explode('{% include "dbtfy-product-tabs" %}',$product_template,2);

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

                $trustbadge_js = (string) '/* start-dbtfy-product-tabs */';
                $end_js = (string) '/* end-dbtfy-product-tabs */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-product-tabs */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-product-tabs */')){
                        $trustbadge_js1 = (string) '/* start-register-product-tabs */';
                        $end_js = (string) '/* end-register-product-tabs */';
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
                logger('add product_tabs throws client exception');
            }
            catch(\Exception $e){
                logger('add product_tabs throws exception');
            }

            // special update to save data settings
            if($update_addon == 1){
              update_producttabs_addon($StoreThemes,$shop, $original_schemas);
              logger("Not Setting Data");
            }

        }
    }
}



if (! function_exists('deactivate_producttabs_addon_curl')) {
  function deactivate_producttabs_addon_curl($theme, $shop)
  {
    // remove schema
    $schemas = getThemeFileCurl($shop, $theme, 'config/settings_data.json') ?? '';

    $original_schemas = $schemas;

    if(str_contains($schemas,'product-template')){
        $json = json_decode($schemas, true);
        if(Arr::has($json, ['current.sections.product-template.blocks', 'current.sections.product-template.block_order'])) {
            $json = Arr::except($json, ['current.sections.product-template.blocks', 'current.sections.product-template.block_order']);
            $value = json_encode($json);
            $updated_schema = $value;

            $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_data.json');
            $schemas = $updated_schema;
        }
    }

    // remove data schema of featured product
    if(str_contains($schemas,'featured-product')){
        $json = json_decode($schemas, true);

        $product_sections = array_keys(
            array_filter($json['current']['sections'], function($v) {
              return $v['type'] === 'featured-product';
            })
        );

        foreach($product_sections as $id){
            if(Arr::has($json, ["current.sections.$id.blocks", "current.sections.$id.block_order"])) {
                $json = Arr::except($json, ["current.sections.$id.blocks", "current.sections.$id.block_order"]);
                $value = json_encode($json);
                $updated_schema = $value;
                logger('updated_schema='.$updated_schema);
                $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_data.json');
            }
        }
    }

    // remove new code 1
    $new_code =',
{
"type": "header",
"content": "Product tabs"
},
{
"type": "checkbox",
"id": "dbtfy_product_tabs_first",
"label": "Open first tab",
"default": true
},
{
"type": "select",
"id": "dbtfy_product_tabs_size",
"label": "Size",
"default": "small",
"options": [
  {
    "value": "small",
    "label": "Small"
  },
  {
    "value": "large",
    "label": "Large"
  }
]
}';

// remove new code 2
$new_code2 =',
{
"type": "header",
"content": "Product tabs"
},
{
"type": "checkbox",
"id": "dbtfy_product_tabs_first",
"label": "Open first tab",
"default": true
}';

    // remove schema of product template
    $schema = getThemeFileCurl($shop, $theme, 'sections/product-template.liquid') ?? '';

    // new code
    if(str_contains($schema,'Product tabs')){
    $product_template_liquid = (string) ',
"blocks" : [';
    }
    // old code
    else {
      $product_template_liquid = (string) ',"blocks" : [';
    }

    $end_of_file = (string) ' } {% endschema %}';
    $strings = ' ' . $schema;
    $inis = strpos($strings, $product_template_liquid);

    if ($inis == 0) {
        $parseds = '';
    } else{
        $inis += strlen($product_template_liquid);
        $lens = strpos($strings, $end_of_file, $inis) - $inis;
        $parseds = substr($strings, $inis, $lens);
    }

    $valuess = $product_template_liquid.''.$parseds;

    if(str_contains($schema,'dbtfy_product_tabs_title')){
        // new code
        if(str_contains($schema,'Product tabs')){
          $value_n = str_replace($valuess, "", $schema);
          // new code 1
          if(str_contains($schema,'dbtfy_product_tabs_size')){
            $value = str_replace($new_code, "", $value_n);
          } else{
            // new code 2
            $value = str_replace($new_code2, "", $value_n);
          }
        }
        // old code
        else {
          $value = str_replace($valuess, "", $schema);
        }

        if($parseds ==''){
           $value = explode($product_template_liquid,$schema,2);
           if(isset($value[0])){
                $value = $value[0];
            } else{
                $value = (string) $schema;
            }
        }
        $new_template_liquid = (string) $value;
        $update_template_liquid = putThemeFileCurl($shop, $theme, $new_template_liquid, 'sections/product-template.liquid');
    }


    // remove schema of featured product template
    $featured_schema = getThemeFileCurl($shop, $theme, 'sections/featured-product.liquid') ?? '';
    // new code
    if(str_contains($featured_schema,'Product tabs')){
    $featured_templat_liquid = (string) ',
"blocks" : [';
    }
    // old code
    else {
      $featured_templat_liquid = (string) ',"blocks" : [';
    }

    $end_of_settings = (string) ',"presets": [';
    $strings = ' ' . $featured_schema;
    $inis = strpos($strings, $featured_templat_liquid);

    if ($inis == 0) {
        $parsedsf = '';
    } else{
        $inis += strlen($featured_templat_liquid);
        $lens = strpos($strings, $end_of_settings, $inis) - $inis;
        $parsedsf = substr($strings, $inis, $lens);
    }

    $valuesf = $featured_templat_liquid.''.$parsedsf;

    if(str_contains($featured_schema,'dbtfy_product_tabs_title')){
        // new code
        if(str_contains($featured_schema,'Product tabs')){
          $value_N = str_replace($valuesf, "", $featured_schema);
          // new code 1
          if(str_contains($featured_schema,'dbtfy_product_tabs_size')){
            $value = str_replace($new_code, "", $value_N);
          } else{
            // new code 2
            $value = str_replace($new_code2, "", $value_N);
          }
        }
        // old code
        else {
          $value = str_replace($valuesf, "", $featured_schema);
        }

        if($parsedsf ==''){
            $value = explode($featured_templat_liquid,$featured_schema,2);
            if(isset($value[0])){
                $value = $value[0];
            } else{
                $value = (string) $featured_schema;
            }
        }
        $new_featured_liquid = (string) $value;
        $update_template_liquid = putThemeFileCurl($shop, $theme, $new_featured_liquid, 'sections/featured-product.liquid');
    }

    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid') ?? '';

    // old style

    $styles = (string) '/*================ _Product_tabs ================*/ .dbtfy-product_tabs {& + * {margin-top: $spacer;}#ProductTabs {@include screen($small) {margin-left: -$gutter-sm;margin-right: -$gutter-sm;}}.item-product_tabs {border-radius: $borderRadius;margin-bottom: $spacer;border: $borders;@include screen($small) {border-radius: 0;border-left: 0;border-right: 0;border-bottom:0;margin-bottom:0;}&:last-child {margin-bottom: 0;border-bottom: $borders;}}.header-wrapper-product_tabs {padding: $gutter;cursor: pointer;@include hovers;@include transition($transitions);@include display-flexbox();@include justify-content(space-between);@include align-items(center);@include screen($small) {padding: $gutter $gutter-sm;}&:after {@include fontAwesome;content: "\f067";}}.header-wrapper-product_tabs.active{&:after {content: "\f068";}}.header-title-product_tabs {margin-right: $spacer-sm;margin-bottom: 0px;}.active .header-title-product_tabs {color: $colorSecondary;}.content-wrapper-product_tabs {padding: $gutter;padding-top:0px;display: none;margin-bottom: 0px;@include screen($small) {padding: $gutter $gutter-sm;padding-top:0px;}.rte{margin-bottom: 0px; }}.active + .content-wrapper-product_tabs {display: block;}.review-widget {border-top: 0;& > * {border-top: 0;}}#shopify-product-reviews {padding: 0;}#shopify-product-reviews .spr-container {padding: 0;}}';
    $trustbadge_Style2 = (string) '/*================ _Product_tabs ================*/';
    $end2 = (string) '.spr-container{padding:0; }}';
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
    $trustbadge_Style3 = (string) '/*================ start-dbtfy-Product_tabs ================*/';
    $end3 = (string) '/*================ end-dbtfy-Product_tabs ================*/';
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
    $trustbadge_Style = (string) '/* start-dbtfy-product-tabs */';
    $end = (string) '/* end-dbtfy-product-tabs */';
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
        }else{
            $values = $styles;
        }
    }

    if(str_contains($theme_style_content,'.product-tabs-section')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    } else if(str_contains($theme_style_content,'dbtfy-product_tabs')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove sections
    $delete_product_section = deleteThemeFilesCurl($shop, $theme, 'sections/dbtfy-product-tabs.liquid');

    // remove snippet
    $delete_product_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-product-tabs.liquid');

    // remove section include
    $product_liquid = getThemeFileCurl($shop, $theme, 'templates/product.liquid') ?? '';

    if(str_contains($product_liquid,'dbtfy-product-tabs')){
        $value  =  explode("{% section 'dbtfy-product-tabs' %}",$product_liquid,2);

        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        } else{
          $value = (string) $product_liquid;
        }

        $new_prod_liquid = (string) $value;

        $update_prod_liquid = putThemeFileCurl($shop, $theme, $new_prod_liquid, 'templates/product.liquid');
    }

    // remove include
    $product_template = getThemeFileCurl($shop, $theme, 'snippets/product-template.liquid') ?? '';

    if(str_contains($product_template,'dbtfy-product-tabs')){
        $str = '{%- if content_for_header contains "debutify" -%} {% include "dbtfy-product-tabs" %} {%- endif -%}';
        if( str_contains($product_template, $str  ) ){
            $value  =  explode($str, $product_template,2);
        }else{
            $value  =  explode('{% include "dbtfy-product-tabs" %}',$product_template,2);
        }
//        $value  =  explode('{% include "dbtfy-product-tabs" %}',$product_template,2);

        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        } else{
            $value = (string) $product_template;
        }

        $new_prod_template = (string) $value;

        $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'snippets/product-template.liquid');
    }

    // remove js addon
    try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

        $trustbadge_js = (string) '/* start-dbtfy-product-tabs */';
        $end_js = (string) '/* end-dbtfy-product-tabs */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-product-tabs */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-product-tabs */')){
                $trustbadge_js1 = (string) '/* start-register-product-tabs */';
                $end_js = (string) '/* end-register-product-tabs */';
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
        logger('add product_tabs throws client exception');
    }
    catch(\Exception $e){
        logger('add product_tabs throws exception');
    }
  }
}

if (! function_exists('update_producttabs_addon')) {
    function update_producttabs_addon($StoreThemes, $shop, $original_schemas) {
        activate_producttab_addon($StoreThemes,$shop);
        foreach ($StoreThemes as $theme) {
            logger('updated_schema');
            $update_schema_settings = $shop->api()->request(
                'PUT',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_data.json', 'value' => $original_schemas] ]
            );
        }
    }
}
?>
