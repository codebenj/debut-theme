@extends('layouts.landing')

@section('title',"Debutify - World's Smartest Shopify Theme. Free 14-day Trial")
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')

@section('announcement')


    @if (isset($cms_data['announcement_top_bar']['content']) && !empty($cms_data['announcement_top_bar']['content']))
    <div class='bg-dark py-2 text-center text-white'>
    {!! html_entity_decode(htmlspecialchars_decode($cms_data['announcement_top_bar']['content'])) !!}
    </div>
    @endif
    @endsection



@section('content')
{{-- The Shopify Theme For Sales --}}
<section class='debutify-section'>
    <div class='container'>
        <div class='row align-items-center'>
            <div class='col-lg-6'>
                <h1 class='text-lg-left text-center display-3'>
                    <i>The</i> Shopify Theme For <span class='debutify-underline-sm'>Sales</span>
                </h1>
                <div class='text-lg-left text-center'>
                    <p class='my-4 lead'>Good things in life shouldn’t wait. Build a wildly successful store using Debutify.</p>
                    <p class='lead'>Captivate your visitors with Debutify’s Conversion Booster today. Try free for 14 days — no credit card required!</p>
                </div>
                <x-landing.cta  download='btn-primary' class='d-flex justify-content-center justify-content-lg-start' demo='btn-outline-secondary' cta='X'/>
            </div>
            <div class='col-lg-6 order-first order-lg-last' >
                <div class='responsive-container-4by3' style="">
                    <img src="/images/landing/homepage-above-the-fold.jpg?v={{config('image_version.version')}}"  alt='above the fold'>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Ambassador Highlight --}}
