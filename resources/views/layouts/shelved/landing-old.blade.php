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

        <!-- Fav icon ================================================== -->
        <link sizes="192x192" rel="shortcut icon" href="/images/debutify-favicon.png" type="image/png">

        <!-- Title and description ================================================== -->
        <title>@yield('title') – Debutify</title>
        <meta name="description" content="Easy plug & play setup. No coding. Get started in seconds.">

        <!-- Social meta ================================================== -->
        <meta property="og:site_name" content="Debutify">
        <meta property="og:url" content="https://debutify.com/">
        <meta property="og:title" content="Debutify - World\'s Smartest Shopify Theme. Free 14-day Trial">
        <meta property="og:type" content="website">
        <meta property="og:description" content="Easy plug & play setup. No coding. Get started in seconds.">
        <meta property="og:image" content="https://debutify.com/images/debutify-share.png">
        <meta property="og:image:secure_url" content="https://debutify.com/images/debutify-share.png">
        <meta name="twitter:site" content="@debutify">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Debutify - World\'s Smartest Shopify Theme. Free 14-day Trial">
        <meta name="twitter:description" content="Easy plug & play setup. No coding. Get started in seconds.">

        @if (config('env-variables.APP_TRACKING'))
        <script>
          window.dataLayer = window.dataLayer || [];
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-M5BFQ4Q');</script>
        <!-- End Google Tag Manager -->
        @endif

        <!-- App style -->
        <link rel="stylesheet" href="{{ asset('css/app-old.css?v='.config('env-variables.ASSET_VERSION')) }}">

				<style>
					@media (min-width: 576px){
						#downloadModal .modal-dialog {
						    max-width: 450px;
						}
					}
					.toggle-download-info{
						cursor: pointer;
					}
					.main-section .container{
						position:relative;
						z-index:1;
					}
					.toast-container{
						z-index:2;
					}
				</style>

        <!-- page style -->
        @yield('styles')

        <!-- Plugins style -->
        <link rel="stylesheet" href="{{ asset('css/cookiealert.css?v='.config('env-variables.ASSET_VERSION')) }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    </head>

    <body>
      <div class="body-wrapper">
        @if (config('env-variables.APP_TRACKING'))
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M5BFQ4Q"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        @endif

        <button class="btn btn-block btn-lg py-2 rounded-0 toggleModal btn-banner">Build a high converting store for free in seconds!</button>

        <!-- Navigation -->
        <nav id="menu" class="navbar navbar-expand-lg navbar-light site-header p-3" itemscope="" itemtype="http://schema.org/Organization">
          <div class="container-fluid">
            <a href="/" class="navbar-brand">
              <img class="logo default-logo" src="/images/landing/debutify-logo-dark.svg" width="200" alt="Debutify" itemprop="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar"
                    aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fas fa-bars"></span>
            </button>
            <div id="mainNavbar" class="collapse navbar-collapse justify-content-between">
                <ul class="navbar-nav flex-fill">
                    <li class="nav-item mt-3 mt-lg-0">
                      <a class="nav-link" href="/add-ons">
                        Add-Ons
                      </a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                      <a class="nav-link" href="/reviews">
                        Reviews
                      </a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                      <a class="nav-link" href="/faq">
                        FAQ
                      </a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                      <a class="nav-link" href="/contact">
                        Contact
                      </a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0">
                      <a class="nav-link" href="https://www.shopify.com/?ref=debutify&utm_campaign=website" target="_blank">
                        Shopify Free Trial
                      </a>
                    </li>
                    <li class="nav-item mt-3 mt-lg-0 ml-lg-auto">
                        <a href="https://debutifydemo.myshopify.com" target="_blank" class="nav-link">Demo Store</a>
                    </li>
                </ul>
                <div class="nav-item mt-3 mt-lg-0 ml-lg-2">
                    <button class="btn btn-primary btn-block toggleModal">
                      <span class="fas fa-bolt toggleModal"></span>
                        Free Download Now
                    </button>
                </div>
            </div>
          </div>
        </nav>

        <main role="main">
          @yield('content')

          <div class="section py-5 bg-grey border-top">
            <div class="container">
              <div class="row align-items-center text-center text-md-left">
                <div class="col-md-1 mb-3 mb-md-0">
                  <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website" target="_blank">
                    <img class="img-fluid lazyload" data-src="/images/shopify-icon.svg" width="100" alt="shopify">
                  </a>
                </div>
                <div class="col-md-7 mb-3 mb-md-0">
                  <h3>Open a Shopify Online Store For Free!</h3>
                  <p class="lead mb-0 text-muted">Sign up for a free Shopify 14-day trial and start selling today.</p>
                </div>
                <div class="col-md-4 text-md-right">
                  <div class="text-center d-inline-block">
                    <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website" target="_blank" class="btn btn-primary">Start your 14-Day free trial</a>
                    <br>
                    <small class="text-muted">Try Shopify for free. No credit card required.</small>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </main>

        <footer class="text-white footer bg-gradient text-center">
          <div class="section">
      			<div class="container">
  			      <div class="row">
  			        <div class="col-12 text-center">
                  <img data-src="/images/debutify-sales-shot.jpg" width="200" class="img-thumbnail rounded mb-3 lazyload" alt="Shopify sales">
  			          <h2>The world's #1 free shopify theme</h2>
  			          <p>Build a high converting Shopify store in minutes, not hours, without any technical knowledge at all.</p>
  			          <button class="btn btn-warning btn-lg btn-xl toggleModal animated pulse infinite">
                    <span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
  			            Free Download Now
  			          </button>
                  <div class="text-center mt-2">
                    <small class="font-weight-bold"><span class="fas fa-gift"></span> BONUS: Receive 5 Free winning products!</small>
                  </div>
                  <div class="px-2 py-1 mt-2 shopify-wrapper">
        						<small class="fas fa-circle text-danger animated flash infinite"></small>
                    <small class="font-weight-bold">{{$nbShops + 5248}}+</small>
        						<small>Live Downloads</small>
                  </div>
  			        </div>
  			      </div>
            </div>
          </div>

          <div class="section border-top py-5" style="border-color:rgba(255, 255, 255, 0.5)!important;">
            <div class="container-fluid">
              <a href="https://www.shopify.com/?ref=debutify&utm_campaign=website" target="_blank">
                <img src="/images/shopify-partner.png" alt="Shopify Partner" width="180">
              </a>
              <div class="row">
      					<div class="col">
      						<nav class="navbar navbar-expand navbar-dark justify-content-center">
      							<ul class="navbar-nav mb-0">
      	            	<li class="nav-item"><a class="nav-link" target="_blank" href="https://www.facebook.com/debutify/"><i class="fab fa-facebook fa-2x"></i></a></li>
                      <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.instagram.com/debutify/"><i class="fab fa-instagram fa-2x"></i></a></li>
                      <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w"><i class="fab fa-youtube fa-2x"></i></a></li>
                      <li class="nav-item tiktok"><a class="nav-link" target="_blank" href="https://www.tiktok.com/@debutify"><img src="/images/tiktok.svg" height="32" alt="debutify tiktok"></a></li>
      	            	<li class="nav-item"><a class="nav-link" target="_blank" href="https://twitter.com/debutify"><i class="fab fa-twitter fa-2x"></i></a></li>
                      <li class="nav-item"><a class="nav-link" target="_blank" href="https://www.pinterest.com/debutify"><i class="fab fa-pinterest fa-2x"></i></a></li>
                    </ul>
      						</nav>
      					</div>
      				</div>
      				<div class="row mb-3">
      					<div class="col">
      						<nav class="navbar navbar-expand navbar-dark justify-content-center">
      							<ul class="navbar-nav flex-wrap justify-content-center">
                      <li class="nav-item"><a class="nav-link" href="/theme">Theme</a></li>
                      <li class="nav-item"><a class="nav-link" href="/faq">FAQ</a></li>
                      <li class="nav-item"><a class="nav-link" href="/about">Meet the team</a></li>
                      <li class="nav-item"><a class="nav-link" href="/career">Career</a></li>
                      <li class="nav-item"><a class="nav-link" href="/pricing">Pricing</a></li>
                      <li class="nav-item"><a class="nav-link" href="/download">Download</a></li>
                      <li class="nav-item"><a class="nav-link" href="/affiliate">Affiliate</a></li>
                      <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li>
                      <li class="nav-item"><a class="nav-link" href="https://debutify.com/blog" target="_blank">Blog</a></li>
      								<li class="nav-item"><a class="nav-link" href="/terms">Terms of service</a></li>
      								<li class="nav-item"><a class="nav-link" href="/privacy">Privacy policy</a></li>
      							</ul>
      						</nav>
      					</div>
      				</div>
              <div class="row" style="opacity:0.5;">
                <div class="col">
                  <small>Copyright {{ now()->year }} Debutify Inc. All rights reserved.</small>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <nav class="navbar navbar-expand navbar-dark justify-content-center">
                    <ul class="navbar-nav flex-wrap justify-content-center">
                      <li class="nav-item">
                        <a class="nav-link" href="https://debutify.crisp.watch/en/" target="_blank">
                          <small class="fas fa-check-circle"></small>
                          System status
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
      			</div>
          </div>
    		</footer>

        <!-- Dowload Modal -->
        <div class="modal fade" id="downloadModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body p-md-4">

                <div class="text-center">
                  <a target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website" class="d-inline-block mb-3 mx-auto"><img src="/images/shopify-logo.png" width="120" alt="shopify"></a>
                </div>

                <!-- downloadForm -->
                <form id="downloadForm" class="form-horizontal" method="POST" action="">
                  <div class="form-group text-center">
                    <p class="mb-0 h6">Enter your name & email address.</p>
                  </div>
                  <div class="form-group text-left">
                    <input id="downloadName" required type="text" class="form-control form-control-lg" name="name" value="" placeholder="Name">
                  </div>
                  <div class="form-group text-left">
                    <input id="downloadEmail" required type="email" class="form-control form-control-lg" name="email" value="" placeholder="Email">
                  </div>
                  <button id="submitDownloadForm" type="submit" class="btn btn-primary btn-lg btn-block">
                    <span class="btn-text">
                      <span class="fas fa-bolt" aria-hidden="true"></span>
                      Free Download Now
                    </span>
                    <span class="btn-loading" style="display:none;">
                      <span class="fas fa-spin fa-spinner"></span>
                    </span>
                  </button>
                </form>

                <!-- domain form -->
                <form id="domainForm" class="form-horizontal" method="POST" action="{{ route('authenticate') }}" style="display:none;">
                  {{ csrf_field() }}
                  <div class="form-group text-center">
                    <h6 class="mb-0">Enter your shopify domain. <span class="fas fa-question-circle toggle-download-info text-muted"></span></label>
                  </div>
                  <div class="form-group">
                    <input class="form-control form-control-lg" required type="text" name="shop" id="shop" placeholder="storename.myshopify.com" onkeyup="this.value = this.value.toLowerCase();">
                  </div>
                  <button type="submit" class="btn btn-primary btn-lg btn-block dbtfy-addtocart">
                    <span class="fas fa-bolt dbtfy-addtocart" aria-hidden="true"></span>
                    Free Download Now
                  </button>
                  <button style="display: none;" disabled="disabled" type="button" class="btn btn-primary btn-lg btn-block download-loading">
                    <span class="fas fa-spin fa-spinner"></span>
                  </button>
                  <div class="small text-center mt-2">
                    Don't have a Shopify Store yet?<br class="d-block d-sm-none">
                    <a target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website">
                      Get Started Today!
                    </a>
                  </div>
                </form>

                <div class="mt-2 text-center">
      						<small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
                </div>

                <div class="p-3 rounded bg-grey download-info mt-3" style="display:none;">
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
											<a href="#" class="close-modal" onclick="$crisp.push(['do', 'chat:open'])">chat with us.</a>
										</strong>
								  </small>

                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Exit Modal -->
        <div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="downloadModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <div class="container-fluid p-0">
                  <div class="row align-items-center">
                    <div class="col-md-4 d-none d-md-flex">
                      <img src="/images/exit-intent.jpeg" alt="" width="100%" class="img-fluid rounded">
                    </div>
                    <div class="col-md-8 text-center">
                      <!-- exit form -->
                      <form id="exitForm" class="form-horizontal text-center" method="POST" action="">
                        <div class="form-group">
                          <p class="h1">Don't leave yet!</p>
                          <p class="lead">Subscribe and Download Five $1,000,000 Winning Products Chosen by 7 Figure Entrepreneur Ricky Hayes.</p>
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
                        <a href="#" class="toggleModal exitDownloadLink" data-dismiss="modal">Get Debutify theme 100% Free here</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Cookie Box -->
        <div class="alert alert-dismissible text-center cookiealert" role="alert">
          <div class="cookiealert-container">
              <b>Do you like cookies?</b> &#x1F36A; We use cookies to ensure you get the best experience on our website. <a href="http://cookiesandyou.com/" target="_blank">Learn more</a>
              <button type="button" class="btn btn-primary btn-sm acceptcookies" aria-label="Close">
                  I agree
              </button>
          </div>
        </div>

        <!-- App js -->
        <script src="{{ asset('js/app.js?v='.config('env-variables.ASSET_VERSION')) }}"></script>

        <!-- lazysizes -->
        <script src="{{ asset('js/lazysizes.min.j?v='.config('env-variables.ASSET_VERSION')) }}"></script>

        <!-- Start of Async ProveSource Code --><script>!function(o,i){window.provesrc&&window.console&&console.error&&console.error("ProveSource is included twice in this page."),provesrc=window.provesrc={dq:[],display:function(o,i){this.dq.push({n:o,g:i})}},o._provesrcAsyncInit=function(){provesrc.init({apiKey:"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2NvdW50SWQiOiI1ZGNjNTRlZmQxYzE0NTQzNDQzYjg3MmMiLCJpYXQiOjE1NzM2NzIxNzV9.fsXrgarvaQELgyPxn4HIvF0-pP9YR6YoXe-lXIlXBI0",v:"0.0.3"})};var r=i.createElement("script");r.type="text/javascript",r.async=!0,r["ch"+"ar"+"set"]="UTF-8",r.src="https://cdn.provesrc.com/provesrc.js";var e=i.getElementsByTagName("script")[0];e.parentNode.insertBefore(r,e)}(window,document);</script><!-- End of Async ProveSource Code -->

        <!-- exit intent -->
        <script src="/js/jquery.exitintent.min.js?v=".config('env-variables.ASSET_VERSION')></script>

        <!-- jquery validate -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>

        <!-- crisp -->
        <script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="06fc7d7b-6235-4972-8b15-033f45837454";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>

        <!-- OutplayHQ -->
        <script>
          (function(o, u, t, p, l, a, y, _, h, q) {
            if (!o[p] || !o[p]._q) {
              for (; _ < y.length; ) l(a, y[_++]);
              q = u.getElementsByTagName(t)[0];h = u.createElement(t);h.async = 1;
              h.src = "https://us1-cx.outplayhq.com/js/build.min.js";q.parentNode.insertBefore(h, q);o[p] = a;
            }
          })(window,document,"script","outplayhq",function(g, r) {
            g[r] = function() {
              g._q.push([r, arguments]);
            };
          },{ _q: [], _v: 1 },["init"],0);
          outplayhq.init("e515096f683a07731ee96b382d524557");
        </script>

        <script>
          $(document).ready(function(){
            // hide crisp chatbox for outplayHQ leads
            if (window.location.href.indexOf("ophqt=") > -1) {
              $crisp.push(['do', 'chat:hide']);
            }

            // crisp segments
            $crisp.push(["set", "session:segments", [["website"]]])

            @if (config('env-variables.APP_TRACKING'))
            //landing page view tracking
            $(document).ready(function() {
              if(sessionStorage.getItem("landingPageView")){} else{
                window.dataLayer.push({'event': 'landing_page_view'});
                sessionStorage.setItem('landingPageView','yes');
                //webpushr custom attribute intiate_download
                webpushr('attributes',{"View Content" : "True"});
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
            $(".toggleModal").click(function(){
              $('#downloadModal').modal('show');
            });

            // close download modal
            $(".close-modal").click(function(){
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
              };
              @endif
            });

            // more info content on download modal
            $(".toggle-download-info").click(function(){
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

                @if (config('env-variables.APP_TRACKING'))
                //webpushr custom attribute complete_registration
			          webpushr('attributes',{"Complete Registration" : "True"});
                //complete registration tracking
                window.dataLayer.push({'event': 'complete_registration'});
                @endif

                form.submit();
              }
            });

            // trigger exit intent modal
            $.exitIntent("enable");
            $(document).bind("exitintent", function() {
              openExitIntent();
            });
            $(window).blur(function(e) {
              if($("iframe").is(":focus")){} else{
                openExitIntent();
              }
            });

            function openExitIntent(){
              if(sessionStorage.exitModalShown){} else{
                if($("#downloadModal").hasClass("show")) {} else{
                  $('#exitModal').modal('show');
                }
              }
            }

            $('#exitModal').on('shown.bs.modal', function () {
              $("#exitName").trigger('focus');
              sessionStorage.setItem("exitModalShown", "true");
            });

            $(".exitDownloadLink").on("click", function(){
              $("#downloadForm").hide();
              $("#domainForm").show();
            });

          });
        </script>

        <!-- page script -->
        @yield('scripts')
    </div>
  </body>
</html>
