<?php
use Illuminate\Support\Arr;
//activate
if (! function_exists('activate_newsletter_popup_addon')) {
    function activate_newsletter_popup_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            //add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '
{
  "name": "Newsletter pop-up",
  "settings": [
    {
      "type": "header",
      "content": "Activation"
    },
    {
      "type": "checkbox",
      "id": "dbtfy_newsletter_popup",
      "label": "Activate",
      "default": false,
      "info": "Edit your [Spam protection](\/admin\/online_store\/preferences) preferences to disable Google reCAPTCHA on contact forms."
    },
    {
      "type": "header",
      "content": "Floating bar Settings"
    },
    {
      "type": "checkbox",
      "id": "dbtfy_newsletter_floating_bar",
      "label": "Activate",
      "default": false
    },
    {
      "type": "checkbox",
      "id": "dbtfy_floating_bar_mobile",
      "label": "Hide on mobile",
      "default": false
    },
    {
      "type": "select",
      "id": "dbtfy_floating_bar_position",
      "label": "Position",
      "default": "right",
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
      "type": "text",
      "id": "dbtfy_floating_bar_text",
      "label": "Text",
      "default": "Get 20% off!"
    },
    {
      "type": "text",
      "id": "dbtfy_floating_bar_icon",
      "label": "Icon",
      "default": "caret-up",
      "info": "Enter the name of any free solid icons on [FontAwesome](https:\/\/fontawesome.com\/icons?d=gallery&s=solid&m=free)"
    },
    {
      "type": "header",
      "content": "Pop-up Settings"
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_width",
      "label": "Width",
      "default": "600"
    },
    {
      "type": "image_picker",
      "id": "dbtfy_newsletter_popup_image",
      "label": "Image"
    },
    {
      "type": "select",
      "id": "dbtfy_newsletter_popup_image_position",
      "label": "Image position",
      "default": "center center",
      "options": [
        {
          "label": "Top left",
          "value": "top left"
        },
        {
          "label": "Top center",
          "value": "top center"
        },
        {
          "label": "Top right",
          "value": "top right"
        },
        {
          "label": "Middle left",
          "value": "center left"
        },
        {
          "label": "Middle center",
          "value": "center center"
        },
        {
          "label": "Middle right",
          "value": "center right"
        },
        {
          "label": "Bottom left",
          "value": "bottom left"
        },
        {
          "label": "Bottom center",
          "value": "bottom center"
        },
        {
          "label": "Bottom right",
          "value": "bottom right"
        }
      ]
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_title",
      "label": "Title",
      "default": "Don\'t leave yet!"
    },
    {
      "type": "richtext",
      "id": "dbtfy_newsletter_popup_text",
      "label": "Text",
      "default": "<p>Get 10% OFF your first purchase when signing up to our awesome newsletter!<\/p>"
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_close",
      "label": "Close text",
      "default": "No thanks, I don\'t like coupons."
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_icon",
      "label": "Send icon",
      "default": "envelope",
      "info": "Enter the name of any free solid icons on [FontAwesome](https:\/\/fontawesome.com\/icons?d=gallery&s=solid&m=free)"
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_animation",
      "label": "Animation type",
      "default": "zoomIn",
      "info": "Enter the name of any animation from [animate.css](https:\/\/daneden.github.io\/animate.css\/)"
    },
    {
      "type": "header",
      "content": "Trigger Settings"
    },
    {
      "type": "checkbox",
      "id": "dbtfy_newsletter_popup_time_trigger",
      "label": "Enable time-based trigger",
      "default": false
    },
    {
      "type": "range",
      "id": "dbtfy_newsletter_popup_timeout",
      "label": "Trigger timeout (seconds)",
      "min": 5,
      "max": 60,
      "step": 1,
      "default": 15,
      "info": "Trigger will also happen when customer is about to leave your website. (exit-intent)"
    },
    {
      "type": "header",
      "content": "Success settings"
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_title_success",
      "label": "Title",
      "default": "Thank you!"
    },
    {
      "type": "richtext",
      "id": "dbtfy_newsletter_popup_text_success",
      "label": "Text",
      "default": "<p>Click the button below to automatically apply your 10% OFF coupon code at checkout!<\/p>"
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_apply",
      "label": "Apply button label",
      "default": "Apply Coupon Code"
    },
    {
      "type": "text",
      "id": "dbtfy_newsletter_popup_coupon",
      "label": "Coupon code",
      "info": "This coupon code will be automatically applied at checkout"
    }
  ]
}';

                if( ( $badgePos = strpos( $schema , 'dbtfy_newsletter_popup' ) ) === false ) {
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
                logger('update schema on Newsletter pop-up addon throws client exception');
            }
            catch(\Exception $e){
                logger('update schema on Newsletter pop-up addon throws exception');
            }

            // add snippet
            try{
                $snippet = (string) '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}
{%- if settings.dbtfy_newsletter_popup -%}
<div class="dbtfy dbtfy-newsletter_popup" 
      data-coupon="{{ settings.dbtfy_newsletter_popup_coupon }}"
      data-timeout="{{settings.dbtfy_newsletter_popup_timeout}}000"
      data-time-trigger="{{settings.dbtfy_newsletter_popup_time_trigger}}">
  
  <div id="NewsletterPopup" class="modal-newsletter_popup">
    <div class="modal-dialog-newsletter_popup" style="max-width:{{ settings.dbtfy_newsletter_popup_width }}px">
      <div class="modal-content modal-content-newsletter_popup animated {{ settings.dbtfy_newsletter_popup_animation }}">
  
        <div class="grid--full grid-uniform">
          {% assign width_newsletter_popup = "one-whole" %}

          {% if settings.dbtfy_newsletter_popup_image != blank %}
          {% assign width_newsletter_popup = "large--eight-twelfths" %}
          <div class="grid__item large--four-twelfths">
            <div class="image-newsletter_popup lazyload lazypreload"
                  data-bgset="{% include "bgset", image: settings.dbtfy_newsletter_popup_image %}"
                  data-sizes="auto"
                  data-parent-fit="cover"
                  style="background-position: {{ settings.dbtfy_newsletter_popup_image_position }}; background-image: url("{{ settings.dbtfy_newsletter_popup_image | img_url: \'300x300\' }}");">
            </div>
          </div>
          {% endif %}

          <div class="grid__item {{ width_newsletter_popup }}">
            <div class="content-newsletter_popup">

              {% form "customer", id:"formNewsletterPopup" %}
                {% if form.posted_successfully? %}
                <div class="np-success">
                  <div class="text-container-newsletter_popup rte">
                    {% if settings.dbtfy_newsletter_popup_title_success != blank %}
                    <h3>{{ settings.dbtfy_newsletter_popup_title_success }}</h3>
                    {% endif %}
                    {% if settings.dbtfy_newsletter_popup_text_success != blank %}
                    {{ settings.dbtfy_newsletter_popup_text_success }}
                    {% endif %}
                  </div>
                  {% if settings.dbtfy_newsletter_popup_apply != blank %}
                  <a id="ApplyCoupon" href="#" class="btn btn--primary">
                    <span class="btn__text">
                      {{ settings.dbtfy_newsletter_popup_apply }}
                    </span>
                  </a>
                  {% endif %}
                </div>
                {% else %}
                  <script src="{{ \'jquery.exitintent.min.js\' | asset_url }}" defer="defer"></script>
                  <div class="text-container-newsletter_popup rte">
                    {% if settings.dbtfy_newsletter_popup_title != blank %}
                    <h3>{{ settings.dbtfy_newsletter_popup_title }}</h3>
                    {% endif %}
                    {% if settings.dbtfy_newsletter_popup_text != blank %}
                    {{ settings.dbtfy_newsletter_popup_text }}
                    {% endif %}
                  </div>
                  {{ form.errors | default_errors }}
                  <input type="hidden" name="contact[tags]" value="newsletter">
                  <div class="newsletter--form">
                    <div class="input-group">
                      <input id="input-newsletter_popup" type="email" placeholder="{{ \'general.newsletter_form.newsletter_placeholder\' | t }}" name="contact[email]" class="input-group-field newsletter__input" required="required" autocorrect="off" autocapitalize="off">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn--primary newsletter__submit" name="commit" id="Subscribe">
                          <span class="btn__text">
                            <span class="fas fa-{{ settings.dbtfy_newsletter_popup_icon }}"></span>
                          </span>
                        </button>
                      </span>
                    </div>
                  </div>
                  {% if settings.dbtfy_newsletter_popup_close != blank %}
                  <button type="button" class="close-newsletter_popup text-link">
                    <small>{{ settings.dbtfy_newsletter_popup_close }}</small>
                  </button>
                  {% endif %}
                {% endif %}
              {% endform %}

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="overlay-newsletter_popup"></div>

  {% if settings.dbtfy_newsletter_floating_bar %}
  <div class="np-floating-bar btn btn--small np-position-{{ settings.dbtfy_floating_bar_position }} {% if settings.dbtfy_floating_bar_mobile %}small--hide{% endif %}">
    <span>{{ settings.dbtfy_floating_bar_text }}</span>
    <i class="fa fa-{{ settings.dbtfy_floating_bar_icon }}"></i>
  </div>
  {% endif %}

</div>
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

               $create_trustbadge_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-newsletter-popup.liquid', 'value' => $snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add newsletterPopup throws client exception');
            }
            catch(\Exception $e){
                logger('add newsletterPopup throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-newsletter-popup */{% if settings.dbtfy_newsletter_popup %}.dbtfy-newsletter_popup{.modal-newsletter_popup{padding:0 $gutter-sm;position:fixed;top:0;left:0;z-index:$zindexDrawer+($zindexIncrement*2);width:100%;height:100%;overflow:hidden;outline:0;display:none;&.open-newsletter_popup{display:block;overflow-x:hidden;overflow-y:auto;&+.overlay-newsletter_popup{pointer-events:auto;opacity:$colorDrawerOverlayOpacity}}}.modal-dialog-newsletter_popup{margin:$gutter auto;@include display-flexbox;@include align-items(center);min-height:calc(100% - #{$gutter*2});pointer-events:none}.modal-content-newsletter_popup{pointer-events:auto;background-color:$colorDrawer;border-radius:$borderRadius;overflow:hidden;color:$colorDrawerText;border-color:adaptive-color($colorDrawerDefault,$percentageColorBorder);.btn,textarea,input,select{@include button($colorDrawerDefault,$colorDrawerText);@include placeholder($colorDrawerText)}.btn--primary{@include button($colorDrawerPrimary,$colorDrawerButtonText)}.btn-outline-primary{@include button($colorDrawerPrimary,$colorDrawerButtonText,outline)}a,.text-link,h1,h2,h3,h4,h5,h6{color:$colorDrawerText}}.image-newsletter_popup{background-size:cover;background-repeat:no-repeat;background-position:center;height:100%;min-height:150px}.content-newsletter_popup{text-align:center;@include makeWrapper(100%);@include makeBox}.close-newsletter_popup{margin-top:$spacer}.bordered-newsletter_popup{border:$borders;border-color:$colorDrawer}.overlay-newsletter_popup{background-color:$colorDrawerOverlay;position:fixed;left:0;right:0;top:0;bottom:0;width:100%;height:100%;opacity:0;pointer-events:none;z-index:$zindexDrawer+$zindexIncrement;@include transition($transitionDrawers)}&.open-newsletter_popup{#NewsletterPopup{@include display-flexbox()}.overlay-newsletter_popup{pointer-events:auto;opacity:$colorDrawerOverlayOpacity}}.np-floating-bar{position:fixed;top:40vh;writing-mode:vertical-rl;text-orientation:sideways;cursor:pointer;z-index:$zindexOverBody;border-radius:0 $borderRadius $borderRadius 0;line-height:1;text-transform:uppercase;@include button($colorHeadings,$colorBody);@include screen($small){font-size:$baseFontSize-sm}&.np-position-left{left:0}&.np-position-right{right:0;@include transform(rotate(180deg))}i{margin-top:$spacer-xs}}}{% endif %}/* end-dbtfy-newsletter-popup */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-newsletter-popup' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);
                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on newsletter_popup addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on newsletter_popup addon throws exception');
            }

            // add include
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , 'dbtfy-newsletter-popup' ) ) === false ) {
                    if( ( $pos = strrpos( $product_template , '</body>' ) ) !== false ) {
                        $new_prod_template = str_replace('</body>', '{% include "dbtfy-newsletter-popup" %} </body>', $product_template);
                        $update_prod_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'layout/theme.liquid', 'value' => $new_prod_template] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update theme on newsletter_popup addon throws client exception');
            }
            catch(\Exception $e){
                logger('update theme on newsletter_popup addon throws exception');
            }

            // add asset
            try {
                $js = (string) '(function(a){function d(e){0<e.clientY||(b&&clearTimeout(b),0>=a.exitIntent.settings.sensitivity?a.event.trigger("exitintent"):b=setTimeout(function(){b=null;a.event.trigger("exitintent")},a.exitIntent.settings.sensitivity))}function c(){b&&(clearTimeout(b),b=null)}var b;a.exitIntent=function(b,f){a.exitIntent.settings=a.extend(a.exitIntent.settings,f);if("enable"==b)a(window).mouseleave(d),a(window).mouseenter(c);else if("disable"==b)c(),a(window).unbind("mouseleave",d),a(window).unbind("mouseenter",c);else throw"Invalid parameter to jQuery.exitIntent -- should be \'enable\'/\'disable\'";};a.exitIntent.settings={sensitivity:300}})(jQuery);';

                $uploadJs = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/jquery.exitintent.min.js', 'value' => $js] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add newsletterPopup throws client exception');
            }
            catch(\Exception $e){
                logger('add newsletterPopup throws exception');
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-newsletter-popup */function themeNewsletterPopup() { {% if settings.dbtfy_newsletter_popup %} var _0xc122=["\x2E\x64\x62\x74\x66\x79\x2D\x6E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x5F\x70\x6F\x70\x75\x70","\x63\x6F\x75\x70\x6F\x6E","\x64\x61\x74\x61","\x74\x69\x6D\x65\x6F\x75\x74","\x74\x69\x6D\x65\x2D\x74\x72\x69\x67\x67\x65\x72","\x2E\x6E\x70\x2D\x73\x75\x63\x63\x65\x73\x73","\x2E\x6E\x70\x2D\x66\x6C\x6F\x61\x74\x69\x6E\x67\x2D\x62\x61\x72","\x23\x41\x70\x70\x6C\x79\x43\x6F\x75\x70\x6F\x6E","\x2E\x63\x6C\x6F\x73\x65\x2D\x6E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x5F\x70\x6F\x70\x75\x70","\x6F\x72\x69\x67\x69\x6E","\x6C\x6F\x63\x61\x74\x69\x6F\x6E","\x2F\x64\x69\x73\x63\x6F\x75\x6E\x74\x2F","\x3F\x72\x65\x64\x69\x72\x65\x63\x74\x3D","\x70\x61\x74\x68\x6E\x61\x6D\x65","\x23\x4E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x50\x6F\x70\x75\x70","\x6E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x50\x6F\x70\x75\x70\x43\x6C\x6F\x73\x65\x64","\x6F\x70\x65\x6E\x2D\x6E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x5F\x70\x6F\x70\x75\x70","\x61\x64\x64\x43\x6C\x61\x73\x73","\x66\x6F\x63\x75\x73","\x2E\x64\x62\x74\x66\x79\x2D\x6E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x5F\x70\x6F\x70\x75\x70\x20\x2E\x6E\x65\x77\x73\x6C\x65\x74\x74\x65\x72\x5F\x5F\x69\x6E\x70\x75\x74","\x3A\x76\x69\x73\x69\x62\x6C\x65","\x69\x73","\x72\x65\x6D\x6F\x76\x65\x43\x6C\x61\x73\x73","\x74\x72\x75\x65","\x73\x65\x74\x49\x74\x65\x6D","\x63\x6C\x69\x63\x6B","\x2E\x6D\x6F\x64\x61\x6C\x2D\x63\x6F\x6E\x74\x65\x6E\x74","\x74\x61\x72\x67\x65\x74","\x6C\x65\x6E\x67\x74\x68","\x68\x61\x73","\x6D\x6F\x75\x73\x65\x75\x70","\x6B\x65\x79\x43\x6F\x64\x65","\x6B\x65\x79\x75\x70","\x3A\x66\x6F\x63\x75\x73","\x69\x66\x72\x61\x6D\x65","\x62\x6C\x75\x72","\x72\x65\x6D\x6F\x76\x65\x49\x74\x65\x6D","\x6F\x6E","\x68\x72\x65\x66","\x61\x74\x74\x72","\x65\x6E\x61\x62\x6C\x65","\x65\x78\x69\x74\x49\x6E\x74\x65\x6E\x74","\x65\x78\x69\x74\x69\x6E\x74\x65\x6E\x74","\x62\x69\x6E\x64","\x73\x68\x6F\x70\x69\x66\x79\x3A\x73\x65\x63\x74\x69\x6F\x6E\x3A\x6C\x6F\x61\x64","\x2F\x63\x68\x61\x6C\x6C\x65\x6E\x67\x65"];function NewsletterPopup(){var _0x83c2x2=$(_0xc122[0]),_0x83c2x3=_0x83c2x2[_0xc122[2]](_0xc122[1]),_0x83c2x4=_0x83c2x2[_0xc122[2]](_0xc122[3]),_0x83c2x5=_0x83c2x2[_0xc122[2]](_0xc122[4]),_0x83c2x6=$(_0xc122[5])[0],_0x83c2x7=$(_0xc122[6]),_0x83c2x8=$(_0xc122[7]),_0x83c2x9=$(_0xc122[8]),_0x83c2xa=window[_0xc122[10]][_0xc122[9]]+ _0xc122[11]+ _0x83c2x3+ _0xc122[12]+ window[_0xc122[10]][_0xc122[13]],_0x83c2xb=$(_0xc122[14]);function _0x83c2xc(){sessionStorage[_0xc122[15]]|| (_0x83c2xb[_0xc122[17]](_0xc122[16]),setTimeout(function(){$(_0xc122[19])[_0xc122[18]]()},500))}function _0x83c2xd(){_0x83c2xb[_0xc122[21]](_0xc122[20])&& (_0x83c2xb[_0xc122[22]](_0xc122[16]),sessionStorage[_0xc122[24]](_0xc122[15],_0xc122[23]))}_0x83c2x9[_0xc122[25]](function(){_0x83c2xd()}),$(document)[_0xc122[30]](function(_0x83c2x2){var _0x83c2x3=$(_0xc122[26]);_0x83c2x3[_0xc122[21]](_0x83c2x2[_0xc122[27]])|| 0!== _0x83c2x3[_0xc122[29]](_0x83c2x2[_0xc122[27]])[_0xc122[28]]|| _0x83c2xd()}),$(document)[_0xc122[32]](function(_0x83c2x2){27=== _0x83c2x2[_0xc122[31]]&& _0x83c2xd()}),$(window)[_0xc122[35]](function(_0x83c2x2){$(_0xc122[34])[_0xc122[21]](_0xc122[33])|| _0x83c2xc()}),_0x83c2x5&& setTimeout(function(){_0x83c2xc()},_0x83c2x4),_0x83c2x7[_0xc122[37]](_0xc122[25],function(){sessionStorage[_0xc122[36]](_0xc122[15]),_0x83c2xc()}),_0x83c2x6?(_0x83c2x8[_0xc122[39]](_0xc122[38],_0x83c2xa),_0x83c2xb[_0xc122[17]](_0xc122[16]),_0x83c2x8[_0xc122[37]](_0xc122[25],function(){sessionStorage[_0xc122[24]](_0xc122[15],_0xc122[23])})):($[_0xc122[41]](_0xc122[40]),$(document)[_0xc122[43]](_0xc122[42],function(){_0x83c2xc()}))}$(document)[_0xc122[37]](_0xc122[44],function(){sessionStorage[_0xc122[36]](_0xc122[15])}),_0xc122[45]!= window[_0xc122[10]][_0xc122[13]]&& NewsletterPopup() {% endif %} };/* end-dbtfy-newsletter-popup */';

                // add js register
                $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-newsletter-popup */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-newsletter-popup */themeNewsletterPopup();/* end-register-newsletter-popup */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-newsletter-popup */' ) ) === false ) {
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
if (! function_exists('deactivate_newsletter_popup_addon')) {
    function deactivate_newsletter_popup_addon($StoreThemes, $shop, $checkaddon) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_newsletter_popup_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
                if (stripos($obj['name'], 'Newsletter pop-up') !== false) {
                    return false;
                }
                return true;
            });

            if(str_contains($schema,'Newsletter pop-up')){
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

            $trustbadge_Style = (string) '/* start-dbtfy-newsletter-popup */';
            $end = (string) '/* end-dbtfy-newsletter-popup */';
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

            if(str_contains($theme_style_content,'dbtfy-newsletter_popup')){
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
              ['asset' => ['key' => 'snippets/dbtfy-newsletter-popup.liquid'] ]
            );

            // remove asset
            $delete_asset = $shop->api()->request(
                'DELETE',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'assets/jquery.exitintent.min.js'] ]
            );

            // remove include
            $theme_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'layout/theme.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($theme_template,'dbtfy-newsletter-popup')){
                $value  =  explode('{% include "dbtfy-newsletter-popup" %}',$theme_template,2);
                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                }
                else{
                    $value = (string) $theme_template;
                }
                $new_theme_template = (string) $value;
                $update_theme_template = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid', 'value' => $new_theme_template] ]
                );
            }

            // remove js addon
            try{
               $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                $trustbadge_js = (string) '/* start-dbtfy-newsletter-popup */';
                $end_js = (string) '/* end-dbtfy-newsletter-popup */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-newsletter-popup */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-newsletter-popup */')){
                        $trustbadge_js1 = (string) '/* start-register-newsletter-popup */';
                        $end_js = (string) '/* end-register-newsletter-popup */';
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
                logger('add newsletter_popup throws client exception');
            }
            catch(\Exception $e){
                logger('add newsletter_popup throws exception');
            }

        }
    }
}


