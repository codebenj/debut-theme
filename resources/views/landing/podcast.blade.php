@extends('layouts.landing')
@section('title','Ecommerce, Shopify & Dropshipping Podcasts | Ecomonics | Debutify')
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('content')


@if (!Request::is('podcast'))

@php
$podcast_title = "<span class='debutify-underline-lg'>Debutify Podcast</span>";
if(isset($tag_category_name) && !empty($tag_category_name)){
    $podcast_title = $page_title.' : '.htmlspecialchars_decode($tag_category_name['meta_name']);
}

$podcast_description = '';
if(isset($result_count)){
    $podcast_description = "We found {$result_count} results for your search";
    if(isset($term_search_value) && $term_search_value != ''){
        $podcast_description .= ' "'.$term_search_value.'"';
    }
}
@endphp


<div class='debutify-section'>
    <div class='container'>
      <div class='text-center'>
        <h1 class='display-3'>{!!$podcast_title!!}</h1>
        <p class='lead mt-4'>{{$podcast_description}}</p>
      </div>
    </div>
  </div>

@endif

@if (Request::is('podcast') && count($podcasts))

<div class='debutify-section'>
    <div class='container'>
        <div class='row text-center text-lg-left align-items-center'>
            <div class='col-md-6'>
                <h1>
                  <a class="text-black" href="{{Route('podcast_slug', $podcasts[0]->slug)}}">
                      {{$podcasts[0]->title}}
                  </a>
                </h1>

                @php
                $description = html_entity_decode(htmlspecialchars_decode(strip_tags($podcasts[0]->description), ENT_QUOTES));
                @endphp
                @if (strlen($description) > 250 && preg_match('/\s/', $description))
                @php
                $pos = strpos($description, ' ', 250);
                $podcast_description = substr($description, 0, $pos);
                @endphp
                <p> {{$podcast_description}} <a href="{{Route('podcast_slug', $podcasts[0]->slug)}}">Read More...</a></p>
                @else
                <p> {!! $podcasts[0]->description !!}</p>
                @endif

                <h4 class='text-gray-500 '><img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-play.svg"  alt="icon Play" width="21" height="21"/> 1,046 LISTENING</h4>
                <a class='btn btn-primary btn-lg my-4 debutify-hover btn-sm-block' href="{{Route('podcast_slug', $podcasts[0]->slug)}}">
                    Play The Latest Episode
                </a>
            </div>
            <div class='col-md-6'>
              <div class="responsive-container-1by1">
                <img alt="{{ $podcasts[0]->alt_text }}" class="lazyload img-fluid rounded "  data-src="{{$podcasts[0]->feature_image}}?v={{config('image_version.version')}}">
              </div>
                <img  class='lazyload d-lg-block d-none' style="position:absolute;bottom:-60px;right:-50px;z-index:-1;" data-src="images/landing/props-dots-gray.svg" alt="dots" >
            </div>
        </div>
    </div>
</div>


<section class='mt-5'>
    <div class='container'>
        <h3 class='text-center mb-4'> Featured On </h3>
        <div class='row'>
            @foreach ([
            ['image'=>'shopify','link'=>'https://www.shopify.com/?ref=debutify&utm_campaign=website-featured-logo'],
            ['image'=>'oberlo','link'=>'https://www.oberlo.com/'],
            ['image'=>'spocket','link'=>'https://www.spocket.co/'],
            ['image'=>'techstars','link'=>'https://www.techstars.com/'],
            ['image'=>'betakit','link'=>'https://betakit.com/'],
            ['image'=>'geekwire','link'=>'https://www.geekwire.com/']
            ] as $item)
            <div class="col-6 col-sm-4 col-md-4 col-lg-2 mb-3 ">
                <a target="_blank" href="{{$item['link']}}" >
                    <img class="lazyload w-100 " data-src="/images/landing/featured-{{$item['image']}}.png" alt="{{$item['image']}}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endif



