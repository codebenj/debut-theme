<?php
use Illuminate\Support\Arr;
// activate
if (! function_exists('activate_mega_menu_addon')) {
    function activate_mega_menu_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

          // add schema
          $liveview_addon_schema = (string) '"blocks" : [
            {
              "type": "mega",
              "name": "Mega menu",
         	    "limit": 6,
              "settings": [
                {
                  "type": "checkbox",
                  "id": "dbtfy_mega_menu_header",
                  "label": "Show header",
            			"default": true
                },
                {
                  "type": "url",
                  "id": "dbtfy_mega_menu_trigger",
                  "label": "Link trigger"
                },
                {
                  "type": "link_list",
                  "id": "dbtfy_mega_menu_multi",
                  "label": "Menu"
                },
                {
                  "type": "product",
                  "id": "dbtfy_mega_menu_multi_product_1",
                  "label": "Product"
                },
                {
                  "type": "product",
                  "id": "dbtfy_mega_menu_multi_product_2",
                  "label": "Product"
                },
                {
                  "type": "product",
                  "id": "dbtfy_mega_menu_multi_product_3",
                  "label": "Product"
                },
                {
                  "type": "image_picker",
                  "id": "dbtfy_mega_menu_multi_image",
                  "label": "Image"
                },
                {
                  "type": "url",
                  "id": "dbtfy_mega_menu_multi_image_link",
                  "label": "Image link"
                }
              ]
            },
            {
              "type": "product",
              "name": "Products",
       	      "limit": 6,
              "settings": [
                {
                  "type": "checkbox",
                  "id": "dbtfy_mega_menu_header",
                  "label": "Show header",
      		        "default": true
                },
                {
                  "type": "url",
                  "id": "dbtfy_mega_menu_trigger",
                  "label": "Link trigger"
                },
                {
                  "type": "collection",
                  "id": "dbtfy_mega_menu_product",
                  "label": "Collection"
                },
                {
                  "type": "select",
                  "id": "dbtfy_mega_menu_product_grid",
                  "label": "Products to show",
                  "default": "5",
                  "options": [
                    {
                      "value": "4",
                      "label": "4"
                    },
                    {
                      "value": "5",
                      "label": "5"
                    }
                  ]
                }
              ]
            },
            {
              "type": "collection",
              "name": "Collections",
       	      "limit": 6,
              "settings": [
                {
                  "type": "checkbox",
                  "id": "dbtfy_mega_menu_header",
                  "label": "Show header",
      			      "default": true
                },
                {
                  "type": "url",
                  "id": "dbtfy_mega_menu_trigger",
                  "label": "Link trigger"
                },
                {
                  "type": "text",
                  "id": "dbtfy_mega_menu_title",
                  "label": "Title",
                  "default": "Collections"
                },
                {
                  "type": "collection",
                  "id": "dbtfy_mega_menu_collection_1",
                  "label": "Collection"
                },
                {
                  "type": "collection",
                  "id": "dbtfy_mega_menu_collection_2",
                  "label": "Collection"
                },
          		{
                  "type": "collection",
                  "id": "dbtfy_mega_menu_collection_3",
                  "label": "Collection"
                },
          		{
                  "type": "collection",
                  "id": "dbtfy_mega_menu_collection_4",
                  "label": "Collection"
                },
                {
                  "type": "collection",
                  "id": "dbtfy_mega_menu_collection_5",
                  "label": "Collection"
                },
                {
                  "type": "collection",
                  "id": "dbtfy_mega_menu_collection_6",
                  "label": "Collection"
                }
              ]
            },
            {
              "type": "blog",
              "name": "Blog posts",
       	      "limit": 6,
              "settings": [
                {
                  "type": "checkbox",
                  "id": "dbtfy_mega_menu_header",
                  "label": "Show header",
      		      	"default": true
                },
                {
                  "type": "url",
                  "id": "dbtfy_mega_menu_trigger",
                  "label": "Link trigger"
                },
                {
                  "type": "blog",
                  "id": "dbtfy_mega_menu_blog",
                  "label": "Blog"
                }
              ]
            },
            {
              "type": "html",
              "name": "HTML",
       	      "limit": 6,
              "settings": [
                {
                  "type": "url",
                  "id": "dbtfy_mega_menu_trigger",
                  "label": "Link trigger"
                },
                {
                  "type": "html",
                  "id": "dbtfy_mega_menu_html",
                  "label": "HTML"
                }
              ]
            }
          ]';

          // add section json
          try{
              $schema = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'sections/header.liquid'] ]
              )['body']['asset']['value'] ?? '';

              if( ( $badgePos = strpos( $schema , 'dbtfy_mega_menu_header' ) ) === false ) {
                  if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                      $updated_schema    = substr_replace( $schema , "],".$liveview_addon_schema." } {% endschema %}" , $pos );

                      $update_schema_settings = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'sections/header.liquid', 'value' => $updated_schema] ]
                      );
                  }
              }
          }
          catch(\GuzzleHttp\Exception\ClientException $e){
              logger('add mega_menu1 throws client exception');
          }
          catch(\Exception $e){
              logger(json_encode($e));
              logger('add mega_menu2 throws exception');
          }

          // add snippet
          try{
              $snippet = (string) '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}
{%- if section.blocks.size > 0 -%}
<div class="dbtfy dbtfy-mega_menu">
  <div id="MegaMenu" class="small--hide medium--hide">

    <!-- Blocks -->
    {% for block in section.blocks %}
    <div class="item-mega_menu item-mega_menu-{{ block.id }}" {{ block.shopify_attributes }} data-trigger="{{ block.settings.dbtfy_mega_menu_trigger }}">

      <div class="wrapper">
        {% if block.type == "mega" %}
          {% assign has_product_1 = false %}
          {% assign has_product_2 = false %}
          {% assign has_product_3 = false %}
          <div class="grid grid-uniform multi-mega_menu">
            {% assign column_number = 0 %}

            {% if block.settings.dbtfy_mega_menu_multi != blank %}
              {% for link in linklists[block.settings.dbtfy_mega_menu_multi].links %}
                {% assign column_number = column_number | plus: 1 %}
              {% endfor %}
            {% endif %}

            {% if block.settings.dbtfy_mega_menu_multi_product_1 != blank %}
              {% assign column_number = column_number | plus: 1 %}
              {% assign product_1 = all_products[block.settings.dbtfy_mega_menu_multi_product_1] %}
              {% assign has_product_1 = true %}
            {% endif %}

            {% if block.settings.dbtfy_mega_menu_multi_product_2 != blank %}
              {% assign column_number = column_number | plus: 1 %}
              {% assign product_2 = all_products[block.settings.dbtfy_mega_menu_multi_product_2] %}
              {% assign has_product_2 = true %}
            {% endif %}

            {% if block.settings.dbtfy_mega_menu_multi_product_3 != blank %}
              {% assign column_number = column_number | plus: 1 %}
              {% assign product_3 = all_products[block.settings.dbtfy_mega_menu_multi_product_3] %}
              {% assign has_product_3 = true %}
            {% endif %}

            {% if block.settings.dbtfy_mega_menu_multi_image != blank %}
              {% assign column_number = column_number | plus: 1 %}
            {% endif %}

            {% if column_number == 1 %}
              {% if block.settings.dbtfy_mega_menu_multi_product_1 != blank or block.settings.dbtfy_mega_menu_multi_product_2 != blank or block.settings.dbtfy_mega_menu_multi_product_3 != blank %}
                {% assign grid_item_width = "large--one-fifth" %}
              {% else %}
                {% assign grid_item_width = "one-whole" %}
              {% endif %}
            {% else %}
              {% assign grid_item_width = "large--one-fifth" %}
            {% endif %}

            {% if block.settings.dbtfy_mega_menu_multi != blank %}
              {% for link in linklists[block.settings.dbtfy_mega_menu_multi].links %}
              <div class="grid__item {{ grid_item_width }}">
                {% if block.settings.dbtfy_mega_menu_header and column_number > 1 %}
                  <a href="{{ link.url }}" class="h4 title-product-mega_menu">
                    {{ link.title }}
                  </a>
                {% endif %}

                {% if link.links != blank %}
                <ul class="no-bullets{% if column_number == 1 %} inline-list{% endif %}">
                  {% for childlink in link.links %}
                    <li><a href="{{ childlink.url }}">{{ childlink.title }}</a></li>
                  {% endfor %}
                </ul>
                {% endif %}

              </div>
              {% endfor %}
            {% endif %}

            {% if column_number < 5 and block.settings.dbtfy_mega_menu_multi_image == blank %}
              <div class="grid__item {{ grid_item_width }} item-fill"></div>
            {% endif %}

            {% if has_product_1 %}
              {% include "product-grid-item" with product_1 as product %}
            {% endif %}

            {% if has_product_2 %}
              {% include "product-grid-item" with product_2 as product %}
            {% endif %}

            {% if has_product_3 %}
              {% include "product-grid-item" with product_3 as product %}
            {% endif %}

            {% if block.settings.dbtfy_mega_menu_multi_image != blank %}
            <div class="grid__item {{ grid_item_width }} item-fill">
              {% if block.settings.dbtfy_mega_menu_multi_image_link != blank %}
              <a class="image-link" href="{{ block.settings.dbtfy_mega_menu_multi_image_link }}">
              {% endif %}

                <div class="image-wrapper" style="padding-top:{{ 1 | divided_by: block.settings.dbtfy_mega_menu_multi_image.aspect_ratio | times: 100}}%;">
                  {% assign img_url = block.settings.dbtfy_mega_menu_multi_image | img_url: "1x1" | replace: "_1x1.", "_{width}x." %}
                  <img class="image lazyload"
                    src="{{ block.settings.dbtfy_mega_menu_multi_image | img_url: \'300x300\' }}"
                    data-src="{{ img_url }}"
                    data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]"
                    data-aspectratio="{{ block.settings.dbtfy_mega_menu_multi_image.aspect_ratio }}"
                    data-sizes="auto"
                    alt="{{ block.settings.dbtfy_mega_menu_multi_image.alt | escape }}">
                </div>

              {% if block.settings.dbtfy_mega_menu_multi_image_link != blank %}
              </a>
              {% endif %}
            </div>
            {% endif %}
          </div>
        {% endif %}

        {% if block.type == "product" %}
          {% if block.settings.dbtfy_mega_menu_header %}
          <div class="header-wrapper-mega_menu">
            <h4 class="title-product-mega_menu">
              <a href="{{ collections[block.settings.dbtfy_mega_menu_product].url }}">{{ collections[block.settings.dbtfy_mega_menu_product].title | escape }}</a>
            </h4>
            <a class="link-mega_menu text-link" href="{{ collections[block.settings.dbtfy_mega_menu_product].url }}">{{ "blogs.article.view_all" | t }}</a>
          </div>
          {% endif %}
          {% assign counter = 0 %}
          {% if block.settings.dbtfy_mega_menu_product_grid == "4" %}
            {% assign limit = 4 %}
            {% assign grid_item_width = "large--three-twelfths" %}
          {% elsif block.settings.dbtfy_mega_menu_product_grid == "5" %}
        	{% assign limit = 5 %}
          	{% assign grid_item_width = "large--one-fifth" %}
          {% endif %}
          <div class="grid grid-uniform">
            {% for product in collections[block.settings.dbtfy_mega_menu_product].products %}
              {% include "product-grid-item" %}
            {% endfor %}
          </div>
        {% endif %}

        {% if block.type == "collection" %}
          {% if block.settings.dbtfy_mega_menu_header %}
          <div class="header-wrapper-mega_menu">
            <h4 class="title-product-mega_menu">
              <a href="/collections">{{ block.settings.dbtfy_mega_menu_title }}</a>
            </h4>
            <a class="link-mega_menu text-link" href="/collections">{{ "blogs.article.view_all" | t }}</a>
          </div>
          {% endif %}
          <div class="grid grid-uniform grid--spacer collection-mega_menu">
            {% assign collection_index = 0 %}
            {% assign collection_count = 0 %}

            {% assign collection_1 = block.settings.dbtfy_mega_menu_collection_1 %}
            {% assign collection_2 = block.settings.dbtfy_mega_menu_collection_2 %}
            {% assign collection_3 = block.settings.dbtfy_mega_menu_collection_3 %}
            {% assign collection_4 = block.settings.dbtfy_mega_menu_collection_4 %}
            {% assign collection_5 = block.settings.dbtfy_mega_menu_collection_5 %}
            {% assign collection_6 = block.settings.dbtfy_mega_menu_collection_6 %}

            {% if collection_1 != blank %}{% assign collection_count = collection_count | plus: 1 %}{% endif %}
            {% if collection_2 != blank %}{% assign collection_count = collection_count | plus: 1 %}{% endif %}
            {% if collection_3 != blank %}{% assign collection_count = collection_count | plus: 1 %}{% endif %}
            {% if collection_4 != blank %}{% assign collection_count = collection_count | plus: 1 %}{% endif %}
            {% if collection_5 != blank %}{% assign collection_count = collection_count | plus: 1 %}{% endif %}
            {% if collection_6 != blank %}{% assign collection_count = collection_count | plus: 1 %}{% endif %}

            {% assign collection_limit = collection_count %}
            {% assign divisible_by_three = collection_count | modulo: 3 %}
            {% assign divisible_by_two = collection_count | modulo: 2 %}

            {% if collection_1 != blank %}
              {% assign collection = collections[collection_1] %}
              {% assign collection_index = collection_index | plus: 1 %}
              {% assign collection_handle = collection.handle %}
              {% include "collection-grid-collage" %}
            {% endif %}

            {% if collection_2 != blank %}
              {% assign collection = collections[collection_2] %}
              {% assign collection_index = collection_index | plus: 1 %}
              {% assign collection_handle = collection.handle %}
              {% include "collection-grid-collage" %}
            {% endif %}

            {% if collection_3 != blank %}
              {% assign collection = collections[collection_3] %}
              {% assign collection_index = collection_index | plus: 1 %}
              {% assign collection_handle = collection.handle %}
              {% include "collection-grid-collage" %}
            {% endif %}

            {% if collection_4 != blank %}
              {% assign collection = collections[collection_4] %}
              {% assign collection_index = collection_index | plus: 1 %}
              {% assign collection_handle = collection.handle %}
              {% include "collection-grid-collage" %}
            {% endif %}

            {% if collection_5 != blank %}
              {% assign collection = collections[collection_5] %}
              {% assign collection_index = collection_index | plus: 1 %}
              {% assign collection_handle = collection.handle %}
              {% include "collection-grid-collage" %}
            {% endif %}

            {% if collection_6 != blank %}
              {% assign collection = collections[collection_6] %}
              {% assign collection_index = collection_index | plus: 1 %}
              {% assign collection_handle = collection.handle %}
              {% include "collection-grid-collage" %}
            {% endif %}
          </div>
        {% endif %}

        {% if block.type == "blog" %}
		  {% if block.settings.dbtfy_mega_menu_header %}
          <div class="header-wrapper-mega_menu">
            <h4 class="title-product-mega_menu">
              <a href="{{ blogs[block.settings.dbtfy_mega_menu_blog].url }}">{{ blogs[block.settings.dbtfy_mega_menu_blog].title | escape }}</a>
            </h4>
            <a class="link-mega_menu text-link" href="{{ blogs[block.settings.dbtfy_mega_menu_blog].url }}">{{ "blogs.article.view_all" | t }}</a>
          </div>
          {% endif %}
          {% assign counter = 0 %}
          {% assign limit = 3 %}
          {% assign grid_item_width = "large--four-twelfths" %}
          <div class="grid grid-uniform">
            {% for article in blogs[block.settings.dbtfy_mega_menu_blog].articles %}
              {% include "article-grid-item" %}
              {% assign counter = counter | plus: 1 %}
              {% if counter == limit %}
                {% break %}
              {% endif %}
            {% endfor %}
          </div>
        {% endif %}

        {% if block.type == "html" %}
          {{ block.settings.dbtfy_mega_menu_html }}
        {% endif %}

      </div>
    </div>
    {% endfor %}
  </div>
