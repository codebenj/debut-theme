@extends('layouts.landing')
@section('title','Become A Debutify Affiliate | Best Shopify Theme')
@section('description','Become a Debutify affiliate partner and earn monthly revenue promoting the best Shopify theme in the world')
@section('content')

<section class='debutify-section overflow-hidden'>
	<div class='container'>
		<div class='row '>
			<div class='col-lg-6'>
				<div class='text-lg-left text-center'>
					<p class='lead font-weight-bold text-primary'>
						The <span class='debutify-highlight-lg px-2'> Best Affiliate Program</span> in the Industry -
					</p>

					<h1 class="display-4"> Debutify affiliate program offers 40% commission per sale. </h1>
					<p class='mt-4 lead'>
						Grow your passive income with the best-paying affiliate program in the e-commerce niche. Monetize your content with a Shopify theme trusted by {{$nbShops}}+ users — become an affiliate today.
					</p>
				</div>
				<a href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target='_blank' role='button' class='btn btn-lg debutify-hover btn-primary btn-sm-block my-4'>
					Register Now
				</a>
			</div>

			<div class='col-lg-6'>
				<div class='position-relative'>
					<img class='lazyload position-absolute' style="right:-5%;top:-5%" data-src="/images/landing/props-dots-primary.svg" alt="prop dots">
					<img class='lazyload position-absolute' style="left:-5%;bottom:-5%" data-src="/images/landing/props-dots-primary.svg" alt="prop dots">

					<div class='card text-center shadow py-5 mt-5'>
						<div class='card-header'>
							<h1>Your Earning Potential</h1>
							<div class='row align-items-center'>
								<div class='col-lg-3'>Bring In</div>
								<div class='col-lg-4'>
									<input type="number" min='0' class="rounded form-control text-right text-mid-light my-2" value='20' oninput="$('#affiliate_price').text(($(this).val()*97).toLocaleString())">
								</div>
								<div class='col-lg-5'>Paid Users a Month</div>
							</div>
						</div>

						<div class='card-body bg-primary text-white'>
							<p class='m-0'>Earn Up To</p>
							<div style="font-size:73px;font-weight:800;">
								$<span id='affiliate_price'>1,940</span>
							</div>
							<p class='m-0'>Per Month</p>
						</div>
						<div class='card-footer'>
							<p class='my-3'>Earn up to $1,692 a month promoting Debutify. <br>On-time payments, fair and transparent statistics. </p>
							<a href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target='_blank'  role='button' class='debutify-hover btn-sm-block  mt-4 mb-5 btn btn-lg btn-primary'>
								Register Now
							</a>
							<div class='small'>
							 * Payout depends on the plan selected by the converted customer.<br class='d-none d-md-block'>
							  Payouts recur every month as long as the converted customer stays on a paid plan.
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class='row py-5 mt-4'>
			@foreach ([
			['icon'=>'payout2','label'=>'High <br class="d-none d-lg-block"> Payouts'],
			['icon'=>'dashboard2','label'=>'Transparent Dashboard'],
			['icon'=>'support2','label'=>'24/7 <br class="d-none d-lg-block">  Live Support'],
			['icon'=>'page2','label'=>'High-Converting Landing Page'],
			] as $item)
			<div class='col-md-6 col-lg-3 mb-3'>
				<div class='card shadow'>
					<div class='card-body d-flex debutify-animation-wrapper py-4 pl-3 pr-3' data-animation-target='icon-affiliate-{{$item['icon']}}'>
						<object class="mr-3 lazyload pointer-none" width="50" height="50" type="image/svg+xml" id='icon-affiliate-{{$item['icon']}}' data-object="/images/landing/icon-{{$item['icon']}}-infinite-animated.svg"></object>
						<div class="d-flex align-self-center">{!!$item['label']!!}</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>


		<div class='text-center'>
			<h4>Amount Paid To Affiliates So Far:</h4>
			<h1 class='display-4 my-4'>
				<span class='debutify-underline-sm'>$183,951</span>
			</h1>
			<h1 class='display-4 mb-4'>Make Bank On The Fastest-Growing <br class='d-lg-block d-none'> Shopify Theme</h1>


			<div class='row justify-content-center lead'>
				<div class='col-lg-8'>
					<p >
						Do you have an audience of dropshippers, entrepreneurs or
						Shopify store owners who keenly follow you? Are you looking
						to add a new stream of income to your business?
					</p>
					<p >
						Debutify has already paid out over $183,951 to affiliates so far –
						and we’re only getting started.
					</p>
					<p >
						Our affiliate program is the best-paying in the industry. As a
						Debutify affiliate, you can earn 30% recurring monthly
						commission from every customer on a paid plan.
					</p>
					<p >
						That means passive income flowing into your bank account, while you focus on building the lifestyle of your dreams.
					</p>
				</div>
			</div>

			<div class='card rounded-lg shadow mt-5 p-lg-3'>
				<div class='card-body responsive-container-4by3'>
					<img class='w-100 lazyload' data-src="images/landing/affiliate-payouts.png?v={{config('image_version.version')}}" alt="payouts">
				</div>
			</div>
		</div>

	</div>
