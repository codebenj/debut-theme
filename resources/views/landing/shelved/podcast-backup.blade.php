@extends('layouts.landing', ['page' => 'podcast'])
@section('title','Ecommerce, Shopify & Dropshipping Podcasts | Ecomonics | Debutify')
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('styles')
<style>
    .podcast-mic-icon {
        position: absolute;
        bottom: 0;
        right: 70px;
    }
    .btn-play-podcast {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50px;
    }
    .text-gray {
        color: #D1D1D1;
    }
</style>
@endsection

@section('content')
<div class="podcast">
    <section class="podcast-section py-5">
        <div class="container">
            
            @if(isset($result_count))
            <div class="row justify-content-md-center text-center">
                <div class="col-md-10">
                    <p class="mt-4 mb-0">
                        We found {{ $result_count }} results for your search  
                        @if (@isset($term_search_value) && $term_search_value != '')
                        "{{$term_search_value}}"
                        @endif
                    </p>
                </div>
            </div>
            @else
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="debutify-underline">{{ $podcasts[0]->title }}</h1>
                    <?php
                    $description = html_entity_decode(htmlspecialchars_decode(strip_tags($podcasts[0]->description), ENT_QUOTES));
                    if (strlen($description) > 300 && preg_match('/\s/', $description)) {
                        $pos = strpos($description, ' ', 300);
                        $podcast_description = substr($description, 0, $pos);?>
                        <div class="mt-3">{{$podcast_description}}</div>
                    <?php } else {?>
                        <div class="mt-3">{!! $podcasts[0]->description !!}</div>
                    <?php } ?>
                    <?php $listening = number_format(rand(500, 2000)); ?>
                    <p class="text-gray font-weight-bold"><img alt="LISTENING" class="lazyload img-fluid mr-2" data-src="/images/play-icon.png"> {{ $listening }} LISTENING</p>
                    <a href="{{Route('podcast_slug', $podcasts[0]->slug)}}" type="button" class="btn btn-primary mb-5">Play The Latest Episode</a>
                </div>
                <div class="col-md-6 text-center">
                    <div class="position-relative">
                        <img alt="{{ $podcasts[0]->alt_text }}" class="lazyload img-fluid rounded-top w-100" data-src="{{$podcasts[0]->feature_image}}">
                        <a href="{{Route('podcast_slug', $podcasts[0]->slug)}}" class="btn bg-white px-4 btn-play-podcast">
                            <span class="mt-1 mr-3 d-inline-block">Play Now</span> 
                            <img data-src="/images/play-icon-blue.png" class="lazyload img-fluid" alt="">
                        </a>
                    </div>
                    <p class="rounded-bottom shadow p-4 font-weight-bold">{{ $podcasts[0]->alt_text }}</p>
                </div>
            </div>
            @endif

        </div>
    </section>

    <div class="container debutify-dash"></div>

    <section class="py-5">
        <div class='container'>
            <h4 class='text-center mb-4'> Featured On </h4>
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

    <section class="py-4">
        <div class="container">
            <h2 class='text-center mb-4'>Most Popular Episodes</h2>

            <form method="POST" action="{{ route('search_podcasts') }}">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col mb-3 mb-md-0">
                        <input type="text" class="form-control bg-light border-0" name="search_title" placeholder="Search..." value="<?php if(isset($search_field_value['search_title'])){ echo $search_field_value['search_title']; } ?>">
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <section class="section pb-5" id="podcast-page">
        <div class="container">
            <div id="data-wrapper" class="row">

                @if(isset($podcasts) && !empty($podcasts) && count($podcasts) != 0)
                @foreach($podcasts as $key => $podcast)
                <div class="col-sm-6 mb-4">
                    <div class="card h-100 podcast-card shadow">
                        <div class="card-body pb-0">

                            <h4 class="card-title"><a class="font-weight-bold text-black" href="{{Route('podcast_slug', $podcast->slug)}}"> {{$podcast->title}}</a></h4>

                            <iframe class="lazyload" sandbox="allow-same-origin allow-scripts allow-top-navigation allow-popups allow-forms" scrolling=no width="100%" height="185" frameborder="0" data-src="{{$podcast->podcast_widget }}"></iframe>

                            <?php
                            $description = html_entity_decode(htmlspecialchars_decode(strip_tags($podcast->description), ENT_QUOTES));
                            if (strlen($description) > 250 && preg_match('/\s/', $description)) {
                                $pos = strpos($description, ' ', 250);
                                $podcast_description = substr($description, 0, $pos);?>
                                <p> {{$podcast_description}} <a href="{{Route('podcast_slug', $podcast->slug)}}">Read More...</a></p>
                                <?php } else {?>
                                <div> {!! $podcast->description !!}</div>
                            <?php 
                            }
                            ?>

                        </div>
                        <div class="card-footer border-top">
                            <ul class="list-inline list-unstyled mb-0 small">
                                @if(isset($podcast->transcript_time) && !empty($podcast->transcript_time))
                                <li class="list-inline-item">
                                    <span class="fas fa-headphones" aria-hidden="true"></span>
                                    {{ $podcast->transcript_time }} Listening Time
                                </li>
                                <li class="list-inline-item">|</li>
                                @endif

                                <li class="list-inline-item">
                                    <span class="far fa-calendar-alt" aria-hidden="true"></span> 
                                    {{ (!empty($podcast->podcast_publish_date) ? date('M d Y', strtotime($podcast->podcast_publish_date)) : date('M d Y', strtotime($podcast->created_at)) ) }}
                                </li>
                            </ul>
                        </div>
                    </div> 
                </div>
                @endforeach

                @else
                <div class="col-md-7 mb-3 mb-md-0">
                    <h4>Result not found!</h4>
                </div>
                @endif
            </div>

            @if(!isset($result_count))
            <div class="text-center">
                <button type="button" class="btn btn-secondary load-more-podcast">Load More</button>
            </div>
            @endif

        </div>
    </section>

    <section class="section pb-5">
        <div class="container">
            <x-landing.newsletter id="3"/>
        </div>
    </section>

    <section class="section pb-5">
        <div class="container">
            <div class="row">                
                <div class="col-md-8 offset-md-2">
                    <div class="text-center">
                        <h2 class="mb-5">Your Ecomonics Host: Joseph Ianni</h2>
                        <span class="position-relative d-inline-block mb-5">
                            <img data-src="/images/joseph-ianni.png" class="img-fluid lazyload" alt="">
                            <img data-src="/images/mic-icon.png" class="img-fluid podcast-mic-icon lazyload" alt="">
                        </span>
                        <h2 class="mb-5">Hi, I’m Joseph Ianni.</h2>
                    </div>
                    <div>
                        <p>If you’re looking for a podcast oozing with unique eCommerce insights...</p>
                        <p>Which can help you get more leads at lower CPAs, increase AOV, and boost CLV…</p>
                        <p>Then this podcast is probably a perfect fit for you.</p>
                        <p>Here’s why:</p>
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
                        <p>Welcome to Ecomonics -- your new home for eCommerce insights that can set your Stripe account on fire.</p>
                        <p class="mb-5">I’ll see you inside.</p>

                        <div class="text-center">
                            <a href="{{Route('podcast_slug', $podcasts[0]->slug)}}" class="btn btn-primary mb-5">Start Listening To Economics: Click Here</a>
                        </div>

                        <div class="text-center">
                            <img data-src="/images/joseph-sign.png" class="img-fluid lazyload mb-5" alt="">
                        </div>

                        <p>P.S. In the off chance you’re wondering why you haven’t heard of my name before in the eCommerce world, here’s why:</p>
                        <p>That was me at the start of this show.</p>
                        <p>And while I don't have an ecom empire to my name (yet)...</p>
                        <p class="mb-5">What I do have is a very particular set of skills. Skills I have acquired and honed for over 10 years. Skills that make me an asset for people like you...</p>

                        <div class="text-center">
                            <img data-src="/images/movie-scene.png" class="img-fluid lazyload mb-4" alt="">
                            <p class="mb-5">[High five if you remember this scene]</p>
                        </div>

                        <p>Podcasting has been my “ace in the hole” since I discovered it 10 years ago.</p>
                        <p>That’s why I can bring out the best in every expert and unearth unique insights from them... so you, the listener, can get the nuggets you can simply implement in your stores almost instantly.</p>
                        <p class="mb-5">So try it out. See for yourself. Listen to the first episode today.</p>

                        <div class="text-center">
                            <a href="{{Route('podcast_slug', $podcasts[0]->slug)}}" class="btn btn-primary mb-5">Start Listening To Economics: Click Here</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

    <div class="container debutify-dash"></div>

    <section class="py-5">
        <div class='container'>
            <div class='test'>
                <x-landing.reviews type="masonry" btn='secondary'/>
            </div>
        </div>
    </section>
</div>


@endsection

@section('scripts')
<script>
window.addEventListener('DOMContentLoaded', function() {
    function loadMorePodcast(podcastPage) {
        $.ajax({
            url: "/podcast?page=" + podcastPage,
            datatype: "html",
            type: "get",
            beforeSend: function () {
                $('.load-more-podcast').text('Loading...');
            }
        })
        .done(function (response) {
            if (response.length == 0) {
                $('.load-more-podcast').hide();
                return;
            }
            $('.load-more-podcast').prop('disabled', false).text('Load More');
            $("#data-wrapper").append(response);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
    }

    var podcastPage = 1;
    $(document).on('click', '.load-more-podcast', function(){
        $(this).prop('disabled', true);
        podcastPage++;
        loadMorePodcast(podcastPage);
    });
});
</script>
@endsection
