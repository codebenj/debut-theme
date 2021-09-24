<!DOCTYPE html>
<html lang="en">
<head>
  {{-- Meta Tags --}}
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="theme-color" content="#5600e3">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="author" content="Debutify">
  <meta name="description" content="@yield("description")">
  @if(config('env-variables.BLOCK_CRAWLER')) <meta name="robots" content="noindex">   @endif
  <meta property="og:site_name" content="Debutify">
  <meta property="og:url" content="{{ isset($seo_url) ? 'https://debutify.com/'.$seo_url.'/' : 'https://debutify.com/' }}">
  <meta property="og:title" content="{{ isset($seo_title) ? $seo_title : 'Debutify - World\'s Smartest Shopify Theme. Free 14-day Trial' }}">
  <meta property="og:type" content="{{ isset($seo_url) ? 'article' : 'website' }}">
  <meta property="og:description" content="{{ isset($seo_description) ? $seo_description : 'Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today' }}">
  <meta property="og:image" content="{{ isset($seo_feature_image) ? $seo_feature_image : asset('images/debutify-share.jpg') }}">
  <meta property="og:image:secure_url" content="{{ isset($seo_feature_image) ? $seo_feature_image : asset('images/debutify-share.jpg') }}">
  @if(isset($schema_data))
  <meta property="article:published_time" content="{{$schema_data['created_at']}}" />
  <meta property="article:modified_time" content="{{$schema_data['updated_at']}}" />
  <meta property="og:image:width" content="{{$schema_data['width']}}" />
  <meta property="og:image:height" content="{{$schema_data['height']}}" />
  @endif
  <meta name="twitter:site" content="@debutify">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ isset($seo_title) ? $seo_title : 'Debutify - World\'s Smartest Shopify Theme. Free 14-day Trial' }}">
  <meta name="twitter:description" content="{{ isset($seo_description) ? $seo_description : 'Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today' }}">
  <title>@yield("title")</title>

  {{-- Link Tags --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <link rel="canonical" href="https://debutify.com/">

  <link rel="shortcut icon" href="/images/debutify-favicon.png" sizes="192x192" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" >
  <link rel="stylesheet" href="{{ asset('css/landing.css?v='.config('env-variables.ASSET_VERSION')) }}" >
  @yield('styles')


  <script>
    var debutify_app_tracking = "{{config('env-variables.APP_TRACKING')}}";
    var debutify_app_impact =  "{{config('env-variables.IMPACT_ENABLED')}}";
    var debutify_current_page = "{{Route::current() ? Route::current()->getName() : '' }}";
    var debutify_resources = {show:false};
    var recaptcha_site_key = "{{ config('services.recaptcha.site_key') }}";


  // Google Tag Manager
  if(debutify_app_tracking){
    window.dataLayer = window.dataLayer || [];
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
      {'gtm.start':new Date().getTime(),event:'gtm.js'});
      var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';
      j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-M5BFQ4Q');
  }

  </script>


</head>

<body>
  @if (config('env-variables.APP_TRACKING'))
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5BFQ4Q" height="0" width="0" style="display:none;visibility:hidden">
    </iframe>
  </noscript>
  @endif

  @if (!Request::is('login'))
  <header>
    @yield('announcement')
  </header>

  <nav class="navbar navbar-expand-lg navbar-light bg-white smart-scroll sticky-top fixed-top" itemscope="" itemtype="http://schema.org/Organization" style="min-height: 71px">
    <div class='container' id='debutify-navbar' style="display:none" >
      <a class="navbar-brand " href="/">
        <img src="/images/landing/debutify-logo-dark.svg" width="180" height="46"  alt="Debutify Logo" >
      </a>
      <button class="navbar-toggler border-0" aria-label="toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <img class='d-inline-block' src="/images/landing/icons/icon-bars.svg" width="40" height="40" alt="Mobile-nav-abr" >
      </button>

      <div class="collapse navbar-collapse" id="collapsibleNavbar" >
       <ul class="navbar-nav mx-auto navbar-nav-scroll">
          <li class="nav-item">
            <a class="nav-link " href="/reviews"> Reviews </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://debutifydemo.myshopify.com/"> Demo Store </a>
          </li>

         <x-landing.nav-dropdown
          id='Resources'
          label='Resources'
          :links="[
          ['link'=>'/blog','icon'=>'blog','label'=>'Blog'],
          ['link'=>'/podcast','icon'=>'podcast','label'=>'Podcast'],
          ['link'=>'/video','icon'=>'video','label'=>'Videos'],
          ]"
          />


          <x-landing.nav-dropdown
          id='moreLinks'
          label='More Links'
          :links="[
          ['link'=>'/pricing','icon'=>'pricing', 'label'=>'Pricing'],
          ['link'=>'/theme','icon'=>'theme','label'=>'Theme'],
          ['link'=>'/add-ons','icon'=>'addons','label'=>'Add-Ons'],
          ['link'=>'/contact','icon'=>'contact','label'=>'Contact'],
          ['link'=>'/affiliate','icon'=>'affiliate','label'=>'Affiliate'],
          ['link'=>'/integrations','icon'=>'partners','label'=>'Integrations'],
          ['link'=>'https://feedback.debutify.com/','target'=>'_blank','icon'=>'roadmap','label'=>'Roadmap'],
          ['link'=>'https://help.debutify.com/en/','target'=>'_blank','icon'=>'helpcenter','label'=>'Help center'],
          ]"
          />

        </ul>

        <ul class='navbar-nav'>
          <li class="nav-item">
            <a class="nav-link text-primary"  href="/login"> Login </a>
          </li>
          <x-landing.download-btn class='btn-primary btn-sm debutify-hover' cta='X' />
        </ul>

      </div>
    </div>
  </nav>

  <div class="progress-header fixed-top">
    <div class="progress-container">
      <div class="progress-bar bg-primary" id="resource-progress-bar" style="width: 0%"></div>
    </div>
  </div>

  @endif

  <main role="main">
    @yield('content')
  </main>

  @if (!Request::is('login'))

  {{-- This is Important --}}
  <div data-rw-badge1="20434" class="d-none debutify-badge1"></div>
    <div class="modal fade" id="videoModal">
      <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content rounded ">
          <div class="modal-body rounded">
            <button data-dismiss="modal" class="close-modal" style="right:-20px;top:-20px;">
              <i class='fas fa-times'></i>
            </button>
            <div class="embed-responsive embed-responsive-16by9">
              <iframe id='videoPlayer' src="" class='rounded border-0' allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>

  {{-- <div class="modal fade" id="wistiaVideoModal">
    <div class="modal-dialog modal-dialog-centered ">
      <div class="modal-content rounded ">
        <div class="modal-body rounded">
          <button data-dismiss="modal" class="close-modal" style="right:-20px;top:-20px;">
            <i class='fas fa-times'></i>
          </button>
          <div id="wistia_video_content" style="min-height: 380px;"></div>
        </div>
      </div>
    </div>
  </div> --}}

  <div class='modal fade' id="defaultExitIntentModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content bg-primary">
        <div class='modal-body'>
          <button data-dismiss="modal" class="close-modal">
            <img class="lazyload  d-inline-block" data-src="/images/landing/icons/icon-modal-cross.svg" alt="icon cross" width="16" height="16"/>
          </button>
          <h3 class='text-center font-weight-lighter text-white mt-5'>
            <span class='font-weight-bold'>FREE PDF: Five $1,000...</span><br>
          </h3>
          <h2 class='text-center font-weight-lighter text-white'><b>WINNING PRODUCTS</b></h2>
          <h3 class='text-center font-weight-lighter text-white'>
          Chosen by 7 Figure Entrepreneur <br>
          <b>Ricky Hayes</b></h3>
          <img class='lazyload d-block mx-auto img-fluid' data-src="/images/landing/modal-book.png" alt="">
          <div class='row justify-content-center mb-5'>
            <div class='col-lg-7'>
              <form id='defaultExitdownloadForm'>
                <div class='form-group text-white'>
                  <div class="input-group ">
                    <div class="input-group-prepend">
                      <label class='input-group-text ' for="defaultExitdownloadFormName">
                        <img class="lazyload  d-inline-block" data-src="/images/landing/icons/icon-user.svg" alt="icon cross" width="22" height="22" />
                      </label>
                    </div>
                    <input id="defaultExitdownloadFormName"  name="name" type="text" class="form-control border-left-0 pl-0"  placeholder="Enter your name"  required>
                  </div>
                </div>
                <div class='form-group text-white'>
                  <div class="input-group mt-2">
                    <div class="input-group-prepend">
                      <label class='input-group-text' for="defaultExitdownloadFormEmail">
                        <img class='lazyload  d-inline-block' data-src="/images/landing/icons/icon-Envelope.svg" alt="" width="22" height="22">
                      </label>
                    </div>
                    <input  id="defaultExitdownloadFormEmail" name="email" type="email" class="form-control border-left-0 pl-0" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" placeholder="Enter your best email" required>
                  </div>
                </div>
                <button type="submit" class='btn btn-secondary btn-block my-3 debutify-hover'>
                  Try Debutify Free
                </button>
                <div class="custom-control custom-checkbox text-white">
                  <input type="checkbox" class="custom-control-input" id="defaultExitdownloadFormCheckbox" name="" required>
                  <label class="custom-control-label " for="defaultExitdownloadFormCheckbox"> I agree to receive regular updates from Debutify. <a href="/privacy-policy" class='text-secondary'>View Privacy Policy here.</a> </label>
                </div>
              </form>
              <div id='defaultThankYou' class='text-center text-white' style="display: none">
                <h1 class='text-white'>Thank you!</h1>
                <p>Please check your email inbox for a special surprise.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="downloadModal" >
    <div class="modal-dialog align-items-end align-items-md-center modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-block p-0 bg-primary">
          <div class='responsive-container ' style="padding-bottom:34.48%; min-height:250px;">
          <img class='lazyload w-100' data-src="/images/landing/download-header.svg" alt="download-header">
        </div>
        <div class='text-center position-absolute w-100'  style="top:13%">
        <img class='lazyload img-fluid' data-src="/images/landing/modal-banner.png" alt="modal" >
       </div>
        <img class='lazyload position-absolute' data-src="/images/landing/debutify-logo-light.svg" width="170"  alt="Debutify Logo" style="top:30px; left:30px;">
          <button data-dismiss="modal" class="close-modal">
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-modal-cross.svg" alt="icon cross" width="16" height="16"/>
          </button>
        </div>
        <div class="modal-body">
            <div class="trustpilot-widget pt-4" data-locale="en-US" data-template-id="5419b6ffb0d04a076446a9af" style="height: 20px" data-businessunit-id="5e8cc7b101c8d800012b308a" data-style-height="20px" data-style-width="100%" data-theme="light">
              <a href="https://www.trustpilot.com/review/debutify.com" target="_blank" rel="noopener"></a>
            </div>
          <div class='row justify-content-center'>
            <div class='col-lg-8'>
              <form id='downloadForm'>
                <h4 class='text-center my-4'> Enter your first name and email address </h4>
                  <div class='form-group'>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class='input-group-text ' for="downloadFormName">
                          <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-user.svg" alt="icon cross" width="22" height="22" />
                        </label>
                      </div>
                      <input id="downloadFormName"  name="name" type="text" class="form-control border-left-0 pl-2"  placeholder="John" required>
                    </div>
                  </div>
                  <div class='form-group'>
                    <div class="input-group mt-2">
                      <div class="input-group-prepend">
                        <label class='input-group-text' for="downloadFormEmail">
                          <img class='lazyload d-inline-block' data-src="/images/landing/icons/icon-Envelope.svg" alt="" width="22" height="22">
                        </label>
                      </div>
                      <input  id="downloadFormEmail" name="email" type="email" class="form-control border-left-0 pl-2" pattern='^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$' placeholder="john@gmail.com" required>
                    </div>
                  </div>

                <button type="submit" class='btn btn-primary btn-block my-3 debutify-hover'>
                  Try Debutify Free <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-right-arrow.svg"  alt="icon right arrow" width="30" height="30">
                </button>

                <div class="alert alert-primary text-center rounded-pill mt-2" >
                  🎁 BONUS: Receive 5 Free Winning Products
                </div>
              </form>

              <form id='domainForm' action="{{route('authenticate')}}"  target="_blank" style="display: none">
                {{ csrf_field() }}
                <h4 class='text-center my-4'> Enter your shopify domain.</h4>
                <div class="form-group">
                  <input class="form-control"  type="text" name="shop" placeholder="storename.myshopify.com" onkeyup="this.value = this.value.toLowerCase();" pattern=".+myshopify.com" title="storename.myshopify.com" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  Try Debutify Free
                </button>
                <div class="alert alert-success text-center small rounded-pill mt-3">
                  To install Debutify theme, an active Shopify store is required. Don't have one yet?<br class="d-block d-sm-none">
                  <a class="text-primary" target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website-modal-get-started">
                    <u> Start your 14-Day free trial</u>
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>

        {{-- <div class='modal-footer d-flex justify-content-center' style="background:rgb(127, 205, 255,.06)">
          <div>
            <p class='text-black font-weight-light'> What our {{$nbShops??''}}+ customers say </p>
            <div data-rw-inline="22067"></div>
          </div>
        </div>   --}}
      </div>
    </div>
  </div>

  <section class='debutify-section bg-light'>
    <div class='container'>
      <div class='row'>
        <div class='col-lg-5'>
          <div class='responsive-container-4by3'>
          <img class='lazyload' data-src="/images/landing/footer-cta-animated-v3.svg?v=1.00" alt="footer cta">
          </div>
        </div>
        <div class='col-lg-7 '>
          <div class='text-lg-left text-center'>
            <h1 class='text-dark'>Start Selling <span class='debutify-underline-sm'>Today</span> </h1>
            <p class='my-4 lead text-dark'> Join the ranks of smart ecommerce owners. Launch a wildly successful store today, only with Debutify. </p>
          </div>
          <x-landing.cta cta='X' download='btn-primary' checklist='0' demo='btn-outline-secondary'/>
        </div>
      </div>
    </div>
  </section>

  <footer class='bg-dark'>
    <div class='container pt-4 pb-3'>
      <div class='row'>
        <div class='col-lg-6'>
          <div class='d-flex align-items-center'>
            {{-- <object class='img-fluid lazyload mr-3 pointer-none'  id='footerLetter' width="80"  data-object="/images/landing/subscribe-prop-v2.svg" type="image/svg+xml"></object> --}}
            <img class='lazyload mr-3'  width="83" height="58" data-src="/images/landing/graph_mail.svg"/>
            <p class='lead text-footer '>
              {{$nbShops??0?$nbShops.'+':'Numerous'}} brand owners reading the Debutify newsletter
            </p>
          </div>
        </div>
        <div class='col-lg-6'>
          <form id='footerNewsletter' class='text-white'>
            <div class='form-row justify-content-center no-gutters position-relative'>
              <div class='col-lg-9'>
                <div class="form-group">
                  <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                      <label class='input-group-text' style="padding-right: 0;width:35px;">
                        <img class='lazyload mr-2 d-inline-block' data-src="/images/landing/icons/icon-Envelope.svg" alt="icon Envelope" width="20" height="20">
                      </label>
                    </div>
                    <input type="email" class='border-left-0 form-control form-control-sm' placeholder="Enter your email address" name='email' pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required >
                  </div>
                </div>
              </div>
              <div class='col-lg-3'>
                <button type="submit" class=" btn btn-primary btn-sm btn-block mb-2 debutify-hover"> Subscribe </button>
              </div>
              <div class='col-lg-12'>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="footerNewsletterCheckbox" name=""  required>
                  <label class="custom-control-label" for="footerNewsletterCheckbox">
                    <small class='text-footer'> I agree to receive regular updates from Debutify. <a href="/privacy-policy" class='text-white'>View Privacy Policy here.</a></small>
                  </label>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <hr style="border-bottom:1px solid rgba(255, 255, 255, 0.5);">

      <div class='row mt-4'>
        <div class='col-12 col-lg-4'>
          <div class='text-lg-left text-center'>
            <img class='lazyload' data-src="/images/landing/debutify-logo-light.svg" width="167" height="42" alt="Debutify Logo">
            <ul class="nav mt-4 mb-4 justify-content-lg-start justify-content-center">
              @foreach ([
              ['icon'=>'footer-facebook','link'=>'https://www.facebook.com/debutify'],
              ['icon'=>'footer-instagram','link'=>'https://www.instagram.com/debutify'],
              ['icon'=>'footer-youtube','link'=>'https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w'],
              ['icon'=>'footer-tiktok','link'=>'https://www.tiktok.com/@debutify'],
              ['icon'=>'footer-twitter','link'=>'https://twitter.com/debutify'],
              ['icon'=>'footer-pintrest','link'=>'https://www.pinterest.com/debutify'],
              ['icon'=>'footer-linkdin','link'=>'https://www.linkedin.com/company/debutify'],
              ] as $item)
              <li class="nav-item">
                <a class="nav-link p-0 mr-2 " target="_blank" href="{{$item['link']}}">
                  <!-- <div class='text-dark rounded-circle d-flex justify-content-center align-items-center'  style="width:28px;height:28px;background-color: #A9B0BA"> -->
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-{{$item['icon']}}.svg" alt="social icon" width="30" height="30">
                  <!-- </div> -->
                </a>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class='col-lg-8'>
          <div class='row'>
            @foreach (
            ['Product'=>[
            ['label'=>'Theme','link'=>'/theme'],
            ['label'=>'Add-Ons','link'=>'/add-ons'],
            ['label'=>'Pricing','link'=>'/pricing'],
            ['label'=>'Download','link'=>'/download'],
            ['label'=>'Courses','link'=>'/courses'],
            ],'Company'=>[
            ['label'=>'About Us','link'=>'/about-us'],
            ['label'=>'Meet the team','link'=>'/about'],
            ['label'=>'Careers','link'=>'/career'],
            ['label'=>'Affiliate Program','link'=>'/affiliate'],
            ['label'=>'Integrations','link'=>'/integrations']
            ],'Resources'=>[
            ['label'=>'Blog','link'=>'/blog'],
            ['label'=>'Podcast','link'=>'/podcast'],
            // ['label'=>'Webinar','link'=>'/webinar'],
            ['label'=>'Videos','link'=>'/video'],
            ['label'=>'Roadmap','link'=>'https://feedback.debutify.com/','target'=>'_blank'],
            ],'Support'=>[
            ['label'=>'Contact Us','link'=>'/contact'],
            ['label'=>'FAQ','link'=>'/faq'],
            ['label'=>'Help Center','link'=>'https://intercom.help/debutify/en/','target'=>'_blank'],
            // ['label'=>'Feedback','link'=>'https://feedback.debutify.com/','target'=>'_blank'],
            // ],'Other Information'=>[
            // ['label'=>'Login','link'=>'/login'],

            ]] as $key => $footerLinks)

            <div class='col-6 col-lg-3'>
              <ul class="nav flex-column mb-3">
                <li class="nav-item">
                  <span class="nav-link text-white font-weight-bolder py-1">
                    {{$key}}
                  </span>
                </li>

                @foreach($footerLinks as $footerLink)
                <li class="nav-item">
                  <a class="nav-link py-1 text-footer {{$footerLink['class']??''}}" target="{{$footerLink['target']??''}}" href="{{$footerLink['link']}}">
                    <small>{{$footerLink['label']}}</small>
                  </a>
                </li>
                @endforeach
              </ul>
            </div>
            @endforeach

          </div>
        </div>
      </div>

      <hr style="border-top:1px solid rgba(255, 255, 255, 0.5);">

      <ul class="nav align-items-center justify-content-center text-lg-left text-center">
        <li>
          <div class="nav-link text-footer">
            <small class="copyright">
              <span>Copyright 2021 Debutify Inc.</span> <span>All rights reserved.</span>
            </small>
          </div>
        </li>
        <li class="nav-item mx-auto">
          <div class='nav-link text-footer'>
            <small>
              <a class='text-footer text-decoration-none' href="/terms-of-use">Terms of Use</a>
              <span class='mx-1'>|</span> <a class='text-footer text-decoration-none' href="/privacy-policy">Privacy Policy</a>
            </small>
          </div>
        </li>
        <li class="nav-item ">
          <a class="nav-link text-footer pr-1" href="https://www.shopify.com/free-trial?ref=debutify&utm_campaign=website-shopify-partners" target="_blank">
            <img class='lazyload' data-src="/images/landing/shopify-partner.png" alt="">
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-footer pr-1" href="https://www.dmca.com/Protection/Status.aspx?ID=55794deb-0c7a-4eaf-aad0-7d610f9e6413&refurl=https://debutify.com/affiliate" target="_blank">
            <img class='lazyload' data-src="/images/landing/dmca.png" alt="">
          </a>
        </li>
      </ul>
    </div>
  </footer>

  @endif

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

  <script src="{{ asset('js/landing.js?v='.config('env-variables.ASSET_VERSION')) }}" defer></script>
  @yield('scripts')
</body>
</html>