</section>

<section class='bg-primary debutify-section'>
	<div class='container'>
		<div class='text-center text-white'>
			<h1 class='text-white display-4'>Place an Affiliate Link Once, <br class='d-none d-lg-block'> Earn Money Forever</h1>
			<p class='my-5 lead'>
				With Debutify, your money earns itself. Place your affiliate link once  <br class='d-none d-lg-block'>
				and cash in whenever a user signs up for a paid plan.
			</p>
		</div>

		<div class='card rounded-lg'>
			<div class='card-body'>
				<h1 class='text-center my-5'>Debutify's Affiliate Program is The Best Way <br class='d-none d-lg-block'> to Earn Passive Income If You Are a...</h1>
				<div class='row my-4' >
					@foreach ([ 'YouTube Content Creator','Blog Writer','Course Creator','Facebook Influencer','Instagram content creator','E-com influencer','Shopify mentor','Email marketer'] as $item)
					<div class='col-md-5 my-3 offset-md-1'>
						<div class='lead'>
							<img class='lazyload mr-2 d-inline-block' data-src="images/landing/cta-check.svg" width='21px' height="21px">
							{{$item}}
						</div>
					</div>
					@endforeach
				</div>

				<div class='text-center'>
					<a href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target='_blank'  role='button' class='my-5 debutify-hover btn btn-lg btn-primary'>
						Our affiliate program will make you money while you sleep!
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class='debutify-section'>
	<div class='container'>
		<div class='row'>
			@foreach ([
			['icon'=>'sale2','label'=>'Debutify affiliate program offers 40% commission per sale','description'=>"Earn 40% commission on all new sales and also on renewal subscriptions for up to a year."],
			['icon'=>'paypal2','label'=>'On-Time Monthly Payouts Via Paypal','description'=>"Easily set up your account and receive payouts every month via Paypal."],
			['icon'=>'analytics2','label'=>'See New Conversions In Real Time With Transparent Analytics Dashboard','description'=>"Track your sales with Debutify's easy-to-use affiliate dashboard. Have complete insights into your clicks, leads, referrals, payouts and more."],
			] as $item)
			<div class='col-md-4 mb-4'>
				<div class='card text-center shadow h-100 border-top-primary'>
					<div class='card-body debutify-animation-wrapper' data-animation-target='icon-updates-{{$item['icon']}}'>
						 <object class="mr-2 lazyload" width="80" height="80" type="image/svg+xml" id='icon-updates-{{$item['icon']}}' data-object="/images/landing/icon-{{$item['icon']}}-infinite-animated.svg"></object>
						<h4 class='my-4'>{{$item['label']}}</h4>
						<p>{{$item['description']}}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>

<section class='bg-light debutify-section'>
	<div class='container text-center'>
		<h1 class='display-4'>Testimonials</h1>
		<p class='lead my-4'>
			Debutify is a leading free Shopify theme, used by the biggest ecom entrepreneurs. <br class='d-none d-lg-block'>
			If you’re not convinced that Debutify is good for you, then listen why 7-figure <br class='d-none d-lg-block'>
			dropshippers use it for their businesses:
		</p>
		<x-landing.dropshippers/>
		<a href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target='_blank' role='button' class='btn btn-sm-block btn-lg btn-primary mt-5 debutify-hover'>
			Register Now
		</a>
	</div>
</section>