<section class='debutify-section'>
    <div class='container position-relative' >
        <h1 class='text-center display-4 mb-4'>Trusted By Leading <br class='d-none d-lg-block'> Ecommerce Entrepreneurs</h1>

        <div style="min-height:470px;">
            <div id='ambassadors-carousel' class='debutify-carousel' style="display:none;">
                @foreach ([
                // ['image'=>'ricky-hayes','wistia_video_id'=>'udc3l8p7kk','message'=>"Before using Debutify, I'm about 2 percent conversion. Right now, I'm at a 3 percent conversion rate, and I've done over $15,000,000 in sales since I started in 2017. I love Debutify because you'll get all of the conversion rate hacks... a super-fast loading theme, fantastic support and a minimalistic design. Because of these, I can now focus on what matters most to my business.",'name'=>"Ricky Hayes", 'description'=>"8 Figure Ecommerce Entrepreneur. Digital Marketing Agency Owner. Ecommerce Mentor with 50,000+ students."],
                ['image'=>'kamil-sattar','wistia_video_id'=>'ddp06vz1by','message'=>"Me and all my students use Debutify theme and <b>we generated over $7,000,000</b> combined in the last two to three months. The conversion rates are amazing, the Add-Ons are amazing... it's changed my store and my life.",'name'=>"Kamil Sattar", 'description'=>"The Ecom King. Youngest FORBES Business Council Member."],
                ['image'=>'jordan-welch','wistia_video_id'=>'o9giis8s90','message'=>"Right now, Debutify is my favorite theme which gives the <b>highest conversion rates and the fastest page speed</b>. Debutify has rocking support team that really cares about you and wants to help you with whatever issues you're facing. Debutify ranks up there in the top ones for sure.",'name'=>"Jordan Welch", 'description'=>"7 Figure Brand Owner, Ecommerce Influencer"],
                ['image'=>'james-beattie','wistia_video_id'=>'q4axn6p5ts','message'=>"I've been using Debutify theme for three to four months now and we're seeing about a 2 to 3 percent conversion rate. We made some optimizations within the theme and we're now heading about <b>five percent conversion rate on a new branded Shopify store</b>. I like Debutify theme and they've got a ton of Add-Ons as well.",'name'=>"James Beattie", 'description'=>"Ecom Insider. Ecommerce Mentor and Influencer."],
                ['image'=>'chris-wane','wistia_video_id'=>'','message'=>"I've switched to Debutify across all my stores and saved $180 a month from expensive standalone apps. I truly believe [Debutify] is a game changer. <b>So if you're looking for a way to cut the running cost of your of your Shopify store then take a look at [Debutify] </b>.",'name'=>"Chris Wane", 'description'=>"Ecommerce Influencer and Mentor"],
                ['image'=>'marc-chapon','wistia_video_id'=>'5elz3nbyg7','message'=>"<b>Debutify has everything that you need in order to test and scale to store efficiently</b>. You don't need to worry about... oh is my store fast enough?... Is my store optimized for conversions? With Debutify you know that you have everything to succeed. Debutify is an amazing choice and I just couldn't recommend it enough.",'name'=>"Marc Chapon", 'description'=>"7-Figure Ecommerce Entrepreneur & YouTube Content Creator"],
                ['image'=>'otis-coleman','wistia_video_id'=>'','message'=>"In terms of store design, I would definitely use Debutify. It’s <b>clean and simple</b> and I've been using it recently and <b>transformed all of my stores</b> with it. A really good theme to use.",'name'=>"Otis Coleman", 'description'=>"The Ecom Wizard"],
                ] as $item)

                <div class='card shadow'>
                    <div class='card-body p-0  rounded overflow-hidden'>
                        <div class='row no-gutters'>
                            <div class='col-lg-8 bg-primary mobile-height'>
                                <img class="lazyload img-fluid position-absolute" data-src="images/landing/slider-quote.svg" style="top:5%;left:5%;" alt="Ambassador Quote">
                                <div class='p-5 text-white'>
                                    <p class='font-italic lead'>{!!$item['message']!!}</p>
                                    <p class="font-weight-bolder mt-4 mb-0">{{$item['name']}}</p>
                                    <p>{{$item['description']}}</p>
                                </div>
                            </div>
                            <div class='col-lg-4 bg-light order-first order-lg-last'>
                                <x-landing.wistia-video-player type='slot' :embedId="$item['wistia_video_id']" class='responsive-container-9by10'>
                                    <img class="lazyload " data-src="/images/landing/ambassador-{{$item['image']}}.jpg?v={{config('image_version.version')}}" alt="{{$item['name']}}">
                                </x-landing.wistia-video-player>
                            </div>
                        </div>
                    </div>
                </div>

                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- The Old Way Vs The Smart Way --}}
<section class='debutify-section'>
    <div class='container text-center'>
        <h1 class='mb-5 display-4'>
            The Old Way Vs <span class='text-nowrap debutify-underline-lg'>The Smart Way</span>
        </h1>
        <div class='row justify-content-center'>
            <div class='col-lg-8'>
                <div class='text-center'>
                    <p class='mb-4 lead'>Shopify themes are broken. If you've ever built a store, you know the drill: spend way too much time building pages, add dozens of Apps to help you convert (each costing an arm and a leg)... and end up with a store that's difficult to manage — and <br class='d-lg-block d-none'/> converts miserably.</p>
                    <p class='lead mb-4'>Debutify is the smart way to launch your ecom business. Build a persuasive store in hours — not weeks — and verify your product idea today. Then rely on Debutify's smart marketing features to scale your sales through the roof.</p>
                </div>
            </div>
        </div>
        <div class='position-relative'>
            <div class='responsive-container-16by9' style="">
                <video class="lazyload w-100" preload="none" muted="" data-autoplay="" loop  src="/product_video/theme_landing_page_video_2.mp4">
                </video>
            </div>
        </div>
    </div>
</section>