</div>
{%- endif -%}';

              $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

              $create_producttab_snippet = $shop->api()->request(
                  'PUT',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'snippets/dbtfy-mega-menu.liquid', 'value' => $snippet] ]
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
              $styles = (string) '/* start-dbtfy-mega-menu */.dbtfy-mega_menu{pointer-events:none;#MegaMenu{position:relative;z-index:-1}.item-mega_menu{border-top:$borders;position:absolute;top:0;left:0;right:0;width:100%;background-color:$colorBody;padding:$gutter 0;opacity:0;@include shadow($shadow);@include transition($transitions);@include transform(translate3d(0,-12px,0));&.animation-mega_menu{pointer-events:auto;opacity:1;@include transform(translate3d(0,0,0))}}.title-product-mega_menu{display:inline-block}.link-mega_menu{float:right}.item-fill{@include flex(auto)}.multi-mega_menu{ul li a{display:block;@include leadFontStack;padding:$spacer-xs 0}.inline-list{text-align:center;li{margin-right:$gutter;margin-bottom:0;&:last-child{margin-right:0}}}}.collection-mega_menu .large--eight-twelfths{width:100%;left:0}.article{.blog-meta{display:none}h2,h3{font-size:$headerSize6}.rte{overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;& + p{display:none}}}}.nav-mega_menu{&:after{@include fontAwesome;content:"\f107"}}.is-scrolling .item-mega_menu{border-top:none}/* end-dbtfy-mega-menu */';

              $theme_style_content = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
              )['body']['asset']['value'] ?? '';

              if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-mega-menu' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);
                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
              }
          }
          catch(\GuzzleHttp\Exception\ClientException $e){
              logger('update CSS on mega_menu addon throws client exception');
          }
          catch(\Exception $e){
              logger('update CSS on mega_menu addon throws exception');
          }

          // add include
          try{
              $product_template = $shop->api()->request(
                  'GET',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'sections/header.liquid'] ]
              )['body']['asset']['value'] ?? '';

              if( ( $pos = strpos( $product_template , 'dbtfy-mega-menu' ) ) === false ) {
                  if( ( $pos = strrpos( $product_template , '</header>' ) ) !== false ) {
                      $new_prod_template = str_replace("</header>", '{% include "dbtfy-mega-menu" %}</header>', $product_template);

                      $new_prod_template = addScriptTagCondition($shop, '{% include "dbtfy-mega-menu" %}', $new_prod_template, true);

                      $update_prod_template = $shop->api()->request(
                          'PUT',
                          '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                          ['asset' => ['key' => 'sections/header.liquid', 'value' => $new_prod_template] ]
                      );
                  }
              }
          }
          catch(\GuzzleHttp\Exception\ClientException $e){
              logger('update mega_menu on trustbadge addon throws client exception');
          }
          catch(\Exception $e){
              logger('update mega_menu on trustbadge addon throws exception');
          }

          // add js addon
          try{
              $script= (string)'/* start-dbtfy-mega-menu */function themeMegaMenu() { var _0xade9=["\x2E\x64\x62\x74\x66\x79\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x61\x6E\x69\x6D\x61\x74\x69\x6F\x6E\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x2E\x69\x74\x65\x6D\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x6D\x6F\x75\x73\x65\x6F\x76\x65\x72","\x68\x72\x65\x66","\x61\x74\x74\x72","\x2E\x69\x74\x65\x6D\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75\x5B\x64\x61\x74\x61\x2D\x74\x72\x69\x67\x67\x65\x72\x3D\x22","\x22\x5D","\x61\x64\x64\x43\x6C\x61\x73\x73","\x6F\x6E","\x2E\x73\x69\x74\x65\x2D\x6E\x61\x76\x5F\x5F\x6C\x69\x6E\x6B","\x6D\x6F\x75\x73\x65\x6C\x65\x61\x76\x65","\x6D\x6F\x75\x73\x65\x65\x6E\x74\x65\x72","\x2E\x61\x6E\x6E\x6F\x75\x6E\x63\x65\x6D\x65\x6E\x74\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2C\x2E\x6E\x61\x76\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2D\x72\x69\x67\x68\x74\x2D\x69\x63\x6F\x6E\x73\x2C\x2E\x6E\x61\x76\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2D\x6C\x65\x66\x74\x2D\x69\x63\x6F\x6E\x73\x2C\x2E\x6E\x61\x76\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2D\x6C\x6F\x67\x6F\x2C\x2E\x6D\x61\x69\x6E\x2D\x63\x6F\x6E\x74\x65\x6E\x74","\x64\x61\x74\x61\x2D\x74\x72\x69\x67\x67\x65\x72","\x6E\x61\x76\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x2E\x73\x69\x74\x65\x2D\x6E\x61\x76\x5F\x5F\x6C\x69\x6E\x6B\x5B\x68\x72\x65\x66\x3D\x22","\x65\x61\x63\x68","\x2E\x69\x74\x65\x6D\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75\x5B\x64\x61\x74\x61\x2D\x74\x72\x69\x67\x67\x65\x72\x5D","\x73\x68\x6F\x70\x69\x66\x79\x3A\x73\x65\x63\x74\x69\x6F\x6E\x3A\x6C\x6F\x61\x64"];function MegaMenu(){$(_0xade9[0]);var _0xb5acx2=_0xade9[1],_0xb5acx3=$(_0xade9[2]);function _0xb5acx4(){_0xb5acx3[_0xade9[3]](_0xb5acx2)}$(_0xade9[11])[_0xade9[10]](_0xade9[4],function(){var _0xb5acx3=$(this)[_0xade9[6]](_0xade9[5]),_0xb5acx5=$(_0xade9[7]+ _0xb5acx3+ _0xade9[8]);_0xb5acx4(),_0xb5acx5[_0xade9[9]](_0xb5acx2)}),$(_0xade9[0])[_0xade9[10]](_0xade9[12],function(){_0xb5acx4()}),$(_0xade9[14])[_0xade9[10]](_0xade9[13],function(){_0xb5acx4()}),$(_0xade9[19])[_0xade9[18]](function(){var _0xb5acx3=$(this)[_0xade9[6]](_0xade9[15]);$(_0xade9[17]+ _0xb5acx3+ _0xade9[8])[_0xade9[9]](_0xade9[16])})}$(document)[_0xade9[10]](_0xade9[20],function(){MegaMenu()}),MegaMenu() }/* end-dbtfy-mega-menu */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-mega-menu */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-mega-menu */sections.register("header-section", themeMegaMenu);/* end-register-mega-menu */', $theme_js_content);

                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }
              
                sleep(5);

                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';
                $replace_code= '/* start-dbtfy-addons */';
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-mega-menu */' ) ) === false ) {
                    $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content);
                    $add_js = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update js on mega menu addon throws client exception');
            }
            catch(\Exception $e){
                logger('update js on mega menu addon throws exception');
            }

        }
    }
}

