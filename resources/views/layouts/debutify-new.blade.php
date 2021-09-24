<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @if(config('env-variables.BLOCK_CRAWLER'))<meta name="robots" content="noindex">@endif


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


            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/' + APP_ID;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
        </script>
{{--        END:: GTM test--}}


        <title>{{ config('shopify-app.app_name') }}</title>

        <!-- start webpushr tracking code -->
    <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";
      fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));
      webpushr('setup',{'key':'BMeiyOfl0UwiTFfglscHOxPAqdjSVd5e5G6xnqifNB0DVffDegvnbThFxmgnoBIh-vJV5rJ1WiwrKqlP0Zu0O8U' });</script>
      <!-- end webpushr tracking code --> 
        <link rel="stylesheet" href="{{ asset('css/debutify.css?v='.config('env-variables.ASSET_VERSION')) }}" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        
        @yield('styles')
    </head>

    <body class="template-@yield('title')">

        @if (config('env-variables.APP_TRACKING'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5BFQ4Q" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        @yield('content')
        <!-- Shopify -->
        <script src="https://cdn.shopify.com/s/assets/external/app.js?{{ date('YmdH') }}"></script>
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
          --}}
        </script>
          
        <script src="{{  asset(mix('js/react.js'))  }}?v={{ config('env-variables.ASSET_VERSION') }}"></script>
        <!-- Google ptimize -->
        <script src="https://www.googleoptimize.com/optimize.js?id=OPT-P8N97L2"></script>
    </body>
  </html>