{{-- Bootstrap Your Business --}}
<section class='debutify-section'>
    <div class='container'>
        <div class='row'>
            @foreach ([
            ['title'=>'Launch Your Next Ecommerce Brand','icon'=>'launch',
            'description'=>'Add a new store to your income stream with Debutify. Use our powerful selling features to grow from zero to six figures and beyond.',
            'list'=>['Create new stores quickly and easily','Increase your conversions','Kill the competition'
            ]],
            ['title'=>'Build A Successful Dropshipping Store','icon'=>'dropshipping',
            'description'=>'Start selling today, and build your dream business with an ecommerce mentor.',
            'list'=>['Make maximum revenue from every visitor','Build your store exactly how you visualize it','Scale with secret marketing strategies & group mentoring'
            ]],
            ['title'=>'Extend Your Retail Brand Online','icon'=>'store',
            'description'=>'Grow your retail business online with easy customization options and tested online sales methods.',
            'list'=>['Create your desired store look quickly and easily','Let our Sales Add-Ons do the selling for you','Learn foolproof tactics to grow your business online'
            ]],
            ] as $index => $item)
            <div class='col-lg-4 mb-4'>
                <div class='card h-100 shadow-sm'>
                    <div class='card-body'>
                        <div class='rounded d-flex align-items-center justify-content-center' style="width:82px;height:82px;background:#F8F8F8;">
                            <img class='lazyload' data-src="/images/landing/icon-{{$item['icon']}}.svg" alt="sss icons" width="45" height="45">
                        </div>

                        <h3 class='my-4'>  {{$item['title']}} </h3>
                        <p class='mb-4'> {{$item['description']}} </p>

                        @foreach ($item['list'] as $list)
                        <div class='d-flex mb-3'>
                            <img class='lazyload mt-1 mr-2' data-src="/images/landing/cta-check.svg" alt="list detail" width="21" height="21">
                            <div>{{$list}}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class='card-footer pb-5'>
                        <x-landing.download-btn link='1' class='text-primary lead' cta='X' label="Bootstrap Your Business" arrow='1'/>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Debutify To Grow --}}
<section class='bg-light debutify-section'>
    <div class='container'>
        <div class='text-center'>
            <h1 class='mb-4 display-4'>Over <span class='debutify-underline-lg'>{{$nbShops}} Brands</span> Are <br class='d-none d-lg-block'> Using Debutify To Grow</h1>
            <p class='lead mb-5'>Join thousands of smart ecommerce <br class='d-none d-lg-block'> owners scaling their business</p>
        </div>

        <div style="min-height: 612px" class='mb-4'>
            <div id="debutify-businesses" style="display: none">
                @foreach ([
                ['image'=>'livine','title'=>'FITNESS','description'=>'Livine'],
                ['image'=>'beautify-cosmetic','title'=>'BEAUTY & COSMETICS','description'=>'Jenniferlay'],
                ['image'=>'baby-products','title'=>'BABY','description'=>'Little Baby Paws'],
                ['image'=>'supplements','title'=>'HEALTH','description'=>'Normshealy'],
                ['image'=>'art','title'=>'ART','description'=>'Make Me Royal USA'],
                ['image'=>'lifestyle','title'=>'ACTIVE LIFESTYLE','description'=>'Chaos Sports'],
                ['image'=>'boxing','title'=>'SPORTS EQUIPMENT','description'=>'Fight Cables'],
                ['image'=>'home','title'=>'HOME PRODUCTS','description'=>'Wunderhaas'],
                ] as $item)
                <div >
                    <div class='pt-3 debutify-hover mx-3'>
                        <div class='responsive-container-9by16'>
                            <img class='w-100 rounded lazyload' data-src="/images/landing/homepage-business-{{$item['image']}}.jpg?v={{config('image_version.version')}}" alt="{{$item['image']}}">
                        </div>
                    </div>
                    <div class='text-lg-left text-center mx-3'>
                        <h4 class='my-3'>{{$item['title']}}</h4>
                        <p class='lead'>{{$item['description']}}</p>
                    </div>
                </div>

                @endforeach
            </div>
        </div>

        <x-landing.cta widget='0' class='d-flex justify-content-center' download='btn-primary' demo='btn-outline-secondary' cta='X'/>

    </div>
