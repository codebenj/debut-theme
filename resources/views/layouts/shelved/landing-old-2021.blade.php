<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="canonical" href="https://debutify.com/">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="theme-color" content="#5600e3">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="author" content="Debutify">

        <!-- Google Optimize -->
        <script src="https://www.googleoptimize.com/optimize.js?id=OPT-P8N97L2"></script>

        <!-- Fav icon ================================================== -->
        <link sizes="192x192" rel="shortcut icon" href="/images/debutify-favicon.png" type="image/png">

        <!-- Title and description ================================================== -->
        <title>@yield("title")</title>
        <meta name="description" content="@yield("description")">

        <!-- Social meta ================================================== -->
        <meta property="og:site_name" content="Debutify">
        <meta property="og:url" content="{{ isset($seo_url) ? 'https://debutify.com/'.$seo_url.'/' : 'https://debutify.com/' }}">
        <meta property="og:title" content="{{ isset($seo_title) ? $seo_title : 'Debutify - World\'s Smartest Shopify Theme. Free 14-day Trial' }}">
        <meta property="og:type" content="{{ isset($seo_url) ? 'article' : 'website' }}">
        <meta property="og:description" content="{{ isset($seo_description) ? $seo_description : 'Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today' }}">
        <meta property="og:image" content="{{ isset($seo_feature_image) ? $seo_feature_image : asset('images/debutify-share.jpg') }}">
        <meta property="og:image:secure_url" content="{{ isset($seo_feature_image) ? $seo_feature_image : asset('images/debutify-share.jpg') }}">
        @if(isset($schema_data))<meta property="article:published_time" content="{{$schema_data['created_at']}}" />
        <meta property="article:modified_time" content="{{$schema_data['updated_at']}}" />
        <meta property="og:image:width" content="{{$schema_data['width']}}" />
        <meta property="og:image:height" content="{{$schema_data['height']}}" />@endif

        <meta name="twitter:site" content="@debutify">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ isset($seo_title) ? $seo_title : 'Debutify - World\'s Smartest Shopify Theme. Free 14-day Trial' }}">
        <meta name="twitter:description" content="{{ isset($seo_description) ? $seo_description : 'Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today' }}">
        <script type="application/ld+json">
        @if(isset($schema_data))
        {
         "@context": "https://schema.org",
         "@graph": [
            {
               "@type": "WebSite",
               "@id": "{{ $schema_data['base_url'] }}/#website",
               "url": "{{ $schema_data['base_url'] }}",
               "name": "Debutify",
               "description": "{{ $schema_data['description'] }}",
               "potentialAction": [
                  {
                     "@type": "SearchAction",
                     "target": "{{ $schema_data['base_url'] }}/search/?s={search_term_string}",
                     "query-input": "required name=search_term_string"
                  }
               ],
               "inLanguage": "en-US"
            },
            {
               "@type": "ImageObject",
               "@id": "{{ $schema_data['base_url'] }}/{{$schema_data['slug']}}/#primaryimage",
               "inLanguage": "en-US",
               "url": "{{$seo_feature_image}}",
               "width": {{$schema_data['width']}},
               "height": {{$schema_data['height']}},
               "caption": "{{$seo_title}}"
            },
            {
               "@type": "WebPage",
               "@id": "{{ $schema_data['base_url'] }}/{{$schema_data['slug']}}/#webpage",
               "url": "{{ $schema_data['base_url'] }}/{{$schema_data['slug']}}/",
               "name": "{{$seo_title}}",
               "isPartOf": {
                  "@id": "{{ $schema_data['base_url'] }}/#website"
               },
               "primaryImageOfPage": {
                  "@id": "{{ $schema_data['base_url'] }}/{{$schema_data['slug']}}/#primaryimage"
               },
               "datePublished": "{{$schema_data['created_at']}}",
               "dateModified": "{{$schema_data['updated_at']}}",
               "author": {
                  "@id": "{{ $schema_data['base_url'] }}/author/{{$schema_data['author']}}"
               },
               "description": "{{ isset($seo_description) ? $seo_description : 'Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today' }}",
               "inLanguage": "en-US",
               "potentialAction": [
                  {
                     "@type": "ReadAction",
                     "target": [
                        "{{ $schema_data['base_url'] }}/{{$schema_data['slug']}}/"
                     ]
                  }
               ]
            },
            {
               "@type": [
                  "Person"
               ],
               "@id": "{{ $schema_data['base_url'] }}/author/{{$schema_data['author']}}",
               "name": "{{$schema_data['author_name']}}",
               "image": {
                  "@type": "ImageObject",
                  "@id": "{{ $schema_data['base_url'] }}/#personlogo",
                  "inLanguage": "en-US",
                  "url": "{{$schema_data['author_image']}}",
                  "caption": "{{$schema_data['author_name']}}"
               }
            }
         ]
        }
        @endif
        </script>

        @if (config('env-variables.APP_TRACKING'))
        <script>
          dataLayer = [];
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M5BFQ4Q');</script>
        <!-- End Google Tag Manager -->
        @endif

      <!-- start webpushr tracking code -->
      <script>(function(w,d, s, id) {if(typeof(w.webpushr)!=='undefined') return;w.webpushr=w.webpushr||function(){(w.webpushr.q=w.webpushr.q||[]).push(arguments)};var js, fjs = d.getElementsByTagName(s)[0];js = d.createElement(s); js.id = id;js.async=1;js.src = "https://cdn.webpushr.com/app.min.js";
        fjs.parentNode.appendChild(js);}(window,document, 'script', 'webpushr-jssdk'));
        webpushr('setup',{'key':'BMeiyOfl0UwiTFfglscHOxPAqdjSVd5e5G6xnqifNB0DVffDegvnbThFxmgnoBIh-vJV5rJ1WiwrKqlP0Zu0O8U' });</script>
      <!-- end webpushr tracking code -->

        {{-- Impact integration --}}
        <script type="text/javascript">
            (function(a,b,c,d,e,f,g){e['ire_o']=c;e[c]=e[c]||function(){(e[c].a=e[c].a||[]).push(arguments)};f=d.createElement(b);g=d.getElementsByTagName(b)[0];f.async=1;f.src=a;g.parentNode.insertBefore(f,g);})('//d.impactradius-event.com/A2559139-2134-4977-8281-7ed0d8c7c7ef1.js','script','ire',document,window);
        </script>
        {{-- End Impact integration --}}

        <!-- App style -->
        <link rel="stylesheet" href="{{ asset('css/app.css?v='.config('env-variables.ASSET_VERSION')) }}">

        <!-- page style -->
        @yield('styles')



    </head>

    <body>
        @if (config('env-variables.APP_TRACKING'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5BFQ4Q"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        @yield('announcement')

        <!-- Navigation -->
        @if(!isset($hide_top_menu))
        <header class="nav-down">
            <!-- nav -->
            <nav id="menu" class="navbar navbar-expand-lg navbar-light {{ $bgColor ?? 'bg-light' }}" itemscope="" itemtype="http://schema.org/Organization">
              <div class="container-fluid p-0">
                <div class="align-items-center d-flex flex-fill flex-lg-grow-0 flex-nowrap justify-content-between">
                  <a href="/" class="navbar-brand" itemprop="url">
                    <img class="logo default-logo img-fluid" src="/images/landing/debutify-logo-dark.svg" width="200" alt="Debutify" itemprop="logo">
                  </a>
                  <div class="flex-shrink-0 d-block d-lg-none">
                    <button class="btn btn-primary btn-sm ml-auto mr-1 download-cta" data-cta-tracking="cta-5" data-toggle="modal" data-target="#downloadModal">
                      Free Download
                    </button>
                    <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#mainNavbar"
                            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fas fa-bars"></span>
                    </button>
                  </div>
                </div>
                <div id="mainNavbar" class="collapse navbar-collapse justify-content-between">
                    <ul class="navbar-nav flex-fill">
                        <li class="nav-item mr-lg-auto">
                          <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website-header" target="_blank" class="nav-link">
                              <span class="fab fa-shopify"></span>
                              Shopify Free Trial
                          </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/reviews">
                              <!-- <span class="fas fa-star"></span> -->
                              Reviews
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://debutifydemo.myshopify.com/" target="_blank">
                              <!-- <span class="fas fa-eye"></span> -->
                              Demo store
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Resources</a>
                          <div class="dropdown-menu animated fadeIn faster">
                            <a class="dropdown-item" href="/blog">Blog</a>
                            <a class="dropdown-item" href="/podcast">Podcast</a>
                            <a class="dropdown-item" href="/free-dropshipping-course">Webinar</a>
                          </div>
                        </li>


                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">More links</a>
                          <div class="dropdown-menu animated fadeIn faster">
                            <a class="dropdown-item" href="/pricing">Pricing</a>
                            <a class="dropdown-item" href="/theme">Theme</a>
                            <a class="dropdown-item" href="/add-ons">Add-ons</a>
                            <a class="dropdown-item" href="/contact">Contact</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/affiliate">Affiliate</a>
                            <a class="dropdown-item" href="/partners">Partners</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="http://feedback.debutify.com" target="_blank">
                              <span class="fas fa-external-link-alt"></span>
                              Roadmap
                            </a>
                            <a class="dropdown-item" href="/help" target="_blank">
                              <span class="fas fa-external-link-alt"></span>
                              Help center
                            </a>
                          </div>
                        </li>
                    </ul>
                    <div class="nav-item mt-3 mt-lg-0 ml-lg-2">
                        <button class="btn btn-primary btn-block download-cta" data-cta-tracking="cta-2" data-toggle="modal" data-target="#downloadModal">
                          <span class="fas fa-download"></span>
                          Free Download Now
                        </button>
                    </div>
                </div>
              </div>
            </nav>
        </header>
        @endif


        <main role="main">
          @yield('content')
        </main>


        @if(!isset($hide_shopify_download))
        <hr/>
        <div class="shopify-section py-5">
          <div class="container">
            <div class="row align-items-center text-center text-md-left">
              <div class="col-md-1 mb-3 mb-md-0">
                <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website-footer-banner" target="_blank">
                  <img class="img-fluid lazyload" data-src="/images/shopify-icon.svg" width="100" alt="shopify">
                </a>
              </div>
              <div class="col-md-7 mb-3 mb-md-0">
                <h4>Open a Shopify Online Store For Free!</h4>
                <p class="mb-0 text-muted">Sign up for a free Shopify 14-day trial and start selling today.</p>
              </div>
              <div class="col-md-4 text-md-right">
                <div class="text-center d-inline-block">
                  <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website-footer-banner" target="_blank" class="btn btn-primary">Start your 14-Day free trial</a>
                  <br>
                  <small class="text-muted">Try Shopify for free. No credit card required.</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        <footer class="text-white footer bg-gradient text-center text-white">
           @if(!isset($hide_shopify_download))
          <section class="dropshipping-section py-5">
              <div class="container">
                  <div class="row align-items-center">
                      <div class="col-lg-6">
                          <img data-src="/images/new/dropshipping-img.png" alt="" class="img-fluid mb-3 lazyload" />
                      </div>
                      <div class="col-lg-6">
                          <h2>Bootstrap Your Dropshipping Empire Today, FREE</h2>
                          <h6>Download Debutify and get
                              <strong>all premium features FREE</strong>
                              for 14 days.
                              <br class="d-none d-sm-block"> Set up and install in 1 click!</h6>
                          @include ("components.download-wrapper", ['cta_tracking' => 'cta-31'])
                      </div>
                  </div>
              </div>
          </section>
           @endif
          <hr/>

          <section class="footer-nav-section py-5">
            <div class="container">
              @if(!isset($hide_shopify_download))
                <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website-shopify-partners" target="_blank">
                  @endif
                    <img loading="lazy" src="/images/shopify-partner.png" alt="Shopify Partner" width="180">
                @if(!isset($hide_shopify_download))
                </a>
                @endif
                @if(!isset($hide_shopify_download))
                <div class="row">
                  <div class="col">
                    <nav class="navbar navbar-expand navbar-dark justify-content-center">
                      <ul class="navbar-nav mb-0">
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.facebook.com/debutify/"><i class="fab fa-facebook fa-2x"></i></a></li>
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.instagram.com/debutify/"><i class="fab fa-instagram fa-2x"></i></a></li>
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w"><i class="fab fa-youtube fa-2x"></i></a></li>
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.tiktok.com/@debutify"><i class="fab fa-tiktok fa-2x"></i></a></li>
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://twitter.com/debutify"><i class="fab fa-twitter fa-2x"></i></a></li>
                        <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.pinterest.com/debutify"><i class="fab fa-pinterest fa-2x"></i></a></li>
                    </ul>
                  </nav>
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-12">
                  <nav class="navbar navbar-expand navbar-dark justify-content-center">
                    <ul class="navbar-nav flex-wrap justify-content-center">
                      <li class="nav-item"><a class="nav-link" href="/theme">Theme</a></li>
                      <li class="nav-item"><a class="nav-link" href="/add-ons">Add-ons</a></li>
                      <li class="nav-item"><a class="nav-link" href="/faq">FAQ</a></li>
                      <li class="nav-item"><a class="nav-link" href="/about">Meet the team</a></li>
                      <li class="nav-item"><a class="nav-link" href="/pricing">Pricing</a></li>
                      <li class="nav-item"><a class="nav-link" href="/download">Download</a></li>
                      <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                    </ul>
                  </nav>
                  <nav class="navbar navbar-expand navbar-dark justify-content-center">
                    <ul class="navbar-nav flex-wrap justify-content-center">
                      <li class="nav-item"><a class="nav-link" href="/career">Career</a></li>
                      <li class="nav-item"><a class="nav-link" href="/affiliate">Affiliate</a></li>
                      <li class="nav-item"><a class="nav-link" href="/partners">Partners</a></li>
                      <li class="nav-item"><a class="nav-link" href="/blog">Blog</a></li>
                      <li class="nav-item"><a class="nav-link" href="/podcast">Podcast</a></li>
                      <li class="nav-item"><a class="nav-link" href="/free-dropshipping-course">Webinar</a></li>
                    </ul>
                  </nav>
                </div>
                <div class="col-12">
                  <nav class="navbar navbar-expand navbar-dark justify-content-center">
                    <ul class="navbar-nav flex-wrap justify-content-center">
                      <li class="nav-item"><a class="nav-link" href="/terms-of-use"><small>Terms of use</small></a></li>
                      <li class="nav-item"><a class="nav-link" href="/privacy-policy"><small>Privacy policy</small></a></li>
                      <li class="nav-item"><a class="nav-link" href="/terms-of-sales"><small>Terms of sales</small></a></li>
                    </ul>
                  </nav>
                </div>
              </div>
              @endif
              <div class="row" style="opacity:0.5;">
                <div class="col">
                  <small>Copyright {{ now()->year }} Debutify Inc. All rights reserved.</small>
                </div>
              </div>
              @if(!isset($hide_shopify_download))
              <div class="row">
                <div class="col">
                  <nav class="navbar navbar-expand navbar-dark justify-content-center">
                    <ul class="navbar-nav flex-wrap justify-content-center">
                      <li class="nav-item">
                        <a class="nav-link" href="http://feedback.debutify.com" target="_blank">
                          <small class="fas fa-external-link-alt"></small>
                          Roadmap
                        </a>
                        <a class="nav-link" href="/help" target="_blank">
                          <small class="fas fa-external-link-alt"></small>
                          Help Center
                        </a>
                        <a target="_blank" href="//www.dmca.com/Protection/Status.aspx?ID=55794deb-0c7a-4eaf-aad0-7d610f9e6413" title="DMCA.com Protection Status" class="dmca-badge"> <img src ="https://images.dmca.com/Badges/_dmca_premi_badge_5.png?ID=55794deb-0c7a-4eaf-aad0-7d610f9e6413" alt="DMCA.com Protection Status" /></a> <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
              @endif
            </div>
          </section>
        </footer>

        <!-- back to top -->
        <button type="button" class="btn btn-primary btn-sm back-to-top"><i class="fa fa-arrow-up"></i></button>

        <!-- Download box -->


        @php
        $route_name = ['blog_tag_slug','blog','blog_slug','blog_tag_slug','blog_category_slug','podcast','podcast_slug','search_blogs'];
        $name = Route::currentRouteName();
        if(!in_array($name, $route_name)){
        @endphp

           @if(!isset($hide_download_box))
        <div class="download-box text-center">
            <button type="button" class="btn btn-warning p-2" data-toggle="modal" data-target="#downloadModal">
              <span class="d-flex mb-2 align-items-center justify-content-center">
                <span class="mr-2 d-none d-sm-inline">
                  {{-- <img src="images/new/downloads.png" alt="" class="img-fluid" /> --}}
                </span>
                <span class="">
                  <span class="download-number d-block font-weight-bold">{{$nbShops}}+</span>
                  <span class="small d-block">Downloads</span>
                </span>
              </span>
              <div class="btn btn-primary btn-sm btn-block download-cta" data-cta-tracking="cta-3">
                <span class="d-none d-sm-inline">Free</span>
                Download
              </div>
            </button>
        </div>
        @endif
        @php } @endphp

        <!-- Dowload Modal -->
        <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body p-md-4">

                <div class="text-center">
                  <a target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website-modal-logo" class="d-inline-block mb-3 mx-auto"><img src="/images/shopify-logo.png" width="120" alt="shopify"></a>
                </div>

                <!-- downloadForm -->
                <form id="downloadForm" class="form-horizontal" method="POST" action="">
                  <p class="lead text-center" id="downloadModalLabel">Enter your name & email address.</p>
                  <div class="form-group text-left">
                    <input id="downloadName" required type="text" class="form-control form-control-lg" name="name" value="" placeholder="Name">
                  </div>
                  <div class="form-group text-left">
                    <input id="downloadEmail" required type="email" class="form-control form-control-lg" name="email" value="" placeholder="Email">
                  </div>
                  <button id="submitDownloadForm" type="submit" class="btn btn-primary btn-lg btn-block">
                    <span class="btn-text">
                      <span class="fas fa-download" aria-hidden="true"></span>
                      Free Download Now
                    </span>
                    <span class="btn-loading" style="display:none;">
                      <span class="fas fa-spin fa-spinner"></span>
                    </span>
                  </button>
                  <div class="alert alert-primary text-center small mt-3 mb-0">
                    🎁 <span class="font-weight-bold">BONUS:</span> Receive 5 Free winning products!
                  </div>
                </form>

                <!-- domain form -->
                <form id="domainForm" class="form-horizontal" method="POST" action="{{ route('authenticate') }}" style="display:none;" target="_blank">
                  {{ csrf_field() }}
                  <p class="lead text-center">Enter your shopify domain. <span class="fas fa-question-circle toggle-download-info text-muted"></span></p>
                  <div class="form-group">
                    <input class="form-control form-control-lg" required type="text" name="shop" id="shop" placeholder="storename.myshopify.com" onkeyup="this.value = this.value.toLowerCase();">
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block dbtfy-addtocart">
                    <span class="fas fa-download dbtfy-addtocart" aria-hidden="true"></span>
                    Free Download Now
                  </button>
                  <button style="display: none;" disabled="disabled" type="button" class="btn btn-primary btn-lg btn-block download-loading">
                    <span class="fas fa-spin fa-spinner"></span>
                  </button>
                  <div class="alert alert-success text-center small mt-3 mb-0">
                    To install Debutify theme, an active Shopify store is required. Don't have one yet?<br class="d-block d-sm-none">
                    <a class="font-weight-bold alert-link" target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website-modal-get-started">
                      Start your 14-Day free trial
                    </a>
                  </div>
                </form>

                <div class="p-3 rounded bg-grey download-info" style="display:none;">
                  <p>
                    <small>
                      <span class="fa fa-question-circle"></span>
                      <strong>Why do I need to enter my domain?</strong>
                      <br>
                      Your shopify domain is required to download Debutify Theme Manager, where you will have access to our theme and add-ons.
                    </small>
                  </p>
                  <p>
                    <small>
                      <span class="fa fa-question-circle"></span>
                      <strong>What permission is your app asking for?</strong>
                      <br>
                      We only access the "manage store permission" to be able to edit theme files to install our theme and add-ons. We do not have access to any of your customer's data.
                    </small>
                  </p>
                  <p>
                    <small>
                      <span class="fa fa-question-circle"></span>
                      <strong>Why isn't Debutify in the Shopify App Store?</strong>
                      <br>
                      We couldn't get in the Shopify App Store because our functions are only compatible with Debutify theme.
                    </small>
                  </p>
                  <hr>
                  <small class="text-center">
                      <strong>
                        Have any questions?
                        <a href="#" class="close-modal" onclick="Intercom('show');">chat with us.</a>
                      </strong>
                  </small>
                </div>
              </div>
            </div>
          </div>
        </div>

        @if(isset($page) && $page == "affiliate")
        <div class="modal fade" id="affiliateExitModal" tabindex="-1" role="dialog" aria-labelledby="affiliateExitModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content affiliate-popup-content bg-gradient py-3 text-white">
              <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                      <div class="col text-center">
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h2 class="font-weight-normal" id="affiliateExitModalLabel">You're Missing Out On</h2>
                        <h2>Free Money!</h2>
                        <p class="w-75 m-auto">Debutify is taking the Shopify world by STORM. Be part of this gold rush - cash in with Debutify as an affiliate partner.</p>
                        <div class="rounded m-3 bg-white">
                            <ul class="text-left py-3">
                                <li>Get all the material you need to promote</li>
                                <li>Make more money with ultra-high converting landing page</li>
                                <li>Earn <strong>lifetime recurring commission</strong> for every conversion!</li>
                            </ul>
                        </div>
                        <p class="w-75 m-auto">Promote the best Shopify theme available. Earn your first check as soon as next week - become an affiliate today!</p>
                        <div class="download-btn mt-3">
                            <a href="https://app.linkmink.com/a/debutify/181" target="_blank" class="btn btn-warning mb-4 btn-lg animated pulse infinite text-uppercase">Become a Debutify Affiliate</a>
                            <img src="images/new/arrow-yellow.png" alt="" class="img-fluid arrow-img animated pulse infinite" />
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif

        <!-- Exit Modal -->
        <div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="exitModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span class="fas fa-times" aria-hidden="true"></span>
                    </button>
            </div>
              <div class="modal-body">
                <div class="container-fluid p-0">
                  <div class="row align-items-center">
                    <div class="col-lg-5 d-none d-lg-flex">
                      <img loading="lazy"  data-src="/images/exit-intent_mini_s.webp" alt="" width="100%" class="img-fluid rounded lazyload">
                    </div>
                    <div class="col-lg-7 text-center">
                      <!-- exit form -->
                      <form id="exitForm" class="form-horizontal text-center" method="POST" action="">
                        <div class="form-group">
                          <p class="h2" id="exitModalLabel">FREE Winning Products & FREE Training You Don't Want to Miss</p>
                          <p class="lead">
                              Get the <strong>FREE</strong> ebook on <strong>FIVE $1,000,000 PRODUCTS</strong> in unsaturated niches, PLUS an exclusive invitation to
                              <strong>FREE MASTERCLASS WEBINAR</strong> by 7-figure entrepreneur Ricky Hayes.
                          </p>
                        </div>
                        <div class="form-group text-left">
                          <input id="exitName" required type="text" class="form-control form-control-lg" name="name" value="" placeholder="Name">
                        </div>
                        <div class="form-group text-left">
                          <input id="exitEmail" required type="email" class="form-control form-control-lg" name="email" value="" placeholder="Email">
                        </div>
                        <button id="submitExitForm" type="submit" class="btn btn-primary btn-lg btn-block">
                          <span class="btn-text">
                            <span class="fas fa-bolt" aria-hidden="true"></span>
                            Free Download Now
                          </span>
                          <span class="btn-loading" style="display:none;">
                            <span class="fas fa-spin fa-spinner"></span>
                          </span>
                        </button>
                      </form>
                      <div id="exitFormSuccess" style="display:none;">
                        <p class="h1">Thank you!</p>
                        <p class="lead">We just sent your $1,000,000 Winning Products to your email inbox.</p>
                        <a href="#" class="exitDownloadLink" data-dismiss="modal" data-toggle="modal" data-target="#downloadModal">Get Debutify theme 100% Free here</a>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>

        <!--Badge for rich snippet-->
        <div data-rw-badge1="20434" class="d-none"></div>

        <!-- Cookie Box -->
        <div class="alert alert-dismissible text-center cookiealert" role="alert">
          <div class="cookiealert-container">
              <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="http://cookiesandyou.com/" target="_blank">Learn more</a>
              <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
                  I agree
              </button>
          </div>
        </div>
 <!-- Plugins style -->
        <link rel="stylesheet" href="{{ asset('css/cookiealert.css') }}">
        <script defer src="https://kit.fontawesome.com/fdcc8b7628.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
        <!-- App js (bootstrap/jquery)-->
        <script src="{{ asset('js/app.js') }}"></script>

        <!-- lazysizes -->
        <script src="{{ asset('js/lazysizes.min.js') }}"></script>

        <!-- exit intent -->
        <script src="{{ asset('js/jquery.exitintent.min.js') }}" defer="defer"></script>

        <!-- jquery validate -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" defer="defer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js" defer="defer"></script>

        <script>
            var APP_ID = "dlaqi8xq";
            window.intercomSettings = {
                app_id: APP_ID
            };
            (function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/' + APP_ID;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
        </script>

        <script>
          $('.download-cta').on('click', function(){
            var cta = $(this).attr('data-cta-tracking');

            dataLayer.push({
              'event':' GAEvent',
              'eventCategory': 'CTA Clicks', 
              'eventAction': 'Free Download Now',                                   
              'eventLabel': cta
            });
          })
        </script>

        <script defer="defer">
            $(document).ready(function(){
                $('#videoModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var title = button.data('title');
                    var subtitle = button.data('subtitle');

                    @include("components.video-addons")

                    $('.tutorial').attr("src","https://www.youtube.com/embed/" + videoSource + "?autoplay=1");

                    $(".addon-title").text(title);
                    $(".addon-subtitle").text(subtitle);

                    if(videoSource){
                      $(".video-tutorial").show();
                    } else {
                      $(".video-tutorial").hide();
                    }
                });

                $('#videoModal').on('hide.bs.modal', function (e) {
                    $('.tutorial').attr("src","");
                });

                @if (config('env-variables.APP_TRACKING'))
                //landing page view tracking
                $(document).ready(function() {
                  if(sessionStorage.getItem("landingPageView")){} else{
                    window.dataLayer.push({'event': 'landing_page_view'});
                    sessionStorage.setItem('landingPageView','yes');
                  };
                });
                @endif

                // jQuery validate
                jQuery.validator.setDefaults({
                    errorElement: 'span',
                    errorPlacement: function (error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
                jQuery.validator.addMethod("domain", function(value, element) {
                  return this.optional(element) || /.myshopify.com/.test(value);
                }, "Please enter your .myshopify.com domain");

                // open download modal
                $(document).on('click', '.toggleModal', function(){
                  $('#downloadModal').modal('show');
                });

                // close download modal
                $(document).on('click', '.close-modal', function(){
                  $('#downloadModal').modal('hide');
                });

                // on download modal open
                $('#downloadModal').on('shown.bs.modal', function () {

                  if( $("#downloadForm").is(":visible") ){
                    $('#downloadName').trigger('focus');
                  } else if( $("#domainForm").is(":visible") ){
                    $('#shop').trigger('focus');
                  }
                  @if (config('env-variables.APP_TRACKING'))
                  //initiate download tracking
                  if(sessionStorage.getItem("initiateDownload")){} else{
                    window.dataLayer.push({'event': 'initiate_download'});
                    sessionStorage.setItem('initiateDownload','yes');
                    //webpushr custom attribute intiate_download
                    webpushr('attributes',{"Initiate Download" : "True"});
                  };
                  @endif
                });

                // more info content on download modal
                $(document).on('click', ".toggle-download-info", function(){
                  if( $(".download-info").is(":visible")){
                    $(".download-info").hide();
                  }
                  else{
                    $(".download-info").show();
                  }
                });

                $('#downloadModal').on('hidden.bs.modal', function () {
                  $(".download-info").hide();
                });

                $('input#shop').focusin(function(){
                    $(".download-info").hide();
                });

                $('#downloadModal').on('hidden.bs.modal', function () {
                  $(".download-info").hide();
                });
                $('input#shop').focusin(function(){
                  $(".download-info").hide();
                });


                // download app email/name form
                var downloadForm = $("#downloadForm");
                downloadForm.validate({
                  submitHandler: function(form) {
                    var button = downloadForm.find("button[type='submit']");
                    var name = downloadForm.find('#downloadName').val();
                    var email = downloadForm.find('#downloadEmail').val();
                    var url = '{{ route('initiate_download')}}';
                    button.find(".btn-text").hide();
                    button.find(".btn-loading").show();
                    $.get(url+'?name='+name+'&email='+email, function(response){
                      if(response.status == 'success'){
                        $("#downloadForm").hide();
                        $("#domainForm").show();
                        $('#shop').trigger('focus');

                        @if (config('env-variables.APP_TRACKING'))
                        //lead tracking
                        window.dataLayer.push({'event': 'lead'});
                        // webpushr custom attribute lead
                        webpushr('attributes',{"Lead" : "True"});
                        @endif
                      }
                    });
                  }
                });

                // exit intent email/name form
                var exitForm = $("#exitForm");
                exitForm.validate({
                  submitHandler: function(form) {
                    var button = exitForm.find("button[type='submit']");
                    var name = exitForm.find('#exitName').val();
                    var email = exitForm.find('#exitEmail').val();
                    var url = '{{ route('exit_intent')}}';
                    button.find(".btn-text").hide();
                    button.find(".btn-loading").show();
                    $.get(url+'?name='+name+'&email='+email, function(response){
                      if(response.status == 'success'){
                        exitForm.hide();
                        $("#exitFormSuccess").show();
                      }
                    });
                  }
                });

                // validate domain format .myshopify
                $('#domainForm').validate({
                  rules: {
                    shop: {
                      required: true,
                      nowhitespace: true,
                      domain: true
                    }
                  },
                  submitHandler: function(form) {
                    $(".dbtfy-addtocart").hide();
                    $(".download-loading").show();
                    const domainValue = $("#shop").val();

                    if(domainValue){
                        localStorage.setItem("shopDomain" , domainValue)
                    }


                    @if (config('env-variables.APP_TRACKING'))
                    //webpushr custom attribute complete_registration
                    webpushr('attributes',{"Complete Registration" : "True"});
                    //complete registration tracking
                    window.dataLayer.push({'event': 'complete_registration'});
                    @endif

                    form.submit();

                    $(".download-loading").hide();
                    window.location.href = "{{ route('thank-you')}}";
                  }
                });

                // trigger exit intent modal
                $.exitIntent("enable");
                $(document).bind("exitintent", function() {
                    @if(isset($page) && $page == "affiliate")
                        openAffiliateExitIntent();
                    @else
                        openExitIntent();
                    @endif
                });
                $(window).blur(function(e) {
                  if($("iframe").is(":focus")){} else{
                      @if(isset($page) && $page == "affiliate")
                        openAffiliateExitIntent();
                     @else
                        openExitIntent();
                     @endif
                  }
                });

                function openExitIntent(){
                  if(sessionStorage.exitModalShown){ } else{
                    if($("#downloadModal").hasClass("show")) {} else{
                      $('#exitModal').modal('show');
                    }
                  }
                }

                function openAffiliateExitIntent(){
                  if(sessionStorage.affiliateExitModalShown){ } else{
                    if($("#downloadModal").hasClass("show")) {} else{
                      $('#affiliateExitModal').modal('show');
                    }
                  }
                }

                $('#exitModal').on('shown.bs.modal', function () {
                  $("#exitName").trigger('focus');
                  sessionStorage.setItem("exitModalShown", "true");
                });

                $('#affiliateExitModal').on('shown.bs.modal', function () {
                  sessionStorage.setItem("affiliateExitModalShown", "true");
                });

                $(".exitDownloadLink").on("click", function(){
                  $("#downloadForm").hide();
                  $("#domainForm").show();
                });

                // scrollin navigation
                var didScroll;
                var lastScrollTop = 0;
                var delta = 5;
                var navbarHeight = $('header').outerHeight();

                setInterval(function() {
                    if (didScroll) {
                        hasScrolled();
                        didScroll = false;
                    }
                }, 250);

                function hasScrolled() {
                    var st = $(this).scrollTop();

                    // Make sure they scroll more than delta
                    if(Math.abs(lastScrollTop - st) <= delta)
                        return;

                    // If they scrolled down and are past the navbar, add class .nav-up.
                    // This is necessary so you never see what is "behind" the navbar.
                    if (st > lastScrollTop && st > navbarHeight){
                        // Scroll Down
                        $('header').removeClass('nav-down').addClass('nav-up');
                    } else {
                        // Scroll Up
                        if(st + $(window).height() < $(document).height()) {
                            $('header').removeClass('nav-up').addClass('nav-down');
                        }else{
                          // console.log($('div#blog_detail_processbar').width());

                            $('header').removeClass('nav-up').addClass('nav-down');

                        }
                    }

                    lastScrollTop = st;
                }

                // back to top
                $(".back-to-top").on('click', function () {
                  $("html, body").animate({scrollTop: 0}, 1000);
                });
                $(window).on('scroll', function(){
                    didScroll = true;
                    if ($(this).scrollTop() > 1000) {
                        $('.back-to-top').fadeIn();
                    } else {
                        $('.back-to-top').fadeOut();
                    }
                });

                //pricing toggle
                $("#planSwitch").click(function(){
                  if($(this).is(":checked")){
                    $(".starter-price").text("$114");
                    $(".hustler-price").text("$282");
                    $(".guru-price").text("$582");
                    $(".term-plan").text("/Year");
                  }
                  else{
                    $(".starter-price").text("$19");
                    $(".hustler-price").text("$47");
                    $(".guru-price").text("$97");
                    $(".term-plan").text("/Month");
                  }
                });
            });
        </script>

        <script defer="defer">
          $(document).ready(function(){
            var parentAction = window._webpushrPromptAction;
            window._webpushrPromptAction = async function(argument) {
              //your code
              await parentAction(argument);

              //webpushr custom attribute view_landingpage
              setTimeout(function(){
                webpushr('attributes',{"View Landing Page" : "True"});
              }, 5000);
            }
          });

          function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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
        </script>

        <script type="text/javascript">
            ire('identify', {customerId: '', customerEmail: ''});
        </script>

        <!-- Begin badge widget code -->
        <script>var script = document.createElement("script");script.type = "module";script.src = "https://widgets.thereviewsplace.com/2.0/rw-widget-badge1.js";document.getElementsByTagName("head")[0].appendChild(script);</script>

        <!-- Begin reviews widget code -->
        <script>var script = document.createElement("script");script.type = "module";script.src = "https://widgets.thereviewsplace.com/2.0/rw-widget-masonry.js";document.getElementsByTagName("head")[0].appendChild(script);</script>

        <!-- Begin all reviews widget code -->
        <script>var script = document.createElement("script");script.type = "module";script.src = "https://widgets.thereviewsplace.com/2.0/rw-widget-masonry.js";document.getElementsByTagName("head")[0].appendChild(script);</script>

         <!-- page script -->
        @yield('scripts')
    </body>
</html>
