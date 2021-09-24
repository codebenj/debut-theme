@extends('layouts.landing')

@section('title',"Debutify - World's Smartest Shopify Theme. Free 14-day Trial")

@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('styles')
@endsection

@section('content')
<div class="homepage">
  <div class="angle-wrapper">

    <section class="black-friday-sale-section section">
      <div class="container get-sells-section">
        <div class="row align-items-center">
          <div class="col-lg-6 text-center text-lg-left">
            <img class="logo default-logo img-fluid lazyload mb-4" data-src="/images/landing/debutify-logo-dark.svg" width="200" alt="Debutify" itemprop="logo">
            <h1>BLACK FRIDAY SALE 50% OFF</h1>
            <p class="font-weight-normal" style="font-size: 20px;line-height: 1.4444;">Get the #1 Shopify Theme to Boost Sales and Drive Conversions
            <br/> Save Up To 50% On The First 3 Months!
            <br/>LIMITED TIME OFFER!</p>
            <div class="download-wrapper">
              <div class="user-ratings mb-3 justify-content-start">
                @include ("components.star-rating-badges")
              </div>
              <div class="download-btn mb-4 text-center text-lg-left">
                <button class="btn btn-primary btn-lg mb-3 animated pulse infinite" data-cta-tracking="{{ $cta_tracking ?? '' }}" data-toggle="modal" data-target="#downloadModal">YES! I WANT MY DISCOUNT!</button>
              </div>
                <div class="card-deck text-center">
                  <div class="card">
                    <div class="card-body">
                      <span  class= "h2 font-weight-normal"  id="black_sale_countdown_days"></span>
                      <p class="text-muted small">Days</p>
                    </div>
                  </div>
                   <div class="card">
                    <div class="card-body">
                      <span  class= "h2 font-weight-normal"  id='black_sale_countdown_hours'></span>
                      <p class="text-muted small">Hours</p>
                    </div>
                  </div>
                   <div class="card">
                    <div class="card-body">
                      <span class= "h2 font-weight-normal" id='black_sale_countdown_minutes'></span>
                      <p class="text-muted small">Minutes</p>
                    </div>
                  </div>
                   <div class="card">
                    <div class="card-body">
                      <span  class= "h2 font-weight-normal"  id='black_sale_countdown_seconds'></span>
                      <p class="text-muted small">Seconds</p>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-lg-6 mt-4 mt-lg-0">
            <div class="embed-responsive embed-responsive-16by9 mb-3">
              <iframe class="embed-responsive-item" width="560" height="315" src="https://www.youtube.com/embed/jyADqBzVkHQ?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
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
            <p class="lead"><u>As Featured On:</u></p>
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

    <section class="building-shopify-section section">
      <div class="bg-angle"></div>
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1 text-center">
            <h2>Building a Shopify Store That Makes Thousands Doesn't Have To Be Hard! </h2>
            <p>There's one reason why most aspiring dropshippers are not becoming millionaires and leaving their 9-to-5's. It's because they can't figure out how to make their Shopify store ACTUALLY generate sales!</p>

            <p>Truth is you don't need to have a PhD. in marketing or be an expert programmer to build a thriving eCommerce business. All you need is two things. A Shopify theme with everything you need for high-conversions included, and the right time of the year to start...</p>
          </div>
        </div>

      </div>
    </section>
</div>

    <section class="quote-section bg-gradient text-white my-0 section py-md-0">
        <div class="container">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 offset-quote-img">
                    <img data-src="images/new/chart.png" alt="" class="img-fluid chart-img rounded shadow lazyload">
                </div>
                <div class="col-md-8 py-0 py-md-5 mb-3 mb-md-0">
                    <p><span class="fas fa-quote-left fa-3x" aria-hidden="true"></span></p>
                    <h6 class="font-weight-normal mb-3"><strong>Seriously amazing app and support.</strong> Do not be afraid to try debutify out for yourself. Customer support reply in less than 20 min.</h6>
                    <p>— <strong>Silas Nielsen,</strong> made over $5M with debutify</p>
                </div>
            </div>
        </div>
    </section>
