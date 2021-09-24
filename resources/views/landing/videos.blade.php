@extends('layouts.landing')
@section('title', $seo_title??'Videos | Debutify')
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('content')


@if (Request::is('video') && $videos[0]??0)
<section class='debutify-section'>
    <div class='container'>
        <div class='row align-items-center text-lg-left text-center'>
            <div class='col-lg-6 '>
                <a class='text-reset' href="{{Route('video_slug', $videos[0]->slug)}}">
                <h1> {{$videos[0]->title}} </h1>
                </a>
                <p class='my-4'>

                    @php
                    $description = html_entity_decode(htmlspecialchars_decode(strip_tags($videos[0]->description), ENT_QUOTES));
                    $video_desc = 0;
                    if(strlen($description) > 130 && preg_match('/\s/', $description)){
                        $pos = strpos($description, ' ', 100);
                        $video_desc = substr($description, 0, $pos);
                    }
                    @endphp

                    @if ($video_desc)
                    <p> {{$video_desc}} <a href="{{Route('video_slug', $videos[0]->slug)}}">Read More...</a></p>
                    @else
                    <p class="text-left"> {!! $videos[0]->description !!}</p>
                    @endif

                </p>
                <h4 class='text-gray-500 '><img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-play.svg"  alt="icon Play" width="21" height="21" /> 4.45K subscribers</h4>
                <a class='btn btn-primary btn-lg my-4 debutify-hover btn-sm-block' href="{{Route('video_slug', $videos[0]->slug)}}">
                    Play The Latest Video
                </a>
            </div>
            <div class='col-lg-6'>
                <x-landing.video-player :link='$videos[0]->video_id' type='inline' resolution='maxresdefault'/>
            </div>
        </div>
    </div>
</section>

<section class="debutify-section">
    <div class="container">
        <x-landing.featured/>
          <div class='card mt-5 p-3 p-md-5 shadow'>
              <div class='card-body p-0'>
                  <div class='row'>
                      <div class='col-lg-7'>
                          <h3>Improve Your Business One Lesson <br class='d-none d-lg-block'> At A Time</h3>
                          <p class='mt-4 mb-5'>For more ecommerce education, subscribe to our official YouTube channel. Get notified first when a new video is out.</p>
                          <a class='btn btn-secondary debutify-hover  btn-sm-block' target="_blank" href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w">
                              Subscribe Now <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-subscribe.svg"  alt="external link" width="24" height="24"/>
                          </a>
                      </div>
                    <div class='col-lg-5 mt-3 mt-md-0'>
                      <div class="responsive-container-4by3">
                        <img class='d-block mx-auto img-fluid lazyload' data-src="/images/landing/video-youtube-animated.svg?v={{config('image_version.version')}}" alt="youtube-videos">
                      </div>
        				{{-- <object class='d-block mx-auto img-fluid lazyload' data-object="/images/landing/video-youtube-animated.svg" type="image/svg+xml"></object> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endif


@if (!Request::is('video'))
@php
$video_title = 'Debutify Videos';
if(isset($tag_category_name) && !empty($tag_category_name)){
    $video_title = $page_title.' : '.htmlspecialchars_decode($tag_category_name['meta_name']);
}

$video_description = '';
if(isset($result_count)){
    $video_description = "We found {$result_count} results for your search";
    if(isset($term_search_value) && $term_search_value != ''){
        $video_description .= ' "'.$term_search_value.'"';
    }
}
@endphp

<x-landing.jumbotron :title="$video_title" :description='$video_description'/>
@else
<h1 class='text-center'>Most Popular Videos</h1>
@endif

<section class="debutify-section">
    <div class='container'>
        <form method="POST" id="video-search" action="{{ route('search_videos') }}" class='mb-4'>
            {{ csrf_field() }}
            <div class="form-row">
                <div class='col-lg-6'>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend ">
                            <button class="btn btn-light" type="submit">
                              <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25" />
                            </button>
                          </div>
                        <input type="text" class="form-control  border-left-0 pl-0" id="search_title" name="search_title" placeholder="Search..." value="{{$search_field_value['search_title']??''}}">
                    </div>
                </div>
                <div class='col-md-3 '>
                    <select  class="selectpicker mb-3" data-live-search="true" data-width='100%' data-size="6" id="category" name="search_by_category">
                        <option value="">Category...</option>
                        @foreach($all_tags_and_cat['video_category']??[] as $key => $category)
                        <option value="{{ $key }}" {{(($search_field_value['search_by_category']??'')== $key)?'selected':''}}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class='col-md-3'>
                    <select class="selectpicker" data-live-search="true" data-width='100%' data-size="6" id="tag" name="search_by_tag">
                        <option selected value="">Tag...</option>
                        @foreach($all_tags_and_cat['video_tag']??[] as $key => $video_tag)
                        <option value="{{ $key }}" {{(($search_field_value['search_by_tag']??'')== $key)?'selected':''}}>
                            {{ $video_tag }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div id="videos-container">
            <div class="row justify-content-center">
                @if (isset($videos) && !empty($videos) && count($videos) != 0)

                @foreach($videos as $video)
                <div class="col-md-6 col-lg-4 mb-4">
                    <x-landing.video-template :video='$video'/>
                </div>
                @endforeach
                @else
                <div class='col'>
                    <h1 class='text-center my-5'>Result not found!</h1>
                </div>
                @endif
            </div>

            @php  $querystringArray = ['search' => request()->get('search')];  @endphp
            {!! $videos->links('vendor.pagination.default')->render() !!}
        </div>
    </div>
</section>

<section class='debutify-section'>
    <div class='container'>
      <div class='card border-top-primary shadow '>
          <div class='card-body'>
              <div class='text-center'>
                  <img class='lazyload mb-3' data-src="/images/landing/icon-video-infinite-animated.svg" alt="icon video" width="130">
                  <h1>Get The Latest Videos In Your Inbox</h1>
                  <p class='mt-4'>
                      Join over {{$nbShops}} smart business owners reading the Debutify newsletter. Be the first <br class='d-none d-block'>
                      to know when a new video is released. Subscribe today:
                  </p>
              </div>
              <form id='videoNewsletter'>
                  <div class='form-row justify-content-center no-gutters position-relative'>
                      <div class='col-12 col-lg-6 '>
                          <div class='form-group'>
                              <input type="email" class='form-control form-control-sm mb-3' placeholder="Enter your email address" name='email' pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>
                          </div>
                      </div>
                      <div class='col-12 col-lg-2'>
                          <button type="submit" class="ml-lg-1 btn btn-primary btn-sm btn-block mb-3 "> Subscribe now </button>
                      </div>
                      <div class='col-12 col-lg-8' >
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="videoNewsletterCheckbox" name="" required>
                              <label class="custom-control-label" for="videoNewsletterCheckbox">
                                 <small> I agree to receive regular updates from Debutify. <a href="/privacy-policy">View Privacy Policy here.</a></small>
                              </label>
                          </div>
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function() {
    $("#video-search").on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: "{{ route('search_videos') }}",
        data: {
          search_title: $("#search_title").val(),
          search_by_category: $("#category").val(),
          search_by_tag: $("#tag").val(),
        },
        success: function(result) {
          $('#videos-container').html(result.html);
        }
      })
    });

    $("#search_title").keyup($.debounce(function(e) {
      $("#video-search").submit();
    },500));

    $("#category").change($.debounce(function(e) {
      $("#video-search").submit();
    },500));

    $("#tag").change($.debounce(function(e) {
      $("#video-search").submit();
    },500));
  });
</script>
@endsection
