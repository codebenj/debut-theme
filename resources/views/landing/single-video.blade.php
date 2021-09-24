@extends('layouts.landing')
@section('title',$video->title)
@section('description', $og_description)
@section('content')

@php
$link  = '#';
if(isset($video->currentauthUser['name'])){
    $link = Route('video_author_slug', strtolower(str_replace(' ','-',$video->currentauthUser['name'])));
}
@endphp


<section class='debutify-section'>
    <div class='container'>
        <div class='row align-items-center'>
            <div class='col-lg-5 text-mid-light text-lg-left text-center'>
                <img class="lazyload mr-1 d-inline-block"  data-src="/images/landing/icons/icon-folder-black.svg" alt="icon folder" width="18" height="18" />
                @foreach($video->categories as $k => $meta)
                <a class="text-reset" href="{{Route('video_category_slug', $meta->slug)}}">
                    {{htmlspecialchars_decode($meta->meta_name)}}
                </a>
                @endforeach

                {{$video->categories == '[]'?'Uncategorized':''}}
                <h1 class='my-3'>{{$video->title}}</h1>
                <img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-calendar.svg" alt="icon calendar" width="18" height="18"/>
                {{$video->publish_date??'XXXX-XX-XX'}}

                <span class='mx-1'>|</span>
                  <img class="lazyload mr-1 d-inline-block" src="/images/landing/icons/icon-microphone.svg" alt="icon microphone" width="18" height="18">  {{ $video->watching_time??'Xh' }}

                @if(isset($video->currentauthUser['name']))
                <span class='mx-1'>|</span>
                <img class="lazyload d-inline-block mr-1" data-src="/images/landing/icons/icon-user.svg" alt="icon user" width="18" height="18">
                <a class="text-mid-light" href="{{$link}}">
                    <b>{{$video->currentauthUser['name']}}</b>
                </a>
                @endif

                <br>

                <a class='mt-5 btn btn-primary btn-lg debutify-hover btn-sm-block' target="_blank" href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w">
                    Subscribe Now
                </a>

            </div>

            <div class='col-lg-7'>
                <div class='position-relative d-flex align-items-center justify-content-center mt-4'>
                    <div class='position-absolute' style="z-index: 1; width:85%;">
                        <x-landing.video-player
                        :link='$video->video_id'
                        type='inline'
                        resolution='maxresdefault'/>
                    </div>
                    <img class='lazyload position-relative w-100 ' data-src="/images/landing/prop-wrapper-16by9.svg">
                </div>
            </div>
        </div>
    </div>
</section>