<div class="angle-wrapper">
    <section class="word-as-much-section section">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1 text-center">
            <h2>Work as Much as You Want <br class="d-none d-md-block">From Anywhere In The World</h2>
            <p>How would your life be like if you had a passive income source that generates thousands while you sleep? All by just working a couple hours per day. Imagine working from anywhere in the world and having a life full of luxury and travelling.</p>
            <p>Debutify is here to make that dream come true.</p>
            <button class="btn btn-primary btn-lg download-cta mt-4" data-cta-tracking="" data-toggle="modal" data-target="#downloadModal">GET DEBUTIFY NOW!</button>
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
                      <h2>Trusted by Leading<br class="d-none d-md-block"> E-Commerce Entrepreneurs</h2>
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


    <section class="eCommerce-empire-section section">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1 text-center">
            <h2>Everything You Need to Build Your eCommerce Empire</h2>
            <p>Debutify makes creating an online store that makes you thousands easy! It includes all the features 7-Figure entrepreneurs use to run successful eCommerce stores. Even if you have ZERO experience and no marketing skills.</p>
            <p>Get it with a 50% OFF for the first three months. This offer will disappear FOREVER after Black Friday!</p>
            <button class="btn btn-primary btn-lg download-cta mt-4" data-cta-tracking="" data-toggle="modal" data-target="#downloadModal">GET DEBUTIFY NOW!</button>
          </div>
        </div>
      </div>
    </section>
</div>
    <section class="quote-section bg-gradient text-white my-0 my-md-5 section py-md-0">
        <div class="container">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-8 py-0 py-md-5 mb-3 mb-md-0">
                    <p><span class="fas fa-quote-left fa-3x" aria-hidden="true"></span></p>
                    <h6 class="font-weight-normal mb-3"><strong>Seriously amazing app and support.</strong> Do not be afraid to try debutify out for yourself. Customer support reply in less than 20 min.</h6>
                    <p>— <strong>Silas Nielsen,</strong> made over $5M with debutify</p>
                </div>
                <div class="col-md-4 offset-quote-img">
                    <img data-src="images/new/chart.png" alt="" class="img-fluid chart-img rounded shadow lazyload">
                </div>
            </div>
        </div>
    </section>

    <!-- Visitors buyers section -->
