@extends('layouts.landing')

@section('title',"Debutify - World's Smartest Shopify Theme. Free 14-day Trial")

@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('styles')
@endsection

@section('content')
<div class="homepage">
    <div class="angle-wrapper">
        <!-- section above-the-fold -->
        <section class="above-fold-section section">
          <div class="container get-sells-section">
            <div class="row text-center mb-3">
              <div class="col-12">
                <h1 class="">Get The Highest-Converting FREE Shopify Theme For Aspiring Millionaires 💸</h1>
              </div>
            </div>

            <div class="row align-items-center">
              <div class="col-lg-7 mb-3 mb-lg-0">
                <div class="embed-responsive embed-responsive-16by9 mb-3">
                  <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/jyADqBzVkHQ?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="card">
                  <div class="card-body">
                    <div class="row text-center">
                      <div class="col">
                        <span class="fas fa-funnel-dollar fa-2x text-primary"></span>
                        <p class="small mb-0">40+ conversion hack Add-Ons to get more sales</p>
                      </div>
                      <div class="col">
                        <span class="fas fa-tachometer-alt fa-2x text-primary"></span>
                        <p class="small mb-0">Fast & mobile-optimized out of the box</p>
                      </div>
                      <div class="col">
                        <span class="fas fa-graduation-cap fa-2x text-primary"></span>
                        <p class="small mb-0">Step-by-step courses to build a 7-figure store</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-5 text-center">
                <p class="">Tired of making dropshipping work - or just starting out? You could join the ranks of successful dropshippers working a few hours a day, making thousands of dollars a month... Debutify, the best free Shopify theme, will help you get there.</p>
                @include ("components.download-wrapper")
              </div>
            </div>

          </div>
        </section>

        <hr>

        <!-- section featured -->
        <section class="featured-section section py-5">
            <div class="container">
                <div class="row text-center align-items-center">
                    <div class="col-12">
                      <p class="lead"><strong>As Featured On:</strong></p>
                    </div>
                    <div class="col-4 col-lg mb-5 mb-lg-0">
                        <a target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website-featured-logo">
                            <img class="lazyload img-fluid" data-src="/images/shopify-logo.png" width="200" alt="shopify">
                        </a>
                    </div>
                    <div class="col-4 col-lg mb-5 mb-lg-0">
                        <img class="lazyload img-fluid" data-src="/images/oberlo-logo.png" width="200" alt="oberlo">
                    </div>
                    <div class="col-4 col-lg mb-5 mb-lg-0">
                        <img class="lazyload img-fluid" data-src="/images/spocket-logo.svg" width="200" alt="spocket">
                    </div>
                    <div class="col-4 col-lg">
                        <img class="lazyload img-fluid" data-src="/images/techstars-logo.png" width="200" alt="techstars">
                    </div>
                    <div class="col-4 col-lg">
                        <img class="lazyload img-fluid" data-src="/images/betakit-logo.png" width="200" alt="betakit">
                    </div>
                    <div class="col-4 col-lg">
                        <img class="lazyload img-fluid" data-src="/images/geekwire-logo.png" width="200" alt="geekwire">
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- section trusted by -->
        <section class="trusted-section section">
          <div class="bg-angle"></div>

          <div class="container">
              <div class="row mb-3">
                  <div class="col-lg-10 offset-lg-1 text-center">
                      <h2>🏆 Trusted by Leading<br class="d-none d-md-block"> E-Commerce Entrepreneurs</h2>
                  </div>
              </div>
              <div class="row">
                  <div class="col">
                      <div class="card-deck text-center">
                          <div class="card mb-3 animated slow infinite upAndDown">
                              <div class="card-body">
                                  <img data-src="images/new/marc.png" class="img-fluid rounded-circle mb-3 lazyload" alt="" />
                                  <p>"...everything you need <strong>to succeed</strong>"</p>
                                  <p class="text-muted small"><span class="">- Marc Chapon,</span><br class="d-none d-md-block"> 7-figure entrepreneur & youtuber</p>
                              </div>
                          </div>
                          <div class="card mb-3 animated slow infinite upAndDown delay-1">
                              <div class="card-body">
                                  <img data-src="images/new/sharif.png" class="img-fluid rounded-circle mb-3 lazyload" alt="" />
                                  <p>"...fantastic, <strong>ultra-high-converting</strong> free theme"</p>
                                  <p class="text-muted small"><span class="">- Sharif Mohsin,</span><br class="d-none d-md-block"> 7-figure entrepreneur & youtuber</p>
                              </div>
                          </div>
                          <div class="w-100 d-lg-none"></div>
                          <div class="card mb-3 animated slow infinite upAndDown delay-2">
                              <div class="card-body">
                                  <img data-src="images/new/kamil.png" class="img-fluid rounded-circle mb-3 lazyload" alt="" />
                                  <p>"...generated over <strong>$7M in 2-3 months</strong>"</p>
                                  <p class="text-muted small"><span class="">- Kamil Sattar "the ecom king"</span><br class="d-none d-md-block"> 7-figure entrepreneur & Youtuber</p>
                              </div>
                          </div>
                          <div class="card mb-3 animated slow infinite upAndDown delay-3">
                              <div class="card-body">
                                  <img data-src="images/new/james.png" class="img-fluid rounded-circle mb-3 lazyload" alt="" />
                                  <p>"...about <strong>5% conversion rate</strong> on a new store"</p>
                                  <p class="text-muted small"><span class="">- James Beattie,</span><br class="d-none d-md-block"> ceo, ecom insiders 7-figure entrepreneur</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </section>
    </div>


    <!-- section tired -->
    <section class="tired-section section py-0">
        <div class="bg-gradient py-5 text-white section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>⏰ Are You Tired of Getting 0 Sales?
                          Tired Of Your 9-to-5 Job?
                          Or Just Starting Out, And Don't Know Which Theme to Use?
                        </h2>
                        <p class="mb-0">
                            Discover how you could build a <strong>thriving e-com business</strong> (and live a luxurious life) with <strong>no marketing knowledge,
                            no Shopify knowledge, no programming knowledge</strong> and without breaking the bank… with a copy-paste <strong>"blueprint for success"</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- section dropshipping -->
    <section class="dropshipping-section section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-12 text-center">
                    <h2>Only For Shopify Dropshipping, Print-On-Demand & Brand Stores <span>That Want Sales, Now  👇</span></h2>
                    <p class="lead">See How Debutify Can Buff Your Store — Live Demo Store</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col text-center">
                    <a href="https://debutifydemo.myshopify.com" target="_blank">
                        <span class="fa fa-eye fa-5x text-primary icon-hover"></span>
                        <img data-src="images/new/debutify-demo.png" alt="" class="img-fluid rounded shadow debutify-demo-img lazyload" />
                    </a>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <p class="lead">Launch your e-commerce empire today. <strong>Download the Debutify theme for free.</strong><br class="d-none d-md-block">
                        Install & set up on your store in 1 click. No experience or coding skills needed.</p>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    @include ("components.download-wrapper")
                </div>
            </div>
        </div>
    </section>

    <!-- section addons -->
    <section class="section-addons section bg-gradient text-white">
      <div class="container text-center">
        <div class="row mb-3">
            <div class="col-lg-10 offset-lg-1">
                <h2>🚀 Convert Traffic Into Buyers <br class="d-none d-md-block">With Battle-Tested Sales Hacks</h2>
                <p class="lead">Buff your store with {{$nbAddons}}+ tested e-commerce sales boosters.<br class="d-none d-md-block"> Get more orders, increase your conversion rate <strong>and make more cash.</strong></p>
            </div>
        </div>
        <div class="row align-items-end">
          @foreach($global_add_ons as $addon)
            @if($loop->iteration < 9)
            <div class="col-6 col-lg-3 mb-3">
                <p class="mb-2"><strong>{{ $addon->title }}</strong></p>
                <div class="img-wrapper" data-toggle="modal" data-target="#videoModal" data-title="{{ $addon->title }}" data-subtitle="{{ $addon->subtitle }}">
                    <span class="fab fa-youtube fa-3x text-primary icon-hover"></span>
                    @include("components.image-addons")
                </div>
            </div>
            @endif
          @endforeach
        </div>
        <div class="row collapse align-items-end" id="collapseAddon">
          @foreach($global_add_ons as $addon)
            @if($loop->iteration > 8)
            <div class="col-6 col-lg-3 mb-3">
                <p class="mb-2"><strong>{{ $addon->title }}</strong></p>
                <div class="img-wrapper" data-toggle="modal" data-target="#videoModal" data-title="{{ $addon->title }}" data-subtitle="{{ $addon->subtitle }}">
                    <span class="fab fa-youtube fa-3x text-primary icon-hover"></span>
                    @include("components.image-addons")
                </div>
            </div>
            @endif
          @endforeach
        </div>
        <a class="btn btn-outline-light btn-block mb-3" data-toggle="collapse" href="#collapseAddon" role="button" aria-expanded="false" aria-controls="collapseAddon">
          Show all {{$nbAddons}} Add-Ons
          <span class="fas fa-caret-down"></span>
        </a>
        <div class="row mb-3">
            <div class="col-lg-10 offset-lg-1 text-center">
                <p class="lead">Create your dropshipping empire. <strong>Say YES</strong> to the life of your dreams. <br class="d-none d-md-block">
                  Why procrastinate -- Download the Debutify template <strong>FREE</strong> and launch in 1 click.</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                @include ("components.download-wrapper")
            </div>
        </div>
      </div>
    </section>

    <div class="angle-wrapper">

        <!-- section no coding -->
        <section class="no-coding-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>💻 No Coding, Website design  <br class="d-none d-md-block">or Shopify Experience Needed</h2>
                        <p class="lead">Debutify makes things simple. Launch your store in a few clicks,<br class="d-none d-md-block"> with all the features you need to succeed already built-in.</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                      <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item lazyload" width="560" height="315" data-src="https://www.youtube.com/embed/vO13Xm1Fmn8?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <p>Use the visual editor to customize your store as much as you want, or go with pre-configured settings. Either way, you'll be up and running with the perfect look and all Add-Ons in minutes.</p>
                    </div>
                </div>
                <div class="row features rounded font-weight-bold">
                    <div class="col-sm-6 col-md-4 feature">
                        <span class="fas fa-check-circle text-primary mr-2 fa-2x"></span>
                        <div>Install theme in 1 click</div>
                    </div>
                    <div class="col-sm-6 col-md-4 feature">
                        <span class="fas fa-check-circle text-primary mr-2 fa-2x"></span>
                        <div>Bulk-install Add-Ons in 1 click</div>
                    </div>
                    <div class="col-sm-6 col-md-4 feature">
                        <span class="fas fa-check-circle text-primary mr-2 fa-2x"></span>
                        <div>Automatic updating</div>
                    </div>
                    <div class="col-sm-6 col-md-4 feature">
                        <span class="fas fa-check-circle text-primary mr-2 fa-2x"></span>
                        <div>Integrate with existing plugins in 1 click</div>
                    </div>
                    <div class="col-sm-6 col-md-4 feature">
                        <span class="fas fa-check-circle text-primary mr-2 fa-2x"></span>
                        <div>100% Optimized for Dropshipping</div>
                    </div>
                    <div class="col-sm-6 col-md-4 feature">
                        <span class="fas fa-check-circle text-primary mr-2 fa-2x"></span>
                        <div>Rely on 24/7 customer support to solve all issues and answer all your questions</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- section support -->
        <section class="support-section pb-5">
            <div class="bg-angle"></div>
            <div class="support-wrapper py-4 text-white">
                <h2>24/7 Customer Support Team Available At Your Disposal</h2>
            </div>
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <p class="lead">Have an issue? Need a code change? Our support team is available around the clock to help you.
                            Have all your questions answered by one of 10 dedicated experts. Get professional code changes done for free.
                        </p>
                    </div>
                </div>
                <div class="card-deck text-center support-rep">
                    <div class="card mb-3 animated slow infinite upAndDown">
                      <div class="card-body">
                        <img data-src="images/new/mirza.png" class="mb-3 img-fluid rounded-circle shadow lazyload" alt="" />
                        <p><strong>Mirza</strong></p>
                        <p class="small text-muted">Customer Support specialist</p>
                        <span class="fas fa-circle animated flash infinite text-success small"></span> Online 24/7
                      </div>
                    </div>
                    <div class="w-100 d-lg-none"></div>
                    <div class="card mb-3 animated slow infinite upAndDown delay-1">
                      <div class="card-body">
                        <img data-src="images/new/adil.png" class="mb-3 img-fluid rounded-circle shadow lazyload" alt="" />
                        <p><strong>Adil</strong></p>
                        <p class="small text-muted">Customer Support specialist</p>
                        <span class="fas fa-circle animated flash infinite text-success small"></span> Online 24/7
                      </div>
                    </div>
                    <div class="card mb-3 animated slow infinite upAndDown delay-2">
                      <div class="card-body">
                        <img data-src="images/new/jun.png" class="mb-3 img-fluid rounded-circle shadow lazyload" alt="" />
                        <p><strong>Jun</strong></p>
                        <p class="small text-muted">Customer Support specialist</p>
                        <span class="fas fa-circle animated flash infinite text-success small"></span> Online 24/7
                      </div>
                    </div>
                    <div class="w-100 d-lg-none"></div>
                    <div class="card mb-3 animated slow infinite upAndDown delay-3">
                      <div class="card-body">
                        <img data-src="images/new/muhammad.jpg" class="mb-3 img-fluid rounded-circle shadow lazyload" alt="" />
                        <p><strong>Muhammad</strong></p>
                        <p class="small text-muted">Customer Support specialist</p>
                        <span class="fas fa-circle animated flash infinite text-success small"></span> Online 24/7
                      </div>
                    </div>
                    <div class="card mb-3 animated slow infinite upAndDown delay-4">
                      <div class="card-body">
                        <img data-src="images/new/abhishek.png" class="mb-3 img-fluid rounded-circle shadow lazyload" alt="" />
                        <p><strong>Abhishek</strong></p>
                        <p class="small text-muted">Customer Support specialist</p>
                        <span class="fas fa-circle animated flash infinite text-success small"></span> Online 24/7
                      </div>
                    </div>
                </div>

                <div class="row align-items-center section text-center text-md-left pb-0">
                    <div class="col-md-5">
                        <img data-src="images/new/case-study-analytics.png" class="mb-3 img-fluid lazyload" alt="" />
                    </div>
                    <div class="col-md-7">
                        <h3>Liel Levin</h3>
                        <p class="mb-3"><img data-src="images/stars.png" alt="" class="lazyload"/> <span> &nbsp; 5.0/5.00</span></p>
                        <p>
                            Amazing theme, I love it because ; 1. it looks clean 2. <strong>A lot of integrated features like sticky ATC, upsell bundles, product tabs etc all in one theme,
                            makes it much easier than having to download all the apps in seperate</strong> 3. Amazing customer support! any question you have and any edit you want to do
                            they help you with it and even do it for you :)
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <hr/>

        <!-- section entrepreneur -->
        <section class="entrepreneur-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>What our {{$nbShops}}+ customers say</h2>
                        <p class="lead">🥇 We're the World's #1 Free Shopify Theme</p>
                    </div>
                </div>
                <div class="row mb-3">
                  <div class="col">
                      <div data-rw-masonry="20376"></div>
                  </div>
                </div>
                <div class="row">
                    <div class="col">
                        @include ("components.download-wrapper")
                    </div>
                </div>
            </div>
        </section>
    </div>

    <hr>

    <div class="angle-wrapper">
        <!-- section featured addon -->
        <section id="stickyAddToCart" class="featured-addon-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>Sticky Add to Cart</h2>
                        <p class="lead"><strong>Conversion-boosting Add-On #1</strong></p>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-md-6 text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Sticky add-to-cart" data-subtitle="Display a sticky add-to-cart bar when scrolling passed the add-to-cart button." class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            @php($title = $addon->title)
                            @php($addon->title = 'Sticky add-to-cart')
                            @include("components.image-addons")
                        </a>
                    </div>
                    <div class="col-md-6">
                        <p class="h3">
                          <span class="line-through">$119.88/yr.</span>
                          <span class="text-danger">FREE*</span>
                        </p>
                        <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 11.8% *</span></h4>
                        <p class="text-muted small">*Actual results may vary. *Compared with app <a href="https://apps.shopify.com/sticky-add-to-cart-booster" target="_blank">"Sticky Add to cart + popup"</a></p>
                        <ul class="addon-list list-unstyled">
                            <li>Make it easy for customers to buy with sticky Buy button</li>
                            <li>Get more sales by increasing urgency</li>
                            <li>Fully customizable: change mobile display, customize countdown, quantity, reviews & more</li>
                            <li>Easy 1-click install & 1-click activation</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        @include ("components.download-wrapper")
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- section integration -->
        <section class="integration-section section">
            <div class="bg-angle"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h4><span class="badge bg-gradient text-white">Coming Soon</span></h4>
                        <h2>⚡ Easy Integration<br class="d-none d-md-block"> With Leading Shopify Apps</h2>
                        <p class="lead mb-3">Debutify is works perfectly with all the popular apps you need to run your business.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="apps-icons">
                            <div class="app-icon"><img data-src="images/new/oberlo.png" alt="oberlo" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/smsbump.png" alt="smsbump" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/klaviyo.png" alt="klaviyo" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/hubspot.png" alt="hubspot" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/printful.png" alt="printful" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/spocket.png" alt="spocket" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/sendinblue.png" alt="sendinblue" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/shipstation.png" alt="shipstation" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/doofinder.png" alt="doofinder" class="img-fluid lazyload" /></div>
                            <div class="app-icon"><img data-src="images/new/quickbooks.png" alt="quickbooks" class="img-fluid lazyload" /></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- section featured addon -->
        <section id="newsletter" class="featured-addon-section section">
          <div class="container">
              <div class="row mb-3">
                  <div class="col-lg-10 offset-lg-1 text-center">
                      <h2 class="mb-3 title">Newsletter Pop Up</h2>
                      <p class="lead"><strong>Conversion-boosting Add-On #2</strong></h6>
                  </div>
              </div>
              <div class="row align-items-center mb-3">
                  <div class="col-md-6 order-2 order-md-0">
                      <p class="h3">
                        <span class="line-through">$90/yr.</span>
                        <span class="text-danger">FREE*</span>
                      </p>
                      <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 30% *</span></h4>
                      <p class="text-muted small">Actual results may vary. *Compared with app <a href="https://apps.shopify.com/eggflow-marketing-automation" target="_blank">"Smart Popup"</a></p>
                      <ul class="addon-list list-unstyled">
                          <li>Lower cart abandonment & bounce rates</li>
                          <li>Get more sales by turning exits into purchases</li>
                          <li>Sync contacts with Klavyio & Mailchimp</li>
                          <li>Fully customizable: text, style, image, trigger, animation, coupon code & more</li>
                          <li>Easy 1-click install & 1-click activation</li>
                      </ul>
                  </div>
                  <div class="col-md-6 text-center">
                      <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Newsletter pop-up" data-subtitle="Display a newsletter popup on exit intent and reward customers with a coupon code." class="mb-3 mb-md-0 shadow d-block">
                          <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                          @php($addon->title = 'Newsletter pop-up')
                          @include("components.image-addons")
                      </a>
                  </div>
              </div>
              <div class="row">
                  <div class="col text-center">
                      @include ("components.download-wrapper")
                  </div>
              </div>
          </div>
        </section>
    </div>

    <hr>

    <!-- section speed test -->
    <section class="speed-section section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <h2>Explode Your Profits in 1 Click</h2>
                    <p class="lead mb-3">Debutify is the highest-converting free Shopify theme - with best-in-class load time, mobile responsiveness and conversion-boosting Add-Ons.
                        <strong>Get into the heart of business in 1 click,</strong> with everything you need to succeed.</p>
                </div>
            </div>
            <div class="row pingdom-slider align-items-center">
                <div class="col-md-7 text-center text-md-left order-2 order-md-0">
                    <h3 class="mt-4 mb-3">📱 Make Your Store Ready<br class="d-none d-lg-block"> For Millions of Mobile Shoppers</h3>
                    <p>Make the most out of every visitor on your website. Debutify is one of the fastest-loading themes available,
                        at <strong>1.35s store load time out-of-the-box.</strong> With Debutify, your store is ready for thousands of orders from mobile devices.</p>
                </div>
                <div class="col-md-5 text-center">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-primary">GTmetrix Live Test</h3>
                            <p class="text-muted">💪 Built with Debutify</p>
                            <a href="https://gtmetrix.com/reports/dbtfy-test-5.myshopify.com/dOBg9wmQ/" target="_blank">
                                <img class="img-fluid mb-3 rounded lazyload" data-src="images/debutify-gtmetrix.png" alt="gtmetrix result">
                            </a>
                            <p class="store-url">
                              <a href="https://dbtfy-test-5.myshopify.com/products/ederadia" target="_blank">dbtfy-test-5.myshopify.com</a>
                            </p>
                            <a class="btn btn-outline-primary mt-3" href="https://gtmetrix.com/reports/dbtfy-test-5.myshopify.com/dOBg9wmQ/" target="_blank"><span class="fa fa-external-link-alt "></span> View on GTmetrix</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <hr/>

    <!-- section testimonial -->
    <section class="testimonial-section bg-gradient text-white section">
      <div class="container-fluid">
          <div class="row">
              <div class="col">
                  <div id="testimonialCarousel" class="carousel slide text-center">
                      <div class="carousel-inner">
                          <div class="item carousel-item active">
                              <div class="row">
                                  <div class="col-sm-2 offset-sm-1 quote-left">
                                      <img data-src="images/new/octicons-quote-left.png" class="lazyload" alt="" />
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="mb-3 d-flex align-items-center justify-content-center">
                                          <div class="testimonial-person">
                                              <p><strong>Giancarlo Fittipaldi</strong></p>
                                              <p class="user-ratings mb-3"><img data-src="images/new/stars.png" alt="" class="lazyload"/> <span class="text-white"> &nbsp; 4.9/5.00</span></p>
                                          </div>
                                      </div>
                                      <p class="testimonial">
                                          Beautifil theme, clean and practical, helps me a lot in basically everything I need, also had I nice support right now, guy gave me the best attention I could have!
                                      </p>
                                  </div>
                                  <div class="col-sm-2 quote-right">
                                      <img data-src="images/new/octicons-quote-right.png" class="lazyload" alt="" />
                                  </div>
                              </div>
                          </div>
                          <div class="item carousel-item">
                              <div class="row">
                                  <div class="col-sm-2 offset-sm-1 quote-left">
                                      <img data-src="images/new/octicons-quote-left.png" alt="" class="lazyload" />
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="mb-3 d-flex align-items-center justify-content-md-center">
                                          <div class="testimonial-person">
                                              <p><strong>Fili Santana</strong></p>
                                              <p class="user-ratings mb-3"><img data-src="images/new/stars.png" alt="" class="lazyload"/> <span> &nbsp; 4.8/5.00</span></p>
                                          </div>
                                      </div>
                                      <p class="testimonial">
                                          The theme is really easy to configure, the support is amazing. I was able to setup the theme really fast to start my dropshipping store. Worth it!!!!
                                      </p>
                                  </div>
                                  <div class="col-sm-2 quote-right">
                                      <img data-src="images/new/octicons-quote-right.png" alt="" class="lazyload" />
                                  </div>
                              </div>
                          </div>
                          <div class="item carousel-item">
                              <div class="row">
                                  <div class="col-sm-2 offset-sm-1 quote-left">
                                      <img data-src="images/new/octicons-quote-left.png" alt="" class="lazyload" />
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="mb-3 d-flex align-items-center justify-content-md-center">
                                          <div class="testimonial-person">
                                              <p><strong>Jose Gonzalez</strong></p>
                                              <p class="user-ratings mb-3"><img data-src="images/new/stars.png" class="lazyload" alt=""/> <span> &nbsp; 4.9/5.00</span></p>
                                          </div>
                                      </div>
                                      <p class="testimonial">
                                          Theme is very smooth and easy to customize. Conversion rates def went up. The support team has also been great, they are always there to help.
                                      </p>
                                  </div>
                                  <div class="col-sm-2 quote-right">
                                      <img data-src="images/new/octicons-quote-right.png" class="lazyload" alt="" />
                                  </div>
                              </div>
                          </div>
                      </div>
                      <a class="carousel-control left carousel-control-prev" href="#testimonialCarousel" data-slide="prev"><span class="fas fa-angle-left fa-fw"></span></a>
                      <a class="carousel-control right carousel-control-next" href="#testimonialCarousel" data-slide="next"><span class="fas fa-angle-right fa-fw"></span></a>
                  </div>
              </div>
          </div>
      </div>
    </section>

    <div class="angle-wrapper">

      <!-- section featured addon -->
      <section id="productTabs" class="featured-addon-section section">
          <div class="container">
              <div class="row mb-3">
                  <div class="col-lg-10 offset-lg-1 text-center">
                      <h2>Product Tabs</h2>
                      <p class="lead"><strong>Conversion-boosting Add-On #3</strong></p>
                  </div>
              </div>
              <div class="row align-items-center mb-3">
                  <div class="col-md-6 text-center">
                      <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Product tabs" data-subtitle="Display organised tabs on your product page." class="mb-3 mb-md-0 shadow d-block">
                          <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                          @php($addon->title = 'Product tabs')
                          @include("components.image-addons")
                      </a>
                  </div>
                  <div class="col-md-6">
                      <p class="h3">
                        <span class="line-through">$59.88/yr.</span>
                        <span class="text-danger">FREE*</span>
                      </p>
                      <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 75% *</span></h4>
                      <p class="text-muted small">*Actual results may vary. *Compared with app <a href="https://apps.shopify.com/custom-product-accordion-tabs" target="_blank">"Custom Product Accordion Tabs"</a></p>
                      <ul class="addon-list list-unstyled">
                          <li>Easily create & organize rich content for customers</li>
                          <li>Improve customer experience to get more sales</li>
                          <li>Fully customizable: HTML content, tab name, icons, images, reviews, layout, visibility per product & more</li>
                          <li>Easy 1-click install & 1-click activation</li>
                      </ul>
                  </div>
              </div>
              <div class="row">
                  <div class="col text-center">
                      @include ("components.download-wrapper")
                  </div>
              </div>
          </div>
      </section>

      <hr/>

      <!-- section language -->
      <section class="languages-section section">
          <div class="bg-angle"></div>
          <div class="container">
              <div class="row mb-3">
                  <div class="col-lg-10 offset-lg-1">
                      <h2 class="mb-3 text-center">Sell Anywhere in The World With 20+ Translated Languages 🌎</h2>
                      <p class="lead mb-3 text-center">Scale your e-commerce empire globally. Debutify is translated into 20 languages
                          so you can <strong>make money selling products to the entire world.</strong></p>
                  </div>
              </div>
              <div class="row mb-3">
                <div class="col">
                    <div class="languages-wrapper">
                        <div><img data-src="images/new/Chinese.png" alt="Chinese" class="lazyload" /> Chinese</div>
                        <div><img data-src="images/new/Czech.png" alt="Czech" class="lazyload" /> Czech</div>
                        <div><img data-src="images/new/Danish.png" alt="Danish" class="lazyload" /> Danish</div>
                        <div><img data-src="images/new/Dutch.png" alt="Dutch" class="lazyload" /> Dutch</div>

                        <div><img data-src="images/new/english.png" alt="English" class="lazyload" /> English</div>
                        <div><img data-src="images/new/Finnish.png" alt="Finnish" class="lazyload" /> Finnish</div>
                        <div><img data-src="images/new/french.png" alt="French" class="lazyload" /> French</div>
                        <div><img data-src="images/new/german.png" alt="German" class="lazyload" /> German</div>
                        <div><img data-src="images/new/Hindi.png" alt="Hindi" class="lazyload" /> Hindi</div>
                        <div><img data-src="images/new/italian.png" alt="Italian" class="lazyload" /> Italian</div>

                        <div><img data-src="images/new/Japanese.png" alt="Japanese" class="lazyload" /> Japanese</div>
                        <div><img data-src="images/new/South-korea.jpg" alt="Korean" class="lazyload" /> Korean</div>
                        <div><img data-src="images/new/Malay.png" alt="Malay" class="lazyload" /> Malay</div>
                        <div><img data-src="images/new/Norwegian.png" alt="Norwegian" class="lazyload" /> Norwegian</div>
                        <div><img data-src="images/new/Polish.png" alt="Polish" class="lazyload" /> Polish</div>
                        <div><img data-src="images/new/Portuguese.png" alt="Portuguese" class="lazyload" /> Portuguese</div>

                        <div><img data-src="images/new/spanish.png" alt="Spanish" class="lazyload" /> Spanish</div>
                        <div><img data-src="images/new/Swedish.png" alt="Swedish" class="lazyload" /> Swedish</div>
                        <div><img data-src="images/new/Thai.png" alt="Thai" class="lazyload" /> Thai</div>
                        <div><img data-src="images/new/turkish.png" alt="Turkish" class="lazyload" /> Turkish</div>

                        <p class="clearfix"></p>
                    </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col">
                      @include ("components.download-wrapper")
                  </div>
              </div>
          </div>
      </section>

      <hr/>

      <!-- section featured addon -->
      <section id="trustBadges" class="featured-addon-section section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <h2 class="mb-3 title">Trust Badges</h2>
                    <p class="lead"><strong>Conversion-boosting Add-On #4</strong></h6>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-md-6 order-2 order-md-0">
                    <p class="h3">
                      <span class="line-through">$90/yr.</span>
                      <span class="text-danger">FREE*</span>
                    </p>
                    <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 137% *</span></h4>
                    <p class="text-muted small">Actual results may vary. *Compared with app <a href="https://apps.shopify.com/trust-by-kamozi" target="_blank">"TrustBadges"</a></p>
                    <ul class="addon-list list-unstyled">
                        <li>Earn customer's trust and lower resistance to sale</li>
                        <li>Increase conversions and lower cart abandonment</li>
                        <li>Fully customizable: change appearance, location</li>
                        <li>Easy 1-click install & 1-click activation</li>
                    </ul>
                </div>
                <div class="col-md-6 text-center">
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Trust badge" data-subtitle="Display a trust badge under the add-to-cart and checkout buttons.." class="mb-3 mb-md-0 shadow d-block">
                        <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                        @php($addon->title = 'Trust badge')
                        @include("components.image-addons")
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col text-center">
                    @include ("components.download-wrapper")
                </div>
            </div>
        </div>
      </section>

    </div>

    <hr/>

    <!-- section makemoney -->
    <section class="makemoney-section make-money-bg section bg-overlay-image text-white">
      <div class="container">
          <div class="row mb-3">
              <div class="col-lg-10 offset-lg-1 text-center">
                  <h2><span class="display-2">SAY YES</span><br> to Making Money While You Sleep! 😴</h2>
                  <p class="lead">Use Debutify to launch your dropshipping empire.<br class="d-none d-md-block">
                    Work anywhere, at any time you want, as much or as little as you want.<br class="d-none d-md-block">
                    A world of leisure, money and travel is awaiting. <strong>Download Debutify for free, today.</strong>
                  </p>
              </div>
          </div>
          <div class="row">
              <div class="col text-center">
                  @include ("components.download-wrapper")
              </div>
          </div>
      </div>
    </section>

    <div class="angle-wrapper">
        <!-- section featured addon -->
        <section id="salesPop" class="featured-addon-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>Sales Pop</h2>
                        <p class="lead"><strong>Conversion-boosting Add-On #5</strong></p>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-md-6 text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Sales pop" data-subtitle="Display a notification of past purchases.." class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            @php($addon->title = 'Sales pop')
                            @include("components.image-addons")
                        </a>
                    </div>
                    <div class="col-md-6">
                        <p class="h3">
                          <span class="line-through">$348/yr.</span>
                          <span class="text-danger">FREE*</span>
                        </p>
                        <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 15% *</span></h4>
                        <p class="text-muted small">*Actual results may vary. *Compared with app <a href="https://apps.shopify.com/shoppop" target="_blank">"Sales Pop ‑ Popup Notification"</a></p>
                        <ul class="addon-list list-unstyled">
                            <li>Increase trust with strong social proof</li>
                            <li>Make your product look like it's in-demand</li>
                            <li>Fully customizable: style, frequency, text, animation, icons, products & more</li>
                            <li>Easy 1-click install & 1-click activation</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        @include ("components.download-wrapper")
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- section blueprint -->
        <section class="blueprint-section section">
            <div class="bg-angle"></div>
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>Explode Your Sales With The All-in-One "Blueprint For Success" 🎯</h2>
                        <p class="lead mb-3">Debutify can help you grow a passive income and complete financial independence, so you can live your life how you want.
                            Imagine having a stable source of income that makes you truckloads of money while you sleep. <strong>Debutify can help you get there.</strong></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-6 text-center">
                        <img data-src="images/new/explode-sale.png" class="features-img img-fluid lazyload" alt=""  />
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="card-deck">
                          <div class="card mb-3">
                            <div class="card-body">
                              <img data-src="images/new/fi-1.png" class="mb-3 img-fluid lazyload" alt="" />
                              <p><strong>Fast & Responsive</strong></p>
                              <p class="text-muted small mb-0">Blazing-Fast On Desktop & Mobile</p>
                            </div>
                          </div>
                          <div class="w-100"></div>
                          <div class="card mb-3">
                            <div class="card-body">
                              <img data-src="images/new/fi-2.png" class="mb-3 img-fluid lazyload" alt="" />
                              <p><strong>Sleek Design</strong></p>
                              <p class="text-muted small mb-0">Get (Significantly) More Sales</p>
                            </div>
                          </div>
                          <div class="card mb-3">
                            <div class="card-body">
                              <img data-src="images/new/fi-3.png" class="mb-3 img-fluid lazyload" alt="" />
                              <p><strong>High-converting</strong></p>
                              <p class="text-muted small mb-0">Turn Traffic Into Buyers</p>
                            </div>
                          </div>
                          <div class="w-100"></div>
                          <div class="card mb-3">
                            <div class="card-body">
                              <img data-src="images/new/fi-4.png" class="mb-3 img-fluid lazyload" alt="" />
                              <p><strong>1-Click Setup</strong></p>
                              <p class="text-muted small mb-0">No Technical Knowledge Needed</p>
                            </div>
                          </div>
                          <div class="card mb-3">
                            <div class="card-body">
                              <img data-src="images/new/fi-5.png" class="mb-3 img-fluid lazyload" alt="" />
                              <p><strong>24/7 Support</strong></p>
                              <p class="text-muted small mb-0">Live Support Always Available</p>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        @include ("components.download-wrapper")
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- section featured addon -->
        <section id="cartCountdown" class="featured-addon-section section">
          <div class="container">
              <div class="row mb-3">
                  <div class="col-lg-10 offset-lg-1 text-center">
                      <h2 class="mb-3 title">Cart Countdown</h2>
                      <p class="lead"><strong>Conversion-boosting Add-On #6</strong></h6>
                  </div>
              </div>
              <div class="row align-items-center mb-3">
                  <div class="col-md-6 order-2 order-md-0">
                      <p class="h3">
                        <span class="line-through">$49.00/yr.</span>
                        <span class="text-danger">FREE*</span>
                      </p>
                      <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 226% *</span></h4>
                      <p class="text-muted small">Actual results may vary. *Compared with app <a href="https://apps.shopify.com/timerly" target="_blank">"Timerly by Kamozi"</a></p>
                      <ul class="addon-list list-unstyled">
                          <li>Increase urgency to make customers buy now</li>
                          <li>Lower cart abandonment rate</li>
                          <li>Fully customizable: set message text, message icon, timer, translation and more</li>
                          <li>Easy 1-click install & 1-click activation</li>
                      </ul>
                  </div>
                  <div class="col-md-6 text-center">
                      <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Cart countdown" data-subtitle="Display a Countdown Timer in the cart drawer/page." class="mb-3 mb-md-0 shadow d-block">
                          <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                          @php($addon->title = 'Cart discount')
                          @include("components.image-addons")
                      </a>
                  </div>
              </div>
              <div class="row">
                  <div class="col text-center">
                      @include ("components.download-wrapper")
                  </div>
              </div>
          </div>
        </section>
    </div>

    <!-- section product research -->
    <section class="product-research-section section bg-gradient text-white">
        <div class="container">
            <div class="row mb-3">
              <div class="col-lg-10 offset-lg-1 text-center">
                  <h2>Discover $1,000,000 Products in 3 Clicks With Winning Product Research Tool 🙌</h2>
                  <p class="lead mb-3">
                      <strong>Find winning products in unsaturated niches</strong> with Debutify's Winning Product Research Tool. New products, freshly updated every
                      week and ready for you to make real bucks. <strong>All 1 click away.</strong> Debutify also bundles the $1,000,000 Product Research Course to help you <strong>find true product gold mines.</strong>
                  </p>
                </div>
              </div>
              <div class="row">
                <div class="col text-center">
                    @include ("components.download-wrapper")
                </div>
            </div>
        </div>
    </section>

    <div class="angle-wrapper">
        <!-- section course -->
        <section class="course-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1  text-center">
                        <h2>Exclusive Industry Success Secrets From E-Commerce "Insiders" Entrepreneur 🤫</h2>
                        <p class="lead"><strong>Cut your way from 0 to $1M business.</strong> With Debutify, you get the secret knowledge and sales tactics of 7-figure entrepreneurs.
                            All bundled in 4 exclusive courses by Ricky Hayes, e-commerce business owner with a track record of <strong>over $8,000,000 in sales,</strong>
                            whose students are now <strong>7-figure entrepreneurs themselves.</strong>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <div class="card-deck">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img data-src="images/new/ecom-lifestyle.png" alt="" class="img-fluid rounded-circle shadow mb-3 lazyload" />
                                    <p><strong>Exclusive Ecom<br> Lifestyle University</strong></p>
                                    <span class="line-through">$3000</span>
                                    <h6><span class="badge bg-gradient text-white">Free With Debutify</span></h6>
                                    <p class="text-muted small">A-to-Z course on everything from Shopify setup to picking the right products and running social media ads that convert to big bucks.</p>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img data-src="images/new/shopify.png" alt="" class="img-fluid rounded-circle shadow mb-3 lazyload" />
                                    <p><strong>$0-$100,000 a day<br> Shopify store setup training</strong></p>
                                    <span class="line-through">$3000</span>
                                    <h6><span class="badge bg-gradient text-white">Free With Debutify</span></h6>
                                    <p class="text-muted small">You'll learn the fundamental success strategies to setup your store for $100,000 a day in sales.</p>
                                </div>
                            </div>
                            <div class="w-100 d-sm-block d-lg-none"></div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img data-src="images/new/fb-ads.png" alt="" class="img-fluid rounded-circle shadow mb-3 lazyload" />
                                    <p><strong>$0-$10,000 a day<br> Facebook ads mastery</strong></p>
                                    <span class="line-through">$3000</span>
                                    <h6><span class="badge bg-gradient text-white">Free With Debutify</span></h6>
                                    <p class="text-muted small">Discover the exclusive secrets of successful Facebook ads turn your store into a gold mine.</p>
                                </div>
                            </div>
                            <div class="w-100 d-none d-lg-block"></div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img data-src="images/new/google-mastery.png" alt="" class="img-fluid rounded-circle shadow mb-3 lazyload" />
                                    <p><strong>$0-$100,00 a day<br> Google ads mastery</strong></p>
                                    <span class="line-through">$3000</span>
                                    <h6><span class="badge bg-gradient text-white">Free With Debutify</span></h6>
                                    <p class="text-muted small">You'll learn the step-by-step process of using Google Ads to 10x your business.</p>
                                </div>
                            </div>
                            <div class="w-100 d-sm-block d-lg-none"></div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img data-src="images/new/product-search.png" alt="" class="img-fluid rounded-circle shadow mb-3 lazyload" />
                                    <p><strong>$1,000,000 winning<br> product research masterclass</strong></p>
                                    <span class="line-through">$3000</span>
                                    <h6><span class="badge bg-gradient text-white">Free With Debutify</span></h6>
                                    <p class="text-muted small">Learn how and where to find unsaturated $1M products waiting for you to sell them and cash in.</p>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <img data-src="images/new/youtube-video.png" alt="" class="img-fluid rounded-circle shadow mb-3 lazyload" />
                                    <p><strong>$0-$10,000 a day<br> Youtube ads mastery</strong></p>
                                    <span class="line-through">$3000</span>
                                    <h6><span class="badge bg-gradient text-white">Free With Debutify</span></h6>
                                    <p class="text-muted small">Learn how to use this little-known e-commerce weapon to bring loads of buyers to your store.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr/>

        <!-- section author -->
        <section class="author-section section">
            <div class="bg-angle"></div>
            <div class="container">
                <div class="row text-center text-md-left">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h4><span class="badge bg-gradient text-white">Course Author</span></h4>
                        <h2>7-Figure E-Commerce & Dropshipping Master, Ricky Hayes</h2>
                        <p>
                            Ricky Hayes has generated over $8,000,000 in e-commerce and dropshipping sales through his own stores and for his clients' businesses.
                            He's worked in all niches, from skin care and beauty to pet stores. Ricky has taught dozens of aspiring dropshippers like you who
                            have achieved multi-million-dollar success under his mentorship.
                        </p>
                        <div class="sell-img-wrapper d-flex align-items-center justify-content-center justify-content-sm-start flex-wrap flex-sm-nowrap">
                            <img class="img-fluid rounded shadow ml-sm-0 lazyload" data-src="images/new/sell-month.png" alt="">
                            <img class="img-fluid rounded shadow lazyload" data-src="images/new/sell-yesterday.png" alt="">
                            <img class="img-fluid rounded shadow mr-sm-0 lazyload" data-src="images/new/sell-today.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <img class="img-fluid rounded shadow lazyload" data-src="images/new/ricky.png" alt="">
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <!-- section featured addon -->
        <section id="upsellBundles" class="featured-addon-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>Upsell Bundles</h2>
                        <p class="lead"><strong>Conversion-boosting Add-On #7</strong></p>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-md-6 text-center">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Upsell bundles" data-subtitle="Display frequently bought together product bundles." class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            @php($addon->title = 'Upsell bundles')
                            @include("components.image-addons")
                            @php($addon->title = $title)
                        </a>
                    </div>
                    <div class="col-md-6">
                        <p class="h3">
                          <span class="line-through">$95.88/yr.</span>
                          <span class="text-danger">FREE*</span>
                        </p>
                        <h4><span class="badge bg-gradient text-white">Increase Conversion Rate up to 27% *</span></h4>
                        <p class="text-muted small">*Actual results may vary. *Compared with app <a href="https://apps.shopify.com/frequently-bought-together" target="_blank">"Frequently Bought Together"</a></p>
                        <ul class="addon-list list-unstyled">
                            <li>Cash in by increasing average order value</li>
                            <li>Recommend AI-powered bundles for highest AOV</li>
                            <li>Fully customizable: change position, style, create custom bundles to re-use & more</li>
                            <li>Easy 1-click install & 1-click activation</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        @include ("components.download-wrapper")
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- section cash printing -->
    <section class="cash-printing-section section bg-overlay-image">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-10 offset-lg-1 text-center text-white">
                    <h2>🤑 Turn Your Shopify Store<br class="d-none d-md-block"> Into a "Money-Making" Empire</h2>
                    <p class="lead">
                        If you want to live the entrepreneurial lifestyle… if you want to work wherever you want, as little as you want,
                        from anywhere around the world… Debutify can help you get there. <strong>Download Debutify free today,</strong>
                        and set up in 1 click. <strong>0 effort needed.</strong>
                    </p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col text-center">
                    <div class="card-deck">
                        <div class="card mb-3">
                            <div class="card-body">
                                <img data-src="images/new/fi-1.png" class="img-fluid rounded-circle shadow mb-3 lazyload" alt="" />
                                <p><strong>Blazing-fast on mobile (1.35s load time out of the box)</strong></p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <img data-src="images/new/fi-2.png" class="img-fluid rounded-circle shadow mb-3 lazyload" alt="" />
                                <p><strong>Pro design, ux that converts</strong></p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <img data-src="images/new/fi-3.png" class="img-fluid rounded-circle shadow mb-3 lazyload" alt="" />
                                <p><strong>40+ conversion Add-Ons boost sales</strong></p>
                            </div>
                        </div>
                        <div class="w-100 d-lg-none"></div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <img data-src="images/new/fi-6.png" class="img-fluid rounded-circle shadow mb-3 lazyload" alt="" />
                                <p><strong>Fully customizable, easy to edit</strong></p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <img data-src="images/new/fi-4.png" class="img-fluid rounded-circle shadow mb-3 lazyload" alt="" />
                                <p><strong>1-click set-up, 1-click app install - no technical knowledge needed</strong></p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <img data-src="images/new/fi-5.png" class="img-fluid rounded-circle shadow mb-3 lazyload" alt="" />
                                <p><strong>24/7 customer & dev support. we've always got your back</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-white">
                <div class="col">
                    @include ("components.download-wrapper")
                </div>
            </div>
        </div>
    </section>

    <div class="angle-wrapper">
        <!-- section secret weapon -->
        <section class="secret-weapon-section section">
            <div class="container">
                <div class="bg-angle"></div>
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>The Secret Weapon of The Most Successful E-Commerce Entrepreneurs ⚔️</h2>
                        <p class="lead">
                            Debutify is a leading free Shopify theme, used by the biggest ecom entrepreneurs. If you’re not convinced that Debutify is good for you, then listen why 7-figure dropshippers use it for their businesses:
                        </p>
                    </div>
                </div>
                <div class="row mb-3 text-center">
                    <div class="col-md-4 col-sm-12 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Chris Wane" data-subtitle="7-figure Dropshipping entrepreneur & youtuber" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v1.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“From spending $180/mo. on my store to run itself, down to <strong>practically nothing</strong> with Debutify”</p>
                        <p class="text-muted small">— <strong>Chris Wane,</strong> 7-figure Dropshipping entrepreneur & youtuber</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Kamil Sattar" data-subtitle="7-figure e-commerce entrepreneur & Youtuber" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v2.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“The conversion rates are amazing, the Add-Ons are amazing... it's <strong>changed my life and my store</strong>”</p>
                        <p class="text-muted small">— <strong>Kamil Sattar,</strong> 7-figure e-commerce entrepreneur & Youtuber</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="James Beattie" data-subtitle="CEO, ecom insiders; 7-figure entrepreneur & Youtuber" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v9.jpg" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“From 2-3% conversion rate to <strong>5% on a new branded Shopify store</strong> with optimizations in the theme”</p>
                        <p class="text-muted small">— <strong>James Beattie,</strong> ceo, ecom insiders; 7-figure entrepreneur & Youtuber</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Jordan Welch" data-subtitle="Serial entrepreneur, digital marketer & 7-Figure store owner" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v3.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“The <strong>highest conversion rates…</strong> the <strong>highest page speeds…</strong> Debutify ranks among the top ones”</p>
                        <p class="text-muted small">— <strong>Jordan Welch,</strong> serial entrepreneur, digital marketer & 7-Figure store owner</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Marc Chapon" data-subtitle="7-figure e-commerce entrepreneur & Youtuber" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v4.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“Everything you need to test & scale your store efficiently. <strong>The best free theme by far</strong>”</p>
                        <p class="text-muted small">— <strong>Marc Chapon,</strong> 7-figure e-commerce entrepreneur & Youtuber</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Brandon Nguyen" data-subtitle="7-figure professional dropshipper" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v5.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“Generated over $210k in the first month… High-converting, super easy, super customizable”</p>
                        <p class="text-muted small">— <strong>Brandon Nguyen,</strong> 7-figure professional dropshipper</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Cameron" data-subtitle="7-figure e-commerce entrepreneur" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v6.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“Absolutely ridiculous results and literally took 30 minutes to set up. <strong>Improved my conversions by 2%</strong>”</p>
                        <p class="text-muted small">— <strong>Cameron,</strong> 7-figure e-commerce entrepreneur</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Clayton Bates" data-subtitle="7-figure professional dropshipper & e-commerce entrepreneur" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v7.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“After downloading Debutify, a lot of these businesses [our clients] went from 1-2% to <strong>3, 4, 5% conversion rate</strong>”</p>
                        <p class="text-muted small">— <strong>Clayton Bates,</strong> 7-figure professional dropshipper & e-commerce entrepreneur</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#testimonialModal" data-title="Nick" data-subtitle="e-commerce" class="d-block relative">
                            <span class="fab fa-youtube fa-4x text-primary icon-hover" aria-hidden="true"></span>
                            <img data-src="images/new/v8.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“Significantly helped with conversions… Perfect for <strong>building a branded e-commerce business</strong>”</p>
                        <p class="text-muted small">— <strong>Nick,</strong> e-commerce</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col text-center">
                        <p class="lead">Take the shortcut to becoming a <strong>thriving entrepreneur.</strong><br class="d-none d-md-block">
                           Download Debutify for <strong>free.</strong> Get started in seconds.
                         </p>
                        @include ("components.download-wrapper")
                    </div>
                </div>

            </div>
        </section>

        <hr/>

        <!-- section funnel -->
        <section class="funnel-section section">
            <div class="bg-angle"></div>
            <div class="container">
                <div class="row mb-3 d-flex align-items-center justify-content-center text-center text-md-left">
                    <div class="col-md-7">
                        <h4><span class="badge bg-gradient text-white">Real Cash + Easy Management</span></h4>
                        <h2>👉 Build high-converting funnels for your PRODUCTS</h2>
                        <p class="lead">Debutify's sales Add-Ons will turn your product pages into high-converting funnels. Get the results of a Clickfunnels page AND the
                            convenience of your Shopify store management — <strong>only with Debutify.</strong>
                        </p>
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h4><span class="badge badge-primary p-3 w-100">$4,309,201</span></h4>
                                <p class="text-muted small">Made by debutify users</p>
                            </div>
                            <div class="col-md-4">
                                <h4><span class="badge badge-danger p-3 w-100">4.5% CR</span></h4>
                                <p class="text-muted small">Average conversion rate of a profitable debutify store.</p>
                            </div>
                            <div class="col-md-4">
                              <h4><span class="badge badge-warning p-3 w-100">4.8/5.0 <span class="fas fa-star"></span></span></h4>
                                <p class="text-muted small">Average user rating</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-center">
                        <img data-src="images/new/funnel.png" class="mb-3 img-fluid lazyload" alt="" />
                    </div>
                </div>
                @include ("components.download-wrapper")
            </div>
        </section>

        <hr>

        <!-- section save on apps -->
        <section class="save-on-apps-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <h2>💰 Save Up To $2,000 a Year on Expensive Apps, Without Losing Premium Features</h2>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover bg-white">
                                <thead class="thead-light">
                                    <tr>
                                      <th scope="col" width="25%">Features</th>
                                      <th scope="col" width="25%" class="bg-gradient text-white"><strong><span class="fas fa-trophy"></span> Debutify</strong></th>
                                      <th scope="col" width="25%">Shopify App Cost</th>
                                      <th scope="col" width="25%">Conversion Rate Increase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php($total_cost = 0)
                                    @php($total_conversion = 0)
                                    @foreach($global_add_ons as $addon)
                                    <tr>
                                      <td scope="row">{{ $addon->title }}</td>
                                      <td>
                                        <div class="d-flex align-items-center justify-content-center font-weight-bold">
                                          <span class="fa fa-check-circle text-primary fa-2x mr-2"></span> INCLUDED
                                        </div>
                                      </td>
                                      @include ('components.addon-cost')
                                      @php($total_cost += $addon->cost)
                                      @php($total_conversion += $addon->conversion_rate)
                                      <td>${{ $addon->cost }}/mo.</td>
                                      <td>+{{ $addon->conversion_rate }}%*</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="thead-light">
                                    <tr>
                                      <th scope="col" width="25%">
                                        <div class="h4 mb-0">TOTAL</div>
                                      </th>
                                      <th scope="col" width="25%" class="bg-gradient text-white">
                                        <div class="h4 mb-0"><strong>$23.5/mo.</strong></div>
                                        <div class="small">$47/month billed monthly</div>
                                      </th>
                                      <th scope="col" width="25%">
                                        <div class="h4 mb-0">${{ $total_cost }}/mo</div>
                                        <div class="small">Standalone Cost</div>
                                      </th>
                                      <th scope="col" width="25%">
                                        <div class="h4 mb-0">{{ $total_conversion }}% *</div>
                                        <div class="small">Expected CR Increase With Debutify</div>
                                      </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                @include ("components.download-wrapper")
            </div>
        </section>
    </div>

    <!-- section quote -->
    <section class="quote-section bg-gradient text-white my-0 my-md-5 section py-md-0">
        <div class="container">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-8 py-0 py-md-5 mb-3 mb-md-0">
                    <p><span class="fas fa-quote-left fa-3x"></span></p>
                    <h6 class="font-weight-normal mb-3"><strong>Seriously amazing app and support.</strong> Do not be afraid to try debutify out for yourself. Customer support reply in less than 20 min.</h6>
                    <p>— <strong>Silas Nielsen,</strong> made over $5M with debutify</p>
                </div>
                <div class="col-md-4 offset-quote-img">
                    <img data-src="images/new/chart.png" alt="" class="img-fluid chart-img rounded shadow lazyload" />
                </div>
            </div>
        </div>
    </section>

    <div class="angle-wrapper">
        <!-- section powerful feature -->
        <section class="powerful-features-section section">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>💪 The #1 Most Powerful Features<br class="d-none d-md-block"> Any Shopify Theme Could Give You</h2>
                        <p class="lead mb-3">Debutify gives you many times the performance and apps of Shopify leading themes, plus exclusive features and masters training you won't find anywhere else.</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col text-center">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover bg-white">
                                <thead class="thead-light">
                                    <tr>
                                      <th scope="col" width="29%">Features</th>
                                      <th scope="col" width="29%" class="bg-gradient text-white"><strong><span class="fas fa-trophy"></span> Debutify</strong></th>
                                      <th scope="col" width="14%">Booster</th>
                                      <th scope="col" width="14%">Turbo</th>
                                      <th scope="col" width="14%">EcomSolid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                      <td  scope="row">Free Lifetime Upgrades</td>
                                      <td>
                                          <div class="d-flex align-items-center justify-content-center font-weight-bold">
                                              <span class="fa fa-check-circle text-primary fa-2x mr-2"></span> <span>Free New Updates Every Month + No-Click Auto Updater</span>
                                          </div>
                                      </td>
                                      <td>Only 1 year</td>
                                      <td>Yes</td>
                                      <td>Yes</td>
                                    </tr>
                                    <tr>
                                      <td  scope="row">Page Load Time*</td>
                                      <td >
                                          <div class="d-flex align-items-center justify-content-center font-weight-bold">
                                              <span class="fa fa-check-circle text-primary fa-2x mr-2"></span> <span>1.68s avg. (39% Faster) Even With All Apps Turned On</span>
                                          </div>
                                      </td>
                                      <td>2.87s avg.</td>
                                      <td>2.35s avg.</td>
                                      <td>3.21s avg.</td>
                                    </tr>
                                    <tr>
                                      <td  scope="row">Conversion-Boosting Apps</td>
                                      <td >
                                          <div class="d-flex align-items-center justify-content-center font-weight-bold">
                                              <span class="fa fa-check-circle text-primary fa-2x mr-2"></span> <span>26 Apps + New Added Every Month</span>
                                          </div>
                                      </td>
                                      <td>12 Apps</td>
                                      <td>10 Apps</td>
                                      <td>10 Apps</td>
                                    </tr>
                                    <tr>
                                      <td  scope="row">E-Commerce Pro Training</td>
                                      <td >
                                          <div class="d-flex align-items-center justify-content-center font-weight-bold">
                                              <span class="fa fa-check-circle text-primary fa-2x mr-2"></span> <span>6 Fully-Fledged, Premium Courses (FB Ads, Google Ads, YT Ads, $0-$1k Store Setup & More)</span>
                                          </div>
                                      </td>
                                      <td class="pink-text"><span class="fa fa-times-circle text-danger fa-2x"></span></td>
                                      <td>"Bonus Ecom Training"</td>
                                      <td class="pink-text"><span class="fa fa-times-circle text-danger fa-2x"></span></td>
                                    </tr>
                                    <tr>
                                      <td  scope="row">Product Research Tools</td>
                                      <td >
                                          <div class="d-flex align-items-center justify-content-center font-weight-bold">
                                              <span class="fa fa-check-circle text-primary fa-2x mr-2"></span> <span>Winning Product Research Tool + $1,000,000 Product Research Course</span>
                                          </div>
                                      </td>
                                      <td class="pink-text"><span class="fa fa-times-circle text-danger fa-2x"></span></td>
                                      <td class="pink-text"><span class="fa fa-times-circle text-danger fa-2x"></span></td>
                                      <td class="pink-text"><span class="fa fa-times-circle text-danger fa-2x"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr/>

        <!-- section case study -->
        <section class="casestudy-section section">
            <div class="bg-angle"></div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div id="caseStudyCarousel3" class="carousel slide casestudy-carousel">
                            <div class="carousel-inner">
                                <div class="item carousel-item active">
                                    <div class="row align-items-center justify-content-md-center">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <p><img class="img-fluid shadow mb-3 lazyload" data-src="images/new/casestudy-img-1.png" alt="">
                                        </div>
                                        <div class="col-md-7">
                                            <p><span class="fas fa-quote-left fa-3x text-primary"></span></p>
                                            <p class="lead">
                                                <strong>Debutify is without question the best Shopify theme available.</strong> Free or not. It offers more features than almost any theme out there,
                                                the code is extremely well written and very easy to modify (if you're into that sorta thing), and most importantly the customer support is
                                                nothing less than amazing. Raphael and team go above and beyond to help with anything you need, and never price gauge you with small edits or support.
                                                With Debutify you're given an amazing foundation on which to grow your business. <strong>I left my very expensive paid theme for Debutify, and I haven't looked
                                                back for even one second. Debutify is 10/10!</strong>
                                            </p>
                                            <p><strong>Jared Bolokofsky</strong></p>
                                            <p class="text-muted small">Made over $5,000,000 with his debutify store</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item carousel-item">
                                    <div class="row align-items-center justify-content-md-center">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <p><img class="img-fluid shadow mb-3 lazyload" data-src="images/new/casestudy-img-1.png" alt="">
                                        </div>
                                        <div class="col-md-7">
                                            <p><span class="fas fa-quote-left fa-3x text-primary"></span></p>
                                            <p class="lead">
                                                <strong>Great theme and really great Customer Support!!</strong> They fixed the issues in few hours, i really recommend!
                                            </p>
                                            <p><strong>Valentina Iasevoli</strong></p>
                                            <p class="text-muted small">Made over $4,000,000 with his debutify store</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="item carousel-item">
                                    <div class="row align-items-center justify-content-md-center">
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <p><img class="img-fluid shadow mb-3 lazyload" data-src="images/new/casestudy-img-1.png" alt="">
                                        </div>
                                        <div class="col-md-7">
                                            <p><span class="fas fa-quote-left fa-3x text-primary"></span></p>
                                            <p class="lead">
                                                <strong>Very good theme with great page speed and a lot of useful functions.</strong> Furthermore the support is great! Thanks a lot
                                            </p>
                                            <p><strong>Jochen</strong></p>
                                            <p class="text-muted small">Made over $3,000,000 with his debutify store</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#caseStudyCarousel3" role="button" data-slide="prev">
                                <span class="fas fa-chevron-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#caseStudyCarousel3" role="button" data-slide="next">
                                <span class="fas fa-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr/>

        <!-- section plan -->
        <section class="section">
            <div class="container">
                <div class="row mb-3">
                  <div class="col-lg-10 offset-lg-1 text-center">
                    <h2>👏 Miserably low price<br class="d-none d-md-block"> compared to earning potential</h2>
                  </div>
                </div>
                @include('landing.pricing-module')
            </div>
        </section>

    </div>

    <!-- section success -->
    <section class="road-to-success-section section bg-overlay-image text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-10 offset-lg-1">
                    <h2>🤝 Take The <span class="text-underline">Easiest</span> Road To Success</h2>
                    <h6>Try Debutify's premium features <strong>FREE for 14 days.</strong><br class="d-none d-md-block"> Install and set up in 1 click.</h6>
                    <img class="mb-3" data-src="images/new/download-now.png" alt="" class="img-fluid lazyload"  />
                    <h6>Download now and get</h6>
                    <h3 class="mb-3">Five $100,000 products (PDF) by ricky hayes, free!</h3>
                    @include ("components.download-wrapper")
                </div>
            </div>
        </div>
    </section>

    <!-- section faq -->
    <section class="faq-section section">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-10 offset-lg-1 text-center">
                    <h2>Frequently Asked Questions</h2>
                    <p class="lead">We know you have some questions in mind, we've tried to list the most important ones!</p>
                </div>
            </div>
            @include('landing.faq-module')
        </div>
    </section>
</div>

<!-- modal testimonial -->
<div class="modal fade" tabindex="-1" role="dialog" id="testimonialModal" aria-labelledby="testimonialVideo" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="testimonial-title mb-0"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="testimonial-subtitle"></p>
        <div class="embed-responsive embed-responsive-16by9 video-testimonial">
          <iframe class="embed-responsive-item testimonial-iframe" width="560" height="315" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#downloadModal">
            <span class="fas fa-download" aria-hidden="true"></span>
            Free Download Now
        </button>
      </div>
    </div>
  </div>
</div>


<!-- modal video -->
<div class="modal fade" tabindex="-1" role="dialog" id="videoModal" aria-labelledby="addonVideo" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="addon-title mb-0"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="addon-subtitle"></p>
        <div class="embed-responsive embed-responsive-16by9 video-tutorial">
          <iframe class="embed-responsive-item tutorial" width="560" height="315" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#downloadModal">
            <span class="fas fa-download" aria-hidden="true"></span>
            Free Download Now
        </button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>
    $(function() {
        $('#carouselAddon').on('slide.bs.carousel', function (e) {
            var $e = $(e.relatedTarget);
            var idx = $e.index();
            var inner = $(this).find('.carousel-inner');
            var items = $(this).find('.carousel-item');
            var itemsPerSlide = 4;
            var totalItems = items.length;

            if (idx >= totalItems-(itemsPerSlide-1)) {
                var it = itemsPerSlide - (totalItems - idx);
                for (var i=0; i<it; i++) {
                    // append slides to end
                    if (e.direction=="left") {
                        items.eq(i).appendTo(inner);
                    }
                    else {
                        items.eq(0).appendTo(inner);
                    }
                }
            }
        });

        $('#testimonialModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var title = button.data('title');
            var subtitle = button.data('subtitle');

            @include("components.video-testimonials");

            $('.testimonial-iframe').attr("src","https://www.youtube.com/embed/" + testimonialSource + "?autoplay=1");

            $(".testimonial-title").text(title);
            $(".testimonial-subtitle").text(subtitle);

            if(testimonialSource){
              $(".video-testimonial").show();
            } else{
              $(".video-testimonial").hide();
            }
        });

        $('#testimonialModal').on('hide.bs.modal', function (e) {
            $('.testimonial-iframe').attr("src","");
        });

    });

</script>
@endsection
