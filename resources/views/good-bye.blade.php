@extends('layouts.debutify')
@section('title','Good Bye')
@section('good-bye','good-bye')

@section('styles')
<style>
 #dashboard{
    min-height: 80vh;
  }
  .Polaris-Page-Header,.Polaris-FooterHelp{
    display:none;
  }
  .page-container{
    margin-left: 0px;
  }
  .main{
    margin-top: 0px;
  }
</style>
@endsection

@section('content')

@php
if($is_paused == 1){
  $alladdons_plan  = $paused_plan_name;
}

$plan_price = "";
  if ($alladdons_plan == $starter) {
    $plan_price = $starterPriceMonthly;
  }elseif ($alladdons_plan == $hustler) {
    $plan_price = $hustlerPriceMonthly;
  }elseif ($alladdons_plan == $guru) {
    $plan_price = $guruPriceMonthly;
  }
@endphp


<div class="Polaris-Page__Content">
  <div id="dashboard">
    <h1> {{session('error')}}</h1>

    @if( request()->get('subscription') == null)
    <section class="subscription-cancel">
      <div class="Polaris-Card">
        <div class="Polaris-CalloutCard__Container">
          <div class="Polaris-Card__Section p-5">
              <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-5">Are you sure you want to cancel? </h2>
              <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="PolarisBanner6Heading" aria-describedby="PolarisBanner6Content">
                  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 11a1 1 0 102 0V9a1 1 0 10-2 0v2zm0 4a1 1 0 102 0 1 1 0 00-2 0zm8.895 1.549l-7-14.04c-.339-.679-1.45-.679-1.79 0l-7 14.04A1.004 1.004 0 003 18h14a1 1 0 00.895-1.451z"></path>
                      </svg></span></div>
                  <div class="Polaris-Banner__ContentWrapper">
                    <div class="Polaris-Banner__Heading" id="PolarisBanner6Heading">
                      <p class="Polaris-Heading"><b>Warning:</b> Canceling your plan could <b>plummet</b> your conversions</p>
                    </div>
                  </div>
                </div>
              <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall">
                <p>
                  {{ $shopify_shop_data['shop_owner'] }}, we want to help you succeed. However, if you choose to cancel {{ $alladdons_plan }} plan, your conversion rate could <strong>plummet overnight.</strong>
                </p>
                <p>
                Why not keep sales coming in? Remember, you can always cancel your monthly subscription if you decide to quit.</p>
              </div>
              <div class="text-center mt-5">
               <button type="button" class="Polaris-Button Polaris-Button--primary download_theme btn-loading" onclick="window.location='{{ route("plans") }}'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Take me back</span></span></button>
             </div>
          </div>
          <hr>
          <div class="Polaris-Card__Section p-5">
             <h2 class="Polaris-DisplayText--sizeLarge text-center">If you decide to cancel, we'll have to revoke Debutify's best features from your store.</h2>
                  <div class="row justify-content-center">
                    <div class="col-md-10">
                      <div class="row text-center mt-4 mb-5">
                        @if($alladdons_plan == $starter)
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('theme_addons') }}" class="text-body d-block">
                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="80" height="80">
                              <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">5 Conversion-boosting Add-Ons</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('technical_support') }}" class="text-body d-block">
                            <img src="/images/Icon_3-Priority-technical-support.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Technical support</p>
                             {{--  <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                                <p>You’ll lose Debutify’s premium sales Add-Ons, hence your conversion rate and profits could plummet overnight.</p>
                              </div> --}}
                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('winning_products') }}" class="text-body d-block">
                            <img src="/images/Icon_4-Full-product-research-tool.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Basic product research tool</p>

                          </a>
                        </div>
                        @endif
                        @if($alladdons_plan == $hustler)
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('theme_addons') }}" class="text-body d-block">
                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">30 Conversion-boosting Add-Ons</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('technical_support') }}" class="text-body d-block">
                            <img src="/images/Icon_3-Priority-technical-support.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Technical support</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('winning_products') }}" class="text-body d-block">
                            <img src="/images/Icon_4-Full-product-research-tool.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Product research tool</p>

                          </a>
                        </div>
                        @endif
                        @if($alladdons_plan == $guru)
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('theme_addons') }}" class="text-body d-block">
                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">{{ $addon_infos_count }} Conversion-boosting Add-Ons</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('app_courses') }}" class="text-body d-block">
                            <img src="/images/Icon_2-Exclusive-traning-courses.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Exclusive training courses</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('technical_support') }}" class="text-body d-block">
                            <img src="/images/Icon_3-Priority-technical-support.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Priority technical support</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('winning_products') }}" class="text-body d-block">
                            <img src="/images/Icon_4-Full-product-research-tool.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Full product research tool</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('mentoring') }}" class="text-body d-block">
                            <img src="/images/Icon_5-Private 1-on-1-mentoring.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Private 1-on-1 Mentoring Group</p>

                          </a>
                        </div>
                        <div class="col-md-4 mb-4">
                          <a href="{{ route('mentoring') }}" class="text-body d-block">
                            <img src="/images/Icon_6-Chance-for 1-on-1-mentoring-call.png" width="80" height="80">
                            <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall mt-4 mb-3">Chance for 1-on-1 mentoring call</p>

                          </a>
                        </div>
                        @endif
                      </div>
                      </div>
                  </div>
                  <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued text-center mb-4">
                      <p>
                      Keep Debutify's best features on your store. Cancel anytime, whenever you like.</p>
                    </div>
                    <div class="text-center">
                      <button type="button" class="Polaris-Button Polaris-Button--primary download_theme btn-loading" onclick="window.location='{{ route("plans") }}'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Take me back</span></span></button>
                      <div class="mt-4">
                        <a id="cancel-btn" href="{{ route('goodbye') }}/?subscription=feedback" class="Polaris-Button Polaris-Button--plain">
                          <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No, I still want to cancel!</span></span>
                        </a>
                      </div>
                    </div>
                </div>
    </div>
  </div>