<div class="angle-wrapper">
    <section class="visitors-buyers-section section">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1 text-center">
            <h2>All You Need To Convert Visitors Into Buyers</h2>
          </div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-6 mb-4 mb-md-0 text-center">
            <img data-src="images/new/explode-sale.png" alt="" class="features-img img-fluid lazyload">
          </div>
          <div class="col-md-6">
            <h3>31+ Add-Ons to Boost Your Conversions.</h3>
            <p>From Add-To-Cart animations and Cart Discounts and Color Swatches, Debutify comes out-of-the-box with all the features you need to increase your conversion rates and make more cash!</p>
          </div>
        </div>

        <div class="row align-items-center">
          <div class="col-md-6 order-md-1 mb-4 mb-md-0">
            <img data-src="images/new/funnel.png" alt="" class="img-fluid lazyload">
          </div>
          <div class="col-md-6">
            <h3>Find Winning Products For Your Store In 1-Click</h3>
            <p>Afraid you won't make any sales this Black Friday because everyone is selling the same? Our Winning Product Research Tool will find new products in unsaturated niches every week for you.</p>
          </div>
        </div>

        <div class="row align-items-center section">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="row no-gutters">
              <div class="col-6 col-md-4 py-1 px-1">
                <img data-src="images/new/oberlo.png" alt="oberlo" class="img-fluid lazyload">
              </div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/smsbump.png" alt="smsbump" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/klaviyo.png" alt="klaviyo" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/hubspot.png" alt="hubspot" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/printful.png" alt="printful" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/spocket.png" alt="spocket" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/sendinblue.png" alt="sendinblue" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/shipstation.png" alt="shipstation" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/doofinder.png" alt="doofinder" class="img-fluid lazyload"></div>
              <div class="col-6 col-md-4 py-1 px-1"><img data-src="images/new/quickbooks.png" alt="quickbooks" class="img-fluid lazyload"></div>
            </div>
          </div>
          <div class="col-md-6">
            <h3>Integrations With Leading Shopify Apps</h3>
            <p><span class="badge bg-gradient text-white">Coming Soon</span></p>
            <p>Hubspot, Oberlo, Quickbooks, and more. Debutify integrates perfectly with all the leading apps you need to run your business.</p>
          </div>
        </div>

        <div class="row align-items-center section">
          <div class="col-md-6 order-md-1 mb-4 mb-md-0 text-center">
            <div class="card-deck">
                <div class="card mb-3">
                    <div class="card-body">
                        <img data-src="images/new/ecom-lifestyle.png" alt="" class="img-fluid rounded-circle shadow lazyload">
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <img data-src="images/new/shopify.png" alt="" class="img-fluid rounded-circle shadow lazyload">
                    </div>
                </div>
                <div class="w-100 d-sm-block d-lg-none"></div>
                <div class="card mb-3">
                    <div class="card-body">
                        <img data-src="images/new/fb-ads.png" alt="" class="img-fluid rounded-circle shadow lazyload">
                    </div>
                </div>
                <div class="w-100 d-none d-lg-block"></div>
                <div class="card mb-3">
                    <div class="card-body">
                        <img data-src="images/new/google-mastery.png" alt="" class="img-fluid rounded-circle shadow lazyload">
                    </div>
                </div>
                <div class="w-100 d-sm-block d-lg-none"></div>
                <div class="card mb-3">
                    <div class="card-body">
                        <img data-src="images/new/product-search.png" alt="" class="img-fluid rounded-circle shadow lazyload">
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <img data-src="images/new/youtube-video.png" alt="" class="img-fluid rounded-circle shadow lazyload">
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-6">
            <h3>Advanced Courses With Exclusive eCommerce Secrets</h3>
            <p>Ever wondered what techniques do 7-Figure Entrepreneurs use to make millions with dropshipping? In these exclusive courses, you will learn their secrets to create high-converting Shopify store from scratch.</p>
          </div>
        </div>

        <div class="row align-items-center section pb-0">
          <div class="col-md-6 mb-4 mb-md-0">
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
                    <div class="w-100 d-none d-lg-block"></div>
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
          </div>
          <div class="col-md-6">
            <h3>A Customer Support Team Available 24/7</h3>
            <p>Need a customized change? Have a problem with your store? Using Debutify means having a support team ready to help you when you need it. Our team of professionals will always be there for you to solve any problem you might have.</p>
          </div>
        </div>

      </div>
      <div class="bg-angle"></div>
    </section>
</div>



    <section class="perfect-time-section bg-gradient text-white section">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 offset-lg-1 text-center">
            <h2>Now's The Perfect Time To Start Your Shopify Store!</h2>
            <p>
              Black Friday is almost here. Millions of customers will be buying online for the holidays. Get your store setup today with a 50% OFF for the first 3 months on any of our plans. After Black Friday, this deal will be gone FOREVER!
          </p>
          <div class="mt-4">
              <button class="btn btn-primary btn-lg" data-cta-tracking="" data-toggle="modal" data-target="#downloadModal"> GIVE ME MY DISCOUNT!</button>
              <button class="btn btn-outline-warning btn-lg download-cta ml-lg-4 mt-4 mt-lg-0" data-cta-tracking="" data-toggle="modal" data-target="#downloadModal"><span class="fas fa-download" aria-hidden="true"></span> DOWNLOAD THE FREE VERSION</button>
            </div>
        </div>
      </div>
    </div>
  </section>


  <!-- powerful-feature-section -->