<section class='debutify-section'>
    <div class='container'>

        @if (Request::is('podcast'))
        <h1 class='display-4 text-center mb-5'>Most Popular Episodes</h1>
        @endif

        <form id="podcast-search" method="POST" action="{{ route('search_podcasts') }}" class='mb-4'>
            {{ csrf_field() }}
            <div class="form-row">
                <div class='col-lg-6 mb-3'>
                    <div class="input-group">
                        <div class="input-group-prepend ">
                            <button class="btn btn-light" type="submit">
                              <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25"/>
                            </button>
                          </div>
                        <input type="text" class="form-control border-left-0 pl-0" id="search_title" name="search_title" placeholder="Search..." value="{{$search_field_value['search_title']??''}}">
                    </div>
                </div>
                <div class='col-md-3 mb-3'>
                    <select class="selectpicker" data-live-search="true" data-width='100%' data-size="6" id="category" name="search_by_category">
                        <option value="">Category...</option>
                        @foreach($all_tags_and_cat['podcast_category']??[] as $key => $category)
                        <option value="{{ $key }}" {{(($search_field_value['search_by_category']??'')== $key)?'selected':''}}>
                            {{ $category }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class='col-md-3 mb-3'>
                    <select class="selectpicker" data-live-search="true" data-width='100%' data-size="6" id="tag" name="search_by_tag">
                        <option selected value="">Tag...</option>

                        @foreach($all_tags_and_cat['podcast_tag']??[] as $key => $podcast_tag)
                        <option value="{{ $key }}" {{(($search_field_value['search_by_tag']??'')== $key)?'selected':''}}>
                            {{ $podcast_tag }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        <div id="podcasts-container">
            <div class='row justify-content-center'>
                @if (isset($podcasts) && !empty($podcasts) && count($podcasts) != 0)
                @foreach($podcasts as $key => $podcast)
                <div class="col-md-6 col-lg-4 mb-5">
                    <x-landing.podcast-template :podcast='$podcast'/>
                </div>
                @endforeach
                @else
                <div class='col'>
                    <h1 class='text-center my-5'>Result not found!</h1>
                </div>
                @endif
            </div>

            <?php $querystringArray = ['search' => request()->get('search')];?>
            {!! $podcasts->links('vendor.pagination.default')->render() !!}
        </div>

        <div class='card border-top-primary shadow mt-5'>
            <div class='card-body py-5'>
                <div class='text-center'>
                  <img class="lazyload" data-src="/images/landing/podcast-icon-infinite-anmated.svg" alt="podcast" width="190"/>
                    <!-- <object class='img-fluid lazyload' width="190" data-object="/images/landing/podcast-icon-infinite-anmated.svg" type="image/svg+xml"></object> -->
                    <h1 class='my-4'> Get The Latest Episodes In Your Inbox </h1>
                    <p >
                        Join over {{$nbShops}}+ smart business owners reading the Debutify newsletter.
                        Know first <br class='d-none d-lg-block'> when a new episode of Ecomonics is released. Subscribe today:
                    </p>
                </div>

                <form id='podcastNewsletter'>
                    <div class='form-row justify-content-center no-gutters position-relative'>
                        <div class='col-12 col-lg-6 '>
                            <div class='form-group'>
                                <input type="email" class='form-control form-control-sm mb-3' placeholder="Enter your email address" name='email' pattern="^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$" required>
                            </div>
                        </div>
                        <div class='col-12 col-lg-2'>
                            <button type="submit" class="btn btn-primary btn-sm btn-block mb-3"> Subscribe now </button>
                        </div>
                        <div class='col-12 col-lg-8' >
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="podcastNewsletterCheckbox" name="" required>
                                <label class="custom-control-label" for="podcastNewsletterCheckbox">
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


@if (Request::is('podcast') && count($podcasts))
<section class='debutify-section'>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-lg-8'>
                <div class='text-center mb-5'>
                    <h1>Your Ecomonics Host: Joseph Ianni</h1>
                      <img data-src="/images/landing/podcast-ianni.png" class="img-fluid lazyload my-5" alt="Joseph Ianni">
                    <h1>Hi, I’m Joseph Ianni. </h1>
                </div>
                <div class='lead'>
                    <p>If you’re looking for a podcast oozing with unique eCommerce insights...</p>
                    <p>Which can help you get more leads at lower CPAs, increase AOV, and boost CLV…</p>
                    <p>Here’s why:</p>
                    <p>Then this podcast is probably a perfect fit for you.</p>
                    <p>Every week, we’re bringing in experts from diverse backgrounds who know the “ins and outs” of their respective eCommerce domains.</p>
                    <p>We’ll be picking the brains of these successful, passionate, and driven individuals.</p>
                    <p>And my goal is to get them to spill the beans, let the cat out of the bag, and pull back the curtains to reveal some of their closely guarded secrets!</p>
                    <p>I’m talking about the juicy stuff regarding all things eCommerce: </p>
                    <p>From Facebook Ads, SEO, and PPC... to finding million-dollar products, the best automation strategies, and even insider 8-figure secrets from people who’ve already been there and beyond.</p>
                    <p>So whether you’ve been in this game for only a couple of months... or a “rugged veteran” for 10 years... you can still profit from what you’ll discover in each episode.</p>
                    <p>One single idea can mean hundreds of thousands… if not millions to your bottomline.</p>
                    <p>And if you’re new to the show, my request is for you to start with a white-belt mindset. </p>
                    <p>Go from the beginning. </p>
                    <p>Hear how my questions evolve as well as my views.</p>
                    <p>So join me in this exciting journey... learning from entrepreneurs who have in the trenches experience most dropshipping “goo-roos” can only dream about.</p>
                    <p>Welcome to Ecomonics — your new home for eCommerce insights that can set your Stripe account on fire.</p>
                    <p>I’ll see you inside.</p>
                    <div class='text-center'>
                    <a class="btn btn-primary btn-lg my-5 debutify-hover btn-sm-block" href="{{Route('podcast_slug', $podcasts[0]->slug)}}">
                        Start Listening To Ecomonics: Click Here
                    </a>
                    </div>
                    <img data-src="/images/joseph-sign.png" class="img-fluid lazyload my-5 mx-auto d-block" alt="joseph-sign">
                    <p><b>P.S.</b> In the off chance you’re wondering why you haven’t heard of my name before in the eCommerce world, here’s why:</p>
                    <p>Remember what I said about being a <i>white belt?</i></p>
                    <p>That was me at the start of this show.</p>
                    <p>And while I don't have an ecom empire to my name (yet)...</p>
                    <p>What I do have is a very particular set of skills. Skills I have acquired and honed for over 10 years. Skills that make me an asset for people like you...</p>
                    <div class="responsive-container-16by9 my-5">
                      <img data-src="/images/landing/podcast-movie-scene.jpg" class="lazyload" alt="movie scene">
                    </div>
                    <p class='text-center mb-4'><i>[High five if you remember this scene]</i></p>
                    <p>Podcasting has been my “ace in the hole” since I discovered it 10 years ago. </p>
                    <p>That’s why I can bring out the best in every expert and unearth unique insights from them… so you, the listener, can get the nuggets you can simply implement in your stores almost instantly.</p>
                    <p>So try it out. See for yourself. Listen to the first episode today.</p>
                    <div class='text-center'>
                        <a class="btn btn-primary btn-lg my-5 debutify-hover btn-sm-block" href="{{Route('podcast_slug', $podcasts[0]->slug)}}">
                            Start Listening To Ecomonics: Click Here
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


<section class='debutify-section'>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-lg-8'>
                <div class='card p-lg-5 shadow'>
                    <div class='card-body text-center'>
                        <div class='debutify-inline' data-rw-inline="22067"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function() {
    $("#podcast-search").on('submit', function(e) {
      e.preventDefault();
      $.ajax({
        type: 'POST',
        url: "{{ route('search_podcasts') }}",
        data: {
          search_title: $("#search_title").val(),
          search_by_category: $("#category").val(),
          search_by_tag: $("#tag").val(),
        },
        success: function(result) {
          $('#podcasts-container').html(result.html);
        }
      })
    });

    $("#search_title").keyup($.debounce(function(e) {
      $("#podcast-search").submit();
    },500));

    $("#category").change($.debounce(function(e) {
      $("#podcast-search").submit();
    },500));

    $("#tag").change($.debounce(function(e) {
      $("#podcast-search").submit();
    },500));
  });
</script>
@endsection
