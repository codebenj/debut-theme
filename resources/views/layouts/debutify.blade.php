<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @if(config('env-variables.BLOCK_CRAWLER'))<meta name="robots" content="noindex">@endif

        <!-- Google ptimize -->
        <script src="https://www.googleoptimize.com/optimize.js?id=OPT-P8N97L2"></script>
        <script src="https://afarkas.github.io/lazysizes/lazysizes.min.js"></script>

        <!-- Fav icon ================================================== -->
        <link sizes="192x192" rel="shortcut icon" href="/images/debutify-favicon.png" type="image/png">

        @if (config('env-variables.APP_TRACKING'))
        <script>
          window.dataLayer = window.dataLayer || [];
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-M5BFQ4Q');</script>
        <!-- End Google Tag Manager -->
        @endif

{{--        START:: GTM test--}}
{{--        //Set your APP_ID--}}
        <script>
            var APP_ID = "dlaqi8xq";

            window.intercomSettings = {
                app_id: APP_ID,
                user_id: "{{ $owner_details['storeID'] }}",
                email: "{{ $owner_details['email'] }}",
                phone: "{{ $owner_details['phone'] }}",
                website: "{{$shop_domain}}"
            };
            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/' + APP_ID;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
        </script>
{{--        END:: GTM test--}}


        <title>{{ config('shopify-app.app_name') }}</title>

        <!-- start webpushr tracking code -->
    <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";
      fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));
      webpushr('setup',{'key':'BMeiyOfl0UwiTFfglscHOxPAqdjSVd5e5G6xnqifNB0DVffDegvnbThFxmgnoBIh-vJV5rJ1WiwrKqlP0Zu0O8U' });</script>
      <!-- end webpushr tracking code -->

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@5.10.1/dist/styles.css" />
        <!--<link rel="stylesheet" href="{{ asset('css/debutify.css') }}?version={{time()}}" />-->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ==" crossorigin="anonymous" />

        <link rel="stylesheet" href="{{ asset('css/debutify.css?v='.config('env-variables.ASSET_VERSION')) }}" />
        <link rel="stylesheet" href="{{ asset('css/banner.css?v='.config('env-variables.ASSET_VERSION')) }}" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

        @yield('styles')

        {{--        custom js--}}
        <script src="{{  asset(mix('js/app.js'))  }}?v={{ config('env-variables.ASSET_VERSION') }}"></script>

    </head>

    <body class="template-@yield('title')">

        @if (!isset($hide_side_bar) || $hide_side_bar != 1)
          @include('components.top_nav_bar')
        @endif
        @if (config('env-variables.APP_TRACKING'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5BFQ4Q" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        <div class="main">

          @if (!isset($hide_side_bar) || $hide_side_bar != 1)
          @include('components.sidebar')
          @endif

          <div class="page-container">
              @include('components.sticky-banner')
            <div class="Polaris-Page">
                @include('components.breadcrumbs-bar')
                <!-- mobile menu button -->
                @if (!isset($hide_side_bar) || $hide_side_bar != 1)
                <div class="Polaris-Page__Content layout-item btn-open-nav-container" style="display:none;margin-bottom:0;">
                  <button type="button" class="btn-open-nav Polaris-Button Polaris-Button--sizeLarge Polaris-Button--fullWidth" tabindex="0" data-polaris-unstyled="true">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Icon" style="margin-right:5px;">
                        <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path d="M19 11H1a1 1 0 1 1 0-2h18a1 1 0 1 1 0 2zm0-7H1a1 1 0 0 1 0-2h18a1 1 0 1 1 0 2zm0 14H1a1 1 0 0 1 0-2h18a1 1 0 1 1 0 2z"></path></svg>
                      </span>
                      Open menu
                    </span>
                  </button>
                </div>
                 @endif
                <!-- page title -->
                <div class="Polaris-Page-Header Polaris-Page-Header--separator">
                  @hasSection("breadcrumbs_link")
                  <div class="Polaris-Page-Header__Navigation">
                    <div class="Polaris-Page-Header__BreadcrumbWrapper">
                      <nav role="navigation">
                        <a class="Polaris-Breadcrumbs__Breadcrumb" href="{{config('env-variables.APP_PATH')}}@yield('breadcrumbs_link')" data-polaris-unstyled="true">
                          <span class="Polaris-Breadcrumbs__ContentWrapper">
                            <span class="Polaris-Breadcrumbs__Icon">
                              <span class="Polaris-Icon">
                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path></svg>
                              </span>
                            </span>
                            <span class="Polaris-Breadcrumbs__Content page-title">@yield('breadcrumbs_title')</span>
                          </span>
                        </a>
                      </nav>
                    </div>
                  </div>
                  @endif

                  <div class="Polaris-Page-Header__MainContent">
                    <div class="Polaris-Page-Header__TitleActionMenuWrapper">
                      <div>
                        <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                          <div class="Polaris-Header-Title">
                            <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge page-title">@yield('title')</h1>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                @php
                  $name = Route::currentRouteName();
                  if(!in_array($name, ['goodbye','free_trial_expired','paypal.success'])){
                @endphp
                @include("components.general-banners")
                @php } @endphp

                @php
                  $route_name = ['free_trial_expired','goodbye','paypal.success'];
                  $name = Route::currentRouteName();
                  if(!in_array($name, $route_name)){
                @endphp
                    @if ($trial_days < 14)
                      @include("components.trial-over")
                    @endif
                    @php }

                    @endphp


                <div class="Polaris-Page__Content">
                  @yield('content')
                </div>

                    <div class="Polaris-FooterHelp">
                   <div class="Polaris-FooterHelp__Content">
                      <div class="Polaris-FooterHelp__Icon"><span class="Polaris-Icon Polaris-Icon--colorTeal Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9" fill="#ffffff"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4a1 1 0 1 0 0 2 1 1 0 1 0 0-2m0-10C8.346 4 7 5.346 7 7a1 1 0 1 0 2 0 1.001 1.001 0 1 1 1.591.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path></svg></span></div>
                      <div class="Polaris-FooterHelp__Text">Need help?
                        <a href="https://help.debutify.com/" target="_blank" class="Polaris-Link" data-polaris-unstyled="true" data-no_loader="true">Visit Help Center</a>.
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>

        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

        <!-- Shopify -->
        <script src="https://cdn.shopify.com/s/assets/external/app.js?{{ date('YmdH') }}"></script>

        <!-- Shopify/Polaris -->
        {{--
        <script src="https://unpkg.com/@shopify/app-bridge{{ config('shopify-app.appbridge_version') ? '@'.config('shopify-app.appbridge_version') : '' }}"></script>
        --}}

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous"></script>

        <script type="text/javascript">
          // init shopify app
          {{--
          var AppBridge = window['app-bridge'];
          var actions = AppBridge.actions;
          var TitleBar = actions.TitleBar;
          var Button = actions.Button;
          var Redirect = actions.Redirect;
          var Loading = actions.Loading;
          var createApp = AppBridge.default;
          var Toast = actions.Toast;
          var Modal = actions.Modal;

          var ShopifyApp = createApp({
              apiKey: '{{ config('shopify-app.api_key') }}',
              shopOrigin: '{{ Auth::user()->name }}'
          });


          const titleBarOptions = {
            title: '',
          };
          const ShopifyTitleBar = TitleBar.create(ShopifyApp, titleBarOptions);

          const loading = Loading.create(ShopifyApp);
          loading.dispatch(Loading.Action.START);

          const redirect = Redirect.create(ShopifyApp);

          // show loading on href trigger
          $("a[href]:not([target='_blank'])").on("click",function(e){
            e.preventDefault();
            redirect.dispatch(Redirect.Action.APP, {
              path: $(this).attr('href'),
            });

          })
          --}}
          $("a[href]:not([target='_blank'])").on("click",function(e){
                loadingBarCustom();
            });

            $("form").submit(function(e){
                loadingBarCustom();
            });

          // select
          $(".Polaris-Select__Input").each(function(){
              var selectedText = $(this).find("option:selected").text();
              $(this).closest(".Polaris-Select").find(".Polaris-Select__SelectedOption").text(selectedText);
          });
          $(".Polaris-Select__Input").on('change', function(){
              var selectedText = $(this).find("option:selected").text();
              $(this).closest(".Polaris-Select").find(".Polaris-Select__SelectedOption").text(selectedText);
          });

          function closeAlert(elClass) {
            $('.' + elClass).hide();
          }

          // open modal
          function openModal(modal){
            setTimeout(function(){
              $("body").addClass("modal-open");
              modal.addClass('open').show();
            }, 10);
          }

          // close modal
            function closeModal(modal){
                if(modal){
                    modal.removeClass('open').hide();
                    //code by Anil to stop the iframe video, when the modal is closed
                    if(modal.contents().find('iframe').length){
                        modal.contents().find('iframe').attr("src", modal.find('iframe').attr("src").replace("autoplay=1","autoplay=0"));
                    }
                } else{
                    $(".modal").removeClass('open').hide();
                }
                $("body").removeClass("modal-open");

                // plan page
                $('.link-uninstall').show();
                $('.btn-update').show();
                $('.cancel-link-uninstall').hide();
                $('.btn-uninstall').hide();
                $('.radio-button').off("click");
                $('.tutorial').attr("src","");

                // course view
                modal.find(".course-video").trigger("pause");

                // initiate checkout tracking - remove on modal close
                sessionStorage.removeItem('initiateCheckoutMonthly');
                sessionStorage.removeItem('initiateCheckoutYearly');
            }

          $('.dismiss-banner').click(function () {
              $('.banner-trial').hide();
              sessionStorage.setItem('bannerTrialClosed','yes');
          });

          window.onscroll = function() {scrollFunction()};

          function scrollFunction() {
              if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                  $('.sticky-banner').fadeIn(300);
              } else {
                  $('.sticky-banner').hide();
              }
          }

          function loadingBarCustom(start = true){
              if(start == true){
                  if (typeof rotate !== 'undefined'){
                      $('.Polaris-Frame-Loading').css('display', 'none');
                      clearTimeout(rotate);
                  }
                  loadBarRecursive();
                  $('.Polaris-Frame-Loading').css('display', 'block');
              }
              else{
                  $('.Polaris-Frame-Loading').css('display', 'none');
                  if (typeof rotate !== 'undefined'){
                      clearTimeout(rotate);
                  }
              }
          }

          function customToastMessage(message, success = true)
          {
              if(success){
                  var bgColor = 'black';
                  var textColor = 'white';
              }
              else
              {
                  var bgColor = '#DE3618';
                  var textColor = 'white';
              }
              setTimeout(function(){
                  $.toast({
                      text: "<p class='toast-text'>"+message+"</p>",
                      showHideTransition: 'slide',
                      allowToastClose: true,
                      hideAfter: 3000,
                      stack: 5,
                      position: 'bottom-center',
                      textAlign: 'center',
                      loader: false,
                      bgColor: bgColor,
                      textColor: textColor
                  });
              }, 1000);
          }

          function loadBarRecursive(thumb = 1) {
              rotate = setTimeout(function() {
                  if(thumb < 20){
                      loadBarRecursive(thumb + (Math.floor(Math.random() * 100)/10));
                  }
                  else if(thumb > 70){
                      loadBarRecursive(thumb + 0.1);
                  }
                  else{
                      loadBarRecursive(thumb + (Math.floor(Math.random() * 10)/10));
                  }
                  $('.Polaris-Frame-Loading__Level').css('transform', 'scaleX('+(thumb/100)+')');
              }, 1000);
          }


          function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
          }

          function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i < ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) == ' ') {
                c = c.substring(1);
              }
              if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
              }
            }
            return "";
          }

          function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
            function(m,key,value) {
              vars[key] = value;
            });
            return vars;
          }

          var code = getUrlVars()["code"];
          if( code ) {
            setCookie('discount-code', code, 60);
          }

          // flash notification

          function beta_banner_info(){
                  $('.beta_theme_info').hide();
                  sessionStorage.setItem('beta_banner_info','1');
          }

          if (sessionStorage.getItem("beta_banner_info")) {
            } else {
                $('.beta_theme_info').show();
          }

          function new_update_theme_available(){
                  $('.newThemeVersionBanner').hide();
                  sessionStorage.setItem('new_theme_updation','1');
          }

          if (sessionStorage.getItem("new_theme_updation")) {
            } else {
                $('.newThemeVersionBanner').show();
          }

        </script>
        @include('shopify-app::partials.flash_messages')

        <!-- Common script -->
        <script type="text/javascript">
          // function customToastMessage(message, success = true)
          // {
          //   if(success){
          //     var bgColor = 'black';
          //     var textColor = 'white';
          //   }
          //   else
          //   {
          //     var bgColor = '#DE3618';
          //     var textColor = 'white';
          //   }
          //   setTimeout(function(){
          //     $.toast({
          //       text: "<p class='toast-text'>"+message+"</p>",
          //       showHideTransition: 'slide',
          //       allowToastClose: true,
          //       hideAfter: 3000,
          //       stack: 5,
          //       position: 'bottom-center',
          //       textAlign: 'center',
          //       loader: false,
          //       bgColor: bgColor,
          //       textColor: textColor
          //     });
          //   }, 1000);
          // }
          //
          // function loadBarRecursive(thumb = 1) {
          //   rotate = setTimeout(function() {
          //       if(thumb < 20){
          //         loadBarRecursive(thumb + (Math.floor(Math.random() * 100)/10));
          //       }
          //       else if(thumb > 70){
          //         loadBarRecursive(thumb + 0.1);
          //       }
          //       else{
          //         loadBarRecursive(thumb + (Math.floor(Math.random() * 10)/10));
          //       }
          //       $('.Polaris-Frame-Loading__Level').css('transform', 'scaleX('+(thumb/100)+')');
          //   }, 1000);
          // }
          //
          // function loadingBarCustom(start = true){
          //   if(start == true){
          //     if (typeof rotate !== 'undefined'){
          //       $('.Polaris-Frame-Loading').css('display', 'none');
          //       clearTimeout(rotate);
          //     }
          //     loadBarRecursive();
          //     $('.Polaris-Frame-Loading').css('display', 'block');
          //   }
          //   else{
          //     $('.Polaris-Frame-Loading').css('display', 'none');
          //     if (typeof rotate !== 'undefined'){
          //       clearTimeout(rotate);
          //     }
          //   }
          // }
          //
          // $(document).mouseup(function(e) {
          //     var container = $(".Polaris-Popover__PopoverOverlay--toggle");
          //     var container2 = $(".Polaris-TopBar-Menu__Activator-register-click");
          //     if ((!container.is(e.target) && container.has(e.target).length === 0) && (!container2.is(e.target) && container2.has(e.target).length === 0)){
          //       $('.Polaris-Popover__PopoverOverlay--toggle').removeClass('Polaris-Popover__PopoverOverlay--open');
          //       $('.Polaris-Popover__PopoverOverlay--toggle').css('display', 'none');
          //     }
          // });
          //
          // $(document).ready(function(){
          //
          //   $('.Polaris-TopBar-Menu__Activator-register-click').click(function(){
          //     if($('.Polaris-Popover__PopoverOverlay--toggle').hasClass('Polaris-Popover__PopoverOverlay--open')){
          //       $('.Polaris-Popover__PopoverOverlay--toggle').removeClass('Polaris-Popover__PopoverOverlay--open');
          //       $('.Polaris-Popover__PopoverOverlay--toggle').css('display', 'none');
          //     }
          //     else{
          //       $('.Polaris-Popover__PopoverOverlay--toggle').addClass('Polaris-Popover__PopoverOverlay--open');
          //       $('.Polaris-Popover__PopoverOverlay--toggle').css('display', 'block');
          //     }
          //   });
          //
          //   //nav
          //   var activeNav = "active-nav";
          //   if (window.location.href.indexOf("themes") > -1) {
          //     $('.Polaris-Navigation a[href*="themes"]').addClass(activeNav);
          //   }
          //   else if (window.location.href.indexOf("add_ons") > -1) {
          //     $('.Polaris-Navigation a[href*="add_ons"]').addClass(activeNav);
          //   }
          //   else if (window.location.href.indexOf("courses") > -1) {
          //     if(window.location.href.indexOf("courses/17") > -1){
          //       $('.Polaris-Navigation .course-link-17').addClass(activeNav);
          //     }
          //     else if(window.location.href.indexOf("courses/16") > -1){
          //       $('.Polaris-Navigation .course-link-16').addClass(activeNav);
          //     }
          //     else if(window.location.href.indexOf("courses/15") > -1){
          //       $('.Polaris-Navigation .course-link-15').addClass(activeNav);
          //     }
          //     else if(window.location.href.indexOf("courses/14") > -1){
          //       $('.Polaris-Navigation .course-link-14').addClass(activeNav);
          //     }
          //     else{
          //       $('.Polaris-Navigation .top-link-courses').addClass(activeNav);
          //     }
          //     $('.Polaris-Navigation__SecondaryNavigation-courses').css('display','block');
          //   }
          //   else if (window.location.href.indexOf("help") > -1) {
          //     $('.Polaris-Navigation a[href*="help"]').addClass(activeNav);
          //   }
          //   else if (window.location.href.indexOf("support") > -1) {
          //     $('.Polaris-Navigation a[href*="support"]').addClass(activeNav);
          //   }
          //   else if (window.location.href.indexOf("changelog") > -1) {
          //     $('.Polaris-Navigation a[href*="changelog"]').addClass(activeNav);
          //   }
          //   else if (window.location.href.indexOf("mentoring") > -1) {
          //     $('.Polaris-Navigation a[href*="mentoring"]').addClass(activeNav);
          //   }
          //   else if (window.location.href.indexOf("integrations") > -1) {
          //     $('.Polaris-Navigation a[href*="integrations"]').addClass(activeNav)
          //   }
          //   else if (window.location.href.indexOf("feedback") > -1) {
          //     $('.Polaris-Navigation a[href*="feedback"]').addClass(activeNav)
          //   }
          //   else if (window.location.href.indexOf("affiliate") > -1) {
          //     $('.Polaris-Navigation a[href*="affiliate"]').addClass(activeNav)
          //   }
          //   else if (window.location.href.indexOf("winning-products") > -1) {
          //     $('.Polaris-Navigation a[href*="winning-products"]').addClass(activeNav)
          //   }
          //   else if (window.location.href.indexOf("plans") > -1 || window.location.href.indexOf("thank-you") > -1 || window.location.href.indexOf("good-bye") > -1) {
          //     $('.Polaris-Navigation__Item[href*="plans"]').addClass(activeNav);
          //     $('.Polaris-Button[href*="plans"]').addClass("Polaris-Button--disabled").prop('disabled', true);
          //   }
          //   else if (window.location.href.indexOf("partners") > -1) {
          //     $('.Polaris-Navigation a[href*="partners"]').addClass(activeNav)
          //   }
          //   else{
          //     $('.Polaris-Navigation .home-link').addClass(activeNav)
          //   }
          //
          //   $("a[href]:not([target='_blank'])").on("click",function(e){
          //     loadingBarCustom();
          //   });
          //
          //   $("form").submit(function(e){
          //     loadingBarCustom();
          //   });
          //
          //   // toggle nav
          //   $(".btn-open-nav").click(function(){
          //     $(".Polaris-Navigation").addClass("open-menu");
          //   });
          //   $(".btn-close-nav").click(function(){
          //     $(".Polaris-Navigation").removeClass("open-menu");
          //   });
          //
          //   // leave review banner
          //   $(".btn-leaveReview").click(function(){
          //       localStorage.setItem('leaveReview','yes');
          //   });
          //   if(localStorage.getItem("leaveReview")){} else{
          //     $(".reviewBanner").show();
          //   }
          // });
          </script>

           <script>
            $(document).ready(function(){
              if (sessionStorage.getItem("bannerTrialClosed")) {} else{
                $('.banner-trial').show();
              }

              @if($theme_check == 0)
                $.get("{{ url('update_themecheck') }}", function(response){
                  if(response.status == 'success'){}
                });

                // app download tracking
                @if (config('env-variables.APP_TRACKING'))
                window.dataLayer.push({
                  'event': 'app_download'
                });
                //webpushr custom attribute app_download
                webpushr('attributes',{"App Download" : "True"});
                @endif

                // start trial tracking
                @if (config('env-variables.APP_TRACKING'))
                window.dataLayer.push({
                  'subscriptionId': '{{$hustleridMonthly}}',
                  'event': 'start_trial'
                });
                //webpushr custom attribute start_trial
			          webpushr('attributes',{"Start Trial" : "True"});
                @endif
              @endif


              @if($trial_days && $trial_check == 0)
                $.get("{{ url('update_trail') }}", function(response){
                  if(response.status == 'success'){}
                });

                // start trial tracking
                @if (config('env-variables.APP_TRACKING'))
                window.dataLayer.push({
                  'subscriptionId': '{{$hustleridMonthly}}',
                  'event': 'start_trial'
                });
			          webpushr('attributes',{"Start Trial" : "True"});
                @endif
                 @endif

            });
          </script>
          @yield('scripts')

          @php
          session()->forget('status');
          @endphp

    </body>
        </html>
