@extends('layouts.landing')

@section('title',"Debutify - World's Smartest Shopify Theme. Free 14-day Trial")
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')
@section('content')

@php
// This is only a mock data that should be taken from database and follow convention. Should be fixed soon
$addons = [
['link'=>'bjnHoBV8SCk','title'=>'Add-to-cart animation','shopify_app_cost'=>'39.48','conversion_rate'=>'0.12'],
['link'=>'1Eif6LLnnqg','title'=>'Cart countdown','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'RvJe5-uUWEo','title'=>'Cart discount','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'5UetdWCAUGA','title'=>'Cart goal','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'WZqVs5D0KzA','title'=>'Chat box','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'P8GwQ_rN8XI','title'=>'Collection add-to-cart','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'LH_Xzwx-Vfg','title'=>'Color swatches','shopify_app_cost'=>'11.88','conversion_rate'=>'0.07'],
['link'=>'gpmxPLbauw8','title'=>'Cookie box','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'rgtWh4RQWTw','title'=>'Delivery time','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'JproinpFJuU','title'=>'Discount Saved','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'lmhsHB5lHN8','title'=>'F.A.Q page','shopify_app_cost'=>'23.88','conversion_rate'=>'0.07'],
['link'=>'0y-TmTS2ryM','title'=>'Inventory Quantity','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'zfHvGKgHecU','title'=>'Linked options','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'V1TYD-Z6OTg','title'=>'Live view','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'b4OtktdtatU','title'=>'Mega menu','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'xRhq0EvBqVg','title'=>'Newsletter pop-up','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'2SxUeeR4_5M','title'=>'Pricing table','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'N0vh9pcnkag','title'=>'Product tabs','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'h7t1QYObQXc','title'=>'Product video','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'VkaRpFJTNEw','title'=>'Quantity break','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'3AXJj7UOr60','title'=>'Quick view','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'6YeuNEQWh8c','title'=>'Sales countdown','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'Ud_YvHUAhYE','title'=>'Sales pop','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'sGZhpPAe2Yc','title'=>'Shop protect','shopify_app_cost'=>'47.88','conversion_rate'=>'0.39'],
['link'=>'TJhHJEwV9jg','title'=>'Skip cart','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'fQmYha5aCFo','title'=>'Smart search','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'Y6qmf5hEuSU','title'=>'Sticky add-to-cart','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'Wjwv5G9Y8vk','title'=>'Trust badge','shopify_app_cost'=>'59.88','conversion_rate'=>'0.74'],
['link'=>'PlcT73BM1wk','title'=>'Upsell bundles','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
['link'=>'G_UuhJeRzqs','title'=>'Upsell pop-up','shopify_app_cost'=>'17.88','conversion_rate'=>'0.03'],
['link'=>'NL2zfVoR290','title'=>'Wish list','shopify_app_cost'=>'35.88','conversion_rate'=>'0.15'],
];    
@endphp

@section('announcement')
{{-- <div class="bg-dark">
    <div class="container text-white text-center p-2 font-weight-bolder">
        Debutify is the
        <a href="javascript:void(0)" class="text-white" data-toggle="modal" data-target="#downloadModal">
            <u> Best High-Converting Shopify theme of {{ now()->year }}!</u>
        </a>
    </div>
</div> --}}
@endsection

{{-- Above The Fold Section --}}
<section class='debutify-section pt-5'>
    <div class='container'>
        
        <div class='row align-items-center'>    
            <div class='col-lg-6'>
                <div class='text-center text-lg-left'>
                    <h1 class='debutify-underline'>Get The Highest-Converting FREE Shopify Theme For Aspiring Millionaires </h1>
                </div>
                <div id='block-copy' class='my-5 d-block d-lg-none'></div>
                <p class='my-4'>
                    Tired of making dropshipping work - or just starting out? You could join the ranks of successful 
                    dropshippers working a few hours a day, making thousands of dollars a month... Debutify, the best 
                    free Shopify theme, will help you get there.
                </p>
                <x-landing.cta  download='btn-primary' demo='btn-outline-secondary' cta='X'/>
            </div>
            <div class='col-lg-6'>
                <div id='block-origin' class='d-none d-lg-block'>
                    <div class='position-relative'>
                        
                        <img class='lazyload d-none d-md-block w-100 prop prop-pulse position-absolute' style="top:-45%;left:10%;animation-delay: 1s;"  data-src="/images/landing/props-above-fold-secondary.svg" >
                        <img class='lazyload d-none d-md-block w-100 prop prop-pulse position-absolute' style="top:-45%;left:10%;"  data-src="/images/landing/props-above-fold-primary.svg" >
                        <img class='lazyload position-absolute prop prop-left' style="top:-35%; left:50%;" data-src="/images/landing/props-dots-light.svg">
                        <img class='lazyload position-absolute prop prop-right' style="bottom:-35%; left:25%;" data-src="/images/landing/props-dots-light.svg">
                        
                        <div class='rounded overflow-hidden debutify-dropshadow  '>
                            <script src="https://fast.wistia.com/embed/medias/eppg1iegd7.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_eppg1iegd7 videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/eppg1iegd7/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='row mt-4'>
            
            @foreach ([
            ['icon'=>'puzzle','description'=>"28 conversion hack <span class='text-nowrap'>Add-Ons</span> to get more sales"],
            ['icon'=>'mobile','description'=>"Fast and <span class='text-nowrap'>mobile-optimized</span> out of the box"],
            ['icon'=>'stepbystep','description'=>'Step-by-step courses to build a 7-figure store']
            ] as $item)
            
            <div class='col-lg-4 mb-3'>
                <div class='card h-100 shadow-sm px-lg-1'>
                    <div class="card-body">        
                        <div class="d-flex align-items-center justify-content-center"> 
                            <img class='mr-4 lazyload' data-src='images/landing/icon-{{$item['icon']}}.svg' width="70px" height="70px" alt='{{$item['icon']}}' >
                            <div>
                                {!! $item['description'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div> 
    </div>
</section>

{{--  Featured Section --}}
<section>
    <div class='container'>
        <h2 class='text-center mb-4'> Featured On </h2>
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

{{-- Entrepreneurs Section--}}
<section class='debutify-section'>
    <div class='container text-center'>
        <h1 class='mb-5'>
            Trusted by Leading <br class='d-none d-md-block'> 
            <span class='text-nowrap'> E-Commerce</span> Entrepreneurs
        </h1>
        
        <div class='row'>
            @foreach ([
            ['image'=>'marc','title'=>'Marc Chapon, 7-Figure Entrepreneur & Youtuber','qoute'=>'...everything you need to succeed'],
            ['image'=>'sharif','title'=>'Sharif Mohsin, 7-figure Entrepreneur & Youtuber','qoute'=>'...fantastic, ultra-high-converting free theme'],
            ['image'=>'kamil','title'=>'Kamil Shattar "the ecom king" 7-figure Entrepreneur & Youtuber','qoute'=>"...generated over $7M in 2-3 months"],
            ['image'=>'james','title'=>'James Beattie, ceo, ecom insiders 7-figure entrepreneur','qoute'=>'...about 5% conversion rate on a new store'],
            ] as $key => $item)
            
            <div class='col-sm-6 col-lg-3 mb-3'>
                <div class='card shadow prop prop-hover' style="animation-delay:  {{$key}}s">
                    <div class='card-body'>
                        <img class="lazyload img-thumbnail rounded-circle" data-src="/images/landing/entrep-{{$item['image']}}.png" alt="{{$item['image']}}">
                        <p class="my-3">"{{$item['qoute']}}"</p>
                        <p><small>- {{$item['title']}}</small></p>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>
    </div>
</section>

<x-landing.dash/>

{{-- Tired Section--}}
<section class='debutify-section'>
    <div class='container'>
        <div class='row align-items-center my-3'>
            <div class='col-lg-6'>
                <h2> 
                    Are You Tired of Getting 0 Sales? Tired Of Your <span class='text-nowrap'>9-to-5</span> 
                    Job? Or Just Starting Out, And Don't Know Which Theme to Use?
                </h2>
                <p class='my-5'>Discover how you could build a thriving e-com business (and live a luxurious life) with no marketing knowledge, no Shopify knowledge, no programming knowledge and without breaking the bank… with a copy-paste "blueprint for success"</p>
            </div>
            <div class='col-lg-6 d-flex justify-content-center'>
                <div class='position-relative' style="max-width: 450px;width:450px;">
                    <img style='top:-30px; left:20px;' class="lazyload position-absolute prop prop-left-down"  data-src="/images/landing/props-dots-gray.svg">
                    <img style='bottom:-30px; right:20px;' class="lazyload position-absolute prop prop-right-up" data-src="/images/landing/props-dots-gray.svg" >
                    <div class="position-relative rounded overflow-hidden my-4   ">
                        <script src="https://fast.wistia.com/embed/medias/vkrs1syot8.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_vkrs1syot8 videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/vkrs1syot8/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>
                    </div>
                </div>
            </div>
        </div>
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

{{-- Dropshipping Section --}}
<section class='position-relative bg-primary text-white debutify-section pb-0'>
    <div class='position-relative container py-3' style="z-index:1">
        
        <img class="lazyload position-absolute prop prop-fade-right"  style="top:30px;right:30px;" data-src="/images/landing/props-arrow.svg">
        
        <div class='position-relative'>
            <div class='text-center'>
                <h1 class='text-white'>
                    Only For Shopify Dropshipping, <span class='text-nowrap'> Print-On-Demand</span> <br class='d-none d-lg-block'> 
                    & Brand Stores That Want Sales, Now 
                </h1>
                <p class='mt-3 mb-4  lead'>See How Debutify Can Buff Your Store — Live Demo Store</p>
                <p class='lead'>Launch your e-commerce empire today. Download the Debutify theme for free. <br class='d-none d-md-block'>
                    Install & set up on your store in 1 click. No experience or coding skills needed.
                </p>
            </div>
            
            <x-landing.cta id='2' class='mx-auto my-5' download='btn-secondary' demo='btn-outline-light' cta='X'/>
            
            <div class="card-columns card-columns-2 card-columns-md-3 ">
                @foreach (
                ['cart','featured','testimonials','blog',
                'products','related',
                'welcome','selection','others'
                ] as $item)
                <div class='card border-0 my-2' style="background-color:transparent; ">
                    <div class='card-body p-0'>
                        <img class='lazyload w-100 rounded' data-src="/images/landing/dropshipping-{{$item}}.png" alt="{{$item}}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div  style="position: absolute;bottom:0px; left:0px;" class='d-none d-lg-block'>
        <img class="lazyload prop prop-left"  data-src="/images/landing/props-dots-light.svg" width="200">
        <img class="lazyload prop prop-left" data-src="/images/landing/props-dots-light.svg" width="200">
        <img class="lazyload prop prop-left"  data-src="/images/landing/props-dots-light.svg" width="200">
    </div>
    
    <img class='w-100' style="z-index:2;position: absolute;bottom:-1px; min-width:600px" src="/images/landing/blade1.svg">
</section>

{{-- Addon Section --}}
<section class='position-relative '>
    <div class='container debutify-section'>
        <div class='text-center'>
            <h1> 
                Convert Traffic Into Buyers <br class='d-none d-md-block'> With Battle-Tested Sales Hacks 
            </h1>
            <p class='my-5 lead pb-3'>
                Buff your store with {{count($addons)}}+ tested e-commerce sales boosters. <br class='d-none d-md-block'>
                Get more orders, increase your conversion rate and make more cash.
            </p>    
        </div>
        
        <x-landing.addons :addons="$addons" showAll='0'/>
        
        <p class='lead my-4 text-center'>  Create your dropshipping empire. <span class='font-weight-bold'>Say YES</span> to the life of your dreams. <br class='d-none d-md-block'>
            Why procrastinate -- Download the Debutify template <span class='font-weight-bold'>FREE</span> and launch in 1 click. 
        </p>  
        
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
    
    <img class='w-100' style="z-index:2;position: relative;bottom:-1px; min-width:600px" src="/images/landing/blade2.svg">
</section> 

{{-- No Coding Section --}}
<section class='position-relative bg-primary text-white ' >         
    
    <div class='position-relative container debutify-section pt-0'> 
        <div class='position-relative'>
            <div class='text-center'>
                <h1 class='text-white'>No Coding, Website design <br class='d-none d-md-block'/> or Shopify Experience Needed </h1>
                <p class='my-5 lead'>
                    Debutify makes things simple. Launch your store in a few clicks, <br class='d-none d-lg-block'/>
                    with all the features you need to succeed already built-in.
                </p>
            </div>
            
            <div class='row my-4 justify-content-center'>
                @foreach (
                ['Install theme in 1 click',
                'Bulk-install Add-Ons in 1 click',
                'Automatic updating',
                'Integrate with existing plugins in 1 click',
                '100% Optimized for Dropshipping',
                'Rely on 24/7 customer support to solve all issues and answer all your questions'
                ] as $item)
                
                <div class='col-lg-5 my-2'>
                    <div class='d-flex '>
                        <img class='lazyload mr-3' data-src="images/landing/cta-check.svg" alt="cta check" width="27px" height="27px"> 
                        <p class='font-weight-bold lead'> {{$item}}</p>
                    </div>
                </div>
                @endforeach   
            </div>
            
            <blockquote class='debutify-blockquote'>
                <p class='text-center mt-5 lead '>
                    Use the visual editor to customize your store as much as you want, or go with pre-configured <br class='d-none d-lg-block'/>
                    settings. Either way, you'll be up and running with the perfect look and all Add-Ons in minutes.
                </p>
            </blockquote>
            
        </div>
        
    </div>
    
    <img class="lazyload prop prop-fade-right position-absolute"  style="top:0px;right:300px;z-index:+2;" width='700px' data-src="/images/landing/props-arrow.svg">
</section>

{{-- Customer Support Section --}}
<section class='position-relative'>
    <img class='w-100' style="z-index:1;position: relative;top:-1px; min-width:600px" src="/images/landing/blade3.svg">
    
    <div class='py-5 container position-relative'>
        
        <img class='lazyload w-100 prop prop-pulse d-none d-lg-block' data-src="/images/landing/landing-large-hexagon.svg"   style="max-width:1200px; position:absolute;  top:-250px; left: -10px;"> 
        
        <div class='cs-section'>
            <div class='text-center'>
                <h1 >24/7 Customer Support Team <br class='d-none d-lg-block'/> Available At Your Disposal</h1>
                <p> Have an issue? Need a code change? Our support team is available around the clock to help you.<br class='d-none d-lg-block'/>
                    Have all your questions answered by one of 10 dedicated experts. Get professional code change <br class='d-none d-lg-block'/>
                    done for free. 
                </p>
            </div>
            
            <div class='row'>
                @foreach ([
                ['name'=>'Jun'],
                ['name'=>'Mirza'],
                ['name'=>'Adil'],
                ['name'=>'Abhishek'],
                ] as $index => $item)
                <div class='col-12 col-md-6 col-lg-3 mb-3 '>
                    <div class="card shadow-sm  prop prop-hover cs-{{$item['name']}}" style="animation-delay:{{$index}}s">
                        <div class='card-body d-flex'>
                            <img data-src="images/landing/cs-{{$item['name']}}.png" alt="{{$item['name']}}" class=" mr-3 rounded-circle lazyload" width='84px' height='84px' >
                            <div>
                                <p class='lead text-dark font-weight-light m-0' >{{$item['name']}}</p> 
                                <div class='small mb-2'> Customer Support specialist</div>
                                <div class='text-success d-flex align-content-center flex-wrap'> 
                                    <i class="spinner-grow spinner-grow-sm mr-1"></i> 
                                    <small> Online 24/7 </small>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Liel Levin Section --}}
<section class='position-relative'>
    <div class="container debutify-section">
        
        <div class='row align-items-center'>
            <div class='col-md-6 col-lg-4'>
                
                <div class='position-relative'>
                    <img style="position: absolute; top:-20px; left:30px" class='lazyload prop prop-left-down' data-src="images/landing/props-dots-gray.svg" alt="">
                    <img  style="position: absolute; bottom:-20px; right:30px"  class='lazyload prop prop-right-up' data-src="images/landing/props-dots-gray.svg" alt="">
                    <img style="position: relative;" class='py-4 w-100 lazyload rounded' data-src="images/landing/landing-stats-month.png" alt="say yes">
                </div>
            </div>
            
            <div class='col-md-6 col-lg-8'>
                <h1 class='mb-0'> Liel Levin </h1>
                <p class='mb-3'>
                    <span class='text-yellow mr-2'>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                        <i class='fas fa-star'></i>
                    </span>
                    5.0/5.00
                </p>
                
                <p class='lead text-black mt-4'>
                    Amazing theme, I love it because ; 1. it looks clean 2. A lot of integrated features like sticky ATC,
                    upsell bundles, product tabs etc all in one theme, makes it much easier than having to download all
                    the apps in seperate 3. Amazing customer support! any question you have and any edit you want to do
                    they help you with it and even do it for you :)
                </p>
            </div>
        </div> 
    </div>
    
    <img class='w-100' style="z-index:2;position: relative;bottom:-1px; min-width:600px" src="/images/landing/blade4.svg">
    
</section>


{{-- Customer Reviews Section --}}
<section class='bg-light'>
    <div class='container debutify-section'>
        
        <div class='text-center'>
            <h1> What our {{$nbShops}}+ customers say </h1>
            <p class='lead'>We're the World's #1 Free Shopify Theme</p>
        </div>
        <div class='test'>
            <x-landing.reviews btn='secondary'/>
        </div>
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash color='light'/>

{{-- Addon #1 Section--}}
<section class='position-relative bg-light '>
    <div class='container debutify-section pb-0'>
        
        <x-landing.addon 
        title='Sticky Add to Cart' 
        description='Conversion-boosting Add-On #1'
        color='primary'
        increase='11.8'
        price='119.88'
        compareLink='sticky-add-to-cart-booster'
        compareName='Sticky Add to cart + popup'
        :checkList="[
        'Make it easy for customers to buy with sticky Buy button', 
        'Get more sales by increasing urgency', 
        'Fully customizable: change mobile display, customize countdown, quantity, reviews & more', 
        'Easy 1-click install & 1-click activation']"
        />
        
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>    
    
    <img class='w-100' style="z-index:2;position: relative;bottom:-1px; min-width:600px" src="/images/landing/blade2.svg">
</section>

{{-- Integration Section--}}
<section class='position-relative debutify-section pt-0 bg-primary'>
    <div class='container text-center'>
        
        <h1 class="text-white mb-5">
            Easy Integration <br class="d-none d-md-block"> With Leading Shopify Apps
        </h1>
        
        <div class='position-relative mb-5'>
            
            <img  style="bottom:-60px;right:-10px; max-width:500px"  class='position-absolute lazyload prop prop-rotate' data-src="images/landing/props-hexagon.svg" alt="">
            <img  style="bottom:-100px;right:0px;" class='position-absolute lazyload prop prop-swing'  data-src="images/landing/props-design1.svg" alt="">
            
            <div class='position-relative bg-white rounded mx-auto p-3 p-md-5' style=" max-width: 920px; ">  
                <h4 class='pb-4'>
                    Debutify works perfectly with all the popular apps you need to <br class='d-none d-lg-block'>
                    run your business.
                </h4>
                
                <div class='row'>
                    @foreach ([
                    ['image'=>'oberlo','link'=>'https://www.oberlo.com/'],
                    ['image'=>'smsbump','link'=>'https://smsbump.com/'],
                    ['image'=>'klaviyo','link'=>'https://www.klaviyo.com/'],
                    ['image'=>'hubspot','link'=>'https://www.hubspot.com/'],
                    [],
                    [],
                    ['image'=>'printful','link'=>'https://www.printful.com/'],
                    ['image'=>'spocket','link'=>'https://www.spocket.co/'],
                    [],
                    [],
                    ['image'=>'sendinblue','link'=>'https://www.sendinblue.com/'],
                    ['image'=>'shipstation','link'=>'https://www.shipstation.com/'],
                    [],
                    [],
                    ['image'=>'doofinder','link'=>'https://www.doofinder.com/'],
                    ['image'=>'quickbooks','link'=>'https://quickbooks.intuit.com/'],
                    ] as $item)
                    <div class='col-6 col-lg-3 '>
                        @if ($item)
                        
                        <a href="{{$item['link']}}" target="_blank">
                            <img data-src="images/new/{{$item['image']}}.png" alt="{{$item['image']}}" class="w-100 lazyload mb-4" />
                        </a>
                        
                        @endif
                    </div>                    
                    @endforeach
                </div>
                
                <div class='col-lg-6  '>
                    <img class='w-100 rounded-lg lazyload shopify-integration' data-src="images/landing/landing-integration.png" alt="Integration">
                </div>
            </div>
            
        </div>
    </div>
</section>

<x-landing.dash color='primary'/>

{{-- Addon #2 Section--}}
<section class='bg-primary text-white'>
    <div class='container debutify-section'>
        
        <x-landing.addon 
        title='Newsletter Pop Up' 
        description='Conversion-boosting Add-On #2'
        color='secondary'
        price='90'
        increase='30'
        compareName='Smart Popup'
        compareLink='eggflow-marketing-automation'
        :checkList="[
        'Lower cart abandonment & bounce rates', 
        'Get more sales by turning exits into purchases', 
        'Sync contacts with Klavyio & Mailchimp', 
        'Fully customizable: text, style, image, trigger, animation, coupon code & more',
        'Easy 1-click install & 1-click activation'
        ]"
        />  
        
    </div>
</section>

<x-landing.dash color='primary'/>

{{-- Speed Test Section--}}
<section class='position-relative bg-primary '>
    <div class='container debutify-section'>
        <div class='text-center text-white '>
            <h1 class='text-white'>Explode Your Profits in 1 Click</h1>
            <p class='lead my-4'>
                Debutify is the highest-converting free Shopify theme - with best-in-class load time, <br class="d-none d-md-block">
                mobile responsiveness and conversion-boosting Add-Ons. <br class="d-none d-md-block">
                <u class='font-weight-bold'>Get into the heart of business in 1 click</u>, with everything you need to succeed.
            </p>
        </div>
        <div class="row justify-content-center align-items-center mt-lg-5">
            <div class="col-md-6 col-lg-7 text-white">
                <h1 class='text-white'>Make Your Store Ready <br class="d-none d-md-block"> For Millions of Mobile Shoppers</h1>
                <p class='lead mt-4'>Make the most out of every visitor on your website. Debutify is one of the fastest-loading themes available, at 1.35s store load time out-of-the-box. With Debutify, your store is ready for thousands of orders from mobile devices.</p>
            </div>
            <div class="col-md-6 col-lg-5">
                
                <div class='position-relative my-lg-5'>
                    <img  style="top:-100px;right:-40px;"   class='position-absolute lazyload prop prop-swing' data-src="images/landing/props-design1.svg" alt="haxagon">
                    <img  style="top:-70px;right:0px;max-width:480px" class='position-absolute  lazyload prop prop-rotate' data-src="images/landing/props-hexagon.svg" alt="haxagon">
                    
                    <div class='position-relative card text-center debutify-dropshadow-sm py-3 rounded-lg mx-auto' style="z-index:+1;max-width:348px;">
                        <div class='card-body' >
                            <h3>GTmetix Live Test</h3>
                            <small>Built with Debutify</small>
                            <img class="lazyload w-100" data-src="images/landing/landing-gtmetrix.png">
                            
                            <div class='py-2'>
                                <small>
                                    <a target="_blank" href="https://dbtfy-test-5.myshopify.com/">
                                        <u>dbtfy-test-5.myshopify.com</u>
                                    </a>
                                </small><br>
                                <a target="_blank" href="https://gtmetrix.com/reports/dbtfy-test-5.myshopify.com/dOBg9wmQ/">
                                    <u>View GTmetrix report</u>
                                </a>
                            </div>
                            <button class='btn btn-sm btn-primary'>Speed Up My Store!</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    
    <img class='w-100' style="position: absolute;bottom:-1px; min-width:600px" src="/images/landing/blade5.svg">
</section>


{{-- Addon #3 Section--}}
<section class='position-relative debutify-section pb-0'>
    <div class='container'>
        
        <x-landing.addon 
        title='Product Tabs' 
        description='Conversion-boosting Add-On #3'
        color='primary'
        price='59.88'
        increase='75'
        compareName='Custom Product Accordion Tabs'
        compareLink='custom-product-accordion-tabs'
        :checkList="[
        'Easily create & organize rich content for customers', 
        'Improve customer experience to get more sales', 
        'Fully customizable: HTML content, tab name, icons, images, reviews, layout, visibility per product & more', 
        'Easy 1-click install & 1-click activation']
        "
        /> 
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
    
    <img class='w-100' style="position: relative;bottom:-1px; min-width:600px" src="/images/landing/blade6.svg">
</section>

{{-- Languages Section--}}
<section class='position-relative bg-light'>
    <div class='debutify-section pt-0 container'>
        
        @php
        $languages = [
        'Bulgarian','Chinese','Croatian','Czech','Danish','Dutch',
        'English','Finnish','French','German','Greek','Hindi',
        'Hungarian','Indonesia','Italian','Japanese','Korean','Lithuanian',
        'Malay','Norwegian','Polish','Portuguese','Romanian','Russian',
        'Slovak','Slovenian','Spanish','Swedish','Thai','Turkish'
        ]
        @endphp
        
        <div class='text-center'>
            <h1> 
                Sell Anywhere in The World <br class='d-none d-lg-block'> 
                With 32+ Translated Languages
            </h1>
            <p class='my-5 lead'> 
                Scale your e-commerce empire globally. Debutify is translated into 32+ languages so you can make  <br class='d-none d-lg-block'>
                money selling products to the entire world.
            </p>
        </div>
        
        <div class='row my-5'>
            @foreach ($languages as $item)
            <div class='col-6 col-sm-4 col-md-3 col-lg-2 d-md-block' style="display:none">
                <div class='card my-2 '>
                    <div class='card-body py-3 overflow-hidden px-3'>
                        <div class='d-flex align-items-center'>
                            
                            <img class='mr-2 lazyload ' data-src="images/landing/language-{{$item}}.png" width="33px"  alt="">
                            {{$item}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash color='light'/>

{{-- Addon #4 Section--}}
<section class='bg-light  debutify-section'>
    <div class='container'>
        
        
        <x-landing.addon 
        title='Trust Badges' 
        description='Conversion-boosting Add-On #4'
        color='primary'
        price='90'
        increase='137'
        compareName='TrustBadges'
        compareLink='trust-by-kamozi'
        :checkList="[
        'Earn customer&#39;s trust and lower resistance to sale', 
        'Increase conversions and lower cart abandonment', 
        'Fully customizable: change appearance, location', 
        'Easy 1-click install & 1-click activation']"
        />
        
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>


<x-landing.dash color='light'/>

{{-- Sleep Section--}}
<section class='position-relative bg-light'>
    <div class='container debutify-section pb-0'>
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1>SAY YES <br class="d-none d-md-block">to Making Money<br class="d-none d-md-block"> While You Sleep!</h1>
                <p class='lead my-4'>Use Debutify to launch your dropshipping empire. Work anywhere, at any time you want, as much or as little as you want.</p>
                <p class='lead'>A world of leisure, money and travel is awaiting. Download Debutify for free, today.</p>
                <x-landing.cta  download='btn-primary' demo='btn-outline-secondary' cta='X'/>
            </div>
            
            <div class="col-md-6 d-flex justify-content-center ">
                <div class='position-relative'>
                    <img class="position-absolute lazyload prop prop-left-down" style="top:-40px; left:-30px;  " data-src="/images/landing/props-dots-gray.svg">
                    
                    <div class=' '>
                        <img class="position-relative lazyload rounded w-100" data-src="images/landing/landing-yes.png" alt="Ricky Hayes" style="max-width: 450px" >
                    </div>
                    <div class='  position-absolute ' style="bottom:-10%;left:-10%; ">
                        <img class="lazyload rounded  shadow-sm" style=" max-width:200px"  data-src="/images/landing/landing-yes-sub.png">
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    
    <img class='w-100' style="position: relative;bottom:-1px; min-width:600px" src="/images/landing/blade7.svg">
    
</section>

{{-- Addon #5 Section--}}
<section>
    <div class='debutify-section pt-0 container'>
        <x-landing.addon 
        title='Sales Pop' 
        description='Conversion-boosting Add-On #5'
        color='primary'
        price='348'
        increase='15'
        compareName='Sales Pop ‑ Popup Notification'
        compareLink='shoppop'
        :checkList="
        ['Increase trust with strong social proof', 
        'Make your product look like it&#39;s in-demand', 
        'Fully customizable: style, frequency, text, animation, icons, products & more', 
        'Easy 1-click install & 1-click activation']"
        />
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash/>

{{-- Blueprint Section--}}
<section>
    <div class='container debutify-section position-relative'>
        
        <img class='lazyload w-100 prop prop-pulse position-absolute' data-src="/images/landing/landing-large-hexagon.svg"   style="  top:50px; "> 
        
        <div class='position-relative mb-5'>
            <div class='text-center'>
                <h1> 
                    Explode Your Sales With The <span class='text-nowrap'>All-in-One</span> <br class='d-none d-md-block'/>
                    "Blueprint For Success" 
                </h1>
                <p class='lead my-5'>
                    Debutify can help you grow a passive income and complete financial independence, so <br class='d-none d-lg-block'/> 
                    you can live your live how you want. Imagine having a stable source of income that <br class='d-none d-lg-block'/>  
                    makes you truckloads of money while you sleep. Debutify can help you get there.
                </p>
            </div>
            
            <img class='mx-auto d-block img-fluid mb-3' src="images/landing/landing-blueprint.png" alt="landing blueprint">
            
            <div class='row'>
                
                @foreach ([
                ['label'=>'Fast & Responsive','description'=>'Blazing-Fast On Desktop & Mobile','class'=>'blueprint-responsive','icon'=>'responsive'],
                ['label'=>'Sleek Design','description'=>'Get (Significantly) More Sales','class'=>'blueprint-design','icon'=>'design'],
                ['label'=>'High-converting','description'=>'Turn Traffic Into Buyers','class'=>'blueprint-convertion','icon'=>'convertion'],
                ['label'=>'1-Click Setup','description'=>'No Technical Knowledge Needed','class'=>'blueprint-setup','icon'=>'setup'],
                ['label'=>'24/7 Support','description'=>'Live Support Always Available','class'=>'blueprint-support','icon'=>'support'],
                ] as $index => $item)
                
                <div class='col-md-6 col-lg '>
                    <div class='card shadow-sm  prop prop-hover mt-2 {{$item['class']}}' style="animation-delay:{{$index}}s">
                        <div class='card-body'>
                            <div class='d-flex align-items-center'>
                                <div>
                                    <img class='mr-3 lazyload' data-src="images/landing/icon-{{$item['icon']??''}}.svg" alt="" width="60px" >
                                </div>
                                <div>
                                    <h4 class='m-0 text-dark font-weight-light'>{{$item['label']}}</h4>
                                    <p class='m-0'>{{$item['description']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
        
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash/>

{{-- Addon #6 Section--}}
<section class='position-relative'>
    <div class='container debutify-section'>
        <x-landing.addon 
        title='Cart Countdown' 
        description='Conversion-boosting Add-On #6'
        color='primary'
        price='49'
        increase='226'
        compareName='Timerly by Kamozi'
        compareLink='timerly'
        :checkList="
        ['Increase urgency to make customers buy now', 
        'Lower cart abandonment rate', 
        'Fully customizable: set message text, message icon, timer, translation and more', 
        'Easy 1-click install & 1-click activation']"
        />
        <x-landing.cta class='mx-auto'  download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
    
    <img class='w-100' style="position: relative;bottom:-1px; min-width:600px" src="/images/landing/blade8.svg">
</section>

{{-- Discover Section--}}
<section class='bg-primary text-white'>
    <div class='container debutify-section'>
        <div class="row my-4 align-items-center">
            <div class="col-md-6">
                <h1 class='text-white'>Discover $1,000,000 Products in 3 Clicks With Winning Product Research Tool</h1>
                <p class='my-4 lead'>Find winning products in unsaturated niches with Debutify's Winning Product Research Tool. New products, freshly updated every week and ready for you to make real bucks. All 1 click away. Debutify also bundles the $1,000,000 Product Research Course to help you find true product gold mines.</p>
            </div>
            <div class="col-md-6">
                
                <div class='position-relative'>
                    <img style="top:-30px; left:20px" class='lazyload position-absolute prop prop-left-down' data-src="images/landing/props-dots-light.svg" alt="">
                    <img style="bottom:-30px; right:20px" class='lazyload position-absolute  prop prop-right-up' data-src="images/landing/props-dots-light.svg" alt="">
                    <div >
                        <img style='position: relative; ' class="lazyload w-100" data-src="images/landing/landing-discover.png" alt="discover">
                    </div>
                </div>
                
            </div>
        </div>
        <x-landing.cta class='mx-auto' id='2' download='btn-secondary' demo='btn-outline-light' cta='X'/>
    </div>
</section>

<x-landing.dash color='primary'/>

{{-- Exclusive Section--}}
<section class='bg-primary'>
    <div class='container debutify-section'>
        
        <div class="text-center text-white"> 
            <h1 class='text-white'>
                Exclusive Industry Success Secrets From <br class='d-none d-lg-block'> 
                E-Commerce "Insiders" Entrepreneur
            </h1>
            <p class='mt-4 mb-5 lead'>
                Cut your way from 0 to $1M business. With Debutify, you get the secret knowledge and sales tactics of 
                7-figure entrepreneurs. All bundled in 4 exclusive courses by Ricky Hayes, e-commerce business owner with
                a track record of over $8,000,000 in sales, whose students are now 7-figure entrepreneurs themselves.
            </p>
        </div>
        
        <div class="row">
            @foreach ([
            ['label'=>'Exclusive Ecom <br> Lifestyle University','description'=>'A-to-Z course on everything from Shopify setup to picking the right products and running social media ads that convert to big bucks.','image'=>'ecom'],
            ['label'=>'$0-$100,000 a day <br> Shopify store setup training','description'=>"You'll learn the fundamental success strategies to setup your store for $100,000 a day in sales.",'image'=>'shopify'],
            ['label'=>'$0-$10,000 a day <br> Facebook ads mastery','description'=>'Discover the exclusive secrets of successful Facebook ads turn your store into a gold mine.','image'=>'fbads'],
            ['label'=>'$0-$100,00 a day <br>  Google ads mastery','description'=>"You'll learn the step-by-step process of using Google Ads to 10x your business.",'image'=>'gads'],
            ['label'=>'$1,000,000 winning <br> product research masterclass','description'=>'Learn how and where to find unsaturated $1M products waiting for you to sell them and cash in.','image'=>'psearch'],
            ['label'=>'$0-$10,000 a day <br> Youtube ads mastery','description'=>'Learn how to use this little-known e-commerce weapon to bring loads of buyers to your store.','image'=>'ytads'],
            ] as $item)
            <div class='col-12 col-md-6 col-lg-4 mb-4'>
                <div class='card text-center h-100  '>
                    
                    <div class='card-body '>
                        <img data-src="images/landing/exclusive-{{$item['image']}}.png" alt="exclusive {{$item['image']}}" class="my-3 img-fluid rounded-circle lazyload" />
                        <h5><u><?=$item['label']?></u></h5>
                        <h2 class="mb-3"><b><del class="text-decoration-color-primary">$3000</del></b></h2>
                        <p class="badge badge-pill badge-secondary">Free With Debutify</p>
                        <p>
                            {{$item['description']}}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<x-landing.dash color='primary'/>

{{-- Master Section--}}
<section class='debutify-section bg-primary text-white'>
    <div class='container'>
        <div class="row mb-5">
            <div class="col-md-6 ">
                <p class="badge badge-pill badge-secondary px-5">Course Author</p>
                <h1 class='text-white mt-3 mb-4'>7-Figure E-Commerce & Dropshipping Master, Ricky Hayes</h1>
                <p class='lead'>
                    Ricky Hayes has generated over $8,000,000 in <span class='text-nowrap'>e-commerce</span> 
                    and dropshipping sales through his own stores and for his clients' businesses. 
                    He's worked in all niches, from skin care and beauty to pet stores.
                    Ricky has taught dozens of aspiring dropshippers like you who have achieved 
                    <span class='text-nowrap'>multi-million-dollar</span> success under his mentorship.
                </p>
            </div>
            
            <div class="col-md-5 offset-md-1 d-flex justify-content-center align-items-center">
                <div class='position-relative'>
                    <img class="position-absolute lazyload prop prop-down" style="top:-10%;right:-10%;  " data-src="/images/landing/props-dots-light.svg">
                    <img class="position-absolute lazyload prop prop-left" style="bottom:-10%;right:-10%;  " data-src="/images/landing/props-dots-light.svg">
                    <img class="position-absolute lazyload prop prop-up" style="bottom:10%; left:-10%; " data-src="/images/landing/props-dots-light.svg">
                    <div class=' '>
                        <img class="position-relative lazyload rounded" data-src="images/landing/landing-ricky.png" alt="Ricky Hayes" style="max-width: 360px" >
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            @foreach (['month','yesterday','today'] as $item)
            <div class='col-sm-12 col-md-4'>
                <img class="w-100 rounded lazyload" data-src="images/landing/landing-stats-{{$item}}.png" alt="{{$item}}">
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Addon #7 Section--}}
<section>
    <div class='container debutify-section'>
        <x-landing.addon 
        title='Upsell Bundles' 
        description='Conversion-boosting Add-On #7'
        color='primary'
        price='95.88'
        increase='27'
        compareName='Frequently Bought Together'
        compareLink='frequently-bought-together'
        :checkList="[
        'Cash in by increasing average order value', 
        'Recommend AI-powered bundles for highest AOV', 
        'Fully customizable: change position, style, create custom bundles to re-use & more', 
        'Easy 1-click install & 1-click activation'] "
        />
        <x-landing.cta class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash/>

{{-- Money Making Section --}}
<section>
    <div class='debutify-section container'>
        <div class="text-center">
            <h1>Turn Your Shopify Store <br class='d-none d-lg-block'/>Into a "Money-Making" Empire</h1>
            <p class='lead mt-4 mb-5'>
                If you want to live the entrepreneurial lifestyle… if you want to work wherever you want, <br class='d-none d-lg-block'>
                as little as you want, from anywhere around the world… Debutify can help you get there.  <br class='d-none d-lg-block'>
                Download Debutify free today, and set up in 1 click. 0 effort needed.  
            </p>
        </div>

        <div class='row'>
            @foreach ([
            ['image'=>'responsive','label'=>'Blazing-fast on mobile <br> (1.35s load time out of the box)'],
            ['image'=>'design','label'=>'Professional design and user <br> experience that converts'],
            ['image'=>'addons','label'=>'28 conversion Add-Ons <br> boost sales'],
            ['image'=>'customize','label'=>'Fully customizable,<br> easy to edit'],
            ['image'=>'setup','label'=>'1-click set-up, 1-click app install - <br> no technical knowledge needed'],
            ['image'=>'support','label'=>"24/7 customer & dev support.<br> we've always got your back"],
            ] as $item)
            <div class='col-sm-12 col-md-6 col-lg-4'>
                <div class='card text-center shadow-sm my-3'>
                    <div class='card-body'>
                        <img class='lazyload my-3' data-src="images/landing/icon-{{$item['image']}}.svg" width='75px' height="75px" alt="">
                        <p> {!!$item['label']!!}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <x-landing.cta class='mx-auto'  download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash/>

{{-- E-Commerce Enrepreneurs Section --}}
<section>
    <div class='debutify-section container text-center'>
        
        <h1> 
            The Secret Weapon of The Most Successful <br class='d-none d-lg-block'/>  
            <span class='text-nowrap'>E-Commerce</span> Entrepreneurs 
        </h1>
        <p class='pt-4 pb-5'>Debutify is a leading free Shopify theme, used by the biggest ecom entrepreneurs. If you’re not convinced <br class='d-none d-lg-block'/> 
            that Debutify is good for you, then listen why 7-figure dropshippers use it for their businesses:
        </p>
        
        <x-landing.dropshippers />
        
        <p class='lead my-5'>
            Take the shortcut to becoming a thriving entrepreneur. <br class='d-none d-md-block'/>
            Download Debutify for free. Get started in seconds.
        </p>
        <x-landing.cta class='mx-auto'  download='btn-primary' demo='btn-outline-secondary' cta='X'/>
        
    </div>
</section>

{{-- Funnel Section --}}
<section class='debutify-section  bg-light'>
    <div class='container'>
        <div class='row items-align-center'>
            <div class='col-lg-6 '>
                <p class='font-weight-bolder text-primary'> Real Cash + Easy Management </p>
                <h1 class='my-4'>Turn Simple Product Pages Into High-Converting Funnels</h1>
                <p class='my-4 lead'>Get the results of a ClickFunnels page AND the convenience of your Shopify store management — only with Debutify.</p>
                
                <div class='row my-5'>
                    @foreach ([
                    ['label'=>'$10,000,000','description'=>'Made by debutify users'],
                    ['label'=>'4.8/5.0','description'=>'Average user rating'],
                    ] as $item)
                    <div class='col-sm-6 my-2'>
                        <div class='card border-top-primary'>
                            <div class='card-body text-center py-3'>
                                <p class='lead font-weight-bolder text-black mb-1'> {{$item['label']}}</p>
                                <p class='m-0'> {{$item['description']}}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div> 
            </div>
            <div class='col-lg-6 '>
                <img class="w-100 lazyload" data-src="images/landing/landing-funnel.svg" alt="converting funnels">
            </div>
        </div>
        <x-landing.cta  class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash color='light'/>

{{-- Premium Section --}}
<section class='bg-light debutify-section'>
    <div class='container text-center'>
        
        <h1 class='mb-5'>
            Save Up To $2,000 a Year on Expensive <br class='d-none d-lg-block'> 
            Apps, Without Losing Premium Features
        </h1>
        
        <div class='bg-white p-3 rounded mb-5'>
            <div class='rounded overflow-hidden'>
                <table class="table table-striped table-bordered">
                    
                    <thead class='bg-primary text-white lead'>
                        <tr>
                            @foreach ([
                            ['label'=>'Features','width'=>'25%'],
                            ['label'=>'Debutify','width'=>'25%'],
                            ['label'=>'Shopify App Cost','width'=>'25%'],
                            ['label'=>'Conversion Rate Increase','width'=>'25%'],
                            ] as $item)
                            <th class='align-middle font-weight-bold' width="{{$item['width']}}" >
                                {{$item['label']}}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($addons as $item)
                        <tr >
                            <td class='bg-grey '>{{$item['title']}}</td>
                            <td> <i class='fas fa-check text-success h4'></i> </td>
                            <td class='font-weight-bolder'>  ${{$item['shopify_app_cost']}}/mo. </td>
                            <td class='font-weight-bolder'>  +{{$item['conversion_rate']}}%*</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    <tfoot class='bg-light lead'>
                        <tr>
                            <td class='align-middle'> 
                                <h3 class='font-weight-bold text-reset'>Total</h3>
                            </td>
                            <td class='align-middle'> 
                                <h3 class='m-0 font-weight-bold text-reset'>$23.5/mo.</h3> 
                                <p class='m-0 small'>$47/month billed monthly </p> 
                            </td>
                            <td class='align-middle'> 
                                <h3 class='m-0 font-weight-bold text-reset'>${{array_sum(array_column($addons,'shopify_app_cost'))}}/mo.</h3> 
                                <p class='m-0 small'> Standalone Cost  </p> 
                            </td>
                            <td class='align-middle'> 
                                <h3 class='m-0 font-weight-bold text-reset'>{{array_sum(array_column($addons,'conversion_rate'))}}%*</h3> 
                                <p class='m-0 small'> Expected CR Increase With Debutify </p> 
                            </td>
                        </tr>
                    </tfoot>
                    
                </table>
            </div>
        </div>
        
        <x-landing.cta class='mx-auto' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
    </div>
</section>

<x-landing.dash color='light'/>

{{-- Review Section --}}


<section class='position-relative bg-light '>
    <div class='container position-relative debutify-section' style="z-index:+2;">
        <div class='row justify-content-center'>
            <div class='col-md-6 col-lg-7'>
                {{-- <blockquote class='debutify-blockquote'>
                </blockquote> --}}
                <h4 class='py-4 lead font-weight-bold'>
                    Seriously amazing app and support. Do not be afraid to try debutify out for yourself. Customer support reply in less than 20 min.
                </h4>

                <div class='lead text-black'>
                    <div class='font-weight-bolder'>Silas Nielsen</div>
                    made over $5M with debutify
                </div>   
            </div>
            
            <div class='col-md-6 col-lg-4  '>
                <img style="z-index: +1;"  class="w-100 lazyload" data-src="images/landing/landing-stats-yesterday.png" alt="road to success">
            </div>
        </div>
    </div>
    <img class='w-100' style="position: absolute; bottom:-1px; min-width:600px;z-index:1;" src="/images/landing/blade7.svg">
</section>


{{-- Powerful Feature Section --}}
<section>
    <div class='container debutify-section'>
        <div class='text-center'>
            <h1>
                The #1 Most Powerful Features <br class='d-none d-lg-block'> 
                Any Shopify Theme Could Give You 
            </h1>
            <p class='lead my-5'>
                Debutify gives you many times the performance and apps of Shopify leading themes,<br class='d-none d-lg-block'>
                 plus exclusive features and masters training you won't find anywhere else.
            </p>     
        </div>
        
        <div class='rounded overflow-hidden'>
            <div class="table-responsive text-center">
                <table class="table table-striped table-bordered ">
                    <thead class='bg-primary text-light'>
                        <tr>
                            @foreach ([
                            ['label'=>'Features','width'=>'23%'],
                            ['label'=>'Debutify','width'=>'23%'],
                            ['label'=>'Booster','width'=>'14%'],
                            ['label'=>'Turbo','width'=>'14%'],
                            ['label'=>'EcomSolid','width'=>'14%'],
                            ['label'=>'VITALS40','width'=>'14%'],
                            ] as $item)
                            <th class='lead font-weight-light' width="{{$item['width']}}" >
                                {{$item['label']}}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([
                        ['features'=>'Free Lifetime Upgrades','debutify'=>'Free New Updates Every Month + No-Click Auto Updater','booster'=>'Only 1 year','turbo'=>'Yes','ecomsolid'=>'Yes','vitals40'=>'Yes'],
                        ['features'=>'Page Load Time*','debutify'=>'1.68s avg. (39% Faster) Even With All Apps Turned On','booster'=>'2.87s avg.','turbo'=>'2.35s avg.','ecomsolid'=>'3.21s avg.','vitals40'=>'3.21s avg'],
                        ['features'=>'Conversion-Boosting Apps','debutify'=>'26 Apps + New Added Every Month','booster'=>'12 Apps','turbo'=>'10 Apps','ecomsolid'=>'10 Apps','vitals40'=>'Yes','vitals40'=>'3.21s avg'],
                        ['features'=>'E-Commerce Pro Training','debutify'=>'6 Fully-Fledged, Premium Courses (FB Ads, Google Ads, YT Ads, $0-$1k Store Setup & More)','booster'=>'','turbo'=>'"Bonus Ecom Training"','ecomsolid'=>'','vitals40'=>''],
                        ['features'=>'Product Research Tools','debutify'=>'Winning Product Research Tool + $1,000,000 Product Research Course','booster'=>'','turbo'=>'','ecomsolid'=>'','vitals40'=>''],
                        ]  as $item)
                        <tr>
                            <td>{{$item['features']}}</td>
                            <td>
                                <div class='d-flex text-left'> 
                                    <i class='d-none d-lg-block fas fa-check  mr-2 text-success h4'></i> 
                                    {{$item['debutify']}} 
                                </div>
                            </td>
                            <td>
                                <i class='{{$item['booster']?'':'fas fa-times'}}  text-danger h4'></i>  
                                {{$item['booster']}} 
                            </td>
                            <td>
                                <i class='{{$item['turbo']?'':'fas fa-times'}}  text-danger h4'></i> 
                                {{$item['turbo']}} 
                            </td>
                            <td>
                                <i class='{{$item['ecomsolid']?'':'fas fa-times'}}  text-danger h4'></i> 
                                {{$item['ecomsolid']}}
                            </td>
                            <td>
                                <i class='{{$item['vitals40']?'':'fas fa-times'}}  text-danger h4'></i> 
                                {{$item['vitals40']}}
                            </td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        
    </div>
</section>

<x-landing.dash />

{{-- Case Study Section--}}
<section>
    <div class='container debutify-section'>
        <div class='row align-items-center'>
            
            <div class='col-md-6 col-lg-4  '>
                <img class="w-100" src="images/landing/landing-stats-yesterday.png" alt="stats yesterday">                
            </div>
            <div class='col-md-6 col-lg-8'>
                
                <div id="casestudy" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ([
                        ['name'=>'Jared Bolokofsky','comment'=>"I left my very expensive paid theme for Debutify, and I haven't looked back for even one second. Debutify is 10/10!",'status'=>'Made over $5,000,000 with his debutify store'],
                        ['name'=>'Valentina Iasevoli','comment'=>"Great theme and really great Customer Support!! They fixed the issues in few hours, I really recommend!",'status'=>'Made over $4,000,000 with his debutify store'],
                        ['name'=>'Jochen','comment'=>"Very good theme with great page speed and a lot of useful functions. Furthermore the support is great! Thanks a lot",'status'=>'Made over $3,000,000 with his debutify store'],
                        ] as $key => $item)
                        <div class="carousel-item {{$key==0?'active':''}}">
                            <blockquote class='debutify-blockquote'>
                                <h2>{{$item['comment']}} </h2>
                                <h4 class='mt-5'>{{$item['name']}} </h4>
                                <p>{{$item['status']}}</p>
                                
                            </blockquote>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                
                <div class='btn-group float-right '>
                    <button class='btn btn-lg border border-right-0'  href="#casestudy" data-slide="prev">
                        <i class='fas fa-chevron-left text-grey-500'></i>
                    </button>
                    <button class='btn btn-lg border'  href="#casestudy" data-slide="next">
                        <i class='fas fa-chevron-right text-grey-500'></i>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</section>

<x-landing.dash />

{{-- Pricing Section--}}

<section >
    <div class='container debutify-section'>
        <h1 class='text-center mb-5'> 
            Miserably low price <br class='d-none d-md-block'> compared to earning potential 
        </h1>
        <x-landing.pricing/>
    </div>
</section>

{{-- Road to Success Section--}}
<section class='bg-light'>
    <div class='container debutify-section'>
        <div class='row'>
            <div class='col-md-6'>
                <h1>Take The Easiest Road To Success </h1> 
                <p class='mb-4 lead'>Try Debutify's premium features FREE for 14 days. <br class='d-none d-lg-block'> Install and set up in 1 click.</p>
                <p class='my-4 lead'>Download now and get Five $100,000 products (PDF) by Ricky Hayes, FREE!</p>   
                <x-landing.cta  download='btn-primary' demo='btn-outline-secondary' cta='X'/>
            </div>
            
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class='position-relative'>
                    <img class="position-absolute lazyload prop prop-left" style="top:-30px; right:-20px;  " data-src="/images/landing/props-dots-gray.svg">
                    <img class="position-absolute lazyload prop prop-up" style="bottom:30px; left:-20px; " data-src="/images/landing/props-dots-gray.svg">
                    
                    <div class=' '>
                        <img class="position-relative lazyload rounded" data-src="images/landing/landing-road.png" alt="Ricky Hayes" style="max-width: 360px" >
                    </div>
                    <div class='  position-absolute shadow-sm' style="bottom:-10%;right:-10%; ">
                        <img class="lazyload rounded" style=" max-width:200px"  data-src="/images/landing/landing-road-sub.png">
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <img class='w-100' style="position: relative; bottom:-1px; min-width:600px;z-index:1;" src="/images/landing/blade7.svg">
    
</section>

{{-- FAQ Section--}}
<section >
    <div class='container py-5'>
        <div class='text-center'>
            <h1>Frequently Asked Questions</h1>
        <p class='lead mt-3 mb-5'>We know you have some questions in mind, we’ve tried to list the most important ones!</p>
        </div>
        <x-landing.faq/>
    </div>
</section>

@endsection


