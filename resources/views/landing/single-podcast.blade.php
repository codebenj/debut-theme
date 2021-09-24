@extends('layouts.landing')
@section('title',$podcast_detail->title)
@section('description', $og_description)
@section('content')

@php
$link  = '#';
if(isset($podcast_detail->currentauthUser['name'])){
  $link = Route('podcast_author_slug', strtolower(str_replace(' ','-',$podcast_detail->currentauthUser['name'])));
}
@endphp

<section class='debutify-section'>
  <div class='container'>
    <div class='row align-items-center'>
      <div class='col-lg-6 text-mid-light text-lg-left text-center'>
          <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-folder-black.svg" alt="icon folder" width="18" height="18" />
        @foreach($podcast_detail->categories as $meta)
        <a class="text-mid-light" href="{{Route('podcast_category_slug', $meta->slug)}}">
          {{htmlspecialchars_decode($meta->meta_name)}}
        </a>
        @endforeach

        {{$podcast_detail->categories == '[]'?'Uncategorized':''}}
        <h1 class='my-3'>{{$podcast_detail->title}}</h1>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-calendar.svg" alt="icon calendar" width="18" height="18"/>
        {{$podcast_detail->podcast_publish_date??'XXXX-XX-XX'}}
        <span class='mx-1'>|</span>

        <img class="lazyload mr-1 d-inline-block" src="/images/landing/icons/icon-microphone.svg" alt="icon microphone" width="18" height="18">
        {{ $podcast_detail->transcript_time??'N' }} Listening Time

        @if(isset($podcast_detail->currentauthUser['name']))
        <span class='mx-1'>|</span>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-user.svg" alt="icon user" width="18" height="18">
        <a class="text-reset" href="{{$link}}">
          <b>{{$podcast_detail->currentauthUser['name']}}</b>
        </a>
        @endif

      </div>
      <div class='col-lg-6'>
        <div class='position-relative mt-4'>
          <div class="responsive-container-1by1 t-25">
            <img class="lazyload position-absolute rounded" alt="{{ $podcast_detail->alt_text }}" data-src="{{$podcast_detail->feature_image}}?v={{config('image_version.version')}}" style="z-index: 1;width: 85%;right: 0;margin: 0 auto;height: 85%;top: 40px;">
          </div>
          <img class='lazyload position-absolute w-100 ' data-src="/images/landing/prop-wrapper-1by1.svg" style="top:0;">
        </div>
      </div>
    </div>
  </div>
</section>

<div class="addtoany_share_save_container addtoany_content addtoany_content_bottom d-none d-md-block">
  <div class="social-box-icon text-center" style="position: fixed ;top: 25%;z-index: 9;">
    <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" data-a2a-url="{{Route('podcast_slug', $podcast_detail->slug)}}" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
      <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
      <a class="a2a_button_facebook"></a>
      <a class="a2a_button_twitter"></a>
      <a class="a2a_button_email"></a>
      <a class="a2a_button_pinterest"></a>
      <a class="a2a_button_linkedin"></a>
      <a class="a2a_button_whatsapp"></a>
      <a class="a2a_button_google_gmail"></a>
    </div>
  </div>
</div>