if (! function_exists('activate_mega_menu_addon_js')) {
  function activate_mega_menu_addon_js($StoreThemes, $shop) {
    foreach ($StoreThemes as $theme) {
      // add js addon
      try{
          $script= (string)'/* start-dbtfy-mega-menu */function themeMegaMenu() { var _0xade9=["\x2E\x64\x62\x74\x66\x79\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x61\x6E\x69\x6D\x61\x74\x69\x6F\x6E\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x2E\x69\x74\x65\x6D\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x6D\x6F\x75\x73\x65\x6F\x76\x65\x72","\x68\x72\x65\x66","\x61\x74\x74\x72","\x2E\x69\x74\x65\x6D\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75\x5B\x64\x61\x74\x61\x2D\x74\x72\x69\x67\x67\x65\x72\x3D\x22","\x22\x5D","\x61\x64\x64\x43\x6C\x61\x73\x73","\x6F\x6E","\x2E\x73\x69\x74\x65\x2D\x6E\x61\x76\x5F\x5F\x6C\x69\x6E\x6B","\x6D\x6F\x75\x73\x65\x6C\x65\x61\x76\x65","\x6D\x6F\x75\x73\x65\x65\x6E\x74\x65\x72","\x2E\x61\x6E\x6E\x6F\x75\x6E\x63\x65\x6D\x65\x6E\x74\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2C\x2E\x6E\x61\x76\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2D\x72\x69\x67\x68\x74\x2D\x69\x63\x6F\x6E\x73\x2C\x2E\x6E\x61\x76\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2D\x6C\x65\x66\x74\x2D\x69\x63\x6F\x6E\x73\x2C\x2E\x6E\x61\x76\x2D\x63\x6F\x6E\x74\x61\x69\x6E\x65\x72\x2D\x6C\x6F\x67\x6F\x2C\x2E\x6D\x61\x69\x6E\x2D\x63\x6F\x6E\x74\x65\x6E\x74","\x64\x61\x74\x61\x2D\x74\x72\x69\x67\x67\x65\x72","\x6E\x61\x76\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75","\x2E\x73\x69\x74\x65\x2D\x6E\x61\x76\x5F\x5F\x6C\x69\x6E\x6B\x5B\x68\x72\x65\x66\x3D\x22","\x65\x61\x63\x68","\x2E\x69\x74\x65\x6D\x2D\x6D\x65\x67\x61\x5F\x6D\x65\x6E\x75\x5B\x64\x61\x74\x61\x2D\x74\x72\x69\x67\x67\x65\x72\x5D","\x73\x68\x6F\x70\x69\x66\x79\x3A\x73\x65\x63\x74\x69\x6F\x6E\x3A\x6C\x6F\x61\x64"];function MegaMenu(){$(_0xade9[0]);var _0xb5acx2=_0xade9[1],_0xb5acx3=$(_0xade9[2]);function _0xb5acx4(){_0xb5acx3[_0xade9[3]](_0xb5acx2)}$(_0xade9[11])[_0xade9[10]](_0xade9[4],function(){var _0xb5acx3=$(this)[_0xade9[6]](_0xade9[5]),_0xb5acx5=$(_0xade9[7]+ _0xb5acx3+ _0xade9[8]);_0xb5acx4(),_0xb5acx5[_0xade9[9]](_0xb5acx2)}),$(_0xade9[0])[_0xade9[10]](_0xade9[12],function(){_0xb5acx4()}),$(_0xade9[14])[_0xade9[10]](_0xade9[13],function(){_0xb5acx4()}),$(_0xade9[19])[_0xade9[18]](function(){var _0xb5acx3=$(this)[_0xade9[6]](_0xade9[15]);$(_0xade9[17]+ _0xb5acx3+ _0xade9[8])[_0xade9[9]](_0xade9[16])})}$(document)[_0xade9[10]](_0xade9[20],function(){MegaMenu()}),MegaMenu() }/* end-dbtfy-mega-menu */';

          // add js register
          $theme_js_content = $shop->api()->request(
              'GET',
              '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
              ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
          )['body']['asset']['value'] ?? '';

          if( ( $pos = strpos( $theme_js_content , "/* start-register-mega-menu */" ) ) === false ) {
                  $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-mega-menu */sections.register("header-section", themeMegaMenu);/* end-register-mega-menu */', $theme_js_content);

              $add_js = $shop->api()->request(
                  'PUT',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
              );
          }
        
          sleep(5);

          $theme_js_content = $shop->api()->request(
              'GET',
              '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
              ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
          )['body']['asset']['value'] ?? '';
          $replace_code= '/* start-dbtfy-addons */';
          if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-mega-menu */' ) ) === false ) {
              $new_theme_js = str_replace($replace_code, $replace_code.$script, $theme_js_content);
              $add_js = $shop->api()->request(
                  'PUT',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid', 'value' => $new_theme_js] ]
              );
          }
      }
      catch(\GuzzleHttp\Exception\ClientException $e){
          logger('update js on mega menu addon throws client exception');
      }
      catch(\Exception $e){
          logger('update js on mega menu addon throws exception');
      }
    }
  }
}

