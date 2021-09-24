@extends('layouts.landing')

@section('title', $partner->seo_title)
@section('description', $partner->seo_description)


@section('styles')
	<style>
		.img-active {
			cursor: pointer;
			opacity: 1;
			box-shadow: 0 3px 80px 0 rgba(14,2,71,.08)!important;
		}
		.img-inactive {
			cursor: pointer;
			opacity: 0.5;
		}
	</style>
@endsection

@section('content')
<section class="debutify-section">
	<div class="container">
		<a class='text-reset' href="{{$partner->about_link}}">
			<h1 class='display-3 text-center'>
				{{$partner->page_heading?$partner->page_heading:'Debutify Trusted Partner'}} | {{ $partner->name }}
			</h1>
		</a>

		<p class='lead my-4 text-center'>
			{{$partner->page_subheading?$partner->page_subheading:'Debutify is partnered with the industry’s leading technology and Ecommerce providers to deliver our clients excellent merchant experiences.'}}
		</p>

		<div class="row justify-content-center ">
			<div class='col-md-4 mb-3'>
				<div class='card shadow h-100'>
					<div class='card-body'>
						<div class="responsive-container-16by9">
							<img class='lazyload img-fluid'  data-src="{{ $partner->logo }}?v={{config('image_version.version')}}"  alt="partner logo">
						</div>
					</div>
				</div>
			</div>
			<div class='col-md-4 mb-3'>
				<div class='card shadow h-100'>
					<div class='card-body'>
						<div class="responsive-container-16by9">
							<img class='lazyload img-fluid' data-src="/images/landing/debutify-logo-dark-md.svg?v={{config('image_version.version')}}"  alt="debutify logo">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row justify-content-center">
			@if($partner->offer_description)
				<span class="badge badge-pill badge-secondary inline-margin-5">
					{{ $partner->offer_description }}
				</span>
			@endif

			@if($partner->popular == 1)
				<span class="badge badge-pill badge-warning inline-margin-5">
				Popular
				</span>
			@endif

			@if($partner->created_at >= \Carbon\Carbon::now()->subMonth(1)->format('Y-m-d'))
				<span class="badge badge-pill badge-info inline-margin-5">
				New
				</span>
			@endif
		</div>

		@if($partner->short_description)
		<p class="text-center my-4 lead">
			{{ $partner->short_description }}
		</p>

		@endif

		<div class='text-center'>
			@if($partner->link)
			<a href="{{ $partner->link }}" class="btn btn-primary btn-sm-block debutify-hover mr-2 mb-2">
				Start Now
			</a>
			@endif
			@if($partner->documentation_link)
			<a href="{{ $partner->documentation_link }}" class="btn btn-outline-secondary btn-sm-block debutify-hover mb-2">
				See Docs
			</a>
			@endif
		</div>

	</div>
</section>

<section class="debutify-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				@if(count($partner->images))
				<div class="mb-5">
					<div class="responsive-container-1by1">
						<img id="main-image" class="img-fluid rounded w-100 shadow lazyload" data-src="{{ $partner->images[0]->image_path }}?v={{config('image_version.version')}}">
					</div>

					<div class="row mt-4">
						@foreach($partner->images as $image)
						<div class="col">
							<div class="responsive-container-1by1">
								<img class="img-fluid debutify-hover rounded w-100 lazyload shadow img-thumb img-inactive" data-src="{{ $image->image_path }}?v={{config('image_version.version')}}">
							</div>
						</div>
						@endforeach
						@if(count($partner->images) % 5 !== 0)
						@foreach (range(0, count($partner->images) % 5) as $col)
						<div class="col">
						</div>
						@endforeach
						@endif
					</div>
				</div>
				@endif

				{!! $partner->description !!}
			</div>

			<div class="col-12 col-lg-4">
				<div class="card shadow">
					<div class="card-body">
						<p class="lead font-weight-bolder text-black"> CATEGORY </p>

						@if(!count($partner->categories))
						<p> Uncategorized </p>
						@else
						@foreach($partner->categories as $category)
						<p>
							<a class="btn-link" href="{{ route('partners.landing', ['category' => $category]) }}">
								{{ $category }}
							</a>
						</p>
						@endforeach
						@endif

						@if(count($partner->supported_countries))
						<div class="mt-5">
							<p class="lead font-weight-bolder text-black"> SUPPORTED IN </p>

							@foreach($partner->supported_countries as $country)
							<p>
								<img data-src="{{ $country->file_url }}" class="mr-2 lazyload" width="35px" alt="{{ $country->name }}">
								<span class="mt-1">
									{{ $country->name }}
								</span>
							</p>
							@endforeach

						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@if(count($partner->images))