<section class='debutify-section'>
  <div class='container'>
    <div class='row'>
      <div class='col-lg-8'>
        <div class="addtoany_share_save_container addtoany_content addtoany_content_bottom mb-4 d-md-none d-flex justify-content-center">
          <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{Route('podcast_slug', $podcast_detail->slug)}}">
            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
            <a class="a2a_button_facebook"></a>
            <a class="a2a_button_twitter"></a>
            <a class="a2a_button_email"></a>
            <a class="a2a_button_pinterest"></a>
            <a class="a2a_button_linkedin"></a>
            <a class="a2a_button_whatsapp"></a>
            <a class="a2a_button_google_gmail"></a>
          </div>
        </div>

        <div id="in-between-card" class="card border-top-primary text-center shadow my-4">
          <img class='lazyload card-img-top' data-src="/images/landing/resource-map.svg" alt="Resource map"/>
          <div class="card-body">
            <h3> {{ $nbShops }}+ Stores Are Selling Big With <br class='d-none d-lg-block'> Debutify. What About Yours? </h3>
            <p class='my-4'>  Debutify takes guessing out of the equation. Build a <br class='d-none d-lg-block'>  high-converting store with confidence. </p>
            <a href='/' class="btn btn-primary btn-lg my-4 debutify-hover" >
              INCREASE MY SALES NOW
            </a>
          </div>
        </div>

        <x-landing.audio-embed :audioURL="$podcast_detail->podcast_widget" type='inline' padding='30%' autoplay='false'/>

        <ul class="mt-4 nav nav-pills nav-justified" role="tablist">
          @foreach ([
          ['icon'=>'description','label'=>'Description'],
          ['icon'=>'transcript','label'=>'Transcript'],
          ['icon'=>'comments','label'=>'Comments'],
          ] as $index => $item)
          <li class="nav-item mb-4 debutify-tab">
            <a class="nav-link {{$index==0?'active':''}}" data-toggle="pill" href="#resource-{{$item['icon']}}">
              <img class='lazyload' data-src="/images/landing/icon-{{$item['icon']}}.svg" alt="" width="40">
              <p class='lead'>  {{$item['label']}}</p>
            </a>
          </li>
          @endforeach
        </ul>

        <div class="tab-content my-4 single-content">
          <div class="tab-pane container active" id="resource-description" >
              {!! $podcast_detail->description !!}
          </div>

          <div class="tab-pane container fade" id="resource-transcript">
            <div class='max-read'>
              {!! $podcast_detail->podcast_transcript !!}
            </div>

            @if(strlen(strip_tags($podcast_detail->podcast_transcript)) > 5000 )
            <div class='text-center'>
              <button type='button' class='mt-4 btn btn-light max-read-btn'>
                Read More
              </button>
            </div>
            @endif
          </div>

          <div class="tab-pane container fade" id="resource-comments">
            <div class='rounded my-4 p-3' style="background-color:#F6F6F6;">
              <div id="fb-root"></div>
              <div class="fb-comments" data-href="{{Route('podcast_slug', $podcast_detail->slug)}}" data-numposts="10" data-width="100%"></div>
            </div>
          </div>
        </div>


        @if(!empty($podcast_detail->tags) && count($podcast_detail->tags) > 1)
        <div class="my-4 text-lg-left text-center ">
          <span class='lead'><img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-tags.svg" alt="tags icon" width="37" height="37" /> Tags </span><br class='d-block d-lg-none'>
          @foreach($podcast_detail->tags as $item)
          <a href="{{ Route('podcast_tag_slug', $item->slug)}}" class="badge badge-sm badge-pill badge-primary">
            {{$item->meta_name}}
          </a>
          @endforeach
        </div>
        @endif

        @if ($podcast_detail->currentauthUser)

        @php
        $profile_image ='/images/debutify-logo-icon.png';
        if(isset($podcast_detail->currentauthUser['profile_image'])){
          $profile_image = $podcast_detail->currentauthUser['profile_image'];
        }
        @endphp
        <div class='row text-center text-lg-left'>
          <div class='col-sm-3'>
            <a href="{{$link}}">
              <img data-src="{{$profile_image}}" class='lazyload rounded-circle img-fluid' width='160' >
            </a>
          </div>
          <div class='col-sm-9'>
            <p class='text-mid-light my-1'>Written by</p>
            <h4>
              <a class='text-black' href="{{$link}}">{{ $podcast_detail->currentauthUser['name'] }}</a>
            </h4>
            <p>{{ $podcast_detail->currentauthUser['short_description'] }}</p>
          </div>
        </div>

        @endif

        <div class="d-flex justify-content-between debutify-prev-next my-4">
          <a href="{{Route('podcast_slug', $podcast_prev_next['previous']['slug'])}}" class='text-reset d-flex align-items-center'>
            <img class="lazyload mx-3 d-inline-block" data-src="/images/landing/icons/icon-chevron-left.svg" alt="chevron left" width="25" height="25" />
            <div> {{  ucfirst(str_replace('-',' ',$podcast_prev_next['previous']['slug'])) }}</div>
          </a>
          <div class='mx-lg-5 mx-2'></div>
          <a href="{{Route('podcast_slug', $podcast_prev_next['next']['slug'])}}" class="text-reset d-flex align-items-center float-right">
            <div>{{  ucwords(str_replace('-',' ',$podcast_prev_next['next']['slug'])) }}</div>
            <img class="lazyload mx-3 d-inline-block" data-src="/images/landing/icons/icon-chevron-right.svg" alt="chevron right" width="25" height="25" />
          </a>
        </div>
      </div>

      <div class='col-lg-4'>
        <div class="input-group mb-4">
          <div class="input-group-prepend ">
            <label class='input-group-text' for="resource-search">
              <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25"/>
            </label>
          </div>
          <input type="text" id="resource-search"  class="form-control border-left-0 pl-0" placeholder="Search" >
        </div>
        <div id='resource-search-result' class='mb-4'></div>
        <a href="/">
          <video class="lazyload w-100 rounded" preload="none" muted="" data-autoplay=""  src="/product_video/sidebar_video.mp4">
          </video>
        </a>
        <div class='card border-top-primary my-4 shadow'>
          <div class='card-body'>
            <h3>Limited Free Seats:</h3>
            <h4 class='text-reset'>Free Dropshipping Webinar</h4>
            <p>The 3 Eye-Opening Secrets To How I Built a $2,670,000/Month Dropshipping Brand, In Less Than 3 Month</p>
            <div class='responsive-container-1by1'>
              <img class='img-fluid float-right lazyload' data-src="/images/landing/blog-reserve.svg?v={{config('image_version.version')}}" alt="">
            </div>
            <a  role='button' class="mt-4 btn btn-primary btn-sm btn-block disabled">Coming Soon!</a>
          </div>
        </div>
        <div class="card border-top-primary mb-4 shadow">
          <div class="card-body">
            <h4>Featured Article</h4>
            <a href="{{ Route('blog_slug', $latest_blog['slug']) }}">
              <p class="align-items-center">
                {{ $latest_blog['title'] }}
              </p>
              <div class='responsive-container-16by9'>
                <img class="lazyload rounded w-100" data-src="{{ $latest_blog['feature_image'] }}?v={{config('image_version.version')}}" >
              </div>
            </a>
          </div>
        </div>

        <x-landing.newsletter id='default' class='sticky-newsletter '/>

      </div>
    </div>
  </div>