</section>
@endif



@if( request()->get('subscription') != null && request()->get('subscription') == 'feedback')
<section class="subscription-feedback-cancel">
  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section p-5">
        <div class="Polaris-SkeletonPage--narrowWidth ml-auto mr-auto">
          <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4">Sorry to hear that.</h2>
          <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall h4">
            <p>We hope you've enjoyed all the features of {{ $alladdons_plan }} plan. Before you cancel your plan, can you tell us what went wrong?</p>
          </div>
        </div>
        <div class="mt-5">
        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScy9GOjY_qNs9KC-1c7mL1t0vAKr1NbfV2PXRgAciiEk5nF8g/viewform?embedded=true&usp=pp_url&entry.1259007286={{$shopify_shop_data['customer_email']}}" width="100%" height="772" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
        </div>
      </div>
      <div class="Polaris-Card__Footer">
        <div class="Polaris-ButtonGroup">
          <div class="Polaris-ButtonGroup__Item mr-sm-4">
            <button type="button" class="Polaris-Button Polaris-Button--plain">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text"><a id="changed-mind-btn" href="{{ route('plans') }}">I changed my mind</a> </span>
              </span>
            </button>
          </div>

          @if(auth()->user()->has_taken_free_subscription && $pause_subscription == 1)

          <div class="Polaris-ButtonGroup__Item">
            <button type="button" class="Polaris-Button Polaris-Button--destructive download_theme btn-loading" onclick="return cancel_subscription();"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">I still want to cancel</span></span></button>
          </div>

          @else
          <div class="Polaris-ButtonGroup__Item">
            <button type="button" class="Polaris-Button Polaris-Button--destructive download_theme btn-loading" onclick="window.location='{{ route("goodbye") }}?subscription=save'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">I still want to cancel</span></span></button>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<div class="Polaris-ButtonGroup__Item btn-uninstall" style="display:none;">
  <form action="{{ route('cancel_all_subscription') }}" method="post" id="cancel_form">
    @csrf
    <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
      <div style="" class="Polaris-Stack__Item">
        <div class="Polaris-ButtonGroup">
          <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--plain">
            <input type="hidden" name="sub_plan" value='{{ $sub_plan == "month" ? "month" : "Yearly" }}'>
            <input type="hidden" name="cancel_subscription" value="cancel">
            <input type="hidden" name="email" id="email" value="{{ $owner_details['email'] }}" />
            <button type="button" class="Polaris-Button Polaris-Button--destructive btn-cancel-subscription disable-while-loading" onclick="return openCancelModal('{{$store_count}}','{{ $sub_plan }}','{{ $trial_end_date }}');">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text">Cancel subscription</span>
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