</section>

{{-- Sell, ScaleAnd Succeed --}}
<section class='debutify-section'>
    <div class='container overflow-hidden'>
        <h1 class='text-center mb-5 display-4'>
            <span class='debutify-highlight-sm pl-3'>Sell,</span>
            <span class='debutify-highlight-sm px-3'>Scale</span>And
            <span class='debutify-highlight-sm pl-3'>Succeed.</span>
            <br> All With One Smart Theme
        </h1>
        <div class='row justify-content-center'>
            <div class='col-lg-9'>
                @php $sss = ['sell','scale','succeed'] @endphp
                <div class='row align-items-center position-relative'>
                    <img class='position-absolute w-100 lazyload' data-src="/images/landing/landing-cycle.svg" alt="cycle" >
                    @foreach ($sss as $item)
                    <div class='col-4 debutify-hover'>
                        <div class='debutify-animation-wrapper' data-animation-target='icon-cycle-{{$item}}'>
                            <a href="#debutify-{{$item}}" class='smooth-scroll position-relative'>
                                <div class='p-2 p-lg-4 position-relative'>
                                    <div class='responsive-container-1by1 rounded-circle' style="box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);">
                                        <object id='icon-cycle-{{$item}}' class='lazyload w-100  pointer-none' data-object="/images/landing/landing-cycle-{{$item}}-v2.svg?v={{config('image_version.version')}}" type="image/svg+xml" ></object>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class='col-lg-9'>
                <img class='w-100 lazyload mt-5' data-src="/images/landing/sss-label.png" alt="sss" >
            </div>
        </div>
    </div>
</section>

{{-- Get Maximum Sales --}}
<section id='debutify-sell' class='debutify-section'>
    <div class='container text-center'>
        <img  class='lazyload img-fluid' data-src="/images/landing/cycle-sell-block.svg"  alt="block"> <br>
        <h1 class='my-5 display-4'>Get <span class='debutify-underline-lg'>Maximum</span> Sales</h1>
        <p class='lead mb-5'>Say goodbye to low product page conversions. Unlock the built-in Add-Ons <br class='d-none d-lg-block'> and always be converting at maximum.</p>
        <x-landing.addons id='2' showAll='0' />
    </div>
</section>

{{-- Scale Your Brand --}}
<section id='debutify-scale' class='debutify-section'>
    <div class='container'>
        <img  class='lazyload img-fluid mx-auto d-block mb-4' data-src="/images/landing/cycle-scale-block.svg"  alt="block"> <br>

        <div class="row align-items-center">
            <div class='col-lg-6'>
                <div class='text-lg-left text-center'>
                    <h1> Scale Your Brand <span class='debutify-underline-lg'> <br class='d-none d-lg-block'> Through The Roof</span></h1>
                    <p class='mt-5 lead'>Don't stop at Facebook or Google Ads.</p>
                    <p class='lead mt-4 mb-5'>Unlock a world of new marketing channels and conversion tricks with Debutify's Marketing Strategies. Get more traffic, more sales, and more freedom.</p>
                </div>
                <x-landing.download-btn class='btn-outline-primary debutify-hover btn-sm-block' cta='X' />
            </div>
            <div class='col-lg-6 order-lg-last order-first'>
                 <div class='responsive-container-1by1'>
                    <img class='lazyload w-100' data-src="/images/landing/homepage-roof.jpg?v={{config('image_version.version')}}" alt='roof'>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Join The Ranks --}}
