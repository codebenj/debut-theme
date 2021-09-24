@extends('layouts.landing')

@section('title','Pricing | Debutify Shopify Theme')
@section('description','Check out the pricing one of the best ecommerce Shopify themes - Debutify. Get a free 14-day trial before purchasing any plan. Download now for free.')

@section('styles')
<style>
  @media only screen and (min-width:992px) {
    .scale-price{ transform: scale(1.2,1.1); top:20px;transition-duration: 0s !important; }
  }
  .hustler-light{
    max-height: 970px;height:100%
  }
  @media all and (max-width:767px) {
    .hustler-light{ max-height: 970px; height:auto; }
  }

</style>
@endsection

@section('content')

@php
$addons_choice = ['starter'=>5,'hustler'=>30,'master'=>$nbAddons];
@endphp

<section class='debutify-section'>
  <div class='container'>

    <div class='text-center'>
      <p class='lead'>Pricing</p>
      <h1 class='display-3 mb-5'>
        Pick The <span class='debutify-highlight-sm pl-3 pr-2'>Perfect</span>  Plan For <br class='d-lg-block d-none'>
        Your <span class='debutify-highlight-sm pl-4 pr-2'>Business </span>
      </h1>
    </div>

    <div  style="max-width:320px" class='mx-auto text-center'>
      <div class='row'>
        <div class='col'></div>
        <div class='col'> <span class='badge badge-sm badge-secondary mb-2'>Save 15% </span></div>
        <div class='col'> <span class='badge badge-sm badge-secondary mb-2'>Save 50% </span></div>
      </div>
      <div class="btn-group  btn-group-sm mb-3">
        <button type="button" data-plan="monthly" class="btn btn-light pricing-group-btn px-3">Monthly</button>
        <button type="button" data-plan="quarterly" class="btn btn-light pricing-group-btn px-3">Quarterly</button>
        <button type="button" data-plan="yearly" class="btn btn-primary pricing-group-btn px-3">Yearly</button>
      </div>
    </div>

    <div class='row pt-lg-5 my-lg-5 pt-md-3 my-md-3 row_plans'>
      @foreach ([
      ['cta'=>'X','btn'=>'btn-outline-secondary','plan'=>'Free','license'=>1,'price'=>0,'features'=>['1 store licence','Private Facebook group access','Basic support']],
      ['cta'=>'X','btn'=>'btn-outline-secondary','plan'=>'Starter','license'=>1,'price'=>9.5,'features'=>['1 store licence','Any '.$addons_choice['starter'].' Sales Add-Ons','Private Facebook group access','Full support','Bronze Product Vault (name, image)',"1-click Integrations <span class='badge-sm badge-pill badge-dark'>SOON!</span>"]],
      ['cta'=>'X','btn'=>'btn-primary','plan'=>'Hustler','license'=>1,'price'=>23.5,'features'=>['1 store licence','Any '.$addons_choice['hustler'].' Sales Add-Ons','Private Facebook group access','Full support (live support, email & Facebook chat)','Silver Product Vault (name, image, audience, interests &more)',"1-click Integrations <span class='badge-sm badge-pill badge-dark'>SOON!</span>"]],
      ['cta'=>'X','btn'=>'btn-secondary','plan'=>'Master','license'=>3,'price'=>48.5,'features'=>['3 store licences','All '.$addons_choice['master'].'+ Sales Add-Ons','VIP Facebook mentoring group','Priority full support (skip the queue)','Gold Product Vault (name, image, audience, interests, description & more)','Access to tested Marketing Strategies courses','Chance for 1-on-1 mentoring call every week']],
      ] as $item)

      <div class='col-md-6 col-lg-3 mb-4'>
        <div class='card h-100 shadow-sm overflow-hidden {{$item['plan'] == 'Hustler'?'scale-price':''}}'>
          <div class='card-body p-3 rounded text-center {{$item['plan'] == 'Hustler'?'bg-primary':''}}'>

            <div class='{{$item['plan'] == 'Hustler'?'text-white':''}}'>
              <p class='text-secondary font-weight-bolder {{$item['plan'] == 'Hustler'?'':'invisible'}}'>
                Best Value For Money!
              </p>
              <h3 class='font-weight-bold mt-3 {{$item['plan'] == 'Hustler'?'text-white':''}}'>
                {{$item['plan']}}
              </h3>
              <p class='mb-4'>Get started with Debutify</p>
            </div>

              <div class='bg-white rounded p-3 {{$item['plan'] == 'Hustler'?'hustler-light':''}}'>
                <del class="striked-price striked-price-{{$item['plan']}}" style="display: none;">
                  <small class='text-center font-weight-bold'></small>
                </del>

                <div class='{{$item['plan']=='Hustler'?'text-black font-weight-bolder':''}}'>
                  <span class='position-relative' style="top:-20px">$</span>
                  <span class="display-4 {{strtolower($item['plan'])}}-price {{$item['plan']=='Hustler'?'font-weight-bolder':'font-weight-normal'}}">
                    {{$item['price']}}
                  </span>
                  <span>/mo</span>
                </div>

                @if($item['plan'] != 'Free')
                <div>
                  <small style="display: none;" class='coupon-duration-months text-center text-muted'></small>
                </div>
                @endif

                <small class="billed-text text-center {{ $item['plan'] == 'Free' ? 'text-white' : '' }}">Billed Yearly</small>
                <div class='mt-3 mb-2'>
                  <span class='text-yellow'>
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-star.svg" alt="icon star" width="18" height="18"/>
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-star.svg" alt="icon star" width="18" height="18"/>
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-star.svg" alt="icon star" width="18" height="18"/>
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-star.svg" alt="icon star" width="18" height="18"/>
                    <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-star.svg" alt="icon star" width="18" height="18"/>
                  </span>
                  <span class='text-black'>
                    4.8/5.0
                  </span>
                </div>

                <p class='text-mid-light'><span class='debutify-reviews'></span>+ Reviews</p>

                <x-landing.download-btn  cta="$item['cta']" :class="$item['btn'].' debutify-hover btn btn-sm btn-block mt-3'"/>

                @if ($item['plan']=='Master')
                <div class=' mt-3'>Everything in Hustler, plus:</div>
                @endif

                <div class='pt-3'>
                  @foreach ($item['features'] as $feature)
                  <div class='d-flex text-left mb-2 align-items-start'>
                    <!-- <i class='fas fa-check mr-2 mt-1 {{$item['plan']!='Master'?'text-primary':''}}'></i> -->
                    <img class="mr-2 mt-2 d-inline-block {{$item['plan']!='Master'?'text-primary':''}}" src="/images/landing/icons/icon-check-{{$item['plan'] == 'Hustler'?'dark':'blue'}}.svg" alt="icon check" width="14" height="auto">
                    <div>{!!$feature!!}</div>
                  </div>
                  @endforeach
                </div>
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
    <div class='bg-primary p-lg-5 p-3 rounded text-white'>
      <div class='row'>
        <div class='col-md-3'>
          <div class='responsive-container-4by3'>
            <img class='w-100 lazyload' data-src="images/landing/pricing-guarantee-v2.svg?v={{config('image_version.version')}}" alt="">
          </div>
        </div>
        <div class='col-md-9 text-lg-left text-center'>
          <h1 class='text-white'> 30-Day Money Back Guarantee  </h1>
          <p class='lead my-4'>
            If Debutify does not meet <u> and exceed</u> your expectations, contact our customer support and we will immediately issue a refund of your payment — no questions asked. And, you get to keep Debutify until the end of your billing period. Transparent and fair.
          </p>
          <p class='lead'>
            Due to monthly plans lasting only 31 days, we cannot offer our guarantee on monthly plans — only on yearly plans.
          </p>
          <x-landing.download-btn class='debutify-hover btn-secondary my-4 btn-lg' cta='X'/>
        </div>
      </div>
    </div>
  </div>