<div class="angle-wrapper">
  <section class="powerful-feature-section section">
    <div class="bg-angle"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center">
          <h2>Powerful Features. <br>More Sales</h2>
        </div>
      </div>

      <div class="row align-items-center section">
          <div class="col-md-6 order-md-1 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Sticky add-to-cart" data-subtitle="Display a sticky add-to-cart bar when scrolling passed the add-to-cart button." class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            <?php $addon = new stdClass(); ?>

                            @php($addon->title = 'Sticky add-to-cart')
                            @include("components.image-addons")
                        </a>
          </div>
          <div class="col-md-6">
            <h3>Remember Visitors to Buy From You</h3>
            <p>Encourage users to add products to their carts with a Sticky Add-To-Cart button that remains visible to users as they scroll down.</p>
          </div>
        </div>

        <div class="row align-items-center">
          <div class="col-md-6 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Upsell pop-up" data-subtitle="Display an upsell popup that trigger when adding a product to cart" class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            <?php $addon = new stdClass(); ?>
                            @php($addon->title = 'Upsell pop-up')
                            @include("components.image-addons")
                        </a>
          </div>
          <div class="col-md-6">
            <h3>Get Their Attention Back</h3>
            <p>Use Pop Ups to reward users who intent to leave your store and motivate them to buy. Capture email addresses to promote your products.</p>
          </div>
        </div>

        <div class="row align-items-center section">
          <div class="col-md-6 order-md-1 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Product tabs" data-subtitle="Display organised tabs on your product page." class="mb-3 mb-md-0 shadow d-block">
                          <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                          <?php $addon = new stdClass(); ?>
                          @php($addon->title = 'Product tabs')
                          @include("components.image-addons")
                      </a>
          </div>
          <div class="col-md-6">
            <h3>Give users a great experience</h3>
            <p>Use customizable product tabs to organize your content and impress potential customers. This will attract their interest and make them buy from you.</p>
          </div>
        </div>

        <div class="row align-items-center">
          <div class="col-md-6 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Trust badge" data-subtitle="Display a trust badge under the add-to-cart and checkout buttons.." class="mb-3 mb-md-0 shadow d-block">
                        <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                        <?php $addon = new stdClass(); ?>
                        @php($addon->title = 'Trust badge')
                        @include("components.image-addons")
                    </a>
          </div>
          <div class="col-md-6">
            <h3>Make Your Visitors Feel Safe</h3>
            <p>Earn your customer's trust and remove their resistance to buy from you by using Trust Badges. Using this will make users trust your store and make a purchase.</p>
          </div>
        </div>

        <div class="row align-items-center section">
          <div class="col-md-6 order-md-1 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Sales pop" data-subtitle="Display a notification of past purchases.." class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            <?php $addon = new stdClass(); ?>
                            @php($addon->title = 'Sales pop')
                            @include("components.image-addons")
                        </a>
          </div>
          <div class="col-md-6">
            <h3>Build Social Proof</h3>
            <p>Use Debutify's Sales Pop to show recent orders and product reviews to potential customers. This will make your product look in-demand and make clients trust your store.</p>
          </div>
        </div>

        <div class="row align-items-center">
          <div class="col-md-6 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Cart countdown" data-subtitle="Display a Countdown Timer in the cart drawer/page." class="mb-3 mb-md-0 shadow d-block">
                          <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                          <?php $addon = new stdClass(); ?>
                          @php($addon->title = 'Cart discount')
                          @include("components.image-addons")
                      </a>
          </div>
          <div class="col-md-6">
            <h3>Create Urgency in Your Buyers</h3>
            <p>Debutify's cart Countdown Timer is an amazing tool for increasing your conversions. It makes your product look scarce and encourages your customer to take action.</p>
          </div>
        </div>

        <div class="row align-items-center section">
          <div class="col-md-6 order-md-1 mb-4 mb-md-0">
            <a href="javascript:void(0);" data-toggle="modal" data-target="#videoModal" data-title="Upsell bundles" data-subtitle="Display frequently bought together product bundles." class="mb-3 mb-md-0 shadow d-block">
                            <span class="fab fa-youtube fa-6x text-primary icon-hover"></span>
                            <?php   $addon = new stdClass(); ?>
                            @php($addon->title = 'Upsell bundles')
                            @include("components.image-addons")
                        </a>
          </div>
          <div class="col-md-6">
            <h3>Upsell Bundle</h3>
            <p>Debutify's Upsell Bundle Add-On shows products frequently bought together to visitors ready to make a purchase. Some clients have seen the Average Order Value of their stores by more than 27%!</p>
          </div>
        </div>
        <div class="text-center">
          <button class="btn btn-primary btn-lg download-cta" data-cta-tracking="" data-toggle="modal" data-target="#downloadModal">GET DEBUTIFY NOW!</button>
        </div>

    </div>
  </section>