if (! function_exists('deactivate_newsletter_popup_addon_curl')) {
  function deactivate_newsletter_popup_addon_curl($theme, $shop) {

    // remove schema
    $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json');

    $json = json_decode($schema, true);
    $json = array_filter($json, function ($obj) {
        if (stripos($obj['name'], 'Newsletter pop-up') !== false) {
            return false;
        }
        return true;
    });

    if(str_contains($schema,'Newsletter pop-up')){
        $value = json_encode(array_values($json));
        $updated_schema = $value;

        $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid');

    $trustbadge_Style = (string) '/* start-dbtfy-newsletter-popup */';
    $end = (string) '/* end-dbtfy-newsletter-popup */';
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

    if(str_contains($theme_style_content,'dbtfy-newsletter_popup')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove snippet
    $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-newsletter-popup.liquid');

    // remove asset
    $delete_asset = deleteThemeFilesCurl($shop, $theme, 'assets/jquery.exitintent.min.js');

    // remove include
    $theme_template = getThemeFileCurl($shop, $theme, 'layout/theme.liquid') ?? '';

    if(str_contains($theme_template,'dbtfy-newsletter-popup')){
        $value  =  explode('{% include "dbtfy-newsletter-popup" %}',$theme_template,2);
        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        }
        else{
            $value = (string) $theme_template;
        }
        $new_theme_template = (string) $value;
        $update_theme_template = putThemeFileCurl($shop, $theme, $new_theme_template, 'layout/theme.liquid');
    }

    // remove js addon
    try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

        $trustbadge_js = (string) '/* start-dbtfy-newsletter-popup */';
        $end_js = (string) '/* end-dbtfy-newsletter-popup */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-newsletter-popup */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-newsletter-popup */')){
                $trustbadge_js1 = (string) '/* start-register-newsletter-popup */';
                $end_js = (string) '/* end-register-newsletter-popup */';
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
        logger('add newsletter_popup throws client exception');
    }
    catch(\Exception $e){
        logger('add newsletter_popup throws exception');
    }
  }
}
?>
