@extends('layouts.landing')

@section('title','Subscription Confirmation | Free Shopify Template')
@section('description','Know about the team behind Debutify’s best and high converting free Shopify theme. Build your ecommerce store in minutes. Download free today!')

@section('content')


<section class='debutify-section pt-4 pb-4'>
	<div class='container text-center mt-5'>
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="responsive-container-24by11">
					<img class='lazyload d-block' data-aos="zoom-in" data-aos-delay="1200" style="margin: 0 auto;width:352px;right:0;" data-src="/images/subscription/subscription-envelop.svg?v={{config('image_version.version')}}" alt="Sbscribe">
				</div>
				<h1 class='mb-5'>Thanks For Confirming <br>Your <span class="debutify-underline-lg">Subscription!</span></h1>
				<div>
					<p class="lead my-4">It's good to have you on board. Check your email this Friday for our value-packed newsletter.</p>
					<p class="lead my-4"><b>However…</b> there's a trick.</p>
					<p class="lead my-4">Your inbox hasn't learned to <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-heart.svg"  alt="icon heart" width="25" height="25" /> our newsletter yet.</p>
					<p class="lead my-4">It'll most likely end up chipping the walls of Spam prison, with African princes and multi-million-dollar cousins who <i>just</i> happen to need a couple of your bucks.</p>
					<p class="lead my-4">To ensure that never happens -- and that you never miss an issue -- do add us to your Contacts List. Here's how to do it on all major email service providers:</p>
					<a href="#" role='button' class='btn btn-lg mt-5 btn-primary debutify-hover'>Install Debutify Now <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-right-arrow.svg"  alt="right-arrow" width="30" height="30" /></a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class='debutify-section'>
  <div class='container'>
    <div class='row text-center justify-content-center'>
			@foreach ([
					['video_id' => "n0ql2y1bxc", 'title' => "Gmail desktop", 'description' => "Add To Contacts List On", 'icon' => "gmail"],
					['video_id' => "5tbc2eox9k", 'title' => "Apple Mail", 'description' => "Add To Contacts List On", 'icon' => "gmail"]
				] as $item)
      <div class="col-lg-4 col-md-6 mb-3" data-aos="zoom-in" data-aos-delay="500">
        <div class="card h-100 shadow position-relative">
          <div class="card-body">
            <a class='text-black text-decoration-none' href="#">
              <img alt="landing_blog.png" class="lazyload mt-2"  data-src="/images/subscription/icon-{{$item['icon']}}.svg" >
              <h6 class="mt-2">{{$item['description']}}</h6>
							<h3>{{$item['title']}}</h3>
            </a>
            <div class="mt-4">
								<x-landing.wistia-video-player  type='modal' :embedId="$item['video_id']"/>
            </div>
          </div>
        </div>
      </div>
			@endforeach
		</div>
  </div>
</section>
<section class='debutify-section'>
  <div class='container'>
    <div class='row justify-content-center text-center'>
			<div class="col-lg-9">
	    	<h1 class="text-center mb-2 ">Follow Debutify On Social Media</h1>
	    	<p class="text-center lead mb-5">Get fresh ecommerce tips, tricks, industry news and a few "insider" memes along the way! Join the conversation today:</p>
				<div class="row mt-4">

					@foreach ([
					['title'=>'4,508','icon'=>'facebook',
					'description'=>'Debutify',
					'button_name'=>'Like'
					],
					['title'=>'18.4k','icon'=>'youtube',
					'description'=>'Debutify',
					'button_name'=>'subscribe'
					],
					['title'=>'1,767','icon'=>'instagram',
					'description'=>'Debutify',
					'button_name'=>'share'
					],
					] as $index => $item)
					<div class="col-lg-4 col-md-6  mb-3">
						<div class="card h-100 p-3">
							<div class="card-body">
								<div class="follow_icon"><img class="lazyload" width="31" data-src="/images/landing/icon-{{$item['icon']}}.svg"> <p class="text-center mb-0 ml-3">{{$item['description']}}</p></div>
								<h3 class="mt-3">{{$item['title']}} </h3>
								<div class="text-center">
									<a href="/career" role='button' class='debutify-hover btn btn-sm mt-3 btn-primary btn_thin text-decoration-none'>+ {{$item['button_name']}}</a>
								</div>
							</div>
						</div>
					</div>
					@endforeach
				</div>
    	</div>
    </div>
 </section>

 <section class='debutify-section bg-light'>
  <div class='container-fluid' id='#subscription-carousel'>
		<div class='row text-center justify-content-center'>
			<div class="col-lg-5">
				<h1 class="mb-4">Master Debutify & Take Your
					<br class="d-none d-md-block"> Business To The Next Level</h1>
				<p class="lead mb-5">Follow our channel for Debutify tutorials, beginner <i>and</i> advanced marketing strategies, store reviews, winning product reveals and more. All value -- no BS.</p>
    	</div>
    </div>
	  <div class='text-center'>

					@if (isset($videos) && !empty($videos) && count($videos) != 0)
							<div id='subscription-carousel' class='debutify-carousel'>
            @foreach ($videos as $video)
											<div class="px-3">
					                <x-landing.video-template :video='$video'/>
					            </div>
            @endforeach
							  </div>
						@endif
        </div>

		<div class='row text-center mt-5'>
			<div class="col-lg-6 offset-lg-3 ">
				<a role="button" href="https://www.youtube.com/results?search_query=debutify"  target="_blank" class="debutify-hover btn btn-lg btn-sm-block mr-3 mb-3 btn-primary">
					Subscribe <img class="lazyload ml-1 d-inline-block" data-src="/images/landing/icons/icon-right-arrow.svg"  alt="right-arrow" width="30" height="30" />
				</a>
				<a role="button" class=" btn btn-lg debutify-hover  btn-sm-block mb-3 btn-outline-secondary" href="{{url('video')}}" target="_blank">See All Videos</a>
    	</div>
    </div>
	 </div>
 </section>

