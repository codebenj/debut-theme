<?php
//activate
if (! function_exists('activate_chatbox_addon')) {
    function activate_chatbox_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '{
                  "name": "Chat box",
                  "settings": [
                    {
                      "type": "header",
                      "content": "Activation"
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_chat_box",
                      "label": "Activate",
                      "default": false
                    },
                    {
                      "type": "header",
                      "content": "Settings"
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_chat_box_mobile",
                      "label": "Hide on mobile",
                      "default": false
                    },
                    {
                      "type": "checkbox",
                      "id": "dbtfy_chat_box_new",
                      "label": "Open on a new tab",
                      "default": true
                    },
                    {
                      "type": "image_picker",
                      "id": "dbtfy_chat_box_image",
                      "label": "Image"
                    },
                    {
                      "type": "url",
                      "id": "dbtfy_chat_box_link",
                      "label": "Link"
                    },
                    {
                      "type": "select",
                      "id": "dbtfy_chat_box_position",
                      "label": "Position",
                      "default": "left",
                      "options": [
                        {
                          "value": "left",
                          "label": "Left"
                        },
                        {
                          "value": "right",
                          "label": "Right"
                        }
                      ]
                    },
                    {
                      "type": "select",
                      "id": "dbtfy_chat_box_animation",
                      "label": "Animation type",
                      "default": "bounceInLeft",
                      "options": [
                        {
                          "value": "",
                          "label": "None"
                        },
                        {
                          "value": "bounce",
                          "label": "Bounce"
                        },
                        {
                          "value": "bounceIn",
                          "label": "Bounce in"
                        },
                        {
                          "value": "bounceInDown",
                          "label": "Bounce in down"
                        },
                        {
                          "value": "bounceInLeft",
                          "label": "Bounce in left"
                        },
                        {
                          "value": "bounceInRight",
                          "label": "Bounce in right"
                        },
                        {
                          "value": "bounceInUp",
                          "label": "Bounce in up"
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
                      "type": "range",
                      "id": "dbtfy_chat_box_height",
                      "label": "Height",
                      "min": 40,
                      "max": 80,
                      "step": 1,
                      "unit": "px",
                      "default": 59
                    }
                  ]
                }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_chat_box' ) ) === false ) {
                    if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                        $updated_schema = substr_replace( $schema , ",".$liveview_addon_schema."]" , $pos );

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
{%- if settings.dbtfy_chat_box -%}
<div class="dbtfy dbtfy-chat_box">
  {% assign chat_box_height = settings.dbtfy_chat_box_height | prepend: "x" %}
  <div id="ChatBox" class="chat_box-{{ settings.dbtfy_chat_box_position }} {% if settings.dbtfy_chat_box_mobile %}small--hide{% endif %} animated {{ settings.dbtfy_chat_box_animation}}">
    <a href="{{ settings.dbtfy_chat_box_link }}" {% if settings.dbtfy_chat_box_new %}target="_blank"{% endif %} class="image-link">
      <img class="image-chat_box" src="{{ settings.dbtfy_chat_box_image | img_url: chat_box_height }}"
           srcset="{{ settings.dbtfy_chat_box_image | img_url: chat_box_height }} 1x, {{ settings.dbtfy_chat_box_image | img_url: chat_box_height, scale: 2 }} 2x">
    </a>
  </div>
</div>
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

               $create_trustbadge_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-chat-box.liquid', 'value' => $snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add sales_pop throws client exception');
            }
            catch(\Exception $e){
                logger('add sales_pop throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-chat-box */{% if settings.dbtfy_chat_box %}.dbtfy-chat_box{#ChatBox{position:fixed;z-index:($zindexOverBody - 1);bottom:$gutter;@include transition($transitions);&.chat_box-right{right:$gutter}&.chat_box-left{left:$gutter}@include screen($small){bottom:$gutter-sm;&.chat_box-right{right:$gutter-sm}&.chat_box-left{left:$gutter-sm}}.template-product.scroll-sticky_addtocart &{bottom:$gutter+$heightInput+$gutter-sm;@include screen($small){bottom:$gutter-sm+$heightInputSmall+$gutter-sm}}}.image-link{line-height:0}}{% endif %}/* end-dbtfy-chat-box */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-chat-box' ) ) === false ) {
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

                if( ( $pos = strpos( $product_template , 'dbtfy-chat-box' ) ) === false ) {
                    if( ( $pos = strrpos( $product_template , '</body>' ) ) !== false ) {
                        $new_prod_template = str_replace('</body>', '{% include "dbtfy-chat-box" %} </body>', $product_template);
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
        }
    }
}