<section class='debutify-section'>
	<div class='container text-center'>
		<h1 class='display-4'>Get Started In Minutes - Easy For Beginners, <br class='d-none d-lg-block'>
			All Material Provided
		</h1>
		<div class='row'>
			@foreach ([
			['image'=>'link','title'=>"Create your affiliate account and retrieve your own Debutify affiliate link.",'description'=>"Get started in 5 minutes. All you need is an email and a Paypal account to register and instantly get your own affiliate link."],
			['image'=>'media','title'=>"Promote Debutify through your content (courses, videos, social media, articles, etc.)",'description'=>"Promote Debutify to your audience through your content. We'll supply you with all marketing material you need - including banners, email templates, video scripts and more to help you easily generate sales."],
			['image'=>'customer','title'=>"Get paid for every click that converts into a paying customer!",'description'=>"Get started in 5 minutes. All you need is an email and a Paypal account to register and instantly get your own affiliate link."],
			] as $item)
			<div class='col-md-4 my-4'>
				<div class="responsive-container-1by1">
					<img class='lazyload w-100 px-1' data-src="images/landing/affiliate-{{$item['image']}}.svg?v={{config('image_version.version')}}" alt="">
				</div>
				<div class="get-started px-4">
					<div class="d-flex flex-column align-items-center">
						<h4 class='my-4 font-weight-bold' style="min-height: 132px;">{{$item['title']}}</h4>
						<p>{{$item['description']}}</p>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<a href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target='_blank' role='button' class='mt-3 mb-5 btn btn-lg btn-primary debutify-hover'>
			Register Now
		</a>
	</div>
</section>

<section class='debutify-section'>
	<div class='container '>
		<div class='text-center'>
			<h1 class='text-center display-4'>
				The Easy Way to Make Money – <br class='d-none d-lg-block'>
				Copy-Paste Our Tested Creatives <br class='d-none d-lg-block'>
				to Sell Like Crazy
			</h1>

			<div class='row justify-content-center'>
				<div class='col-lg-7'>
					<p class='my-4 lead'>As a Debutify affiliate, all promotional material is done for you.
					</p>
					<p class='my-4 lead'>
						Simply copy-paste our tested material to sell like crazy. We’ll arm you with sales copy, website banners, scripts,
						graphics, videos – everything you need to sell is available on
						your affiliate portal. Just copy-paste into your content
						and your money will make itself.
					</p>
				</div>
			</div>

		</div>
		<div class='row mt-5'>
			@foreach (['today','month','yesterday2','yesterday'] as $item)
			<div class='col-lg-3 col-sm-6 mb-4'>
				<div class="responsive-container-1by1">
					<img class='lazyload w-100 rounded mb-4' data-src="images/landing/landing-stats-{{$item}}.png?v={{config('image_version.version')}}" alt="">
				</div>
			</div>
			@endforeach
		</div>
	</div>
</section>

<section class='debutify-section'>
	<div class='container'>
		<div class='row align-items-center'>
			<div class='col-md-6 text-center text-lg-left'>
				<h1>You're Never Alone-We'll Help You Max Out on Each Lead </h1>
				<p class='lead my-5'>We know that not every trial leads to a sale. That's why we'll do our best to help you convert each user into a paying customer. There's an entire team working for you to sell our highest-paying subscription plan.</p>
				<p class='lead'>Thanks to our marketing ninjas, all you have to do for top-dollar commissions is drive traffic to our homepage.</p>
			</div>
			<div class='col-md-6'>
					<div class="responsive-container-1by1">
						<img  class='lazyload img-fluid rounded' data-src="images/landing/affiliate-max-out.png?v={{config('image_version.version')}}" alt="">
					</div>
				</div>
			</div>
		</div>
</section>

