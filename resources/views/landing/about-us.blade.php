@extends('layouts.landing')

@section('title','About Debutify Team | Free Shopify Template')
@section('description','Know about the team behind Debutify’s best and high converting free Shopify theme. Build your ecommerce store in minutes. Download free today!')
@section('content')
<section class='debutify-section py-0'>
		<div class="responsive-container-24by11">
			<img class='w-100' src='/images/about_banner.jpg?v={{config('image_version.version')}}' alt='about banner'/>
	</div>
</section>
<section class='debutify-section'>
	<div class='container'>
		<h1 class='mb-5 display-4 text-center'>The <span class='debutify-highlight-sm pl-3 pr-3'>Smart Brand Owner's</span> <br class='d-lg-block d-none'> Theme Of Choice</h1>
		<div class='text-lg-left text-center' style='max-width:730px; margin:0 auto;'>
			<p class='lead my-4'>Some people call us 'lazy' because we don't hustle for 16 hours per day, 7 days a week like them. But being overworked and having close to zero time with family and friends and wearing it like some badge of honor isn't really our goal.</p>
			<p class='lead my-4'>Instead, we choose to be <b style='text-decoration: underline;'>smart.</b></p>
			<p class='lead my-4'>That's why we focus our efforts on developing the most efficient, bang-for-the-buck solutions and systems that help grow ecommerce brands...</p>
			<p class='lead my-4'><i>...without</i> being practically chained to our desks and sacrificing what we fought for in the first place: <b>time and financial freedom.</b></p>
			<p class='lead my-4'>From UX-centric design that flows seamlessly from mobile, tablet, or desktop... to {{$nbAddons}}+ Conversion Boosters (Add-Ons) which subtly but effectively persuade your customers to click the buy button... and top-notch Client Success Champions always ready to help with whatever question you have... we've done it all for you.</p>
		</div>
	</div>
</section>
<section class='debutify-section p-0'>
	<div class='banner_abt position-relative'>
		<img data-aos='zoom-in' data-aos-delay='500' class='position-absolute lazyload prop prop-bottom d-none d-lg-block'  data-src='/images/dots.svg' style='right:0%; margin-top:15%;' alt='dots-primary'>
				<div class="responsive-container-24by11">
					<img class='lazyload w-100' data-src='/images/about_mask_group.jpg?v={{config('image_version.version')}}' alt='about banner' style='max-width:92%; '>
				</div>
			<img data-aos='zoom-in' data-aos-delay='500' class='position-absolute lazyload prop prop-bottom mobile-dots d-none'  data-src='/images/landing/about-white-dotted-mobile.svg' style='right:0%; margin-top:15%;' alt='dots-primary'>
		<div class='bannr_logo position-relative'>
	    <img data-aos='zoom-in' data-aos-delay='1800' class='position-absolute lazyload vector-img' data-src='/images/debutify-logo-icon.png' style='max-width: 232px;bottom:-30px; right:3% ; z-index: 1;' alt='dots-primary'>
		</div>
	</div>
	<div class='container'>
		<div class='row'>
			<div class='col-lg-12 text-lg-left text-center'>
				<div class='over_txt position-relative'>
				  <span>OUR MISSION</span>
					<h1 class='mb-5 mt-3'>Unchain Ecommerce Brands</h1>
					<div class=''>
						<p class='lead my-4'>We help Brand Owners break the chains that hold them from unleashing the full potential of their Shopify stores. We believe Brand Owners don't have to worry about compatibility, integrations, and all the other headaches from managing different third-party apps every single day. Because time is valuable and it's better spent on things that matter most to you.</p>
						<p class='lead my-4 mt-3'>With Debutify as your partner, you'll get everything you need to 'break free' and successfully take your ecommerce brand to the next level:</p>
						<div class='d-flex align-items-start mb-3 mt-5 text-left'>
							<img class='mr-3 mt-2 lazyloaded' data-src='/images/landing/cta-check.svg' alt='' width='20' height='20' src='/images/landing/cta-check.svg'>
							<p class='lead'><b><i>The Smart Way to Scale</i></b> - one-click smart optimization plus automations so you won't have to worry about overspending on ads promoting stores that simply don’t convert</p>
						</div>
						<div class='d-flex align-items-start mb-3 text-left'>
							<img class='mr-3 mt-2 lazyloaded' data-src='/images/landing/cta-check.svg' alt='' width='20' height='20' src='/images/landing/cta-check.svg'>
							<p class='lead'><b>Lightning-quick loading speed.</b> Average load speed of around 1.5s, even with all Add-Ons turned on.</p>
						</div>
						<div class='d-flex align-items-start mb-3 text-left'>
							<img class='mr-3 mt-2 lazyloaded' data-src='/images/landing/cta-check.svg' alt='' width='20' height='20' src='/images/landing/cta-check.svg'>
							<p class='lead'><b>Built primarily for mobile.</b> Fluid on any platform. Seamless user-experience every step of the way which makes it easier for your customers to hit the buy button (and do it over and over again...)</p>
						</div>
						<div class='d-flex align-items-start mb-3 text-left'>
							<img class='mr-3 mt-2 lazyloaded' data-src='/images/landing/cta-check.svg' alt='' width='20' height='20' src='/images/landing/cta-check.svg'>
							<p class='lead'><b>“No less than amazing” customer support</b> <i>(at least that’s what our clients say)</i></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class='debutify-section'>
	<div class='container text-center'>
		<div data-rw-inline="22067" class='mb-4'></div>
		<x-landing.download-btn cta='X' class='btn-primary px-3 btn debutify-hover btn-lg' :label="'Find Out Why Over '.$nbShops.' Stores Trust Only Debutify'" arrow='1'/>
	</div>
</section>
@endsection
@section('styles')
<style>
img{max-width:100%;}
body{overflow-x: hidden;}
	.over_txt{background: #fff;margin-top: -80px;width: 100%;padding: 100px 200px 30px 200px;}
@media only screen and (max-width:991px){
	.over_txt {margin-top: 0px;padding: 100px 15px 30px 15px;background: transparent !important;}
	.vector-img {height: 160px !important;bottom: -70px !important;}
	.dots-img {width: 40px;}
	.bannr_logo img {left: 0;right: 0 !important;text-align: center;margin: 0 auto;}
	.banner_abt img {max-width: 100% !important;}
	.mobile-dots {display: block !important;width: 70px;z-index: -1;margin-top: -400px !important;}
}
@media only screen and (max-width:426px){
	.mobile-dots {height: 300px !important;width: 50px;}
	.vector-img {height: 120px !important;bottom: -80px !important;}
	.mobile-dots {margin-top: -65% !important;}
}
</style>

@endsection
