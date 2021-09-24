<?php
//activate
if (! function_exists('activate_instagramfeed_addon')) {
    function activate_instagramfeed_addon($StoreThemes, $shop) {
      	foreach ($StoreThemes as $theme) {

            // add schema
            try{
                $schema = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'config/settings_schema.json'] ]
                )['body']['asset']['value'] ?? '';

                $liveview_addon_schema = (string) '{
    "name": "Instagram feed",
    "settings": [
      {
        "type": "header",
        "content": "Activation"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_feed",
        "label": "Activate",
        "default": false
      },
      {
        "type": "header",
        "content": "Settings"
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_feed_full_width",
        "label": "Full width",
        "default": false
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_hide_home",
        "label": "Hide on Homepage",
        "default": false
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_feed_icon",
        "label": "Show instagram icon",
        "default": true
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_feed_like",
        "label": "Show likes",
        "default": true
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_feed_comment",
        "label": "Show comments",
        "default": true
      },
      {
        "type": "checkbox",
        "id": "dbtfy_instagram_feed_caption",
        "label": "Show caption",
        "default": true
      },
      {
        "type": "text",
        "id": "dbtfy_instagram_feed_access_token",
        "label": "Access Token",
        "info": "[Where do I find Access Token?](http:\/\/instagram.pixelunion.net\/)"
      },
      {
        "type": "text",
        "id": "dbtfy_instagram_feed_title",
        "label": "Heading"
      },
      {
        "type": "text",
        "id": "dbtfy_instagram_feed_subtitle",
        "label": "Subheading"
      },
      {
        "type": "select",
        "id": "dbtfy_instagram_feed_section_style",
        "label": "Section style",
        "default": "border-section",
        "options": [
          {
            "value": "default-section",
            "label": "Default"
          },
          {
            "value": "bg-section",
            "label": "Add background color"
          },
          {
            "value": "border-section",
            "label": "Add border top"
          }
        ]
      },
      {
        "type": "select",
        "id": "dbtfy_instagram_feed_sort",
        "label": "Sort image by",
        "default": "none",
        "options": [
          {
            "value": "none",
            "label": "Default"
          },
          {
            "value": "most-liked",
            "label": "Most liked"
          },
          {
            "value": "most-commented",
            "label": "Most commented"
          },
          {
            "value": "random",
            "label": "Random"
          }
        ]
      },
      {
        "type": "select",
        "id": "dbtfy_instagram_feed_resolution",
        "label": "Resolution of images",
        "default": "low_resolution",
        "info": "Set to thumbnail for square images",
        "options": [
          {
            "value": "thumbnail",
            "label": "Thumbnail"
          },
          {
            "value": "low_resolution",
            "label": "Low Resolution"
          },
          {
            "value": "standard_resolution",
            "label": "Standard Resolution"
          }
        ]
      },
      {
        "type": "select",
        "id": "dbtfy_instagram_feed_rows",
        "label": "Number of rows",
        "default": "1",
        "options": [
          {
            "value": "1",
            "label": "1"
          },
          {
            "value": "2",
            "label": "2"
          }
        ]
      },
      {
        "type": "select",
        "id": "dbtfy_instagram_feed_desktop_grid",
        "label": "Image per row (desktop)",
        "default": "6",
        "options": [
          {
            "value": "3",
            "label": "3"
          },
          {
            "value": "4",
            "label": "4"
          },
          {
            "value": "6",
            "label": "6"
          },
          {
            "value": "8",
            "label": "8"
          },
          {
            "value": "10",
            "label": "10"
          }
        ]
      },
      {
        "type": "select",
        "id": "dbtfy_instagram_feed_mobile_grid",
        "label": "Image per row (mobile)",
        "default": "3",
        "options": [
          {
            "value": "1",
            "label": "1"
          },
          {
            "value": "2",
            "label": "2"
          },
          {
            "value": "3",
            "label": "3"
          },
          {
            "value": "4",
            "label": "4"
          }
        ]
      }
    ]
  }';

                if( ( $badgePos = strpos( $schema , 'dbtfy_instagram_feed' ) ) === false ) {
                    if( ( $pos = strrpos( $schema , ']' ) ) !== false ) {
                        $updated_schema  = substr_replace( $schema , ",".$liveview_addon_schema."]" , $pos );

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
{%- if settings.dbtfy_instagram_feed -%}
{%- unless template ==  "index" and settings.dbtfy_instagram_hide_home -%}
{%- assign limit = settings.dbtfy_instagram_feed_desktop_grid | times: settings.dbtfy_instagram_feed_rows -%}
{% case settings.dbtfy_instagram_feed_mobile_grid %}
{% when "1" %}
{% assign width_mobile = "small--one-whole" %}
{% when "2" %}
{% assign width_mobile = "small--six-twelfths" %}
{% when "3" %}
{% assign width_mobile = "small--four-twelfths" %}
{% when "4" %}
{% assign width_mobile = "small--three-twelfths" %}
{% endcase %}
{% case settings.dbtfy_instagram_feed_desktop_grid %}
{% when "3" %}
{% assign grid_item_width = "large--four-twelfths medium--four-twelfths " | append: width_mobile %}
{% when "4" %}
{% assign grid_item_width = "large--three-twelfths medium--three-twelfths " | append: width_mobile %}
{% when "6" %}
{% assign grid_item_width = "large--two-twelfths medium--four-twelfths " | append: width_mobile %}
{% when "8" %}
{% assign grid_item_width = "large--one-eighth medium--three-twelfths " | append: width_mobile %}
{% when "10" %}
{% assign grid_item_width = "large--one-tenth medium--one-fifth " | append: width_mobile %}
{% endcase %}
<div class="dbtfy dbtfy-instagram_feed {{ settings.dbtfy_instagram_feed_section_style }}">
  <style>
    {% if settings.dbtfy_instagram_feed_full_width %}
    .dbtfy-instagram_feed .box{
      {% if settings.button_label == blank %}
      padding-bottom: 0px;
      {% endif %}

      {% if settings.dbtfy_instagram_feed_title == blank and settings.dbtfy_instagram_feed_subtitle == blank and settings.dbtfy_instagram_feed_icon == false %}
      padding-top: 0px;
      {% endif %}
    }
    {% endif %}
  </style>
  <script src="{{ \'instafeed.min.js\' | asset_url }}" defer="defer"></script>
  <div class="box">
    {% unless settings.dbtfy_instagram_feed_title == blank and settings.dbtfy_instagram_feed_subtitle == blank and settings.dbtfy_instagram_feed_icon == false %}
    <div class="wrapper">
      <div class="grid">
        <div class="grid__item large--eight-twelfths push--large--two-twelfths">
          <div class="section-header">
            {% if settings.dbtfy_instagram_feed_icon %}
            <a href="{{ settings.social_instagram_link }}" target="_blank" class="icon-link-instagram_feed">
              <span class="fab fab fa-instagram fa-2x"></span>
            </a>
            {% endif %}
            {% unless settings.dbtfy_instagram_feed_title == blank %}
            <h2 class="section-header__title">{{ settings.dbtfy_instagram_feed_title | escape }}</h2>
            {% endunless %}
            {% unless settings.dbtfy_instagram_feed_subtitle == blank %}
            <p class="section-header__subtitle">{{ settings.dbtfy_instagram_feed_subtitle | escape }}</p>
            {% endunless %}
          </div>
        </div>
      </div>
    </div>
    {% endunless %}
    <div class="{% if settings.dbtfy_instagram_feed_full_width %}wrapper--full {% else %}wrapper {% endif %}">
      {% if settings.dbtfy_instagram_feed_access_token != blank %}
      <div id="instafeed" class="grid-instagram_feed {% if settings.dbtfy_instagram_feed_full_width %}grid--full {% else %}grid grid--spacer {% endif %} grid-uniform" data-instagram-feed data-accessToken="{{ settings.dbtfy_instagram_feed_access_token }}" data-limit="{{ limit }}" data-sort-images="{{ settings.dbtfy_instagram_feed_sort }}" data-resolution-images="{{ settings.dbtfy_instagram_feed_resolution }}" data-grid-item="{{grid_item_width}}"></div>
      {% else %}
      <div class="grid-instagram_feed {% if settings.dbtfy_instagram_feed_full_width %}grid--full {% else %}grid grid--spacer {% endif %}">
        {% for i in (1..limit) %}
        <div class="grid__item {{ grid_item_width }}">
          {% capture current %}{% cycle 1, 2, 3, 4, 5, 6 %}{% endcapture %}
          {{ "collection-" | append: current | placeholder_svg_tag: "placeholder-svg" }}
        </div>
        {% endfor %}
        <style>
          .grid-instagram_feed > .grid__item{
            line-height: 0;
          }
        </style>
      </div>
      {% endif %}
    </div>
  </div>
</div>
{%- endunless -%}
{%- endif -%}';

                $snippet = addScriptTagCondition($shop, '{%- comment -%}Please do not edit this file. Any modification can be lost as it is automatically updated by Debutify{%- endcomment -%}', $snippet);

                $create_trustbadge_snippet = $shop->api()->request(
                    'PUT',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'snippets/dbtfy-instagram-feed.liquid', 'value' => $snippet] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('add instagram_feed throws client exception');
            }
            catch(\Exception $e){
                logger('add instagram_feed throws exception');
            }

            // add asset
            try{
                 $instaaset = (string) '// Generated by CoffeeScript 1.9.3
(function(){var e;e=function(){function e(e,t){var n,r;this.options={target:"instafeed",get:"popular",resolution:"thumbnail",sortBy:"none",links:!0,mock:!1,useHttp:!1};if(typeof e=="object")for(n in e)r=e[n],this.options[n]=r;this.context=t!=null?t:this,this.unique=this._genKey()}return e.prototype.hasNext=function(){return typeof this.context.nextUrl=="string"&&this.context.nextUrl.length>0},e.prototype.next=function(){return this.hasNext()?this.run(this.context.nextUrl):!1},e.prototype.run=function(t){var n,r,i;if(typeof this.options.clientId!="string"&&typeof this.options.accessToken!="string")throw new Error("Missing clientId or accessToken.");if(typeof this.options.accessToken!="string"&&typeof this.options.clientId!="string")throw new Error("Missing clientId or accessToken.");return this.options.before!=null&&typeof this.options.before=="function"&&this.options.before.call(this),typeof document!="undefined"&&document!==null&&(i=document.createElement("script"),i.id="instafeed-fetcher",i.src=t||this._buildUrl(),n=document.getElementsByTagName("head"),n[0].appendChild(i),r="instafeedCache"+this.unique,window[r]=new e(this.options,this),window[r].unique=this.unique),!0},e.prototype.parse=function(e){var t,n,r,i,s,o,u,a,f,l,c,h,p,d,v,m,g,y,b,w,E,S,x,T,N,C,k,L,A,O,M,_,D;if(typeof e!="object"){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"Invalid JSON data"),!1;throw new Error("Invalid JSON response")}if(e.meta.code!==200){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,e.meta.error_message),!1;throw new Error("Error from Instagram: "+e.meta.error_message)}if(e.data.length===0){if(this.options.error!=null&&typeof this.options.error=="function")return this.options.error.call(this,"No images were returned from Instagram"),!1;throw new Error("No images were returned from Instagram")}this.options.success!=null&&typeof this.options.success=="function"&&this.options.success.call(this,e),this.context.nextUrl="",e.pagination!=null&&(this.context.nextUrl=e.pagination.next_url);if(this.options.sortBy!=="none"){this.options.sortBy==="random"?M=["","random"]:M=this.options.sortBy.split("-"),O=M[0]==="least"?!0:!1;switch(M[1]){case"random":e.data.sort(function(){return.5-Math.random()});break;case"recent":e.data=this._sortBy(e.data,"created_time",O);break;case"liked":e.data=this._sortBy(e.data,"likes.count",O);break;case"commented":e.data=this._sortBy(e.data,"comments.count",O);break;default:throw new Error("Invalid option for sortBy: \'"+this.options.sortBy+"\'.")}}if(typeof document!="undefined"&&document!==null&&this.options.mock===!1){m=e.data,A=parseInt(this.options.limit,10),this.options.limit!=null&&m.length>A&&(m=m.slice(0,A)),u=document.createDocumentFragment(),this.options.filter!=null&&typeof this.options.filter=="function"&&(m=this._filter(m,this.options.filter));if(this.options.template!=null&&typeof this.options.template=="string"){f="",d="",w="",D=document.createElement("div");for(c=0,N=m.length;c<N;c++){h=m[c],p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);E=p.width,y=p.height,b="square",E>y&&(b="landscape"),E<y&&(b="portrait"),v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),d=this._makeTemplate(this.options.template,{model:h,id:h.id,link:h.link,type:h.type,image:v,width:E,height:y,orientation:b,caption:this._getObjectProperty(h,"caption.text"),likes:h.likes.count,comments:h.comments.count,location:this._getObjectProperty(h,"location.name")}),f+=d}D.innerHTML=f,i=[],r=0,n=D.childNodes.length;while(r<n)i.push(D.childNodes[r]),r+=1;for(x=0,C=i.length;x<C;x++)L=i[x],u.appendChild(L)}else for(T=0,k=m.length;T<k;T++){h=m[T],g=document.createElement("img"),p=h.images[this.options.resolution];if(typeof p!="object")throw o="No image found for resolution: "+this.options.resolution+".",new Error(o);v=p.url,l=window.location.protocol.indexOf("http")>=0,l&&!this.options.useHttp&&(v=v.replace(/https?:\/\//,"//")),g.src=v,this.options.links===!0?(t=document.createElement("a"),t.href=h.link,t.appendChild(g),u.appendChild(t)):u.appendChild(g)}_=this.options.target,typeof _=="string"&&(_=document.getElementById(_));if(_==null)throw o=\'No element with id="\'+this.options.target+\'" on page.\',new Error(o);_.appendChild(u),a=document.getElementsByTagName("head")[0],a.removeChild(document.getElementById("instafeed-fetcher")),S="instafeedCache"+this.unique,window[S]=void 0;try{delete window[S]}catch(P){s=P}}return this.options.after!=null&&typeof this.options.after=="function"&&this.options.after.call(this),!0},e.prototype._buildUrl=function(){var e,t,n;e="https://api.instagram.com/v1";switch(this.options.get){case"popular":t="media/popular";break;case"tagged":if(!this.options.tagName)throw new Error("No tag name specified. Use the \'tagName\' option.");t="tags/"+this.options.tagName+"/media/recent";break;case"location":if(!this.options.locationId)throw new Error("No location specified. Use the \'locationId\' option.");t="locations/"+this.options.locationId+"/media/recent";break;case"user":if(!this.options.userId)throw new Error("No user specified. Use the \'userId\' option.");t="users/"+this.options.userId+"/media/recent";break;default:throw new Error("Invalid option for get: \'"+this.options.get+"\'.")}return n=e+"/"+t,this.options.accessToken!=null?n+="?access_token="+this.options.accessToken:n+="?client_id="+this.options.clientId,this.options.limit!=null&&(n+="&count="+this.options.limit),n+="&callback=instafeedCache"+this.unique+".parse",n},e.prototype._genKey=function(){var e;return e=function(){return((1+Math.random())*65536|0).toString(16).substring(1)},""+e()+e()+e()+e()},e.prototype._makeTemplate=function(e,t){var n,r,i,s,o;r=/(?:\{{2})([\w\[\]\.]+)(?:\}{2})/,n=e;while(r.test(n))s=n.match(r)[1],o=(i=this._getObjectProperty(t,s))!=null?i:"",n=n.replace(r,function(){return""+o});return n},e.prototype._getObjectProperty=function(e,t){var n,r;t=t.replace(/\[(\w+)\]/g,".$1"),r=t.split(".");while(r.length){n=r.shift();if(!(e!=null&&n in e))return null;e=e[n]}return e},e.prototype._sortBy=function(e,t,n){var r;return r=function(e,r){var i,s;return i=this._getObjectProperty(e,t),s=this._getObjectProperty(r,t),n?i>s?1:-1:i<s?1:-1},e.sort(r.bind(this)),e},e.prototype._filter=function(e,t){var n,r,i,s,o;n=[],r=function(e){if(t(e))return n.push(e)};for(i=0,o=e.length;i<o;i++)s=e[i],r(s);return n},e}(),function(e,t){return typeof define=="function"&&define.amd?define([],t):typeof module=="object"&&module.exports?module.exports=t():e.Instafeed=t()}(this,function(){return e})}).call(this);';

                $instaaset = addScriptTagCondition($shop, '// Generated by CoffeeScript 1.9.3', $instaaset);

               $create_instagram_feed = $shop->api()->request(
                  'PUT',
                  '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                  ['asset' => ['key' => 'assets/instafeed.min.js', 'value' => $instaaset] ]
                );
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on instagram_feed addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on instagram_feed addon throws exception');
            }

            // add scss
            try{
                $styles = (string) '/* start-dbtfy-instagram-feed */{% if settings.dbtfy_instagram_feed %}.dbtfy-instagram_feed{.content-wrapper-instagram_feed{padding:$gutter-sm/2;line-height:$baseLineHeight;height:100%;width:100%;position:absolute;color:$colorTranparentNavText;opacity:0;top:0;right:0;bottom:0;left:0;z-index:($zindexBase + 1);@include transition($transitions);@include display-flexbox();@include flex-wrap(wrap);@include screen($small){font-size:$baseFontSize-sm}}.caption-instagram_feed{width:100%;overflow:hidden;display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;@include align-self(flex-start);@include screen($small){-webkit-line-clamp:3}}.icon-wrapper-instagram_feed{text-align:right;width:100%;@include align-self(flex-end);.fa-instagram{font-size:20px}&>span{margin:0 $spacer-xs}}.center-icon-instagram_feed{@include align-self(center);text-align:center}.icon-link-instagram_feed{color:$colorSecondary}.grid--full{img,.link-instagram_feed{border-radius:0}}.item-instagram_feed{line-height:0}.link-instagram_feed{display:block;line-height:0;img{width:100%}}.grid--full .overlay:after{border-radius:0}.overlay{&:after{border-radius:$borderRadius;opacity:0;@include transition($transitions)}&:hover{opacity:1;z-index:($zindexBase + 1);&:after{opacity:$opacityOverlay}.content-wrapper-instagram_feed{opacity:1}}}}{% endif %}/* end-dbtfy-instagram-feed */';

                $theme_style_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/theme.scss.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_style_content , 'start-dbtfy-instagram-feed' ) ) === false ) {
                    $new_theme_styles = str_replace($theme_style_content, $theme_style_content.$styles, $theme_style_content);

                    $add_styles = $shop->api()->request(
                        'PUT',
                        '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                        ['asset' => ['key' => 'assets/theme.scss.liquid', 'value' => $new_theme_styles] ]
                    );
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update CSS on instagram_feed addon throws client exception');
            }
            catch(\Exception $e){
                logger('update CSS on instagram_feed addon throws exception');
            }

            // add include
            try{
                $product_template = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'layout/theme.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $product_template , 'dbtfy-instagram-feed' ) ) === false ) {
                    if( ( $pos = strrpos( $product_template , "{% section 'guarantee' %}" ) ) !== false ) {
                        $new_prod_template = str_replace("{% section 'guarantee' %}", "{% include 'dbtfy-instagram-feed' %} {% section 'guarantee' %}", $product_template);
                        $update_prod_template = $shop->api()->request(
                            'PUT',
                            '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                            ['asset' => ['key' => 'layout/theme.liquid', 'value' => $new_prod_template] ]
                        );
                    }
                }
            }
            catch(\GuzzleHttp\Exception\ClientException $e){
                logger('update instagram_feed on trustbadge addon throws client exception');
            }
            catch(\Exception $e){
                logger('update instagram_feed on trustbadge addon throws exception');
            }

            // add js addon
            try{
              $script= (string)'/* start-dbtfy-instagram-feed */function themeInstagramFeed() { {% if settings.dbtfy_instagram_feed %} function InstagramFeed() { var instagramBlock = $("[data-instagram-feed]"); instagramBlock.each(function() { var self = $(this), dataSortImages = self.data("sort-images"), dataResolutionImages = self.data("resolution-images"), dataLimit = self.data("limit"), gridItem = $("#instafeed").data("grid-item"), template = \'<div class="grid__item-instagram_feed grid__item \'+ gridItem +\'"><a href="{% raw %}{{link}}{% endraw %}" target="_blank" class="link-instagram_feed overlay"><div class="content-wrapper-instagram_feed">{% if settings.dbtfy_instagram_feed_caption %}<div class="caption-instagram_feed">{% raw %}{{caption}}{% endraw %}</div>{% endif %}<div class="icon-wrapper-instagram_feed {% unless settings.dbtfy_instagram_feed_caption %}center-icon-instagram_feed{% endunless %}">{% unless settings.dbtfy_instagram_feed_like or settings.dbtfy_instagram_feed_comment %}<span class="fab fa-instagram"></span>{% endunless %}{% if settings.dbtfy_instagram_feed_like %}<span class="fas fa-heart">{% raw %}{{likes}}{% endraw %}</span>{% endif %}{% if settings.dbtfy_instagram_feed_comment %}<span class="fas fa-comment">{% raw %}{{comments}}{% endraw %}</span>{% endif %}</div></div><img src="{% raw %}{{image}}{% endraw %}" /></a></div>\'; var userFeed = new Instafeed({ get: "user", {% if settings.dbtfy_instagram_feed_access_token != blank %} userId: {{settings.dbtfy_instagram_feed_access_token | split: "." | first}}, accessToken: "{{ settings.dbtfy_instagram_feed_access_token }}", {% endif %} sortBy: dataSortImages, resolution: dataResolutionImages, clientId: "c6e4c736e82345a3898a0e299daa00fb", limit: dataLimit, template: template }); userFeed.run(); }); } InstagramFeed(); {% endif %} }; /* end-dbtfy-instagram-feed */';

              // add js register
              $theme_js_content = $shop->api()->request(
                    'GET',
                    '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                    ['asset' => ['key' => 'assets/dbtfy-addons.js.liquid'] ]
                )['body']['asset']['value'] ?? '';

                if( ( $pos = strpos( $theme_js_content , "/* start-register-instagram-feed */" ) ) === false ) {
                        $new_theme_js = str_replace('var sections = new theme.Sections();', 'var sections = new theme.Sections();/* start-register-instagram-feed */themeInstagramFeed();/* end-register-instagram-feed */', $theme_js_content);

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
                if( ( $pos = strpos( $theme_js_content , '/* start-dbtfy-instagram-feed */' ) ) === false ) {
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

//deactivate
if (! function_exists('deactivate_instagramfeed_addon')) {
    function deactivate_instagramfeed_addon($StoreThemes, $shop, $checkaddon = false) {
        foreach ($StoreThemes as $theme) {

            // remove schema
            $schema_get = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'config/settings_schema.json'] ]
            )['body'];

            if(!isset($schema_get['asset']['value']))
            {
                deactivate_instagramfeed_addon_curl($theme, $shop);
                continue;
            }
            else
            {
                $schema = $schema_get['asset']['value'] ?? '';
            }

            $json = json_decode($schema, true);
            $json = array_filter($json, function ($obj) {
                if (stripos($obj['name'], 'Instagram feed') !== false) {
                    return false;
                }
                return true;
            });

            if(str_contains($schema,'Instagram feed')){
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
            $styles = (string) '/*================ _Instagram_feed ================*/ .dbtfy-instagram_feed {.icon-wrapper-instagram_feed{height:100%;width:100%;position: absolute;opacity:0;color:$colorTranparentNavText;top:0;right:0;bottom:0;left:0;z-index: ($zindexBase + 1);@include transition($transitions);@include display-flexbox();@include justify-content(center);@include align-items(center);.fa-instagram{font-size: 20px;}& > span{margin: 0 $spacer-xs; }}.icon-link-instagram_feed{color: $colorSecondary;}.grid--full img {border-radius: 0px;}.item-instagram_feed {line-height: 0;}.link-instagram_feed {display: block;line-height: 0;img {width: 100%;}}.grid--full .overlay:after{border-radius:0px; }.overlay{&:after{border-radius: $borderRadius;opacity:0;@include transition($transitions);}&:hover{opacity:1;z-index: ($zindexBase + 1); &:after{opacity:$opacityOverlay;} .icon-wrapper-instagram_feed{ opacity:1;}}}}';
            $trustbadge_Style2 = (string) '/*================ _Instagram_feed ================*/';
            $end2 = (string) 'img{width:100%;} } }';
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
            $trustbadge_Style3 = (string) '/*================ start-dbtfy-Instagram_feed ================*/';
            $end3 = (string) '/*================ end-dbtfy-Instagram_feed ================*/';
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
            $trustbadge_Style = (string) '/* start-dbtfy-instagram-feed */';
            $end = (string) '/* end-dbtfy-instagram-feed */';
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

            if(str_contains($theme_style_content,'dbtfy-instagram_feed')){
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
                ['asset' => ['key' => 'snippets/dbtfy-instagram-feed.liquid'] ]
            );

            // remove asset
            $delete_instafeed = $shop->api()->request(
                'DELETE',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'assets/instafeed.min.js'] ]
            );

            // remove include
            $product_template = $shop->api()->request(
                'GET',
                '/admin/api/themes/'.$theme->shopify_theme_id.'/assets.json',
                ['asset' => ['key' => 'layout/theme.liquid'] ]
            )['body']['asset']['value'] ?? '';

            if(str_contains($product_template,'dbtfy-instagram-feed')){
                $value  =  explode("{% include 'dbtfy-instagram-feed' %}",$product_template,2);
                if(isset($value[0]) && isset($value[1])){
                    $value = $value[0].' '.$value[1];
                }else{
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

                $trustbadge_js = (string) '/* start-dbtfy-instagram-feed */';
                $end_js = (string) '/* end-dbtfy-instagram-feed */';
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
                if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-instagram-feed */')){
                    $value = str_replace($value_js, " ", $theme_js_content);
                    $new_theme_js = (string) $value;
                    if(str_contains($new_theme_js,'/* start-register-instagram-feed */')){
                        $trustbadge_js1 = (string) '/* start-register-instagram-feed */';
                        $end_js = (string) '/* end-register-instagram-feed */';
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
                logger('add instagram_feed throws client exception');
            }
            catch(\Exception $e){
                logger('add instagram_feed throws exception');
            }
        }
    }
}


if (! function_exists('deactivate_instagramfeed_addon_curl')) {
  function deactivate_instagramfeed_addon_curl($theme, $shop, $checkaddon = false) {

    // remove schema
    $schema = getThemeFileCurl($shop, $theme, 'config/settings_schema.json') ?? '';

    $json = json_decode($schema, true);
    $json = array_filter($json, function ($obj) {
        if (stripos($obj['name'], 'Instagram feed') !== false) {
            return false;
        }
        return true;
    });

    if(str_contains($schema,'Instagram feed')){
        $value = json_encode(array_values($json));
        $updated_schema = $value;

        $update_schema_settings = putThemeFileCurl($shop, $theme, $updated_schema, 'config/settings_schema.json');
    }

    // remove scss
    $theme_style_content = getThemeFileCurl($shop, $theme, 'assets/theme.scss.liquid') ?? '';

    // old style
    $styles = (string) '/*================ _Instagram_feed ================*/ .dbtfy-instagram_feed {.icon-wrapper-instagram_feed{height:100%;width:100%;position: absolute;opacity:0;color:$colorTranparentNavText;top:0;right:0;bottom:0;left:0;z-index: ($zindexBase + 1);@include transition($transitions);@include display-flexbox();@include justify-content(center);@include align-items(center);.fa-instagram{font-size: 20px;}& > span{margin: 0 $spacer-xs; }}.icon-link-instagram_feed{color: $colorSecondary;}.grid--full img {border-radius: 0px;}.item-instagram_feed {line-height: 0;}.link-instagram_feed {display: block;line-height: 0;img {width: 100%;}}.grid--full .overlay:after{border-radius:0px; }.overlay{&:after{border-radius: $borderRadius;opacity:0;@include transition($transitions);}&:hover{opacity:1;z-index: ($zindexBase + 1); &:after{opacity:$opacityOverlay;} .icon-wrapper-instagram_feed{ opacity:1;}}}}';
    $trustbadge_Style2 = (string) '/*================ _Instagram_feed ================*/';
    $end2 = (string) 'img{width:100%;} } }';
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
    $trustbadge_Style3 = (string) '/*================ start-dbtfy-Instagram_feed ================*/';
    $end3 = (string) '/*================ end-dbtfy-Instagram_feed ================*/';
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
    $trustbadge_Style = (string) '/* start-dbtfy-instagram-feed */';
    $end = (string) '/* end-dbtfy-instagram-feed */';
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

    if(str_contains($theme_style_content,'dbtfy-instagram_feed')){
        $value = str_replace($values, " ", $theme_style_content);
        $new_theme_styles = (string) $value;

        $update_styles = putThemeFileCurl($shop, $theme, $new_theme_styles, 'assets/theme.scss.liquid');
    }

    // remove snippet
    $delete_trustbadge_snippet = deleteThemeFilesCurl($shop, $theme, 'snippets/dbtfy-instagram-feed.liquid');

    // remove asset
    $delete_instafeed = deleteThemeFilesCurl($shop, $theme, 'assets/instafeed.min.js');

    // remove include
    $product_template = getThemeFileCurl($shop, $theme, 'layout/theme.liquid');

    if(str_contains($product_template,'dbtfy-instagram-feed')){
        $value  =  explode("{% include 'dbtfy-instagram-feed' %}",$product_template,2);
        if(isset($value[0]) && isset($value[1])){
            $value = $value[0].' '.$value[1];
        }else{
            $value = (string) $product_template;
        }
        $new_prod_template = (string) $value;
        $update_prod_template = putThemeFileCurl($shop, $theme, $new_prod_template, 'layout/theme.liquid');
    }

    // remove js addon
    try{
       $theme_js_content = getThemeFileCurl($shop, $theme, 'assets/dbtfy-addons.js.liquid') ?? '';

        $trustbadge_js = (string) '/* start-dbtfy-instagram-feed */';
        $end_js = (string) '/* end-dbtfy-instagram-feed */';
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
        if(!empty($theme_js_content) && str_contains($theme_js_content,'/* start-dbtfy-instagram-feed */')){
            $value = str_replace($value_js, " ", $theme_js_content);
            $new_theme_js = (string) $value;
            if(str_contains($new_theme_js,'/* start-register-instagram-feed */')){
                $trustbadge_js1 = (string) '/* start-register-instagram-feed */';
                $end_js = (string) '/* end-register-instagram-feed */';
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
        logger('add instagram_feed throws client exception');
    }
    catch(\Exception $e){
        logger('add instagram_feed throws exception');
    }
  }
}
?>