@if( request()->get('subscription') != null && request()->get('subscription') == 'save')
<section class="subscription-save-cancel-section">
  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section p-5">
        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-5">That's okay! We know running an ecom store can be difficult.</h2>
        @if(getPaymentPlatform()=='stripe')
        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall">
          <p>
            We want to help you overcome the burdens and keep your journey going. Take a look at the
             @if(!auth()->user()->has_taken_free_subscription)
                two options
             @else
               option
             @endif
        we've outlined for you below.</p>
        </div>
        <div class="@if(!auth()->user()->has_taken_free_subscription)row @endif @if(!auth()->user()->has_taken_free_subscription)mt-3 @else mt-5 @endif mb-5">
            <div class="Polaris-Card">
                <div class="Polaris-CalloutCard__Container">
                    <div class="row Polaris-Card__Section p-5">
                          @if(!auth()->user()->has_taken_free_subscription)

                          <div class="@if($pause_subscription != 1)col-md-6 border-right @else col-md-12 @endif pr-md-5">
                            <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">

                              @if($sub_plan == 'month')
                                Save ${{ $plan_price }} -- get one month free on us.
                              @elseif($sub_plan == 'Quarterly')
                                Save ${{ $yearly_discount_price }} -- Get 20% on us for your next quarter.
                              @else
                                Save ${{ $yearly_discount_price }} -- Get 20% on us for your next year.
                              @endif

                          </h3>
                            <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued h4 mt-4 mb-5">
                              @if($sub_plan == 'month')
                                <p>Get your next month of {{$alladdons_plan}} plan completely free. If you still decide to quit, feel free to  cancel any time. No obligations.</p>
                               @else
                                <p>Get 20% off on {{$alladdons_plan}} plan. If you still decide to quit, feel free to  cancel any time. No obligations.</p>
                              @endif

                            </div>
                            <div id="free_one_month_subscription">

                            @if($sub_plan == 'month')
                              <a href="{{ route('free_subscription_one_month') }}" style="text-decoration:none">
                                <button type="button" @if(auth()->user()->has_taken_free_subscription) disabled  @endif class="Polaris-Button Polaris-Button--primary btn-loading Polaris-Button--sizeLarge" id="free_on_month"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">I'll take one month free</span></span></button>
                              </a>
                            @elseif($sub_plan == 'Quarterly')
                              <a href="{{ route('free_subscription_one_month') }}" style="text-decoration:none">
                                <button type="button" @if(auth()->user()->has_taken_free_subscription) disabled  @endif class="Polaris-Button Polaris-Button--primary btn-loading Polaris-Button--sizeLarge" id="free_on_month"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Get 20% off next quarter</span></span></button>
                              </a>
                            @else
                              <a href="{{ route('free_subscription_one_month') }}" style="text-decoration:none">
                                <button type="button" @if(auth()->user()->has_taken_free_subscription) disabled  @endif class="Polaris-Button Polaris-Button--primary btn-loading Polaris-Button--sizeLarge" id="free_on_month"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Get 20% off next year</span></span></button>
                              </a>
                            @endif
                            </div>
                          </div>

                          @endif

                          @if($pause_subscription != 1)