<section class="bg-light debutify-section">
	<div class="container">
		@foreach($partner->images as $imageKey => $image)
		<div class="row align-items-center py-lg-5">
			<div class="col-lg-6 {{ $imageKey % 2 == 0 ? '' : 'order-lg-2' }}">
				<div class="responsive-container-1by1">
					<img alt="{{ $image->title }}" class="lazyload img-fluid rounded w-100 lazyload" data-src="{{ $image->image_path }}?v={{config('image_version.version')}}">
				</div>
			</div>
			<div class="col-lg-6 py-4">
				<p class='lead font-weight-bolder'>
					{{ $image->title }}
				</p>
				<p class="mt-2">
					{{ $image->description }}
				</p>
			</div>
		</div>
		@endforeach
	</div>
</section>



<section class='debutify-section'>
	<div class='container text-center'>
		<h1>
			No Coding, Website design or Shopify <br class='d-none d-lg-block'>
			Experience Needed
		</h1>
		<p class='mt-4 mb-5'>
			Debutify makes things simple. Launch your store in a few clicks, with all the featreus you need to succeed <br class='d-none d-lg-block'>
			already built-in.
		</p>

		<div class='row'>
			@foreach ([
			['icon'=>'setup2','title'=>'Install theme in 1 click' ],
			['icon'=>'addons2','title'=>'Bulk-install Add-Ons in 1 click' ],
			['icon'=>'update2','title'=>'Automatic updating' ],
			['icon'=>'integration2','title'=>'Integrate with existing plugins in 1 click' ],
			['icon'=>'dropshipping2','title'=>'100% Optimized for Dropshipping' ],
			['icon'=>'suppot2','title'=>'Rely on 24/7 customer support to solve all issues' ],
			] as $item)
			<div class='col-md-6 col-lg-4 mb-3'>
				<div class='card shadow h-100'>
					<div class='card-body updates-features debutify-animation-wrapper' data-animation-target='icon-updates-{{$item['icon']}}'>
						<!-- <img class='lazyload' data-src="/images/landing/icon-{{$item['icon']}}.svg" alt="" width="70" height="70"> -->
						<object class="mr-2 lazyload" width="70" height="70" type="image/svg+xml" id='icon-updates-{{$item['icon']}}' data-object="/images/landing/icon-{{$item['icon']}}-infinite-animated.svg"></object>
						<h4 class='lead my-3 font-weight-light'>{{$item['title']}}</h4>
					</div>
				</div>
			</div>

			@endforeach
		</div>
	</div>
</section>


<section class='debutify-section'>
	<div class='container text-center'>
		<h1>Want To Partner Up With Debutify?</h1>
		<p>Applications are open! Send yours today:</p>
		<a href="/career" class="btn btn-primary debutify-hover btn-sm-block px-4"> Apply Now </a>
	</div>
</section>

@endif


@endsection

@section('scripts')
	<script>
	window.addEventListener('DOMContentLoaded', function() {
		$(".img-thumb").click(function(e) {
			$(".img-thumb").addClass("img-inactive");
			$(e.target).removeClass("img-inactive");
			$(e.target).addClass("img-active");
			$("#main-image").data("src", $(e.target).attr("src"));
			$("#main-image").attr("src", $(e.target).attr("src"));
		});
	});
	</script>
@endsection
