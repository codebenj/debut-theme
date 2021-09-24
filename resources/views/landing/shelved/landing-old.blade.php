@extends('layouts.landing-old')

@section('title',"Debutify - World's Smartest Shopify Theme. Free 14-day Trial")

@section('styles')
<style>
.slider{
  margin: auto;
  overflow: hidden;
  position: relative;
}
.slide-track{
  animation: scroll {{$nbAddons * 2}}s linear infinite;
  display: flex;
  width: calc(340px * {{$nbAddons + 6}});
}
.slide {
   width: 340px;
}
.slider-inner{
  width: 300px;
  margin: 0px auto;
  text-align: center;
}
.slide-track .slide:nth-child(3n){
  animation-duration: 3s;
}
.slide-track .slide:nth-child(3n+1){
  animation-duration: 5s;
}
.slide-track .slide:nth-child(3n+2){
  animation-duration: 4s;
}
.slide-track:hover {
    -webkit-animation-play-state: paused;
    -moz-animation-play-state: paused;
    -o-animation-play-state: paused;
    animation-play-state: paused;
}

@-webkit-keyframes scroll {
  0% {
      transform: translateX(0);
  }
  100% {
      transform: translateX(calc(-340px * {{$nbAddons}} ));
  }
}
@keyframes scroll {
  0% {
      transform: translateX(0);
  }
  100% {
      transform: translateX(calc(-340px * {{$nbAddons}} ));
  }
}
</style>
@endsection