</div>
<section class="quote-section bg-gradient text-white my-0 my-md-5 section py-md-0">
        <div class="container">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 offset-quote-img">
                    <img data-src="images/new/chart.png" alt="" class="img-fluid chart-img rounded shadow lazyloaded" src="images/new/chart.png">
                </div>
                <div class="col-md-8 py-0 py-md-5 mb-3 mb-md-0">
                    <p><span class="fas fa-quote-left fa-3x" aria-hidden="true"></span></p>
                    <p class="mb-3">Debutify is without question the best Shopify theme available. Free or not. It offers more features than almost any theme out there, the code is extremely well written and very easy to modify (if you're into that sorta thing), and most importantly the customer support is nothing less than amazing. Raphael and team go above and beyond to help with anything you need, and never price gauge you with small edits or support. With Debutify you're given an amazing foundation on which to grow your business. I left my very expensive paid theme for Debutify, and I haven't looked back for even one second. <strong>Debutify is 10/10!</strong></p>
                    <p>— <strong>Jared Bolokofsky,</strong> Made over $5,000,000 with his debutify store</p>
                </div>
            </div>
        </div>
    </section>
    <div class="angle-wrapper">
        <!-- section author -->
        <section class="author-section section">
            <div class="container">
                <div class="row text-center text-md-left">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h4><span class="badge bg-gradient text-white">Course Author</span></h4>
                        <h2>7-Figure E-Commerce &amp; Dropshipping Master, Ricky Hayes</h2>
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
        <!-- section entrepreneur -->
        <section class="entrepreneur-section section">
          <div class="bg-angle"></div>
            <div class="container">
                <div class="row mb-3">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <h2>What our {{$nbShops}}+ customers say</h2>
                        <p class="lead">We're the World's #1 Free Shopify Theme</p>
                    </div>
                </div>
                <div class="row mb-3">
                  <div class="col">
                      <div data-rw-masonry="20376"></div>
                  </div>
                </div>
                <div class="text-center">
                  <button class="btn btn-primary btn-lg download-cta" data-cta-tracking="" data-toggle="modal" data-target="#downloadModal">GET DEBUTIFY NOW!</button>
                </div>
            </div>
        </section>
        <hr>
  <section class="section">
    <div class="container">
      <div class="row mb-3">
        <div class="col-lg-10 offset-lg-1 text-center">
          <h2>Get #1 Shopify Theme With A 50% OFF</h2>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="planSwitch">
            <label class="custom-control-label" for="planSwitch">Yearly plan discount <span class="badge badge-warning">Save 50%</span></label>
          </div>
        </div>
      </div>
      <div class="row text-center price-plan-section">
        <div class="col">
          <div class="card-deck text-center">
            <div class="card bg-primary text-white mb-3">
              <div class="card-img-top">
                <img data-src="images/new/free-plan.png" alt="" class="img-fluid pt-4 pb-4 lazyload">
                <div class="plan-price">
                  <h4><strong>$0</strong></h4>
                  <h6>Free</h6>
                  <p>1 Store License</p>
                </div>
              </div>
              <div class="card-body">
                <p>Debutify Theme</p>
                <p>Facebook group (Support)</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-outline-light download-cta" data-cta-tracking="cta-24" data-toggle="modal" data-target="#downloadModal">Download Now</button>
              </div>
            </div>
            <div class="card bg-primary text-white mb-3">
              <div class="card-img-top">
                <img data-src="images/new/starter-plan.png" alt="" class="img-fluid pt-4 pb-4 lazyload" />
                <div class="plan-price">
                  <h4><strong class="starter-price">$9.5</strong><span class="term-plan">/Month</span></h4><p>DISCOUNT APPLIES TO FIRST 3 MONTHS ONLY</p>
                  <h6>Starter</h6>
                  <p>1 Store License</p>
                </div>
              </div>
              <div class="card-body">
                <p>Debutify Theme</p>
                <p>Facebook, email, live chat <strong>(Full Support)</strong></p>
                <p>Any 5 Add-Ons</p>
                <p>Integrations</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-outline-light download-cta" data-cta-tracking="cta-25" data-toggle="modal" data-target="#downloadModal">I Want My Discount!</button>
              </div>
            </div>
            <div class="w-100 d-sm-block d-lg-none"></div>
            <div class="card bg-gradient text-white mb-3 hustler-plan">
              <div class="card-img-top">
                <h6 class="position-absolute w-100 text-center" style="margin-top:-17px">
                  <div class="badge badge-warning">
                    <span class="fas fa-star animated tada infinite"></span>
                    Most Popular
                  </div>
                </h6>
                <img data-src="images/new/hustler-plan.png" alt="" class="img-fluid pt-4 pb-4 lazyload" />
                <div class="plan-price">
                  <h4><strong class="hustler-price">$23.5</strong><span class="term-plan">/Month</span></h4><p>DISCOUNT APPLIES TO FIRST 3 MONTHS ONLY</p>
                  <h6>Hustler</h6>
                  <p>1 Store License</p>
                </div>
              </div>
              <div class="card-body">
                <p>Debutify Theme</p>
                <p>Facebook, email, live chat <strong>(Full Support)</strong></p>
                <p>Any 30 Add-Ons</p>
                <p>Integrations</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-warning animated pulse infinite download-cta" data-cta-tracking="cta-26" data-toggle="modal" data-target="#downloadModal">I Want My Discount!</button>
              </div>
            </div>
            <div class="card bg-primary text-white mb-3">
              <div class="card-img-top">
                <img data-src="images/new/guru-plan.png" alt="" class="img-fluid pt-4 pb-4 lazyload" />
                <div class="plan-price">
                  <h4><strong class="guru-price">$48.5</strong><span class="term-plan">/Month</span></h4><p>DISCOUNT APPLIES TO FIRST 3 MONTHS ONLY</p>
                  <h6>Master</h6>
                  <p>3 Store Licenses</p>
                </div>
              </div>
              <div class="card-body">
                <p>Debutify Theme</p>
                <p>Facebook, email, live chat <strong>(Priority Full Support)</strong></p>
                <p>All 41 Add-Ons and future Add-Ons</p>
                <p>Integrations</p>
                <p>Mentoring</p>
                <p>Product research tool</p>
                <p>Advanced Courses</p>
              </div>
              <div class="card-footer">
                <button class="btn btn-outline-light download-cta" data-cta-tracking="cta-27" data-toggle="modal" data-target="#downloadModal">I Want My Discount!</button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

<hr>

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
     <!-- section cash printing -->
    <section class="cash-printing-section section bg-overlay-image">
        <div class="container">
            <div class="row mb-3">
                <div class="col-lg-10 offset-lg-1 text-center text-white">
                    <h2>Ready to launch your eCommerce business and start making money?</h2>
                    <p class="lead">
                        Launch your store today in one click and get one step closer to the life of your dreams!
This is an exclusive Black Friday Deal!
                    </p>
                    <p class="lead">Get All Debutify's Premium Plans With a 50% OFF For The First 3 Months.</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col">
                  <button class="btn btn-primary btn-lg download-cta" data-cta-tracking="cta-20" data-toggle="modal" data-target="#downloadModal"> YES! I WANT MY DISCOUNT</button>
                    <button class="btn btn-outline-warning btn-lg ml-lg-4 mt-4 mt-lg-0 download-cta" data-cta-tracking="cta-20" data-toggle="modal" data-target="#downloadModal"><span class="fas fa-download" aria-hidden="true"></span>  DOWNLOAD THE FREE VERSION</button>
                </div>
            </div>
        </div>
    </section>

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
        <button class="btn btn-primary btn-lg download-cta" data-cta-tracking="cta-30" data-dismiss="modal" data-toggle="modal" data-target="#downloadModal">
            <span class="fas fa-download" aria-hidden="true"></span>
            Get This Now!
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

      $(document).ready(function(){
          var code = getUrlVars()["code"];
          if( !code ) {
            setCookie('discount-code', 'BLACKFRIDAY50', 60);
          }
        });

        // Set the date we're counting down to
        // var countDownDate =  new Date('2020-11-27'.replace(/-/g, "/")).getTime();

        // // Update the count down every 1 second
        // var x = setInterval(function() {

        //   // Get today's date and time
        //   var now = new Date().getTime();

        //   // Find the distance between now and the count down date
        //   var distance = countDownDate - now;

        //   // Time calculations for days, hours, minutes and seconds
        //   var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        //   var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        //   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        //   var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        //   // Display the result in the element with id="demo"
        //   document.getElementById("black_sale_countdown_days").innerHTML = days;
        //    document.getElementById("black_sale_countdown_hours").innerHTML = hours;
        //    document.getElementById("black_sale_countdown_minutes").innerHTML = minutes;
        //    document.getElementById("black_sale_countdown_seconds").innerHTML = seconds;

        //   // If the count down is finished, write some text
        //   if (distance < 0) {
        //     clearInterval(x);
        //     document.getElementById("black_sale_countdown").innerHTML = "EXPIRED";
        //   }
        // }, 1000);


        count_down_timer_repeat();
        function count_down_timer_repeat(){
          localStorage.setItem("minutes",15 + ':' + 00);
          var interval_time = localStorage.getItem('minutes');
          if (interval_time != null ) {
              var timer2 = interval_time;
          }else{
              var timer2 = "15:00";
          }

          var interval = setInterval(function() {
          localStorage.setItem("minutes",minutes + ':' + seconds);
          var timer = timer2.split(':');
          var minutes = parseInt(timer[0], 10);
          var seconds = parseInt(timer[1], 10);
          --seconds;
          minutes = (seconds < 0) ? --minutes : minutes;
          seconds = (seconds < 0) ? 59 : seconds;
          seconds = (seconds < 10) ? '0' + seconds : seconds;
          minutes = (minutes < 10) ?  '0' + minutes : minutes;
          $('span#black_sale_countdown_days').html("00");
          $('span#black_sale_countdown_hours').html("00");
          $('span#black_sale_countdown_minutes').html(minutes);
          $('span#black_sale_countdown_seconds').html(seconds);
          if (minutes < 0) clearInterval(interval);
          //check if both minutes and seconds are 0
          if ((seconds <= 0) && (minutes <= 0)) {
            clearInterval(interval);
            localStorage.removeItem('minutes');                       // Remove item
            // count_down_timer_repeat();
          }
          timer2 = minutes + ':' + seconds;
        }, 1000);

        }

      </script>
@endsection