<section class='debutify-section'>
    <div class='container'>
        <div class="row align-items-center">
            <div class='col-lg-6'>
              <div class='responsive-container-1by1'>
                    <img class='lazyload img-fluid' data-src="/images/landing/homepage-ecom.jpg?v={{config('image_version.version')}}" alt='ecom'>
                </div>
            </div>
            <div class='col-lg-6'>
                <div class='text-lg-left text-center'>
                    <h1> Join The Ranks Of  <br class='d-none d-lg-block'> <span class='debutify-underline-sm'>Smart</span> Ecom Owners</h1>
                    <p class='mt-5 mb-4 lead'>Show off your profits and claim your title among the most successful ecom businessmen/women. Plus, learn other members' secret growth strategies — only available inside the group.</p>
                    <p class='lead mb-5'>Oh, and did we also mention the group is monitored directly by Ricky, who helps you with marketing and responds to all your questions?</p>
                </div>
                <x-landing.download-btn class='btn-outline-primary debutify-hover btn-sm-block' cta='X' />
            </div>
        </div>
    </div>
</section>

{{-- Save Over $2.5k Per Month --}}
<section class='debutify-section align-items-center'>
    <div class='container'>
        <div class='row align-items-center'>
            <div class='col-lg-6'>
                <div class='text-lg-left text-center'>
                    <h1>Save Over <span class='debutify-underline-lg'>$2.5k Per Month </span> On Shopify Apps </h1>
                    <p class='mt-4 lead'>Having just a theme isn't enough — you need dozens of extra Apps to launch a true business.</p>
                    <p class='my-4 lead'>With Debutify, your favorite conversion-boosting and product research apps are already built-in.</p>
                    <p class='mb-5 lead'>Launch a successful store without a 4-figure budget, and save over $2.5k every month to invest in testing and scaling.</p>
                </div>
                <x-landing.download-btn class='btn-outline-primary debutify-hover btn-sm-block' cta='X' />
            </div>

            <div class='col-lg-6  order-lg-last order-first'>
                 <div class='responsive-container-4by3'>
                    <img class='lazyload img-fluid' data-src="/images/landing/homepage-save.jpg?v={{config('image_version.version')}}" alt='save'>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Join Thousands Of Brand Owners --}}