</section>

<section class='debutify-section'>
  <div class='container'>
    <h1 class='text-center display-4'>
      Join thousands of successful <br class='d-none d-lg-block'> business owners using Debutify
    </h1>
    <x-landing.reviews type='badge' class='my-5' row='col-md-6 col-lg-4'/>
    <x-landing.reviews type='masonry'/>
    <x-landing.cta class='d-flex justify-content-center' download='btn-primary' demo='btn-outline-secondary' cta='X'/>
  </div>
</section>


<section class='bg-light debutify-section'>
  <div class='container'>
    <h1 class='text-center display-4'>
      Smart Features To Start And <br class='d-none d-lg-block'>
      Scale Your Business
    </h1>

    <x-landing.pricing-template :cta="['X','X','X','X']" label='Theme Features'>
      @foreach ([
        ['Theme','1','1','1','1'],
        ['Store Licences','1 Licence','1 Licence','1 Licence','3 Licences'],
        ['Facebook group access','1','1','1','1'],
        ['Email support','1','1','1','1'],
        ['Live chat support','0','1','1','1'],
        ['Exclusive partner discount','0','0','1','1']
        ] as $item)
        <tr>
          @foreach ($item as $v_index => $values)

          <td class="{{$v_index ==0?'text-left':''}}">
            @if ($values == '1')
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-check-green.svg" alt="icon green check" width="19" height="19" />

            @elseif($values == '0')
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-cross.svg" alt="icon cancel" width="16" height="16" />
            @else
            {{$values}}
            @endif
          </td>
          @endforeach
        </tr>
        @endforeach
    </x-landing.pricing-template>

    <x-landing.pricing-template :cta="['X','X','X','X']" label='Add-Ons'>
      <tr>
        <td class='text-left'> Total Sales Add-Ons </td>
        <td> <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-cross.svg" alt="icon cancel" width="16" height="16" />  </td>
        <td> Any {{$addons_choice['starter']}} of choice</td>
        <td> Any {{$addons_choice['hustler']}} of choice </td>
        <td> All {{$addons_choice['master']}}+ </td>
      </tr>
      @foreach ($global_add_ons as $index => $item)
        <tr>
          <td class='text-left'> {{$item['name']}} </td>
          <td> <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-cross.svg" alt="icon cancel" width="16" height="16" /></td>
          <td>
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-check-{{$index<$addons_choice['starter']? 'green':'green'}}.svg" alt="icon {{$index<$addons_choice['starter'] ? 'green':'yellow'}} check" width="19" height="19" />
          </td>
          <td>
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-check-{{$index<$addons_choice['hustler']? 'green':'green'}}.svg" alt="icon {{$index<$addons_choice['hustler'] ? 'green':'yellow'}} check" width="19" height="19" />
           </td>
          <td> <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-check-green.svg" alt="icon green check" width="19" height="19" /> </td>
        </tr>
        @endforeach
    </x-landing.pricing-template>

    <x-landing.pricing-template :cta="['X','X','X','X']" label='Product Vault'>
      @foreach ([
        ['Oportunity level','0','Bronze','Silver','Gold'],
        ['Weekly products','0','5','10','30'],
        ['Spy tools','0','0','1','1'],
        ['Audiences','0','0','1','1'],
        ['Interest targeting','0','0','1','1'],
        ['Descriptions','0','0','1','1'],
        ] as $item)
        <tr>
          @foreach ($item as $v_index => $values)

          <td class="{{$v_index ==0?'text-left':''}}">
            @if ($values == '1')
              <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-check-green.svg" alt="icon green check" width="19" height="19" />
            @elseif($values == '0')
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-cross.svg" alt="icon cancel" width="16" height="16" />
            @else
            {{$values}}
            @endif
          </td>
          @endforeach
        </tr>
        @endforeach
    </x-landing.pricing-template>


    <x-landing.pricing-template :cta="['X','X','X','X']" label='Marketing Masterclass'>
      @foreach ([
        ['Beginner Shopify Course','0','0','1','1'],
        ['Beginner Product Research Course','0','0','1','1'],
        ['Beginner Google Course','0','0','1','1'],
        ['Beginner Facebook Ads Course','0','0','1','1'],
        ['Facebook Ads Advanced Course','0','0','0','1'],
        ['Google Ads Advanced Course','0','0','1','1'],
        ['Product Research Advanced Course','0','0','0','1'],
        ['Case Studies Course','0','0','0','1'],
        ['Productivity Apps Advanced Course','0','0','0','1'],
        ['Shopify Store Advanced Course','0','0','0','1'],
        ['YouTube Ads Advanced Course','0','0','0','1'],
        ] as $item)
        <tr>
          @foreach ($item as $v_index => $values)

          <td class="{{$v_index ==0?'text-left':''}}">
            @if ($values == '1')
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-check-green.svg" alt="icon green check" width="19" height="19">
            @elseif($values == '0')
            <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-cross.svg" alt="icon cancel" width="16" height="16" />
            @else
            {{$values}}
            @endif
          </td>
          @endforeach
        </tr>
        @endforeach
    </x-landing.pricing-template>
    <x-landing.dropshippers logo="true" :dropshipper="['kamil-sattar','james-beattie','jordan-welch']"/>
  </div>
