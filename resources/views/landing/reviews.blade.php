@extends('layouts.landing')
@section('title','Reviews | Debutify')
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('styles')
<style>
	.kamil-satar{ max-width: 350px;margin-left: -15px;margin-bottom: 20px; }
	@media only screen and (min-width:992px) {
		.kamil-satar{ position: absolute;top: -16px;left: -80px;max-width: 544px;}
	}
	@media all and (max-width:767px) {
	.kamil-satar-message{ font-size: 18px;line-height: normal; }
	}
</style>
@endsection

@section('content')

<section class='debutify-section'>
	<div class='container'>
		<div class='row align-items-center'>
			<div class='col-lg-6'>
				<div class='text-center text-lg-left'>
					<h1 class='display-3'>{{$nbShops}}+</span> Ecommerce Businesses Trust Debutify </h1>
					<p class='lead mt-4 mb-3'>For a good reason. </p>
					<p class='lead'>We set out to design something more than just a high-converting Shopify theme — a true ecommerce powerhouse. To rapidly start, scale and grow your business. </p>
					<p class='lead mb-5'> The results speak for themselves. </p>
				</div>
				<x-landing.cta class='d-lg-block  d-none' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
			</div>
			<div class='col-lg-6'>
				<div class='text-center position-relative'>
					<h5 class='position-absolute text-mid-light' style="top:68%;z-index:1;left:0;right:0;">
						<span class='debutify-reviews'></span>+ REVIEWS
					</h5>
					<div class="responsive-container-4by3">
						<img class="" src="/images/landing/reviews-above-the-fold-v3.svg?v={{config('image_version.version')}}" alt="review fold Image" >
					</div>
				</div>
				<x-landing.cta class='d-flex justify-content-center justify-content-lg-start d-lg-none' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
			</div>
		</div>
	</div>
</section>


<section class='debutify-section'>
	<div class='container'>
		<h1 class='mb-5 text-center display-4'>Industry Best Theme, <br class='d-none d-md-block'>  Based On <span class='debutify-reviews'></span>+ Reviews</h1>
		<x-landing.reviews class='mb-4' type='badge' :badges="['facebook','capterra','google','trustpilot']" row='col-md-6 col-lg-3'/>

		<div class='position-relative '>
			<img  class='lazyload d-lg-block d-none' style="position:absolute;bottom:-70px;right:50px" data-src="images/landing/props-dots-gray.svg" alt="dots" >
				<div class='p-md-5 bg-light overflow-hidden card'>
					<div class='card-body'>
						<div class='row'>
							<div class='col-lg-7'>
								<h2 class='font-weight-normal text-reset order-last order-lg-first kamil-satar-message'>
									“I've never seen something as valuable as the Debutify theme.
									The conversion rates are amazing. We've
									<span class='font-weight-bolder'> generated  over $7M</span> combined
									using that theme.”
								</h2>
							<p class='font-weight-bolder lead mt-3 mt-mb-5 mb-0'> Kamil Sattar </p>
							<p class='lead m-0'>Forbes Business Council Member, <br> E-commerce Entrepreneur </p>
							<img class='lazyload my-3 my-md-5 ' data-src="images/landing/reviews-forbes.png" alt=""> <br>
							<x-landing.download-btn class='btn-primary btn-lg debutify-hover btn-sm-block' cta='X'/>
						</div>
						<div class='col-lg-5 position-relative order-first  order-lg-last'>
							<img class='kamil-satar lazyload' data-src="images/landing/reviews-kamil-sattar.png" alt="kamil satar">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class='debutify-section'>
	<div class='container'>
		<div class='text-center'>
			<h1 class='text-center mb-5 display-4'>Recommended by <br class='d-none d-md-block'>
				leading dropshippers
			</h1>
			<x-landing.dropshippers :dropshipper="['james-beattie','marc-chapon','jordan-welch']"/>
		</div>
	</div>
</section>

<section class='debutify-section'>
	<div class='container'>
		<div class='row align-items-center'>
			<div class='col-lg-6'>
				<div class=' text-lg-left text-center'>
					<h1 class='mb-5'>Loved by <br class='d-none d-md-block'> ecommerce brands</h1>
					<p class='lead mb-5 pr-3'>
						Debutify is the go-to theme of profitable Shopify storeowners. Whether you're an ecommerce brand, a dropshipper, or a retail
						owner going online — Debutify is the theme to grow your business.
					</p>
				</div>
			</div>

			<div class='col-lg-6 text-center'>
				<div class='responsive-container-1by1' style="">
					<img  class='lazyload img-fluid' data-src="images/landing/reviews-brand.png?v={{config('image_version.version')}}" alt="reviews" >
				</div>
			</div>
		</div>
	</div>
</section>

<section class='debutify-section'>
	<div class='container'>
		<h1 class='text-center mb-5 display-4'>Join thousands of successful
			<br class='d-none d-md-block'> business owners using Debutify
		</h1>
		<x-landing.cta id='1' class='justify-content-center d-flex' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
		<x-landing.reviews type='masonry' class='mt-5'/>
	</div>
</section>

@endsection