<section class='bg-light debutify-section'>
    <div class='container'>

        <div class='debutify-grid' data-rw-grid="23004"></div>
        
        {{-- <div id="debutify-reviews" style="display: none">
            @foreach ([
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2591738/','name'=>'Moises, CEO','title'=>'The best Shopify theme','description'=>'Since I started using the theme, I noticed superior performance, because the settings are more intuitive and make it easy for customers to buy the products. I really like this theme. The truth is that it has worked excellently for me to sell my products, I like that it is simple and practical, it has all the settings I need to sell my products correctly.'],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2662258/','name'=>'Krissy F, Mommy/Designer','title'=>'Surprised this was free!','description'=>'I was looking for more customization options and Debutify gave me more than I could have asked for. The functionality and options included are close to those found on 200.00 paid themes, which is unheard of nowadays! <br> <br> Thank you for offering such a great theme!'],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2584305/','name'=>'Dani R, CEO','title'=>"Debutify is the go-to platform for starters.','description'=>'My experience with Debutify is great, they provide top service and their customer support always does their best to help. Website is easy to set up, which is a huge pro in my line of field.<br>Debutify is definitely one of the best out there. The options seem limitless and you can easily change aspects on your website within minutes. It's very easy to use and one of the greatest features is that your website style is the same after just a few clicks."],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2662006/','name'=>'Maxime J, Arts and Crafts','title'=>'A real weapon','description'=>"This app is really easy to use. After installation, my conversion rate went from 1% to 3%. It's a no-brainer, I will highly recommend Debutify to anyone starting an online store."],
           
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2563543/','name'=>'Ryon S, Web Designer','title'=>'Amazing at a decent price for ANY point in your business','description'=>"100% amazing, this is the only theme I would ever use. All the features I needed without paying a bunch of money.<br>I loved the customization options and the free applications that came with my subscription extremely helped me out. The customer service is so interactive in your issue, bet it will get resolved. I loved this theme so much for my small business and only at $20 a month, It is 100% worth it. They have a free version but I didn't stay on that long, Once I upgraded, never even looked back at going free"],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2678837/','name'=>'Jordan G, Marketing and Advertising','title'=>'Great for expanding businesses looking to scale','description'=>'My experience was exceptional and nothing below average. I like how easy it was to use, how flexible it was and how simple it was to set up.'],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2670517/','name'=>'Albert P, Consumer Goods','title'=>'Works Great and Looks Great','description'=>'Very happy. It seems to do everything that I want it to do and I am pleased with that overall. I like the ease of use. I am not real computer literate but I really found this easy to use.'],
            ['image'=>'','link'=>'','name'=>'Da Kuawn J, CEO','title'=>'Great theme to keep your storefront simple and professional','description'=>'One of my friends was doing $100k in revenue per month using this theme and suggested it to me. <br><br>Overall [Debuty is] great. It was one of my highest converting themes. Super easy to customize. The theme was very clean and simple.'],
           
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2646815/','name'=>'Ballal A, Apparel & Fashion Store Owne','title'=>'New to e-commerce','description'=>''],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2591738/','name'=>'','title'=>'','description'=>''],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2591738/','name'=>'','title'=>'','description'=>''],
            ['image'=>'','link'=>'https://www.capterra.com/p/209802/Debutify/reviews/2591738/','name'=>'','title'=>'','description'=>''],
           ] as $item)
            <div class='row'>
                <div class='col-lg-6'>

                </div>
            </div>
            @endforeach
        </div> --}}


        <h1 class='text-center mt-5 display-4'>
            Join Thousands Of <span class='debutify-underline-lg'>Brand Owners</span>  <br class='d-none d-lg-block'>
             Using Debutify
        </h1>
        <p class='mt-4 mb-5 text-center lead'>
            Launch a wildly successful store today. <br class='d-none d-lg-block'>
            Try free for 14 days — no credit card required.
        </p>
        <x-landing.cta class='d-flex justify-content-center' widget='0' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

{{-- Focus On Your Brand --}}
<section id='debutify-succeed' class='debutify-section'>
    <div class='container text-center'>
        <img  class='lazyload img-fluid succeed-img' width='534' data-src="/images/landing/cycle-succeed-block.svg"  alt="block">
        <div class='card shadow-sm'>
            <div class='card-body'>
                <div class='d-block mx-auto' style="max-width:580px">
                    <div class='responsive-container-4by3'>
                        <img  class='lazyload img-fluid my-3' data-src="/images/landing/landing_succeed.svg?v={{config('image_version.version')}}"   alt="succed image">
                    </div>
                </div>

                <h1 class='my-4 display-4'>
                    Focus On Your <span class='debutify-underline-sm'>Brand</span>, <br class='d-none d-lg-block'>
                    Not Your Theme
                </h1>

                <div class='row justify-content-center'>
                    <div class='col-lg-8'>
                        <p class='lead'>
                            Customizing your theme can be a nightmare. With Debutify, you'll never struggle with bugs or custom code again. Our Client
                            Success team is available to help 24/7— on live chat, by email  or on the phone. Your business is our top priority.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Doesn’t Stop There --}}
<section class='debutify-section'>
    <div class='container'>
        <div class='text-center'>
            <h1 class='display-4'>But It <span class='debutify-underline-lg'>Doesn’t Stop</span> There...</h1>
            <p class='my-5 lead'>
                Almost every month, our team of talented developers releases <br class='d-lg-block d-none'>
                new updates with one focus: increasing your conversion rates!
            </p>
            <h3 class='mb-5'>
                Here’s Some Of The Good Stuff Already  <br class='d-lg-block d-none'>
                Lined Up In The Pipeline For You
            </h3>
        </div>

        <x-landing.updates/>
    </div>
</section>


@endsection