<section class='bg-primary debutify-section mobile-top-lg'>
	<div class='container text-center'>
		<h1 class='text-white display-4'>
			Make Money Confidently, Selling The <br class='d-none d-lg-block'>
			 Industry's  Best-Performing Theme
		</h1>
		<p class='text-white lead my-5'>
			Give your audience a theme that'll really beef up their business. Debutify is the industry's <br class='d-none d-lg-block'>
			best-performing Shopify theme, with more than {{$nbShops}} happy users around the globe.
		</p>
		<div class='row justify-content-center pt-5'>
			@foreach ([
			['label'=>'Premium, <br> fully-responsive theme','icon'=>'premium2'],
			['label'=>'Mobile-optimized, loads in under 2 seconds','icon'=>'optimized2'],
			['label'=>'More than '.$nbAddons.' conversion-boosting Add-Ons','icon'=>'addons2'],
			['label'=>'Saves over $2,000 a year in running costs','icon'=>'save2'],
			['label'=>'Mentoring <br> program','icon'=>'mentor2'],
			['label'=>'High-quality <br> e-commerce training <br><br>','icon'=>'training2'],
			['label'=>'Only theme built like a real sales funnel','icon'=>'funnel2'],
			['label'=>'Trustpilot <br>  Reviews','icon'=>'trustpilot2'],
			['label'=>'24/7 support <br><br>','icon'=>'suppot2'],
			] as $item)
			<div class='col-sm-3 mb-4'>
				<div class='card h-100'>
					<div class='card-body debutify-animation-wrapper' data-animation-target='icon-updates-{{$item['icon']}}'>
						<object class="pointer-none lazyload" width="70" height="70" type="image/svg+xml" id='icon-updates-{{$item['icon']}}' data-object="/images/landing/icon-{{$item['icon']}}-infinite-animated.svg"></object>
						<div class='mt-3'> {!!$item['label']!!} </div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<h1 class='text-white mt-4'> {{$nbShops}}+ <br> DOWNLOADS</h1>
	</div>
</section>


<section class='debutify-section'>
	<div class='container'>
		<div class='text-center'>
			<h1 class='display-4'>Frequently Asked Questions</h1>
			<p class='mt-3 mb-5 lead'>We know you have some questions in mind, we’ve tried to list the most important ones!</p>
		</div>
		<x-landing.faq/>
	</div>
</section>

{{-- Affiliate Exit Intent Modal --}}
<div id="affiliateExitIntentModal" class='modal fade'>
	<div class="modal-dialog align-items-end align-items-md-center modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<button data-dismiss="modal" class="close-modal"> <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-cross-black.svg" alt="icon cross" width="16" height="16"/>  </button>
				<div class='text-center'>
					<div class='mt-5 mb-4'>
						<h1 >
							17 <span class='debutify-underline-lg'>Done-For-You </span> <br>Email Templates That<br> Convert Like Crazy
						</h1>
					</div>
					<img class='lazyload img-fluid' data-src="/images/landing/modal-affiliate.png" alt="" width="600">
					<p class='my-4'>
						Add these 6 emails to your marketing and skyrocket your commissions! <br class='d-none d-lg-block'>
						Includes set-up guide, real-world examples and much more <br class='d-none d-lg-block'>
						(completely free!)
					</p>
				</div>
				<div class='row justify-content-center mb-5'>
					<div class='col-lg-8'>
						<form id='affiliateExitdownloadForm'>
							<h4 class="text-center mb-4">Enter your name and email address:</h4>
							<div class='form-group'>
							  <div class="input-group">
								<div class="input-group-prepend">
								  <label class='input-group-text ' for="affiliateExitdownloadFormName">
										<img class="lazyload d-inline-block"  data-src="/images/landing/icons/icon-user.svg" alt="icon user" width="22" height="22"/>
								  </label>
								</div>
								<input id="affiliateExitdownloadFormName"  name="name" type="text" class="form-control border-left-0 pl-0"  placeholder="Name" required>
							  </div>
							</div>
							<div class='form-group'>
							  <div class="input-group mt-2">
								<div class="input-group-prepend">
								  <label class='input-group-text' for="affiliateExitdownloadFormEmail">
										<img class="lazyload d-inline-block"  data-src="/images/landing/icons/icon-envelope.svg" alt="icon envelope" width="22" height="22"/>
								  </label>
								</div>
								<input  id="affiliateExitdownloadFormEmail" name="email" type="email" class="form-control border-left-0 pl-0" placeholder="Email address" pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>
							  </div>
							</div>
							<button type="submit" class='btn btn-primary btn-block my-3 debutify-hover'>
								DOWNLOAD NOW (FREE!)
							</button>
							<div class="custom-control custom-checkbox">
							  <input type="checkbox" class="custom-control-input" id="affiliateExitdownloadFormCheckbox" name="" required>
							  <label class="custom-control-label " for="affiliateExitdownloadFormCheckbox"> I agree to receive regular updates from Debutify.  <a href="/privacy-policy" class='text-secondary'> View Privacy Policy here.</a> </label>
							</div>
						  </form>
						<div id='affiliateThankYou' class='text-center' style="display: none">
							<h1>Thank you!</h1>
							<p>Please check your email inbox for a special surpise.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