{{--                          <div  @if(auth()->user()->has_taken_free_subscription) class="mt-5" @else class="col-md-6 pl-md-5"  @endif>--}}
                            <div  @if(auth()->user()->has_taken_free_subscription) class="" @else class="col-md-6"  @endif>
                            <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">Put my subscription on hold</h3>
                            <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued h4 mt-4 mb-5">
                              <p>Pause all your payments. You won't be able to use {{$alladdons_plan}} plan features, <strong>but all your settings and Add-Ons will remain safe,</strong> just like you left them when you paused.</p>
                            </div>
                            <button class="Polaris-Button--sizeLarge Polaris-Button btn-loading " onclick="window.location='{{ route('pause_subscription') }}'">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Pause my subscription</span>
                              </span>
                            </button>
                          </div>

                          @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(getPaymentPlatform()=='paypal' && $pause_subscription != 1)
              <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall" style="text-align: center">
                  <p> We want to help you overcome the burdens and keep your journey going. Take a look at the option we've outlined for you below.</p>
              </div>
              <div class="row mt-5 mb-5">
                  <div class="Polaris-Card">
                      <div class="Polaris-CalloutCard__Container">
                          <div class="row Polaris-Card__Section p-5">



                                  {{--                          <div  @if(auth()->user()->has_taken_free_subscription) class="mt-5" @else class="col-md-6 pl-md-5"  @endif>--}}
                                  <div>
                                      <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">Put my subscription on hold</h3>
                                      <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued h4 mt-4 mb-5">
                                          <p>Pause all your payments. You won't be able to use {{$alladdons_plan}} plan features, <strong>but all your settings and Add-Ons will remain safe,</strong> just like you left them when you paused.</p>
                                      </div>
                                          <button class="Polaris-Button--sizeLarge Polaris-Button btn-loading " onclick="window.location='{{ route('pause_subscription') }}'">
                                              <span class="Polaris-Button__Content">
                                                <span class="Polaris-Button__Text">Pause my subscription</span>
                                              </span>
                                          </button>
                                  </div>

                          </div>
                      </div>
                  </div>
              </div>
        @endif
          @if(getPaymentPlatform()=='paypal' && $pause_subscription == 1)
          <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall" style="text-align: center">
              <p> We want to help you overcome the burdens and keep your journey going.</p>
          </div>
          @endif
        <div class="text-center mt-4">
          <p>
           <a href="/app/support" class="Polaris-Button Polaris-Button--plain">
            <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Got questions or can't decide? Ask our support team for help!</span></span>
          </a>
          </p>
          <p class="mt-4">
            <a href="" class="Polaris-Button Polaris-Button--plain cancellation_submit">
              <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, please cancel my plan</span></span>
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>



</section>
@endif



@if( request()->get('subscription') != null && request()->get('subscription') == 'paused' && request()->get('alladdons_plan') != null)
<section class="subscription-paused-section">
  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section p-5">
        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4">Your {{ request()->get('alladdons_plan') }} plan is paused!</h2>
        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall">
          <p>
            Your {{ request()->get('alladdons_plan') }} plan is paused. Your store is now running Debutify free plan, but all your {{ request()->get('alladdons_plan') }} plan settings are safe. You can unpause your subscription from dashboard. {{ request()->get('alladdons_plan') }} plan features and payment will be reactivated when you unpause your subscription, and you can keep using it exactly like before. Hooray!</p>
        </div>
      </div>
      <div class="Polaris-Card__Footer">
        <div class="Polaris-ButtonGroup">
          <div class="Polaris-ButtonGroup__Item">
           <button type="button" class="Polaris-Button Polaris-Button--primary disable-while-loading btn-loading close-modal no_take_me_back" onclick="window.location='{{ route("home") }}'">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text">Thanks! Take me to the Dashboard</span>
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@if( request()->get('subscription') != null && request()->get('subscription') == 'free' && request()->get('billing_cycle') != null )
<section class="subscription-free-section">
    <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section p-5">
        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4">
          @if($sub_plan == 'month')
            Your next month of {{$alladdons_plan}} plan is free!
          @elseif($sub_plan == 'Quarterly')
            Your next Quarter of {{$alladdons_plan}} plan is 20% off!
          @else
            Your next Year of {{$alladdons_plan}} plan is 20% off!
          @endif

      </h2>
        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall">
          <p>
          @if($sub_plan == 'month')
            Take the next month on us. Enjoy your Debutify {{$alladdons_plan}} plan completely free until {{ $next_payment_date = date('F d,Y',request()->get('billing_cycle')) }}.
          @elseif($sub_plan == 'Quarterly')
            Enjoy your Debutify {{$alladdons_plan}} plan at 20% discount for next quarter.
          @else
            Enjoy your Debutify {{$alladdons_plan}} plan at 20% discount for next year.
          @endif
            </p>
        </div>
      </div>
      <div class="Polaris-Card__Footer">
        <div class="Polaris-ButtonGroup">
          <div class="Polaris-ButtonGroup__Item">
           <button type="button" class="Polaris-Button Polaris-Button--primary disable-while-loading btn-loading close-modal no_take_me_back" onclick="window.location='{{ route("home") }}'">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text">Thanks! Take me to the Dashboard</span>
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif


@if( request()->get('subscription') != null && request()->get('subscription') == 'cancellation' && request()->get('subscription') != null)
<section class="subscription-free-section">
    <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section p-5">
        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-4">You've cancelled your {{ request()->get('alladdons_plan') }} plan.</h2>
        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall">
          <p>
              {{ request()->get('alladdons_plan') }} plan features will be <strong>deactivated on {{ date('F d,Y') }}.</strong> You still get to keep Debutify for free, forever and you can always get {{ request()->get('alladdons_plan') }} plan back.
            </p>
            <p>
              Simply go to <strong>Apps</strong> > <strong>Debutify</strong> > <strong>Plans</strong>, and pick {{ request()->get('alladdons_plan') }} plan to re-activate.
            </p>
        </div>
      </div>
      <div class="Polaris-Card__Footer">
        <div class="Polaris-ButtonGroup Polaris-Stack__Item--fill Polaris-Stack--alignmentCenter">
          <div class="Polaris-ButtonGroup__Item Polaris-Stack__Item--fill">
            <button type="button" class="Polaris-Button Polaris-Button--plain">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text"><a href="{{ route('home') }}">Take me to the Dashboard</a> </span>
              </span>
            </button>
          </div>
          <div class="Polaris-ButtonGroup__Item">
            <button type="button" class="Polaris-Button Polaris-Button--primary disable-while-loading close-modal btn-loading no_take_me_back" onclick="window.location='{{ route("plans") }}'">
              <span class="Polaris-Button__Content">
                <span class="Polaris-Button__Text">Explore other plans</span>
              </span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif


</div>
</div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">

      $(document).ready(function() {

        var cancelConfirmation = false;
        var cancelFormSubmitted = false;
        var changedMindClicked = false;

        $("a.cancellation_submit").click(function(event) {
          event.preventDefault();

          if (!cancelFormSubmitted) {
            cancelFormSubmitted = true;

            @if (config('env-variables.APP_TRACKING'))
            //unsubscribe tracking
            window.dataLayer.push({'event': 'unsubscribe'});
            @endif

            var forms = document.getElementById('cancel_form');
            forms.submit();
          }
        });

        $("#cancel-btn").click(function(event) {
          event.preventDefault();

          if (!cancelConfirmation) {
            cancelConfirmation = true;
            window.location = '{{ route('goodbye') }}/?subscription=feedback';
          }
        });

        $("#changed-mind-btn").click(function(event) {
          event.preventDefault();

          if (!changedMindClicked) {
            changedMindClicked = true;
            window.location = '{{ route('plans') }}';
          }
        });
      });

      function cancel_subscription(){
              var forms = document.getElementById('cancel_form');
              forms.submit(forms);
      }

    </script>
@endsection