// deactivate
if (! function_exists('deactivate_mega_menu_addon')) {
    function deactivate_mega_menu_addon($StoreThemes, $shop, $checkaddon, $update_addon) {
        foreach ($StoreThemes as $theme) {

            // remove data schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_data.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_mega_menu_addon_curl($theme, $shop, $update_addon);
                continue;
            }
            else
            {
                $schemas = $schema_get['asset']['value'] ?? '';
            }

            $original_schemas = $schemas;

            if(str_contains($schemas,'header')){
                $json = json_decode($schemas, true);
                if(Arr::has($json, ['current.sections.header.blocks', 'current.sections.header.block_order'])) {
                    $json = Arr::except($json, ['current.sections.header.blocks', 'current.sections.header.block_order']);
                    $value = json_encode($json);
                    $updated_schema = $value;
                    //logger('updated_schema='.$updated_schema);
                    $update_schema_settings = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'config/settings_data.json', 'value' => $updated_schema] ]
                    );
                    logger( 'Updated_schema response 1 =' . json_encode($update_schema_settings) );
                    $schemas = $updated_schema;
                }
            }

            // remove section schema
            $schema = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'sections/header.liquid'] ]
            )['body']['asset']['value'] ?? '';

            $header_template_liquid = (string) ',"blocks" : [';
            $end_of_file = (string) ' } {% endschema %}';
            $strings = ' ' . $schema;
            $inis = strpos($strings, $header_template_liquid);

            if ($inis == 0) {
                $parseds = '';
            } else{
                $inis += strlen($header_template_liquid);
                $lens = strpos($strings, $end_of_file, $inis) - $inis;
                $parseds = substr($strings, $inis, $lens);
            }

            $valuess = $header_template_liquid.''.$parseds;

            if(str_contains($schema,'dbtfy_mega_menu_header')){
                $value = str_replace($valuess, " ", $schema);
                if($parseds ==''){
                   $value = explode($header_template_liquid,$schema,2);
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
                    ['asset' => ['key' => 'sections/header.liquid', 'value' => $new_template_liquid] ]
                );
            }

            // remove scss
            $theme_style_content = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
            )['body']['asset']['value'] ?? '';

            $trustbadge_Style = (string) '/* start-dbtfy-mega-menu */';
            $end = (string) '/* end-dbtfy-mega-menu */';
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

            if(str_contains($theme_style_content,'dbtfy-mega_menu')){
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
                ['asset' => ['key' => 'snippets/dbtfy-mega-menu.liquid'] ]
            );

            // remove include
            $header_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'sections/header.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($header_template,'dbtfy-mega-menu')){
                $str = '{%- if content_for_header contains "debutify" -%} {% include "dbtfy-mega-menu" %} {%- endif -%}';
                if( str_contains($header_template, $str  ) ){
                    $value  =  explode($str ,$header_template,2);
                }else{
                    $value  =  explode('{% include "dbtfy-mega-menu" %}',$header_template,2);
                }