// deactivate
if (! function_exists('deactivate_chatbox_addon')) {
    function deactivate_chatbox_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_chatbox_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'];
            }

            if(str_contains($schema,'Chat box')){
                $json = json_decode($schema, true);
                $json = array_filter($json, function ($obj) {
                  if (stripos($obj['name'], 'Chat box') !== false) {
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

            //old style
            $styles = (string) '/*================ _Chat_box ================*/ .dbtfy-chat_box{ #ChatBox{position:fixed;z-index: ($zindexOverBody - 1); bottom:$gutter;&.chat_box-right{right:$gutter;}&.chat_box-left{left:$gutter;}@include screen($small){bottom:$gutter-sm;&.chat_box-right{right:$gutter-sm;}&.chat_box-left{left:$gutter-sm;}}}.image-link{line-height: 0; }}';
            $trustbadge_Style2 = (string) '/*================ _Chat_box ================*/';
            $end2 = (string) '.image-link{line-height: 0; }}';
            $string2 = ' ' . $theme_style_content;
            $ini2 = strpos($string2, $trustbadge_Style2);
            if ($ini2 == 0) {
              $parsed2 = '';
            }else{
              $ini2 += strlen($trustbadge_Style2);
              $len2 = strpos($string2, $end2, $ini2) - $ini2;
              $parsed2 = substr($string2, $ini2, $len2);
            }

            //old style
            $trustbadge_Style3 = (string) '/*================ start-dbtfy-Chat_box ================*/';
            $end3 = (string) '/*================ end-dbtfy-Chat_box ================*/';
            $string3 = ' ' . $theme_style_content;
            $ini3 = strpos($string3, $trustbadge_Style3);
            if ($ini3 == 0) {
              $parsed3 = '';
            }else{
              $ini3 += strlen($trustbadge_Style3);
              $len3 = strpos($string3, $end3, $ini3) - $ini3;
              $parsed3 = substr($string3, $ini3, $len3);
            }

            //new style
            $trustbadge_Style = (string) '/* start-dbtfy-chat-box */';
            $end = (string) '/* end-dbtfy-chat-box */';
            $string = ' ' . $theme_style_content;
            $ini = strpos($string, $trustbadge_Style);
            if ($ini == 0) {
              $parsed = '';
            }else{
              $ini += strlen($trustbadge_Style);
              $len = strpos($string, $end, $ini) - $ini;
              $parsed = substr($string, $ini, $len);
            }

            //result
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

            if(str_contains($theme_style_content,'dbtfy-chat_box')){
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
                ['asset' => ['key' => 'snippets/dbtfy-chat-box.liquid'] ]
            );

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'layout/theme.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,"dbtfy-chat-box")){
                $value  =  explode('{% include "dbtfy-chat-box" %}',$product_template,2);

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
                    ['asset' => ['key' => 'layout/theme.liquid', 'value' => $new_prod_template] ]
                );
            }
        }
    }
}


if (! function_exists('deactivate_chatbox_addon_curl')) {
  function deactivate_chatbox_addon_curl($theme, $shop) {


    // remove schema
    $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json');

    if(str_contains($schema,'Chat box')){
        $json = json_decode($schema, true);
        $json = array_filter($json, function ($obj) {
          if (stripos($obj['name'], 'Chat box') !== false) {
              return false;
          }
          return true;
        });
        $value = json_encode(array_values($json));
        $updated_schema = $value;
        $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid');

    //old style
    $styles = (string) '/*================ _Chat_box ================*/ .dbtfy-chat_box{ #ChatBox{position:fixed;z-index: ($zindexOverBody - 1); bottom:$gutter;&.chat_box-right{right:$gutter;}&.chat_box-left{left:$gutter;}@include screen($small){bottom:$gutter-sm;&.chat_box-right{right:$gutter-sm;}&.chat_box-left{left:$gutter-sm;}}}.image-link{line-height: 0; }}';
    $trustbadge_Style2 = (string) '/*================ _Chat_box ================*/';
    $end2 = (string) '.image-link{line-height: 0; }}';
    $string2 = ' ' . $theme_style_content;
    $ini2 = strpos($string2, $trustbadge_Style2);
    if ($ini2 == 0) {
      $parsed2 = '';
    }else{
      $ini2 += strlen($trustbadge_Style2);
      $len2 = strpos($string2, $end2, $ini2) - $ini2;
      $parsed2 = substr($string2, $ini2, $len2);
    }

    //old style
    $trustbadge_Style3 = (string) '/*================ start-dbtfy-Chat_box ================*/';
    $end3 = (string) '/*================ end-dbtfy-Chat_box ================*/';
    $string3 = ' ' . $theme_style_content;
    $ini3 = strpos($string3, $trustbadge_Style3);
    if ($ini3 == 0) {
      $parsed3 = '';
    }else{
      $ini3 += strlen($trustbadge_Style3);
      $len3 = strpos($string3, $end3, $ini3) - $ini3;
      $parsed3 = substr($string3, $ini3, $len3);
    }

    //new style
    $trustbadge_Style = (string) '/* start-dbtfy-chat-box */';
    $end = (string) '/* end-dbtfy-chat-box */';
    $string = ' ' . $theme_style_content;
    $ini = strpos($string, $trustbadge_Style);
    if ($ini == 0) {
      $parsed = '';
    }else{
      $ini += strlen($trustbadge_Style);
      $len = strpos($string, $end, $ini) - $ini;
      $parsed = substr($string, $ini, $len);
    }

    //result
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

    if(str_contains($theme_style_content,'dbtfy-chat_box')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

   // remove snippet
   $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-chat-box.liquid');

    // remove include
    $product_template = getThemeFileCurl($shop, $theme, 'layout/theme.liquid');

    if(str_contains($product_template,"dbtfy-chat-box")){
        $value  =  explode('{% include "dbtfy-chat-box" %}',$product_template,2);

        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        }
        else{
            $value = (string) $product_template;
        }

        $new_prod_template = (string) $value;

        $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'layout/theme.liquid');
    }

  }
}
?>