</section>

<section class='debutify-section'>
  <div class='container'>
    <div class='card border-top-primary shadow'>
      <div class='card-body p-3 p-md-5'>
        <div class='row align-items-center'>
          <div class='col-md-7 order-2 order-md-1'>
            <h2><b>Be A Guest On Debutify <br class='d-none d-lg-block'>Podcast & YouTube Channel</b></h2>
            <p class='lead mt-4 mb-5'>We're on a mission to help ecommerce owners start, scale and succeed in business. Have valuable lessons to share? Apply and become a guest on our channel today.</p>
            <a class='btn btn-sm-block btn-primary debutify-hover' href='/career' type='button'>Apply Now</a>
          </div>
          <div class='col-md-4 offset-md-1 order-1 order-md-2 mb-4 mb-md-0'>
            <div class='responsive-container-9by10'>
              <img class='lazyload img-fluid m-auto d-block' data-src="/images/landing/podcast-apply.svg?v={{config('image_version.version')}}" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="debutify-section">
  <div class="container">

    @if(isset($latest_podcast_same_cat) && count($latest_podcast_same_cat) > 0)
    <h1 class="text-center mb-5">Related episode</h1>

    <div class="row justify-content-center">
      @foreach($latest_podcast_same_cat as $key => $item)
      @if ($key<3)
      <div class='col-md-4 mb-4'>
        <x-landing.podcast-template :podcast="$item"/>
      </div>
      @endif
      @endforeach
    </div>

    @if(isset($meta->slug)  && count($latest_podcast_same_cat) > 3)
    <div class="text-center">
      <a class="btn btn-light" href="{{Route('podcast_category_slug', $meta->slug)}}">View More</a>
    </div>
    @endif

    @endif

  </div>
</section>
@endsection

@section('scripts')

<script crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js" defer></script>
<script src="{{ asset('js/a2a_social_icon.js') }}" defer></script>
<script>
  var debutify_resources = {show:true,url:'/podcast',route:"{{Route("podcast_slug",":slug")}}"};
</script>
@endsection

@section('styles')
<style>
@media only screen and (max-width:426px){
  .t-25 img {
      top: 25px !important;
  }
}
</style>

@endsection