//                $value  =  explode('{% include "dbtfy-mega-menu" %}',$header_template,2);

                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                }
                else{
                    $value = (string) $header_template;
                }

                $new_header_template = (string) $value;
                $update_header_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'sections/header.liquid', 'value' => $new_header_template] ]
                );
            }

            // remove js addon
            try{
               $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $trustbadge_js = (string) '/* start-dbtfy-mega-menu */';
                $end_js = (string) '/* end-dbtfy-mega-menu */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-mega-menu */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-mega-menu */')){
                        $trustbadge_js1 = (string) '/* start-register-mega-menu */';
                        $end_js = (string) '/* end-register-mega-menu */';
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
                logger('add mega_menu throws client exception');
            }
            catch(\Exception $e){
                logger('add mega_menu throws exception');
            }

            // special update to save data settings
            if($update_addon == 1){
              update_mega_menu_addon($StoreThemes,$shop, $original_schemas);
              logger("update setting data");
            }

        }
    }
}


if (! function_exists('deactivate_mega_menu_addon_curl')) {
  function deactivate_mega_menu_addon_curl($theme, $shop, $update_addon) {

    // remove data schema
    $schemas = getThemeFileCurl($shop, $theme, 'config/settings_data.json');

    $original_schemas = $schemas;

    if(str_contains($schemas,'header')){
        $json = json_decode($schemas, true);
        if(Arr::has($json, ['current.sections.header.blocks', 'current.sections.header.block_order'])) {
            $json = Arr::except($json, ['current.sections.header.blocks', 'current.sections.header.block_order']);
            $value = json_encode($json);
            $updated_schema = $value;
            logger('updated_schema='.$updated_schema);
            $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_data.json');
            $schemas = $updated_schema;
        }
    }

    // remove section schema
    $schema = getThemeFileCurl($shop, $theme, 'sections/header.liquid');

    $header_template_liquid = (string) ',"blocks" : [';
    $end_of_file = (string) ' } {% endschema %}';
    $strings = ' ' . $schema;
    $inis = strpos($strings, $header_template_liquid);

    if ($inis == 0) {
        $parseds = '';
    } else{
        $inis += strlen($header_template_liquid);
        $lens = strpos($strings, $end_of_file, $inis) - $inis;
        $parseds = substr($strings, $inis, $lens);
    }

    $valuess = $header_template_liquid.''.$parseds;

    if(str_contains($schema,'dbtfy_mega_menu_header')){
        $value = str_replace($valuess, " ", $schema);
        if($parseds ==''){
           $value = explode($header_template_liquid,$schema,2);
           if(isset($value[0])){
                $value = $value[0];
            } else{
                $value = (string) $schema;
            }
        }
        $new_template_liquid = (string) $value;
        $update_template_liquid = putThemeFileCurl($shop, $theme, $new_template_liquid, 'sections/header.liquid');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid');

    $trustbadge_Style = (string) '/* start-dbtfy-mega-menu */';
    $end = (string) '/* end-dbtfy-mega-menu */';
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

    if(str_contains($theme_style_content,'dbtfy-mega_menu')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove snippet
    $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-mega-menu.liquid');
    // remove include
    $header_template = getThemeFileCurl($shop, $theme, 'sections/header.liquid');

    if(str_contains($header_template,'dbtfy-mega-menu')){
        $str = '{%- if content_for_header contains "debutify" -%} {% include "dbtfy-mega-menu" %} {%- endif -%}';
        if( str_contains($header_template, $str  ) ){
            $value  =  explode($str ,$header_template,2);
        }else{
            $value  =  explode('{% include "dbtfy-mega-menu" %}',$header_template,2);
        }

        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        }
        else{
            $value = (string) $header_template;
        }

        $new_header_template = (string) $value;
        $update_header_template = putThemeFileCurl($shop, $theme, $new_header_template, 'sections/header.liquid');
    }

    // remove js addon
    try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid');
        if ($theme_js_content == null)
        {
            $theme_js_content = '';
        }
        $trustbadge_js = (string) '/* start-dbtfy-mega-menu */';
        $end_js = (string) '/* end-dbtfy-mega-menu */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-mega-menu */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-mega-menu */')){
                $trustbadge_js1 = (string) '/* start-register-mega-menu */';
                $end_js = (string) '/* end-register-mega-menu */';
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
        logger('add mega_menu throws client exception');
    }
    catch(\Exception $e){
        logger('add mega_menu throws exception');
    }
  }
}


// special update to save data settings
if (! function_exists('update_mega_menu_addon')) {
    function update_mega_menu_addon($StoreThemes, $shop, $original_schemas) {
        activate_mega_menu_addon($StoreThemes,$shop);
        foreach ($StoreThemes as $theme) {
            logger('updated_schema');
            $update_schema_settings = $shop->api()->request(
                'PUT',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_data.json', 'value' => $original_schemas] ]
            );
            logger( 'Updated_schema in loop =' . json_encode($update_schema_settings) );
            sleep(3);
        }
    }
}
?>
