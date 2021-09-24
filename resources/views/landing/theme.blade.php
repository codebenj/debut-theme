@extends('layouts.landing')

@section('title','Best Free Shopify Theme | Debutify')

@section('description','Your perfect online store is just one step away. Get Debutify’s high-converting Shopify template and start selling in minutes. Download now!')

@section('content')

<section class='debutify-section'>
	<div class='container'>
		<div class='text-center'>
			<h1 class='display-3'>Best Free Ecommerce <br class='d-none d-lg-block'> <span class="debutify-underline-lg">Shopify Theme</span></h1>
			<p class='my-5'>Clean code, fast page loading speed and features that matters.</p>
		</div>

		<div class='rounded overflow-hidden'>
			<x-landing.wistia-video-player type='inline' embedId="ssgnut132q"/>
		</div>

		<h3 class='text-center my-5'>
			Debutify makes things simple. Launch your store in a few clicks,
			<br class='d-none d-lg-block'> with all the features you need to succeed already built-in.
		</h3>
		<x-landing.cta class='d-flex justify-content-center' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
	</div>
</section>

<section class='debutify-section'>
	<div class='container'>
		@foreach ([[
		'title'=>'Currency converter.',
		'image'=>'currency-converter',
		'list'=>[
		'Multiple placement option',
		'Multi-currency checkout with Shopify Payments',
		'Loading icon while changing currency',
		]],[
		'title'=>'Product sliders.',
		'image'=>'product-sliders',
		'list'=>[
		'Number of products to show',
		'Mobile & desktop swipe',
		'Autoplay slider and change speed',
		'Arrow/dots visibility',
		]],[
		'title'=>'Customizable slideshow.',
		'image'=>'slideshow',
		'list'=>[
		'Slideshow mobile/desktop height',
		'Fade-in animation',
		'Customizable slider options',
		]],[
		'title'=>'Customizable header.',
		'image'=>'header',
		'list'=>[
		'Navigation left/right/center/hidden',
		'Transparent header',
		'Sticky header',
		'Transparent logo over slideshow',
		]],[
		'title'=>'Customizable footer',
		'image'=>'footer',
		'list'=>[
		'Menus/text/image/social medias/newsletter',
		'Custom column order',
		'Payment icons',
		'Email & phone links',
		]],[
		'title'=>'Guarantee bar.',
		'image'=>'guarantee-bar',
		'list'=>[
		'Choose between 1000+ icons',
		'Add icons, title, text and links',
		'Change columns order',
		]],[
		'title'=>'Product images.',
		'image'=>'product-images',
		'list'=>[
		'Featured image slider',
		'Synced thumbnail slider',
		'Thumbnail/stacked layout',
		'Left/right alignment',
		'Zoom on hover'
		]],[
		'title'=>'Product description.',
		'image'=>'product-details',
		'list'=>[
		'Sticky when scrolling',
		'Dropdown/button variants',
		'Full-width add-to-cart button',
		'Add-to-cart button icon',
		'Dynamic checkout button',
		'Product tags list',
		'Left/center alignment'
		]],[
		'title'=>'Related products.',
		'image'=>'related-products',
		'list'=>[
		'Grid/slider sliders',
		'Advanced product filters',
		'Dynamic recommendations',
		'Customizable slider options',
		]],[
		'title'=>'Product testimonials.',
		'image'=>'testimonials',
		'list'=>[
		'Testimonial slider under product page',
		'Quote icon or images',
		'Customizable slider options',
		]],
		] as $key => $item)


		<div class='debutify-theme d-md-block' style="{{$key>4 ?'display:none':''}}">
			<div class='row align-items-center justify-content-center'>
				<div class='col-lg-6 {{$key % 2== 1?'order-lg-last':''}}'>
					<div class="position-relative mt-4">
						<div class='responsive-container-16by9'>
							<img class="position-absolute rounded lazyloaded" alt="how to make sushis" data-src="/images/landing/theme-{{$item['image']}}.png?v={{config('image_version.version')}}" alt="{{$item['image']}}" style="z-index: 1;width: 85%;height: 78%;right: 0;margin: 0 auto;top: 34px;" src="/images/landing/theme-{{$item['image']}}.png?v={{config('image_version.version')}}">
						</div>
						<img class="position-absolute w-100 ls-is-cached lazyloaded" style="bottom:0;top:0;" data-src="/images/landing/{{$key % 2== 1?'props-dots-gray-right-top-animated.svg':'props-dots-gray-left-bottom-animated.svg'}}" src="/images/landing/{{$key % 2== 1?'props-dots-gray-right-top-animated.svg':'props-dots-gray-left-bottom-animated.svg'}}">
					</div>
				</div>
				<div class='col-lg-6'>
					<h1>{{$item['title']}} </h1>

					@foreach ($item['list'] as $list_item)
					<div class='d-flex'>
						<img class='lazyload mr-3 mt-1 d-inline-block' data-src="images/landing/cta-check.svg" alt="cta check" width="20px" height="20px">
						<p class='mb-1'> {{$list_item}}</p>
					</div>
					@endforeach

				</div>
			</div>
		</div>
		@endforeach

		<button class='btn-block d-sm-block d-md-none btn btn-light mt-3' onclick="$('.debutify-theme').fadeIn();$(this).hide()">View More</button>
	</div>
</section>

@endsection
@section('styles')
<style>
@media only screen and (max-width:991px){
	.responsive-container-16by9 img {
		    top: 44px !important;
	}
}
@media only screen and (max-width:426px){
	.responsive-container-16by9 img {
		    top: 24px !important;
	}
}
</style>

@endsection
