@extends('layouts.debutify')
@section('title','Dashboard')
@section('view-onboarding','view-onboarding')

@section('styles')

{{--
{{ dd(get_defined_vars()['__data']) }}
--}}

<style>
  .reviewBanner,.page-header{
    display: none!important;
  }
  .shopify-review-icon
  {
    width: 35px;
    margin: 0 auto;
    display: block;
    margin-bottom: 10px;
  }
  .shopify-star-icon
  {
    margin: 0 auto;
    display: block;
    margin-bottom: 15px;
  }
  .home-review-stack-item
  {
    width: 100%;
  }
  .shopify-review-button
  {
    margin: 0 auto;
    display: block;
    width: fit-content;
  }
  .review-card-heading
  {
    text-align: center;
  }
  .review-card-paragraph
  {
    text-align: center;
    margin-top: 5px;
    margin-bottom: 10px;
    color: #637381;
  }
  .underline-card-heading
  {
    border-bottom: 2px dashed #919EAB;
  }
  .add-ons-heading
  {
    text-align: center;
  }
  .text-center
  {
    text-align: center !important;
  }
  .center-video
  {
    margin: 0 auto;
    display: block;
    margin-top: 30px;
  }
  .Polaris-Stack-plan-heading
  {
    width: 100%;
  }
  .Polaris-Stack-plan-button
  {
    width: 100%;
  }
  .Polaris-Stack-plan-button a
  {
    display: block;
    margin: 0 auto;
    width: fit-content;
  }
  .winning-products-heading
  {
    margin-bottom: 15px;
  }
  .winning-product-card-overlay
  {
    position: relative;
  }
  .overlay-layer
  {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0.3;
    background: #808080;
    text-align: center;
    z-index: 5;
  }
  .padding-top-5
  {
    padding-top: 5px;
  }
  .winning-button-center
  {
    margin: 0 auto;
    display: inline;
  }
  .winning-products-card-header
  {
    border-bottom: .1rem solid var(--p-border-subdued,#dfe3e8);
    padding-bottom: 2rem;
  }
  .mentoring-card-header
  {
    padding-bottom: 2rem;
  }
  .space-when-empty
  {
    display: inline-block;
    width: 10px;
  }
  .homepage-addon-link, .homepage-addon-link:hover
  {
    text-decoration: none;
    color: #212b36;
  }
  .container-product-img{
    width: 100%;
    padding-top: 100%;
    position: relative;
    overflow: hidden;
  }
  .grid-product-img{
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }
  .grid-product-wrapper{
    overflow: hidden;
  }
  .grid-product-title{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-align: left;
  }
  .video-icon{
    position: absolute;
    top:10px;
    left: 10px;
    color:#6371c7;
    background-color: #fff;
    border-radius: 100%;
    overflow: hidden;
    z-index: 10;
    font-size: 20px;
    border: 2px solid #fff;
  }
  .new-product{
    position: absolute;
    top:10px;
    right: 10px;
    z-index: 10;
  }
  .pagination .Polaris-Button{
    min-width: 54px;
  }
  .grid-product-img{
    cursor: pointer;
  }
  .no-results p{
    text-align: center;
  }
  .no-results .container-product-img {
    padding-top: 0;
  }
  .no-results .Polaris-TextContainer.Polaris-TextContainer--spacingTight.d-flex {
    justify-content: center;
  }
  .no-results .container-product-img.rounded img {
    max-width: 50%;
    margin: 0px auto 0px;
    position: relative;
    display: block;
  }
  .header-with-border-bottom
  {
    border-bottom: var(--p-border-subdued, 0.1rem solid var(--p-divider-subdued-on-surface, #dfe3e8));
    padding-bottom: 2rem;
  }
  .mrr-5{
      margin-right: 5px;
      color: #FF9529;
  }

  .webinar_thumbnail{
    background-position-y: 32%;
  }
</style>
@endsection

@section('content')
<div id="dashboard">
  @include("components.account-frozen-banner")


@php

  $prior_beta_theme = 0;
  foreach($store_themes as $theme)
  {
    if($theme->version == '2.0.2')
    {
      $prior_beta_theme = 1;
    }
  }

    if( ($trial_days && !$master_shop && !$is_beta_user && !$is_paused) || ($alladdons_plan == $freemium || $alladdons_plan == "") && !$is_paused ){
            if($prior_beta_theme != 0){
                  $count = 5;
            }else{
                  $count = 4;
            }
      }else{
            if($prior_beta_theme != 0){
                  $count = 4;
            }else{
                  $count = 3;
                  if($steps_completed == 1) 
                  {
                    $progress = 33;
                  }
                  elseif($steps_completed == 2)
                  {
                    $progress = 66;
                  }
            }
      }
@endphp

  @if( isset($steps_completed) && ($steps_completed < $count) )
  <div class="Polaris-Card">
    <div class="Polaris-Card__Header mentoring-card-header">
      <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
          <h2 class="Polaris-Heading">Your setup progress
          <span class="Polaris-Badge Polaris-Badge--statusSuccess">
            <span class="Polaris-VisuallyHidden">Success</span>
            {{ $steps_completed ?? 0 }}/{{$count}}
          </span>
          </h2>
          <p>Let's get you up and running so you can get more sales and grow your Shopify store</p>
          <br/>
          <div class="Polaris-ProgressBar Polaris-ProgressBar--sizeMedium"><progress class="Polaris-ProgressBar__Progress" max="100"></progress>
            <div class="Polaris-ProgressBar__Indicator" style="width: {{$progress}}%;">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="Polaris-ResourceList__ResourceListWrapper">
      <ul class="Polaris-ResourceList" aria-live="polite">

        <li class="Polaris-ResourceList__ItemWrapper">
          <div class="Polaris-ResourceItem open-modal">
            <a href="{{config('env-variables.APP_PATH')}}" class="Polaris-ResourceItem__Link start-trial-link" tabindex="0" data-polaris-unstyled="true"></a>
            <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter">

              <div class="Polaris-ResourceItem__Owned">
                <div class="Polaris-ResourceItem__Media space-when-empty">
                  @if(isset($trial_check) && $trial_check)
                  <img src="/images/new/tick-mark.png" class="" alt="Completed">
                  @endif
                </div>
              </div>
              <div class="Polaris-ResourceItem__Content">
                @if(isset($trial_check) && $trial_check) <del> @endif 1. Start my Master plan 14-day free trial @if(isset($trial_check) && $trial_check) </del> @endif
              </div>

              <div class="Polaris-ButtonGroup">
                <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--primary">
                  <a class="Polaris-Button @ixf(isset($trial_check) && $trial_check) Polaris-Button--disabled @else Polaris-Button--primary @endif" href="{{config('env-variables.APP_PATH')}}">
                    Start Trial
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>

        <li class="Polaris-ResourceList__ItemWrapper">
          <div class="Polaris-ResourceItem open-modal">
            <a href="{{config('env-variables.APP_PATH')}}themes" class="Polaris-ResourceItem__Link download-theme-link" tabindex="0" data-polaris-unstyled="true"></a>
            <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter">

              <div class="Polaris-ResourceItem__Owned">
                <div class="Polaris-ResourceItem__Media space-when-empty">
                  @if(isset($latestupload) && $latestupload)
                  <img src="/images/new/tick-mark.png" class="" alt="Completed">
                  @endif
                </div>
              </div>
              <div class="Polaris-ResourceItem__Content">
                <div> @if(isset($latestupload) && $latestupload) <del> @endif 2. Download my free Debutify theme @if(isset($latestupload) && $latestupload) </del> @endif </div>
              </div>
              <div class="Polaris-ButtonGroup">
                <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--primary">
                  <a class="Polaris-Button @if(isset($latestupload) && $latestupload) Polaris-Button--disabled @else Polaris-Button--primary @endif" href="{{config('env-variables.APP_PATH')}}themes">
                    Download Theme
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>

      @if($prior_beta_theme != 0)

        <li class="Polaris-ResourceList__ItemWrapper">
          <div class="Polaris-ResourceItem open-modal">
            <a href="{{config('env-variables.APP_PATH')}}add_ons" class="Polaris-ResourceItem__Link install-addons-link" tabindex="0" data-polaris-unstyled="true"></a>
            <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter">

              <div class="Polaris-ResourceItem__Owned">
                <div class="Polaris-ResourceItem__Media space-when-empty">
                  @if(isset($active_add_ons) && $active_add_ons > 0)
                  <img src="/images/new/tick-mark.png" class="" alt="Completed">
                  @endif
                </div>
              </div>
              <div class="Polaris-ResourceItem__Content">
                <div>
                  @if(isset($active_add_ons) && $active_add_ons > 0) <del> @endif 3. Install Add-Ons to increase conversion rate @if(isset($active_add_ons) && $active_add_ons > 0) </del> @endif
                </div>
              </div>
              <div class="Polaris-ButtonGroup">
                <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--primary">
                  <a class="Polaris-Button @if(isset($active_add_ons) && $active_add_ons > 0) Polaris-Button--disabled @else Polaris-Button--primary @endif" href="{{config('env-variables.APP_PATH')}}add_ons">
                    Install Add-ons
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>
        @endif

        <li class="Polaris-ResourceList__ItemWrapper">
          <div class="Polaris-ResourceItem open-modal">
            <a href="#" class="Polaris-ResourceItem__Link rate-debutify-link leaveReviewPopup review_btn" tabindex="0" data-polaris-unstyled="true" ></a>
            <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" >

              <div class="Polaris-ResourceItem__Owned">
                <div class="Polaris-ResourceItem__Media  space-when-empty">
                  @if(isset($review_given) && $review_given)
                  <img src="/images/new/tick-mark.png" class="" alt="Completed">
                  @endif
                </div>
              </div>
              <div class="Polaris-ResourceItem__Content">
                <div>
                  @if(isset($review_given) && $review_given) <del> @endif  @if($prior_beta_theme != 0) 4. @else 3. @endif Rate my experience so far @if(isset($review_given) && $review_given) </del> @endif
                </div>
              </div>
                <span><i class="fa fa-star mrr-5" aria-hidden="true"></i></span>
                <span><i class="fa fa-star mrr-5" aria-hidden="true"></i></span>
                <span><i class="fa fa-star mrr-5" aria-hidden="true"></i></span>
                <span><i class="fa fa-star mrr-5" aria-hidden="true"></i></span>
                <span><i class="fa fa-star mrr-5" aria-hidden="true"></i></span>
              <div class="Polaris-ButtonGroup">
                <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--primary">
                  <a class="Polaris-Button leaveReviewPopup @if(isset($review_given) && $review_given) Polaris-Button--disabled @else Polaris-Button--primary @endif review_btn" href="#">
                   Give us a 5 Star Review
                  </a>
                </div>
              </div>
            </div>
          </div>
        </li>


              @if( ($trial_days && !$master_shop && !$is_beta_user) || ($alladdons_plan == $freemium || $alladdons_plan == "") )
                @if(!$is_paused)
                  <li class="Polaris-ResourceList__ItemWrapper">
                    <div class="Polaris-ResourceItem">
                      <a href="{{ route('extended_trial')}}" class="Polaris-ResourceItem__Link rate-debutify-link" tabindex="0" data-polaris-unstyled="true" ></a>
                      <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" >

                        <div class="Polaris-ResourceItem__Owned">
                          <div class="Polaris-ResourceItem__Media  space-when-empty">
                               @if($extend_all_step)
                                  <img src="/images/new/tick-mark.png" class="" alt="Completed">
                              @endif
                          </div>
                        </div>
                        <div class="Polaris-ResourceItem__Content">
                          <div>
                              @if( ($trial_days > 0 || $alladdons_plan == "Freemium" || $alladdons_plan == "") && $is_beta_user == false && $is_paused != 1)
                                  @if($extend_all_step) <del> @endif @if($prior_beta_theme != 0) 5. @else 4. @endif Extend my free trial @if($extend_all_step) </del> @endif
                               @endif
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                @endif
            @endif

        

      </ul>
    </div>
  </div>
  @endif

  @if(isset($webinar_taken) && $webinar_taken == 0)
  <!--Webinar Registeration-->
  <div class="Polaris-Card">
    <div class="Polaris-MediaCard">
      <div class="Polaris-MediaCard__MediaContainer">
        <div class="Polaris-VideoThumbnail__Thumbnail webinar_thumbnail" style="background-image: url('https://debutify.com/images/new/ricky.png');/* background-position: top; */">
          <a href="{{config('env-variables.APP_PATH')}}webinar_registration" onclick="reloadWithDelay()" target="_blank" class="Polaris-VideoThumbnail__PlayButton" aria-label="Play video of length 1 minute and 20 seconds">
          <img class="Polaris-VideoThumbnail__PlayIcon" src="data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMzggMzgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0xOSAxQzkuMDYgMSAxIDkuMDU3IDEgMTljMCA5Ljk0IDguMDU3IDE4IDE4IDE4IDkuOTQgMCAxOC04LjA1NyAxOC0xOCAwLTkuOTQtOC4wNTctMTgtMTgtMTh6IiBmaWxsPSIjZmZmIi8+PHBhdGggZD0iTTE5IDFDOS4wNiAxIDEgOS4wNTcgMSAxOWMwIDkuOTQgOC4wNTcgMTggMTggMTggOS45NCAwIDE4LTguMDU3IDE4LTE4IDAtOS45NC04LjA1Ny0xOC0xOC0xOHoiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2I1YjViNSIvPjxwYXRoIGQ9Ik0xNSAxMS43MjNjMC0uNjA1LjctLjk0MiAxLjE3My0uNTY0bDEwLjkzIDcuMjE1YS43Mi43MiAwIDAxMCAxLjEyOGwtMTAuOTMgNy4yMTZBLjcyMy43MjMgMCAwMTE1IDI2LjE1M3YtMTQuNDN6IiBmaWxsLW9wYWNpdHk9Ii41NTciLz48L3N2Zz4K" alt="">
          </a>
          <!-- <p class="Polaris-VideoThumbnail__Timestamp">1:20</p> -->
        </div>
      </div>
      <div class="Polaris-MediaCard__InfoContainer d-flex align-items-center">
        <div class="Polaris-Card__Section">
          <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingTight">
            <div class="Polaris-Stack__Item">
              <div class="Polaris-MediaCard__Heading">
                <h2 class="Polaris-Heading">Limited Free Seats: The 3 Eye-Opening Secrets To How I Built a $2,670,000/Month Dropshipping Brand, In Less Than 3 Months</h2>
              </div>
            </div>
            <div class="Polaris-Stack__Item">
              <p>subtitle: Sign up now for a free seat at my latest webinar, where I explain how I built my new dropshipping brand from $0 to $2.67M per month in only three months, as a complete beginner, using 3 game-changing ecom secrets... </p>
            </div>
            <div class="Polaris-Stack__Item">
              <div class="Polaris-MediaCard__ActionContainer">
                <div class="Polaris-ButtonGroup">
                  <div class="Polaris-ButtonGroup__Item">
                    <div class="Polaris-MediaCard__PrimaryAction">
                      <a href="{{config('env-variables.APP_PATH')}}webinar_registration" target="_blank" class="Polaris-Button" onclick="reloadWithDelay()">
                      <span class="Polaris-Button__Content">
                        <span class="Polaris-Button__Text">Reserve my Free Seat Now</span>
                      </span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--End Webinar Registeration-->
  @endif

      @if($prior_beta_theme != 0)

  <div class="Polaris-Card">
    <div class="Polaris-Card__Header mentoring-card-header">
      <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
          <h2 class="Polaris-Heading">Our latest Add-Ons
          @if($all_addons == 1)
          <span class="Polaris-Badge Polaris-Badge--statusSuccess">
            <span class="active-addon">{{$active_add_ons}}</span>/<span class="max-addon">{{$addons_count}}</span>
          </span>
          @endif
          </h2>
        </div>
        <div class="Polaris-Stack__Item">
          <a href="{{config('env-variables.APP_PATH')}}add_ons" class="Polaris-Button Polaris-Button--plain">
            <span class="Polaris-Button__Content">
              <span class="Polaris-Button__Text">View all</span>
            </span>
          </a>
        </div>
      </div>
    </div>
    <div class="Polaris-ResourceList__ResourceListWrapper">
      <ul class="Polaris-ResourceList" aria-live="polite">
        @foreach($dashboard_add_ons as $addon)
        @if($loop->index < 5)
        <li class="Polaris-ResourceList__ItemWrapper">
          <div class="Polaris-ResourceItem open-modal">
            <a class="homepage-addon-link" aria-describedby="{{$addon->title}}" aria-label="View details for {{$addon->title}}" tabindex="0" data-polaris-unstyled="true" href="{{config('env-variables.APP_PATH')}}add_ons">
            <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" id="{{$addon->title}}">
              <div class="Polaris-ResourceItem__Owned">
                <div class="Polaris-ResourceItem__Media">
                  <span aria-label="{{$addon->title}}" role="img" class="Polaris-Avatar Polaris-Avatar--styleSix Polaris-Avatar--sizeMedium Polaris-Avatar--hasImage">
                    @if($addon->status == 1)
                    <img src="/svg/unlock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    @else
                    <img src="/svg/lock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    @endif
                  </span>
                </div>
              </div>
              <div class="Polaris-ResourceItem__Content">
                <h3>
                  <span class="Polaris-TextStyle--variationStrong">{{$addon->title}}</span>
                  @if($all_addons == 1 && $addon->status == 1)
                  <span class="Polaris-Badge Polaris-Badge--statusSuccess">Installed</span>
                  @elseif(empty($all_addons) && $addon->status == 1)
                  <span class="Polaris-Badge Polaris-Badge--statusAttention">Paused</span>
                  @endif
                </h3>
                <div>{{$addon->subtitle}}</div>
              </div>
            </div>
            </a>
          </div>
        </li>
        @endif
        @endforeach
      </ul>
    </div>
  </div>
  @endif


  <div class="Polaris-Card winning-product-card-overlay">
    @if((empty($alladdons_plan) && empty($trial_days)) || $alladdons_plan == $freemium)
    <div class="overlay-layer"></div>
    @endif


    <div class="Polaris-Card__Header winning-products-card-header">
      <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
          <h2 class="Polaris-Heading">Our latest winning products</h2>
        </div>
        <div class="Polaris-Stack__Item">
          <a href="{{config('env-variables.APP_PATH')}}winning-products" class="Polaris-Button Polaris-Button--plain">
            <span class="Polaris-Button__Content">
              <span class="Polaris-Button__Text">View all</span>
            </span>
          </a>
        </div>
      </div>
    </div>

    <div class="Polaris-Card__Section">
      <div class="Polaris-Stack__Item text-center">
        <div class="all-products">
          @include("components.product-result-home")
        </div>
      </div>
    </div>
  </div>

  {{--
    <div class="Polaris-Card text-center">
      <div class="Polaris-Card__Section">
        <div class="Polaris-Stack__Item home-review-stack-item">
          <h2 class="Polaris-Heading">Webinar</h2>
        </div>
        <div class="Polaris-Stack align-items-center">
            <iframe class="center-video" width="560" height="315" src="https://www.youtube.com/embed/U_61TdXpSk4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
    </div>
    --}}

    <div class="Polaris-Card">
      <div class="Polaris-CalloutCard__Container">
        <div class="Polaris-Card__Header mentoring-card-header">
          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
              <h2 class="Polaris-Heading">Our latest mentoring call winner</h2>
            </div>
            <div class="Polaris-Stack__Item">
              <a href="{{config('env-variables.APP_PATH')}}mentoring" class="Polaris-Button Polaris-Button--plain">
                <span class="Polaris-Button__Content">
                  <span class="Polaris-Button__Text">View all</span>
                </span>
              </a>
            </div>
          </div>
        </div>
        <div class="Polaris-ResourceList__ResourceListWrapper">
          <ul class="Polaris-ResourceList" aria-live="polite">
            @php
            $counter=0;
            @endphp
            @foreach($mentoringWinners as $mentoringWinner)
            @php
            if($counter==5)
            break;
            else
            $counter++;
            @endphp
            <li class="Polaris-ResourceList__ItemWrapper" >
              <div class="Polaris-ResourceItem" data-href="">
                <a class="homepage-addon-link" aria-describedby="Trust badge" aria-label="View details for Trust badge" tabindex="0" data-polaris-unstyled="true" href="{{config('env-variables.APP_PATH')}}mentoring">
                <div class="Polaris-ResourceItem__Container" id="{{$mentoringWinner->id}}">
                  <div class="Polaris-ResourceItem__Owned">
                    <div class="Polaris-ResourceItem__Media"><span aria-label="Mae Jemison" role="img" class="Polaris-Avatar Polaris-Avatar--sizeMedium"><span class="Polaris-Avatar__Initials"><svg class="Polaris-Avatar__Svg" viewBox="0 0 40 40">
                      <path fill="currentColor" d="M8.28 27.5A14.95 14.95 0 0120 21.8c4.76 0 8.97 2.24 11.72 5.7a14.02 14.02 0 01-8.25 5.91 14.82 14.82 0 01-6.94 0 14.02 14.02 0 01-8.25-5.9zM13.99 12.78a6.02 6.02 0 1112.03 0 6.02 6.02 0 01-12.03 0z"></path>
                    </svg></span></span></div>
                  </div>
                  <div class="Polaris-ResourceItem__Content">
                    <h3><span class="Polaris-TextStyle--variationStrong text-capitalize">{{$mentoringWinner->name}}</span></h3>
                    <div>{{$mentoringWinner->city}}, {{$mentoringWinner->country}}</div>
                  </div>
                  <?php
                  $now = \Carbon\Carbon::now();
                  $from = \Carbon\Carbon::parse($mentoringWinner->created_at);
                  $days = $from->diffInDays($now);
                  ?>
                  <div class="Polaris-ButtonGroup">
                    <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--plain">
                      <span>Won {{ $days }} days ago</span>
                    </div>
                  </div>
                </div>
              </a>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>


    <div class="Polaris-Card text-center">
      <div class="Polaris-CalloutCard__Container">
        <div class="Polaris-Card__Section">
          <div class="Polaris-CalloutCard">
            <div class="Polaris-CalloutCard__Content">
              <img src="/svg/design.svg" alt="" class="Polaris-CalloutCard__Image mx-auto">
              <div class="Polaris-CalloutCard__Title">
                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">
                  Debutify Help Center
                </h2>
              </div>
              <div class="Polaris-TextContainer">
                <p>Visit our Help Center and find answers to you questions in no time!</p>
              </div>
              <div class="Polaris-CalloutCard__Buttons">
                <a class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge" href="https://help.debutify.com/" target="_blank" data-polaris-unstyled="true">
                  <span class="Polaris-Button__Content">
                    <span>Visit Help Center</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{--
      <div class="Polaris-Card">
        <div class="Polaris-CalloutCard__Container">
          <div class="Polaris-Card__Section">
            <div class="Polaris-CalloutCard">
              <div class="Polaris-CalloutCard__Content">
                <div class="Polaris-CalloutCard__Title">
                  <h2 class="Polaris-Heading">
                    Private 1-On-1 mentoring Facebook group
                    <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                      Guru plan
                    </span>
                  </h2>
                </div>
                <div class="Polaris-TextContainer">
                  <p>Learn from the best in the industry and join our exclusive community to skyrocket your sales</p>
                </div>
                <div class="Polaris-CalloutCard__Buttons">
                  @if($alladdons_plan == $guru)
                  <a class="Polaris-Button Polaris-Button--primary" href="https://www.facebook.com/groups/569596487183386/" target="_blank" data-polaris-unstyled="true">
                    <span class="Polaris-Button__Content"><span>Access mentoring group</span></span>
                  </a>
                  @else
                  <a class="Polaris-Button Polaris-Button--primary" href="{{config('env-variables.APP_PATH')}}plans" data-polaris-unstyled="true">
                    <span class="Polaris-Button__Content"><span>Unlock mentoring group</span></span>
                  </a>
                  @endif
                </div>
              </div>
              <img src="/svg/security.svg" alt="" class="Polaris-CalloutCard__Image">
            </div>
          </div>
        </div>
      </div>
      --}}

        <div class="Polaris-Card">
          <div class="Polaris-Card__Header header-with-border-bottom">
            <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
              <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                <h2 class="Polaris-Heading">Training Courses</h2>
              </div>
              <div class="Polaris-Stack__Item">
                <a href="{{config('env-variables.APP_PATH')}}courses" class="Polaris-Button Polaris-Button--plain">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">View all</span>
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="Polaris-Card__Section">
            <div class="Polaris-Stack__Item">
              @foreach($courses as $key => $course)
               @if($loop->index < 2)
              <div class="Polaris-Card">
                <div class="Polaris-MediaCard">
                  <div class="Polaris-MediaCard__MediaContainer">
                    <div class="Polaris-VideoThumbnail__Thumbnail" style="background-image: url(&quot;{{ $course->image }}&quot;);">
                      <a href="{{config('env-variables.APP_PATH')}}courses/{{ $course->id }}" class="Polaris-VideoThumbnail__PlayButton" aria-label="Play video of length 1 minute and 20 seconds">
                        <img class="Polaris-VideoThumbnail__PlayIcon" src="data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMzggMzgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0xOSAxQzkuMDYgMSAxIDkuMDU3IDEgMTljMCA5Ljk0IDguMDU3IDE4IDE4IDE4IDkuOTQgMCAxOC04LjA1NyAxOC0xOCAwLTkuOTQtOC4wNTctMTgtMTgtMTh6IiBmaWxsPSIjZmZmIi8+PHBhdGggZD0iTTE5IDFDOS4wNiAxIDEgOS4wNTcgMSAxOWMwIDkuOTQgOC4wNTcgMTggMTggMTggOS45NCAwIDE4LTguMDU3IDE4LTE4IDAtOS45NC04LjA1Ny0xOC0xOC0xOHoiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2I1YjViNSIvPjxwYXRoIGQ9Ik0xNSAxMS43MjNjMC0uNjA1LjctLjk0MiAxLjE3My0uNTY0bDEwLjkzIDcuMjE1YS43Mi43MiAwIDAxMCAxLjEyOGwtMTAuOTMgNy4yMTZBLjcyMy43MjMgMCAwMTE1IDI2LjE1M3YtMTQuNDN6IiBmaWxsLW9wYWNpdHk9Ii41NTciLz48L3N2Zz4K" alt="">
                      </a>
                      <!-- <p class="Polaris-VideoThumbnail__Timestamp">1:20</p> -->
                    </div>
                  </div>
                  <div class="Polaris-MediaCard__InfoContainer d-flex align-items-center">
                    <div class="Polaris-Card__Section">
                      <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingTight">
                        <div class="Polaris-Stack__Item">
                          <div class="Polaris-MediaCard__Heading">
                            <h2 class="Polaris-Heading">{{ $course->title }}</h2>
                          </div>
                        </div>
                        <div class="Polaris-Stack__Item">
                          <p>{{ $course->description }}</p>
                        </div>
                        <div class="Polaris-Stack__Item">
                          <div class="Polaris-MediaCard__ActionContainer">
                            <div class="Polaris-ButtonGroup">
                              <div class="Polaris-ButtonGroup__Item">
                                <div class="Polaris-MediaCard__PrimaryAction">
                                  <a href="{{config('env-variables.APP_PATH')}}courses/{{ $course->id }}" class="Polaris-Button">
                                    <span class="Polaris-Button__Content">
                                      <span class="Polaris-Button__Text">Watch course</span>
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endif
              @endforeach
            </div>
          </div>
        </div>

        <div class="Polaris-Card">
          <div class="Polaris-Card__Section">
            <div class="Polaris-Stack__Item home-review-stack-item">
              <h2 class="Polaris-Heading winning-products-heading text-center">Become A Debutify Partner</h2>
              <p class="review-card-paragraph">Earn lifetime monthly recurring revenue promoting the best Shopify theme on the market.</p>
            </div>
            <br/>
            <div class="Polaris-Stack__Item">
              <div class="Polaris-EmptyState__Section">
                <div class="Polaris-EmptyState__ImageContainer">
                  <img src="/svg/empty-state-14.svg" width="100%" role="presentation" alt="" class="Polaris-EmptyState__Image">
                </div>
                <div class="Polaris-EmptyState__DetailsContainer">
                  <div class="Polaris-Stack__Item">
                    <h2 class="Polaris-Heading">30% Recurring Commission.</h2>
                    <p class="partner-card-paragraph">Create your affiliate link in seconds and start sharing it!</p>
                  </div>
                  <br/>
                  <div class="Polaris-Stack__Item padding-top-5">
                    <img src="/svg/circle-tick.svg" width="20px">
                    30% Lifetime Monthly Commission + Bonuses
                  </div>
                  <div class="Polaris-Stack__Item padding-top-5">
                    <img src="/svg/circle-tick.svg" width="20px">
                    Promote A Tool With a 20% Landing Page Conversion Rate
                  </div>
                  <div class="Polaris-Stack__Item padding-top-5">
                    <img src="/svg/circle-tick.svg" width="20px">
                    Get Paid To Give Value To People
                  </div>
                  <div class="Polaris-Stack__Item">
                    <div class="Polaris-CalloutCard__Buttons">
                      <a class="Polaris-Button Polaris-Button--sizeLarge Polaris-Button--primary" href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target="_blank" data-polaris-unstyled="true">
                        <span class="Polaris-Button__Content">
                          <span>Join Now</span>
                        </span>
                      </a>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="Polaris-Card review-polaris-card testtt">
          <div class="Polaris-Card__Header winning-products-card-header">
            <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
              <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                <h2 class="Polaris-Heading">Leave a review</h2>
              </div>
              <div class="Polaris-Stack__Item">
                <a class="Polaris-Button Polaris-Button--plain review_btn leaveReviewPopup" href="#" data-polaris-unstyled="true" >
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Leave a review</span>
                  </span>
                </a>
              </div>
            </div>
          </div>

          <div class="Polaris-Card__Section">
            <div class="Polaris-CalloutCard">
              <div class="Polaris-CalloutCard__Content">
                <img src="/images/shopify-icon.svg" class="Polaris-CalloutCard__Image mx-auto shopify-review-icon" alt="">
                <img src="/images/stars-5.png" class="Polaris-CalloutCard__Image mx-auto shopify-star-icon" alt="">
                <h2 class="Polaris-Heading text-center">
                  Happy with our service and your results?
                </h2>
                <div class="review-card-paragraph">
                  <p>Share your experience with the community.</p>
                </div>
                <div class="Polaris-CalloutCard__Buttons">
                  <a class="Polaris-Button Polaris-Button--primary shopify-review-button leaveReviewPopup" tabindex="0" href="#" data-polaris-unstyled="true">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Text">Leave a review</span>
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      @include ("components.trustpilot-review-modal")

      @if($updates)
      @include ("components.updates-modal")
      @endif


      @if($is_update_addons || !$script_tags)
          @include ("components.updates-addons-modal")
      @endif


      @endsection

      @section('scripts')
      @parent

      <script type="text/javascript">
        {{--
        ShopifyTitleBar.set({
          title: 'Dashboard',
        });
        --}}

        function reloadWithDelay()
        {
          setTimeout(function(){
            location.reload();
          }, 4000);
        }

        // Webpushr custom attributes name, email
        function _webpushrScriptReady(){
            var email = '{{$email}}';
            var name = '{{$fname}}';
            webpushr('attributes',{"email" : email, "name" : name });
            console.log(email, name);
        }

        _webpushrScriptReady();
      </script>


      <script type="text/javascript">
        $(document).on('click','.download_theme', function(e){
          e.preventDefault();
          $.ajax({
            url: '/app/theme',
            type: 'POST',
            data: $('#download_theme_form').serialize(),
            beforeSend: function(){
            },
            success: function(result) {
              loadingBarCustom(false);

              if(result.status == 'ok'){
                toastNotice = Toast.create(ShopifyApp, {
                  message: result.message,
                  duration: 3000,
                });
                toastNotice.dispatch(Toast.Action.SHOW);
                localStorage.setItem('themeBannerView','yes');
                window.location.href= "/app/add_ons";
              }
              else if(result.status == 'error'){
                toastNotice = Toast.create(ShopifyApp, {
                  message: result.message,
                  duration: 3000,
                  isError: true,
                });
                toastNotice.dispatch(Toast.Action.SHOW);
                window.location.href= "/app";
              }
            }
          });
        });


        $(document).ready(function(){
          $('.hide-review-polaris-card').click(function(){
            $('.review-polaris-card').css('display', 'none');
          });

            $('.review_btn').click(function (e){
                e.preventDefault();
                $.ajax({
                    type:'POST',
                    url:'{{ route('redirect_review') }}',
                    dataType: 'json',
                    data: {"_token": "{{ csrf_token() }}"},
                    success:function(data) {
                        console.log(data.msg);
                        if (data.msg){
                            $('.review_btn').attr('disabled', true);
                        }
                    }
                });
            });

            $('.leaveReviewPopup').click(function(){
              var modal = $("#trustReviewModal");
              openModal(modal);
              loadingBarCustom(false);
            });

            $('.trustReviewModalClose').click(function(){
              location.reload();
            });
        });

      </script>

     @if($updates)
      <script type="text/javascript">
      $(document).ready(function(){
         //Code by Anil
        // show modal
        if('{{$updates->id}}' !== localStorage.getItem("recent_update_number") && '{{ $updates->is_showable }}'){
             localStorage.setItem("recent_update_number",'{{$updates->id}}');
              var modal = $("#UpdateVideoModal");
              modal.find('#video_link').attr('src','{{$updates->video}}'+"?autoplay=1");
              openModal(modal);
        }
      });

      </script>
      @endif

      @if (!$script_tags)
          <script type="text/javascript">
            if( $(".updateShop").hasClass("open") ){} else{
              var modal = $("#updateShopModal");
              openModal(modal);
            }
          </script>
      @elseif($is_update_addons)
          <script type="text/javascript">
            if( $(".updateAddons").hasClass("open") ){} else{
              var modal = $("#updateAddonsModal");
              openModal(modal);
              $('.force_all_addon_update1').click();
            }
          </script>
      @endif

      @if(session()->has('status'))
      <script type="text/javascript">
        ShopifyApp.flashNotice("{{ session('status') }}");
      </script>
      @endif

      @if(session()->has('error'))
      <script type="text/javascript">
        ShopifyApp.flashError("{{ session('error') }}");
      </script>
      @endif

      @endsection