<div class="addtoany_share_save_container addtoany_content addtoany_content_bottom d-none d-md-block">
    <div class="social-box-icon text-center" style="position: fixed ;top: 25%;z-index: 9;">
        <div class="a2a_kit a2a_kit_size_32 a2a_floating_style a2a_vertical_style" data-a2a-url="{{Route('video_slug', $video->slug)}}" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
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
                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url="{{Route('video_slug', $video->slug)}}">
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
                    <img class='lazyload w-100' src="/images/landing/resource-map.svg" alt="">
                    <div class="card-body">
                        <h3> {{ $nbShops }}+ Stores Are Selling Big With <br class='d-none d-lg-block'> Debutify. What About Yours? </h3>
                        <p class='my-4'>  Debutify takes guessing out of the equation. Build a <br class='d-none d-lg-block'>  high-converting store with confidence. </p>
                        <a href='/' class="btn btn-primary btn-lg my-4 debutify-hover" >
                            INCREASE MY SALES NOW
                        </a>
                    </div>
                </div>
                <div class='single-content my-4'>
                        {!! $video->description !!}
                </div>
                <div class='rounded mt-4 p-3' style="background-color:#F6F6F6;">
                    <div id="fb-root"></div>
                    <div class="fb-comments" data-href="{{Route('video_slug', $video->slug)}}" data-numposts="10" data-width="100%"></div>
                </div>

                @if(!empty($video->tags) && count($video->tags) > 1)
                <div class="my-4 text-center text-lg-left">
                    <span class='lead'><img class="lazyload mr-1 d-inline-block" data-src="/images/landing/icons/icon-tags.svg" alt="tags icon" width="37" height="37"> Tags </span><br class='d-block d-lg-none'>
                    @foreach($video->tags as $k => $meta)
                    <a href="{{ Route('video_tag_slug', $meta->slug)}}" class="badge badge-sm badge-pill badge-primary">
                        {{$meta->meta_name}}
                    </a>
                    @endforeach
                </div>
                @endif


                @if ($video->currentauthUser)

                @php
                $profile_image ='/images/debutify-logo-icon.png';
                if(isset($video->currentauthUser['profile_image']) && !empty($video->currentauthUser['profile_image'])){
                    $profile_image = $video->currentauthUser['profile_image'];
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
                        <h4> <a class='text-black' href="{{$link}}">{{ $video->currentauthUser['name'] }}</a> </h4>
                        <p>{{ $video->currentauthUser['short_description'] }}</p>
                    </div>
                </div>
                @endif


                <div class="d-flex justify-content-between debutify-prev-next my-4">
                    <a href="{{Route('video_slug', $video_prev_next['previous']['slug'])}}" class='text-reset d-flex align-items-center'>
                        <img class="lazyload mx-3 d-inline-block"  data-src="/images/landing/icons/icon-chevron-left.svg" alt="chevron left" width="25" height="25" />
                        <div> {{  ucfirst(str_replace('-',' ',$video_prev_next['previous']['slug'])) }}</div>
                    </a>
                    <div class='mx-lg-5 mx-2'></div>
                    <a href="{{Route('video_slug', $video_prev_next['next']['slug'])}}" class="text-reset d-flex align-items-center float-right">
                        <div>{{  ucwords(str_replace('-',' ',$video_prev_next['next']['slug'])) }}</div>
                        <img class="lazyload mx-3 d-inline-block"  data-src="/images/landing/icons/icon-chevron-right.svg" alt="chevron right" width="25" height="25" />
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
                    <video class="lazyload w-100 rounded" preload="none" muted="" data-autoplay=""  src="/product_video/sidebar_video.mp4"></video>
                  </a>

                @if(isset($latest_blog))
                <div class="card my-4 border-top-primary shadow">
                    <div class="card-body">
                        <h4>Featured Article</h4>
                        <a href="{{ Route('blog_slug', $latest_blog['slug']) }}">
                            <p> {{ $latest_blog['title'] }}  </p>
                            <img class="lazyload w-100 rounded" data-src="{{ $latest_blog['feature_image'] }}" >
                        </a>
                    </div>
                </div>
                @endif

                <x-landing.newsletter id='default'/>
            </div>
        </div>
    </div>
</section>

<section class='debutify-section'>
    <div class='container'>
      <div class='card border-top-primary shadow'>
        <div class='card-body pl-5 pr-5'>
          <div class='row align-items-center'>
            <div class='col-md-7 order-2 order-md-1'>
              <h3>Be A Guest On Debutify Podcast & YouTube Channel</h3>
              <p class='lead mt-4 mb-5'>We're on a mission to help ecommerce owners start, scale and succeed in business. Have valuable lessons to share? Apply and become a guest on our channel today.</p>
              <a class='btn btn-sm-block btn-primary debutify-hover' href='/career' type='button'>Apply Now</a>
            </div>
            <div class='col-md-4 offset-md-1 order-1 order-md-2'>
              <img class='lazyload img-fluid m-auto d-block p-4' width="300" height="400" data-src="/images/landing/podcast-apply.svg" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<section class='debutify-section'>
    <div class='container'>

        @if(isset($latest_video_same_cat) && count($latest_video_same_cat) > 0)
        <h1 class="text-center mb-5">Related YouTube Videos</h1>

        <div class='row justify-content-center'>
            @foreach($latest_video_same_cat as $key => $latest_video_same_category)
            <div class='col-md-4 mb-4'>
                <x-landing.video-template :video='$latest_video_same_category'/>
            </div>
            @endforeach
        </div>

        @if(isset($meta->slug) && count($latest_video_same_cat) > 3 )
        <div class="text-center">
            <a class="btn btn-light" href="{{Route('video_category_slug', $meta->slug)}}">View More</a>
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
    var debutify_resources = {show:true,url:'/video',route:"{{Route("video_slug",":slug")}}"};
</script>
@endsection