<section class='debutify-section'>
  <div class='container'>
		<div class='row justify-content-center'>
			<div class="col-lg-8">
	  	  <h1 class="text-center mb-4">The Cutting Edge Of Ecommerce: New Ecomonics Podcast</h1>
	    	<p class="text-center lead mb-5">Get bulletproof advice to optimize your marketing, and get actionable tips to help you grow -- both yourself and your business. Only on Ecomonics. Tune in today!</p>
			</div>
		</div>
			<div class='row'>
					@if (isset($podcasts) && !empty($podcasts) && count($podcasts) != 0)
					@foreach($podcasts as $key => $podcast)
					<div class="col-md-6 col-lg-4 mb-4">
							<x-landing.podcast-template :podcast='$podcast'/>
					</div>
					@endforeach
					@else
					<div class='col'>
							<h1 class='text-center my-5'>Result not found!</h1>
					</div>
					@endif
			</div>
		<div class="row mt-5">
			<a href="{{url('podcast')}}" type="button" class="btn btn-md text-primary btn-light"  style="background-color: rgb(240, 240, 240); color: rgb(86, 0, 227); margin:0 auto 10px;">View More</a>
 		</div>
 	</div>
 </section>

<section class='debutify-section'>
  <div class='container'>
		<div class="responsive-container-24by11">
			<img data-aos="zoom-in" data-aos-delay="1200"  src="/images/subscription/recurring-commission-animated.svg?v={{config('image_version.version')}}" class='lazyload d-block'>
		</div>
  	<h1 class="text-center mb-2 mt-4 ">Add Another Stream Of <br>Revenue To Your Business</h1>
    <p class="text-center lead mb-5 mt-4 ">Join our affiliate program and earn a <b>monthly recurring<br> commission</b> from every sale. Get up to 55% commission on every<br> conversion!</p>
		<div class="text-center">
			<a href="/career" role="button" class="btn btn-lg mt-2 btn-primary debutify-hover">See Affilaite Program <img class="lazyload ml-1 d-inline-block" data-src="/images/landing/icons/icon-right-arrow.svg"  alt="right-arrow" width="30" height="30" /></a>
		</div>
	</div>
</section>


@endsection

@section('styles')
<style>
	img.o_play {position: absolute;right: 10%;top: 20%;cursor: pointer;transition-duration: .3s;}
	img.o_play:hover {transform: scale(1.2);}
	.img_over h4 {top: 0;bottom: 0;height: 100%;display: flex;align-items: center;width: 50%;padding: 20px;text-align: left;font-size: 32px;color: #fff;}
	.follow_icon {display: flex;align-items: center;max-width: 100px;margin: 0 auto !important;justify-content: center;}
	h4.f-23 {flex-wrap: wrap;max-width: 60%;padding-right: 0;width: 100%;}
	.vid_play .u_play {position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);cursor: pointer;transition-duration: .3s;}
	.vid_play .u_play:hover{ opacity: .7;}
	.vid_play img:not(.u_play) {max-width: 100%;width: 100%;}
	.mh-185{min-height: 140px;}
	#subscription-carousel h4, #subscription-carousel .card-footer {display: none !important;}
	@media only screen and (max-width:426px){
		h4.f-23 span {font-size: 16px;}
	}
</style>
@endsection
