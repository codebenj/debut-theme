@extends('layouts.landing')
@section('title',$blog_detail->title)
@section('description', $seo_description)
@section('content')

@php
$link  = '#';
if(isset($blog_detail->currentauthUser['name'])){
  $link = Route('blog_author_slug', strtolower(str_replace(' ','-',$blog_detail->currentauthUser['name'])));
}
@endphp

<section class='debutify-section'>
  <div class='container'>
    <div class='row align-items-center'>
      <div class='col-lg-5 text-mid-light text-lg-left text-center'>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-folder-black.svg" alt="icon folder" width="18" height="18" />
        @foreach($blog_detail->categories as $meta)
        <a class="text-reset" href="{{Route('blog_category_slug', $meta->slug)}}">
          {{htmlspecialchars_decode($meta->meta_name)}}
        </a>
        @endforeach

        {{$blog_detail->categories == '[]'?'Uncategorized':''}}
        <h1 class='my-3'>{{$blog_detail->title}}</h1>
        <div class="d-flex align-items-center flex-wrap justify-content-lg-start justify-content-center">
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-calendar.svg" alt="icon calendar" width="18" height="18" />
        {{$blog_detail->blog_publish_date??'XXXX-XX-XX'}}
        <span class='mx-2'>|</span>

        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-glass.svg" alt="icon glass" width="20" height="20" />
        {{floor(str_word_count(strip_tags($blog_detail->description)) / 200 )}} min read

        @if ($blog_detail->currentauthUser)
        <span class='mx-1'>|</span>
        <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-user.svg" alt="icon user" width="18" height="18" />
        <a class="text-reset" href="{{$link}}">
          <b> {{$blog_detail->currentauthUser['name']}}</b>
        </a>
        @endif
      </div>
      </div>
      <div class='col-lg-7'>
        <div class='mt-4 position-relative'>
          <div class="responsive-container-16by9">
            <img class="position-absolute rounded" alt="{{ $blog_detail->alt_text }}" src="{{$blog_detail->feature_image}}?v={{config('image_version.version')}}" style="z-index: 1; width:85%;right:0;margin:0 auto;height
            :85%;top:24px;">
          </div>
          <img class='lazyload position-absolute w-100 ' data-src="/images/landing/prop-wrapper-16by9.svg" style="top:0;"/>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="addtoany_share_save_container addtoany_content addtoany_content_bottom d-none d-md-block">
  <div class="social-box-icon text-center" style="position: fixed ;top: 25%;z-index: 9;">
    <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" data-a2a-url="{{Route('blog_slug', $blog_detail->slug)}}" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
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
          <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{Route('blog_slug', $blog_detail->slug)}}">
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
          <img class='lazyload w-100' data-src="/images/landing/resource-map.svg" alt="">
          <div class="card-body">
            <h3> {{ $nbShops }}+ Stores Are Selling Big With <br class='d-none d-lg-block'> Debutify. What About Yours? </h3>
            <p class='my-4'>  Debutify takes guessing out of the equation. Build a <br class='d-none d-lg-block'>  high-converting store with confidence. </p>
            <a href='/' class="btn btn-primary btn-lg my-4 debutify-hover" >
              INCREASE MY SALES NOW
            </a>
          </div>
        </div>

        <div class='single-content my-4'>
            {!! $blog_detail->description !!}
        </div>

        <div class='card bg-light overflow-hidden py-5'>
          <div class='card-body'>
            <div class=' text-center'>
              <h1 class="w-75 mx-auto"> {{$nbShops}}+ Are Reading The Debutify Newsletter. </h1>
              <p class='my-4'>Get bite-sized lessons from leading experts in the world of e-commerce.  <br class='d-none d-lg-block'>
                Improve your business in 5 minutes a week. Subscribe today:
              </p>
            </div>
            <img class='lazyload position-absolute d-lg-block d-none' style="left:-100px;bottom:0px;" data-src="/images/landing/newsletter-prop-infinite-animated.svg" alt="" width="300px">

            <form id='blogNewsletter'>
              <div class='form-row justify-content-center position-relative pb-4'>
                <div class='col-12 col-lg-6 '>
                  <div class='form-group'>
                    <input type="email" class='form-control form-control-sm mb-3' placeholder="Enter your email address" name='email' pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>
                  </div>
                </div>
                <div class='col-12 col-lg-3'>
                  <button type="submit" class="ml-lg-2 btn btn-primary btn-sm btn-block mb-3"> Subscribe now </button>
                </div>

                <div class='col-12 col-lg-9' >
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="blogNewsletterCheckbox" name="" required>
                    <label class="custom-control-label" for="blogNewsletterCheckbox">
                      <small> I agree to receive regular updates from Debutify. <a href="/privacy-policy">View Privacy Policy here.</a></small>
                    </label>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class='rounded mt-4 p-3' style="background-color:#F6F6F6;">
          <div id="fb-root"></div>
          <div class="fb-comments" data-href="{{Route('blog_slug', $blog_detail->slug)}}" data-numposts="10" data-width="100%"></div>
        </div>


        @if(!empty($blog_detail->tags) && count($blog_detail->tags) > 1)
        <div class="my-4 text-lg-left text-center ">
          <span class='lead'><img class="lazyload mr-1 d-inline-block " data-src="/images/landing/icons/icon-tags.svg" alt="tags icon"> Tags </span><br class='d-block d-lg-none'>
          @foreach($blog_detail->tags as $item)
          <a href="{{ Route('blog_tag_slug', $item->slug)}}" class="badge badge-sm badge-pill badge-primary">
            {{$item->meta_name}}
          </a>
          @endforeach
        </div>
        @endif

        @if ($blog_detail->currentauthUser)
        @php
        $profile_image ='/images/debutify-logo-icon.png';
        if(isset($blog_detail->currentauthUser['profile_image']) && !empty($blog_detail->currentauthUser['profile_image'])){
          $profile_image = $blog_detail->currentauthUser['profile_image'];
        }
        @endphp
        <div class='row text-lg-left text-center'>
          <div class='col-sm-3'>
            <a href="{{$link}}">
              <img data-src="{{$profile_image}}" class='lazyload rounded-circle img-fluid' width='160' >
            </a>
          </div>
          <div class='col-sm-9'>
            <p class='text-mid-light my-1'>Written by</p>
            <h4> <a class='text-black' href="{{$link}}">{{ $blog_detail->currentauthUser['name'] }}</a> </h4>
            <p>{{ $blog_detail->currentauthUser['short_description'] }}</p>
          </div>
        </div>

        @endif

        <div class="d-flex justify-content-between debutify-prev-next my-4">
          <a href="{{Route('blog_slug', $blog_prev_next['previous']['slug'])}}" class='text-reset d-flex align-items-center'>
             <img class="lazyload mx-3 d-inline-block" data-src="/images/landing/icons/icon-chevron-left.svg" alt="chevron left" width="25" height="25">
            <div> {{  ucfirst(str_replace('-',' ',$blog_prev_next['previous']['slug'])) }}</div>
          </a>
          <div class='mx-lg-5 mx-2'></div>
          <a href="{{Route('blog_slug', $blog_prev_next['next']['slug'])}}" class="text-reset d-flex align-items-center float-right">
            <div>{{  ucwords(str_replace('-',' ',$blog_prev_next['next']['slug'])) }}</div>
            <img class="lazyload mx-3 d-inline-block" data-src="/images/landing/icons/icon-chevron-right.svg" alt="chevron right" width="25" height="25">
          </a>
        </div>

      </div>

      <div class='col-lg-4'>
        <div class="input-group mb-4">
          <div class="input-group-prepend ">
            <label class='input-group-text' for="resource-search">
              <img class="lazyload d-inline-block"  data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25" />
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
              <img class='img-fluid lazyload w-100' data-src="/images/landing/blog-reserve.svg" alt="">
            </div>

            <a  role='button' class="mt-4 btn btn-primary btn-sm btn-block disabled">Coming Soon!</a>
          </div>
        </div>


        @if(isset($latest_podcast[0]['slug']) && !empty($latest_podcast[0]['slug']))
        <div class="card border-top-primary mb-4 shadow">
          <div class="card-body">
            <h4>Our Latest Podcast</h4>
            <a href="{{ Route('podcast_slug', $latest_podcast[0]['slug']) }}">
              <p>{{ $latest_podcast[0]['title'] }} </p>
            </a>

            <x-landing.audio-embed :audioURL="$latest_podcast[0]['podcast_widget']" padding='56.25%' type='inline' autoplay='false'/>

          </div>
        </div>
        @endif

        <x-landing.newsletter class='sticky-newsletter '/>
      </div>

    </div>
  </div>
</section>

<section class='debutify-section'>
  <div class='container'>
    @if(!empty($latest_blog_same_cat) && count($latest_blog_same_cat) > 0)

    <h1 class="text-center mb-5">Related articles</h1>

    <div class='row justify-content-center'>
      @foreach($latest_blog_same_cat as $key => $item)
      @if ($key<3)
      <div class='col-md-4  mb-4'>
        <x-landing.blog-template :blog="$item"/>
      </div>
      @endif
      @endforeach
    </div>

    @if(isset($meta->slug) && count($latest_blog_same_cat) > 3)
    <div class="text-center">
      <a class="btn btn-light btn-sm-block" href="{{Route('blog_category_slug', $meta->slug)}}">View More</a>
    </div>
    @endif

    @endif
  </div>
</section>

@endsection

@section('scripts')

<script crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js" defer></script>
<script type="text/javascript" src="{{ asset('js/a2a_social_icon.js') }}" defer></script>
<script>
  var debutify_resources = {show:true,url:'/blog',route:"{{Route("blog_slug",":slug")}}"};
</script>
@endsection