</section>

<section class='debutify-section'>
  <div class='container'>
    <div class='text-center'>
      <h1>Frequently Asked Questions</h1>
      <p class='mt-4 mb-5'>We know you have some questions in mind, we’ve tried to list the most important ones!</p>
    </div>
    <x-landing.faq/>
  </div>
</section>

{{-- Pricing Exit Intent Modal --}}
<div class='modal fade' id="pricingExitIntentModal">
  <div class="modal-dialog align-items-end align-items-md-center modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class='modal-body text-center'>
        <button data-dismiss="modal" class='close-modal'><img class="lazyload d-inline-block " data-src="/images/landing/icons/icon-price-modal-cross.svg" alt="icon cross" width="17" height="17"/>
        </button>
        <img class='lazyload pt-4 pb-3' width="52" data-src="/images/landing/debutify-logo-icon.svg" alt=""> <br>
        <h1><span class='debutify-underline-lg'>Don’t Miss Out!</span></h1>
        <p class='my-3'>Start free and save <b class='text-primary'>10%</b> on any Debutify <br class='d-none d-lg-block'> subscription if you install now.</p>
        <a class='btn btn-primary my-3 debutify-hover' type="button" href="/pricing?code=PLAN10">Take The Discount</a>
        <p>Discount reserved for <b class='text-primary' id="timeWatch">5:00</b> </p>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')

<script>

  window.addEventListener('DOMContentLoaded', function() {


    var time = 5;
    var timer2 = `${time}:01`;
    var interval = setInterval(function() {
      var timer = timer2.split(':');

      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      minutes = (seconds < 0) ? --minutes : minutes;
      if (minutes < 0) {clearInterval(interval); return false;};
      seconds = (seconds < 0) ? 59 : seconds;
      seconds = (seconds < 10) ? '0' + seconds : seconds;

      $('#timeWatch').html(minutes + ':' + seconds);
      timer2 = minutes + ':' + seconds;
    }, 1000);
  });
</script>
@endsection