@section('content')
  <div class="section d-flex align-items-center bg-gradient text-light">
    <div class="container">
      <div class="row mb-3">
        <div class="col-12 text-center">
          <h1 class="display-5">
            <span class="display-3 ">
              Explode your sales now
            </span>
            <br class="d-none d-md-block">
            <span>
              The highest converting FREE shopify theme
            </span>
          </h1>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-md-6 mb-3 mb-md-0">
          <div class="video-wrapper">
            <iframe class="rounded lazyload" width="100%" height="305" data-src="https://www.youtube.com/embed/xlAh2CMwL8k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <p class="text-center mt-2">Instantly get an unfair advantage on your competition.</p>
        </div>
        <div class="col-md-6 text-center">
          <h2 class="h4">Get your sales Boosted in One-Click with the World's #1 FREE and converting Optimized Shopify Theme.⚡</h2>
          <p>Easy plug & play setup. No coding. Get started in seconds.</p>
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

  <div class="image-banner text-center">
    <img data-src="/images/debutify-pitch-1.png" width="500px" class="image-left lazyload" alt="">
    <img data-src="/images/debutify-pitch-3.png" width="500px" class="image-right lazyload" alt="">
  </div>

  <div class="section py-5 bg-grey">
    <div class="container">
      <div class="row text-center align-items-center">
				<p class="lead mb-md-0 w-100 w-md-auto col-md">As featured on</p>
        <div class="col-6 col-md mb-5 mb-md-0">
          <a target="_blank" href="https://www.shopify.com/?ref=debutify&utm_campaign=website">
            <img class="px-0 px-sm-3 lazyload" data-src="/images/shopify-logo.png" width="200" alt="shopify">
          </a>
        </div>
        <div class="col-6 col-md mb-5 mb-md-0">
          <img class="px-0 px-sm-3 lazyload" data-src="/images/oberlo-logo.png" width="200" alt="oberlo">
        </div>
        <div class="col-4 col-md">
          <img class="px-0 px-sm-3 lazyload" data-src="/images/techstars-logo.png" width="200" alt="techstars">
        </div>
        <div class="col-4 col-md">
          <img class="px-0 px-sm-3 lazyload" data-src="/images/betakit-logo.png" width="200" alt="betakit">
        </div>
        <div class="col-4 col-md">
          <img class="px-0 px-sm-3 lazyload" data-src="/images/geekwire-logo.png" width="200" alt="geekwire">
        </div>
      </div>
    </div>
  </div>

	<div class="section">
    <div class="container">

      <div class="row text-center">
        <div class="col">
          <h2 class="display-4">The perfect store <br class="d-none d-md-block">ready <span class="text-primary underline">out of the box</span></h2>
          <!-- <p class="lead">100% optimized for General stores, Niche stores, One product stores and Funnels!</p> -->
          <p class="lead">Debutify theme is 100% optimized for Dropshipping, Print on demand and Brand stores!</p>
        </div>
      </div>

      <!-- <div class="row text-center justify-content-center mb-3">
				<div class="col-6 col-md-2 mb-3 mb-md-0">
					<p class="fa-stack fa-3x animated infinite upAndDown">
					  <i class="fas fa-circle fa-stack-2x text-primary"></i>
					  <i class="fas fa-fire fa-stack-1x fa-inverse"></i>
					</p>
					<h6>General stores</h6>
				</div>
				<div class="col-6 col-md-2 mb-3 mb-md-0">
					<p class="fa-stack fa-3x animated infinite upAndDown delay-1">
					  <i class="fas fa-circle fa-stack-2x text-danger"></i>
					  <i class="fas fa-cat fa-stack-1x fa-inverse"></i>
					</p>
					<h6>Niche stores</h6>
				</div>
				<div class="col-6 col-md-2 mb-3 mb-md-0">
					<p class="fa-stack fa-3x animated infinite upAndDown delay-2">
					  <i class="fas fa-circle fa-stack-2x text-success"></i>
					  <i class="fas fa-blender fa-stack-1x fa-inverse"></i>
					</p>
					<h6>One product stores</h6>
				</div>
				<div class="col-6 col-md-2">
					<p class="fa-stack fa-3x animated infinite upAndDown delay-3">
					  <i class="fas fa-circle fa-stack-2x text-warning"></i>
					  <i class="fas fa-funnel-dollar fa-stack-1x fa-inverse"></i>
					</p>
					<h6>Funnels</h6>
				</div>
			</div> -->

      <div class="row justify-content-center">
        <div class="col">
          <a href="https://debutifydemo.myshopify.com/products/chaoswen" target="_blank" class="icon-wrapper">
            <span class="fas fa-eye fa-3x text-danger hover-icon"></span>
            <img class="img-fluid lazyload" data-src="/images/debutify-demo.png" width="100%" alt="demo store">
          </a>
        </div>
      </div>

      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section bg-grey">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Unlock Premium Add-Ons<br class="d-none d-md-block"> <span class="text-primary">skyrocket your conversion rate</span></h2>
          <p class="lead">Save thousands of dollars on costly Shopify Apps while making more money with our conversion hacks!</p>
        </div>
      </div>
    </div>
    <div class="slider pb-5">
      <div class="slide-track">
        @foreach($global_add_ons as $addon)
        <div class="slide animated infinite upAndDown">
          <div class="slider-inner">
            <h6>{{ $addon->title }}</h6>
            <div class="addon-img-wrapper" onclick="return addonVideo('{{ $addon->title }}','{{ $addon->subtitle }}');">
              <span class="fab fa-youtube fa-3x text-danger hover-icon"></span>
              @include("components.image-addons")
            </div>
          </div>
        </div>
        @endforeach

        @foreach($global_add_ons as $addon)
        <div class="slide animated infinite upAndDown" onclick="return addonVideo('{{ $addon->title }}','{{ $addon->subtitle }}');">
          <div class="slider-inner">
            <h6>{{ $addon->title }}</h6>
            <div class="addon-img-wrapper">
              <span class="fab fa-youtube fa-3x text-danger animated infinite puslse addon-icon"></span>
              @include("components.image-addons")
            </div>
          </div>
        </div>
        @if($loop->iteration == 6)
          @break
        @endif
        @endforeach
      </div>
    </div>
    <div class="container">
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Free <span class="text-primary">lifetime updates</span></h2>
          <p class="lead">Update your theme and get the latest features in one-click for free!</p>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-12 col-md mb-3 mb-md-0 icon-wrapper">
          <span class="fas fa-sync fa-3x text-danger hover-icon fa-spin"></span>
          <img class="img-fluid rounded" src="/images/debutify-product-page.png" width="100%" alt="theme features">
        </div>
        <div class="col-12 col-md">
					<ul class="list-unstyled lead">
            <!-- <h3>No more headaches!</h3> -->
            <li><span class="fas fa-check-circle text-primary"></span> Keep your store updated at all time</li>
            <li><span class="fas fa-check-circle text-primary"></span> Saves $100's in website maintenance fees</li>
            <li><span class="fas fa-check-circle text-primary"></span> Save tons of time not re-design your store</li>
						<li><span class="fas fa-check-circle text-primary"></span> Always get the latest features on your store</li>
            <li><span class="fas fa-check-circle text-primary"></span> Update Debutify on the go from any devices</li>
					</ul>
          <img class="img-fluid mb-3" src="/images/debutify-theme-updater-review.png" width="100%" alt="theme features">
          <!-- <small class="text-muted">*Competitors theme updater apps cost more than $108+ per year.</small> -->
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
				</div>
      </div>
    </div>
  </div>

  <div class="section bg-grey">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Boost conversions with our Super fast <span class="text-primary">2 seconds</span> load times</h2>
          <p class="lead">Debutify theme is 100% optimized to be lightning fast to get the maximum amount of sales!</p>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12">
          <img class="img-fluid rounded" src="/images/debutify-theme-speed.png" width="100%" alt="debutify theme speed">
          <small class="text-muted">*Results from Google PageSpeed Insights</small>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
            <span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4"><span class="text-primary">Mobile first</span> optimized layout</h2>
          <p class="lead">It's more important than ever to have an astounding mobile shopping experience.</p>
        </div>
      </div>
      <div class="row align-items-center text-center">

        <div class="col-md-3">
          <blockquote class="blockquote text-center">
            <p class="mb-0">
              <span class="fas fa-quote-left text-warning"></span>
              Mobile shopping is the future of eCommerce. Over 45% of all online purchases are being made on mobile devices and it’s expected to reach 55% by 2021
              <span class="fas fa-quote-right text-warning"></span>
            </p>
          </blockquote>
				</div>

        <div class="col-md-6">
          <img class="img-fluid" src="/images/debutify-mobile-first.png" width="100%" alt="theme features">
        </div>

        <div class="col-md-3">
          <p class="">Mobile experience is our #1 priority and every update we push is built for mobile first experience so you’re prepared for the future and generate as much revenue as possible.</p>
        </div>

      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
            <span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

	<!-- <div class="section bg-grey">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md mb-3 mb-md-0">
          <img class="img-fluid rounded" src="/images/debutify-product-page.png" width="100%" alt="theme features">
        </div>
        <div class="col-12 col-md">
          <h2>The highest converting Free Shopify theme of {{ date('Y') }}!</h2>
					<ul class="list-unstyled lead">
						<li><span class="fas fa-check-circle text-primary"></span> 100% mobile friendly & optimized</li>
						<li><span class="fas fa-check-circle text-primary"></span> High converting features</li>
						<li><span class="fas fa-check-circle text-primary"></span> Fast page loading speed</li>
						<li><span class="fas fa-check-circle text-primary"></span> Regular updates + Premium support</li>
						<li><span class="fas fa-check-circle text-primary"></span> Plug & Play. No coding required</li>
						<li><span class="fas fa-check-circle text-primary"></span> Advanced customizing options</li>
					</ul>
					<a href="/theme" class="btn btn-outline-primary">See theme features</a>
				</div>
      </div>
    </div>
  </div> -->

	<!-- <div class="section bg-grey">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md mb-3 mb-md-0 order-md-2">
          <img class="img-fluid rounded" src="/images/debutify-app.png" width="100%" alt="premium features">
        </div>
        <div class="col-12 col-md">
          <h2>Pre-built Plug & play premium features available in one click!</h2>
					<ul class="list-unstyled lead">
						<li><span class="fas fa-check-circle text-primary"></span> Upsell Pop-up</li>
						<li><span class="fas fa-check-circle text-primary"></span> Sticky add-to-cart</li>
						<li><span class="fas fa-check-circle text-primary"></span> Collection add-to-cart</li>
						<li><span class="fas fa-check-circle text-primary"></span> Newsletter pop-up (exit-intent)</li>
						<li><span class="fas fa-check-circle text-primary"></span> Product tabs</li>
						<li><span class="fas fa-check-circle text-primary"></span> Instagram feed</li>
					</ul>
          <a href="/add-ons" class="btn btn-outline-primary">See all {{$nbAddons}}+ add-ons</a>
				</div>
      </div>
    </div>
  </div> -->

  <div class="section bg-grey">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Available in <span class="text-primary">20+ languages</span> </h2>
          <p class="lead">Debutify theme is available in 20+ different languages and can easily be edited in seconds!</p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <img data-src="/images/debutify-language.png" alt="debutify theme languages" class="img-fluid mb-3 lazyload">
        </div>
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
            <span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">

      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Unmatched <span class="text-primary">24/7</span> support</h2>
          <p class="lead">Assisting you with an unparalleled customer service experience is our TOP priority here at Debutify.</p>
        </div>
      </div>

      <div class="row align-items-center mb-3">
        <div class="col-md">
          <img data-src="/images/debutify-support-1.png" alt="debutify support" class="img-fluid mb-3 mb-md-0 lazyload">
        </div>
        <div class="col-md text-center">
          <img data-src="/images/debutify-support-review.png" alt="" class="image-fluid mb-3 mb-md-5 lazyload">
          <img data-src="/images/debutify-support-review-1.png" alt="" class="image-fluid lazyload">
          <!-- <p class="lead">Debutify is proud to have a growing team of over 10+ highly skilled profesionnals all over the world, including USA, Ukraine, Finland, Indonesia, Philippines, India and Canada.</p> -->
        </div>
      </div>

      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
            <span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="section bg-grey">
  	<div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <span class="badge badge-warning mb-2">GURU EXCLUSIVE</span>
          <h2 class="display-4"><span class="text-primary">Premium step-by-step</span><br class="d-none d-md-block"> training courses</h2>
          <p class="lead">Starting a successful Shopify store has never been this simple.</p>
        </div>
      </div>
  		<div class="row text-center mb-gutter">
        <div class="col-md mb-3">
          <!-- <h6>Shopify store setup</h6> -->
          <img data-src="/images/debutify-shopify-store-setup-course.jpg" class="rounded img-fluid animated slow infinite upAndDown lazyload" alt="Shopify store setup course">
        </div>
  			<div class="col-md mb-3">
  				<!-- <h6>Product research</h6> -->
  				<img data-src="/images/debutify-winning-product-research-course.jpg" class="rounded img-fluid animated slow infinite upAndDown delay-1 lazyload" alt="Winning product research course">
  			</div>
  			<div class="col-md mb-3">
  				<!-- <h6>Facebook ads</h6> -->
  				<img data-src="/images/debutify-facebook-ads-course.jpg" class="rounded img-fluid animated slow infinite upAndDown delay-2 lazyload" alt="Facebook ads course">
  			</div>
  			<div class="col-md mb-3">
  				<!-- <h6>Google ads</h6> -->
  				<img data-src="/images/debutify-google-ads-course.jpg" class="rounded img-fluid animated slow infinite upAndDown delay-3 lazyload" alt="Google ads course">
  			</div>
  		</div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
  	</div>
  </div>

  <!-- <div class="section">
  	<div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <span class="badge badge-warning mb-2">GURU EXCLUSIVE</span>
          <h2 class="display-4">Private <span class="text-primary">1-on-1 mentoring</span></h2>
          <p class="lead">Get your questions about Shopify & marketing personnaly answered by professionnals!</p>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <ul class="list-unstyled lead">
            <li><span class="fas fa-check-circle text-primary"></span> Learn from the best in the industry</li>
            <li><span class="fas fa-check-circle text-primary"></span> Chance to win a 1-on-1 FREE call with Ricky Hayes</li>
            <li><span class="fas fa-check-circle text-primary"></span> Free winning product training video</li>
            <li><span class="fas fa-check-circle text-primary"></span> Speed-up your learning curve</li>
            <li><span class="fas fa-check-circle text-primary"></span> Chat with like-minded Shopify entrepreneurs</li>
            <li><span class="fas fa-check-circle text-primary"></span> Get advised by top e-comerce owner</li>
          </ul>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
        </div>
      </div>
  	</div>
  </div> -->

  <div class="section bg-gradient text-white">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Save 1000's of dollars every year<br class="d-none d-md-block"> and countles hours of time</h2>
          <p class="lead">On average, our customers are saving over $2000 a year and over 50+ hours of web development.</p>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-warning btn-lg btn-xl animated pulse infinite toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift"></span> BONUS: Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">We let <span class="text-primary">our results talk..</span></h2>
          <p class="lead">Our members success is our top priority at Debutify, See what others have said about their experience!</p>
        </div>
      </div>

      <div class="row">
        @foreach($testimonials as $testimonial)
        <div class="col-md-6 mb-gutter">
          <div class="video-wrapper">
            <iframe class="rounded lazyload" width="100%" height="305" data-src="https://www.youtube.com/embed/{{$testimonial}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        @if($loop->iteration == 6)
          @break
        @endif
        @endforeach
      </div>
      <div data-token="MGzl6p69uxcFAoIyrfhICBQM6AE6jrdBn8eGgNE9TwG9uq03JE" class="romw-reviews"></div>
      <div class="row text-center mt-2">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
        </div>
      </div>
      <!-- <div class="masonry">
        @foreach($screenshots as $screenshot)
        <div class="item">
          <img class="img-fluid rounded" src="{{$screenshot}}">
        </div>
        @if($loop->iteration == 12)
          @break
        @endif
        @endforeach
      </div> -->
    </div>
  </div>

  <div class="section bg-grey">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">What <span class="text-primary">popular Youtubers</span><br class="d-none d-md-block"> are saying about Debutify</h2>
          <!-- <p class="lead">Our members success is our top priority at Debutify, See what others have said about their experience!</p> -->
          <blockquote class="blockquote text-center">
            <p class="mb-0"><span class="fas fa-quote-left text-warning"></span> This is the best high converting free theme I have ever encountered, and everyone should use it. <span class="fas fa-quote-right text-warning"></span></p>
            <footer class="blockquote-footer">Ricky Hayes, <cite title="Source Title">7 figure entrepreneur</cite></footer>
          </blockquote>
        </div>
      </div>
      <div class="row">
        @foreach($youtubers as $youtuber)
        <div class="col-md-6 mb-gutter">
          <div class="video-wrapper">
            <iframe class="rounded lazyload" width="100%" height="305" data-src="https://www.youtube.com/embed/{{$youtuber}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        @if($loop->iteration == 6)
          @break
        @endif
        @endforeach
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
        </div>
      </div>
    </div>
  </div>


  <!-- <div class="section border-top">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mt-md-5 mb-3 mb-md-0 order-md-3">
          <h2>Meet the team</h2>
          <p class="lead">We are working 24/7 to make sure you have the most converting Shopify store guaranteed!</p>
          <a href="/about" class="btn btn-outline-primary">Meet the team</a>
        </div>
				<div class="col-md-4 mb-3">
					<img class="rounded img-fluid mb-3" src="/images/debutify-raphael-bergeron.jpeg" alt="debutify-raphael-bergeron">
					<h4>Raphael Bergeron</h4>
					<p class="text-muted">— CEO & Founder</p>
				</div>
				<div class="col-md-4 mb-3">
					<img class="rounded img-fluid mb-3" src="/images/debutify-ricky-hayes.jpg" alt="debutify-raphael-bergeron">
					<h4>Ricky Hayes</h4>
					<p class="text-muted">— Co-founder & Head of marketing</p>
				</div>
			</div>
    </div>
  </div> -->

  <div class="section">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">
          <h2 class="display-4">Frequently asked questions</h2>
          <p class="lead">We know you have some questions in mind, we've tried to list the most important ones!</p>
        </div>
      </div>
      @include('landing.faq-module')
    </div>
  </div>

  <div class="section pt-0">
    <div class="container">
      <div class="row text-center mb-3">
        <div class="col">

          <h2 class="display-4">Join over <span class="text-primary"><span class="fas fa-store"></span> {{$nbShops + 5248}}+</span><br class="d-none d-md-block"> Shopify stores using Debutify</h2>
          <p class="lead">Get your sales Boosted in One-Click.⚡ Easy Setup. No Coding. Take less than a minute to install.</p>
        </div>
      </div>
      <div class="row text-center">
        <div class="col-12">
          <button class="btn btn-primary btn-lg btn-xl animated pulse infinite toggleModal">
						<span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
          <div class="text-center mt-2">
            <small class="font-weight-bold"><span class="fas fa-gift text-primary"></span> <span class="text-primary">BONUS:</span> Receive 5 Free winning products!</small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="videoModal">
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
          <div class="video-wrapper video-tutorial">
            <iframe class="rounded tutorial" width="100%" height="295" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary toggleModal" data-dismiss="modal">
            <span class="fas fa-bolt toggleModal" aria-hidden="true"></span>
            Free Download Now
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- google search star rating from facebook -->
  @include("components.facebook-ratings")
@endsection

@section('scripts')
<script>
  function addonVideo(title,subtitle){
    @include("components.video-addons")

    $('.tutorial').attr("src","https://www.youtube.com/embed/" + videoSource + "?autoplay=1");

    $(".addon-title").text(title);
    $(".addon-subtitle").text(subtitle);

    if(videoSource){
      $(".video-tutorial").show();
    } else{
      $(".video-tutorial").hide();
    }

    //show modal
    $('#videoModal').modal('show');
  }
</script>
@endsection
