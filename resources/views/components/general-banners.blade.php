@if(Session::has('unpause_subscription'))
<div class="Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
  <div class="Polaris-Banner__Dismiss"><button type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
    <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
  </svg></span></span></span></button></div>
  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
    <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
    <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
  </svg></span></div>
  <div>
    <div class="Polaris-Banner__Heading" id="Banner3Heading">
      <p class="Polaris-Heading">{{ Session::get('unpause_subscription') }}</p>
    </div>
  </div>
</div>
{{--
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ Session::get('unpause_subscription') }}
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
--}}
@endif


@if(isset($is_paused) && $is_paused != false)
   <div class="Polaris-Banner Polaris-Banner--statusCritical Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="PolarisBanner8Heading" aria-describedby="PolarisBanner8Content">
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorRedDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <path d="M2 10c0-1.846.635-3.543 1.688-4.897l11.209 11.209A7.954 7.954 0 0 1 10 18c-4.411 0-8-3.589-8-8zm14.312 4.897L5.103 3.688A7.954 7.954 0 0 1 10 2c4.411 0 8 3.589 8 8a7.952 7.952 0 0 1-1.688 4.897zM0 10c0 5.514 4.486 10 10 10s10-4.486 10-10S15.514 0 10 0 0 4.486 0 10z"></path>
        </svg></span></div>
    <div class="Polaris-Banner__ContentWrapper">
      <div class="Polaris-Banner__Heading" id="PolarisBanner8Heading">
        <p class="Polaris-Heading">Hey {{$fname}}</span> 👋 Your {{ $paused_plan_name }} Plan Is Paused!</p>
        <p>Unpause your plan to get all your old settings back.</p>
      </div>
      
      @if(!$master_shop)
      <div class="Polaris-Banner__Content" id="PolarisBanner8Content">
        <div class="Polaris-Banner__Actions">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <button type="button" onclick="window.location='{{ route('unpause_subscription') }}'" class="Polaris-Button Polaris-Button--outline btn-loading"><span class="Polaris-Button__Content "><span class="Polaris-Button__Text">Unpause my plan now!</span></span></button>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
@endif

@include('components.trial-banner')

<!-- if trial plan changed to free plan -->
@if(!$sub_plan && $trial_days == 0)
    <div class="Polaris-Banner Polaris-Banner--withinPage Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner6Heading" aria-describedby="Banner6Content">
        <div class="Polaris-Banner__Ribbon">
            <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></svg></span>
        </div>
        <div>
            <div class="Polaris-Banner__Heading" id="Banner6Heading">
                <p class="Polaris-Heading"><span class="text-capitalize">{{$fname}}</span>, get back everything you've built with Debutify</p>
            </div>
            <div class="Polaris-Banner__Content" id="Banner6Content">
                <p>Get all your settings back, exactly like you left them. Choose your plan today, for as low as $19/mo. Cancel anytime in 30 days.</p>
                <div class="Polaris-Banner__Actions">
                    <div class="Polaris-ButtonGroup">
                        <div class="Polaris-ButtonGroup__Item">
                            <div class="Polaris-Banner__PrimaryAction">
                                <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--outline">
                                    <span class="Polaris-Button__Content">
                                      <span class="Polaris-Button__Text">Choose plan now</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- endif -->


<!-- if subscription status == past due -->
@if($subscription_status == 'past_due' && !$master_shop)
<div class="subscriptionPastdueBanner Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner6Heading" aria-describedby="Banner6Content">
  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
        <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
      </svg></span></div>
  <div>
    <div class="Polaris-Banner__Heading" id="Banner6Heading">
      <p class="Polaris-Heading">Failed payment: your account will be frozen in 14 days</p>
    </div>
    <div class="Polaris-Banner__Content" id="Banner6Content">
      <p>Please add funds to your credit card or update your payment method to prevent your account from being frozen.</p>
      <div class="Polaris-Banner__Actions">
        <div class="Polaris-ButtonGroup">
          <div class="Polaris-ButtonGroup__Item">
            <div class="Polaris-Banner__PrimaryAction">
              @hasSection('view-plans')
              <button type="button" class="Polaris-Button Polaris-Button--outline" onclick="return openUpdateCardModal();">
                <span class="Polaris-Button__Content">
                  <span class="Polaris-Button__Text">Update payment method</span>
                </span>
              </button>
              @else
              <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--outline">
                <span class="Polaris-Button__Content">
                  <span class="Polaris-Button__Text">Update payment method</span>
                </span>
              </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endif
<!-- endif -->

@if($master_shop)
<!-- child account banner -->
<div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner6Heading" aria-describedby="Banner6Content">
  <div class="Polaris-Banner__Dismiss"><button type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
              <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
            </svg></span></span></span></button></div>
  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <circle cx="10" cy="10" r="9" fill="currentColor"></circle>
        <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path>
      </svg></span></div>
  <div>
    <div class="Polaris-Banner__Heading" id="Banner6Heading">
      <p class="Polaris-Heading">This store is managed by {{$master_shop}}</p>
    </div>
    <div class="Polaris-Banner__Content" id="Banner6Content">
      <p>To change subscription settings, please <a href="https://{{$master_shop}}/admin/apps/debutify/app/plans" target="_blank" class="Polaris-Link Polaris-Link--monochrome">login to your master account</a>.</p>
    </div>
  </div>
</div>
@endif

@if($is_beta_user == true)
<!-- child account banner -->

<div class="beta_theme_info Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner6Heading" aria-describedby="Banner6Content">
  {{--<div class="Polaris-Banner__Dismiss"><button onclick="return closeAlert('beta_theme_info')"  type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
              <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
            </svg></span></span></span></button></div>--}}
  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <circle cx="10" cy="10" r="9" fill="currentColor"></circle>
        <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path>
      </svg></span></div>
  <div>
    <div class="Polaris-Banner__Heading" id="Banner6Heading">
      <p class="Polaris-Heading">Your store is on the BETA plan for the next {{$trial_days}} days</p>
    </div>
    <div class="Polaris-Banner__Content" id="Banner6Content">
      <p>Your current plan has been temporarily paused while you are testing the new features and will resume as usual once your BETA period is over. Please contact our customer support if you have any questions. <a href="{{ route('support')}}" target="_blank">Contact support</a></p>
    </div>

    <div class="Polaris-Banner__Content" id="Banner6Contentt">
        <h3> <span class="Polaris-Heading">Thank you for helping us make Debutify better! 👉</span>
                  <span><a href="https://feedback.debutify.com/b/beta/" target="_blank" class="Polaris-Link"> Click here to report any issues you may find</a></span>
        </h3>
    </div>
  </div>
</div>
@endif

@hasSection('bannerTitle')
<!-- page banner -->
<div class="Polaris-Banner courseAlert Polaris-Banner--hasDismiss Polaris-Banner--statusWarning Polaris-Banner--withinPage pageBanner" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner10Heading" aria-describedby="Banner10Content">
  <div class="Polaris-Banner__Dismiss">
    <button onclick="return closeAlert('courseAlert')" type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly dismiss-banner" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
      </svg></span></span></span>
    </button>
  </div>
  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
      <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
      <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
    </svg></span>
  </div>
  <div>
    <div class="Polaris-Banner__Heading" id="Banner10Heading">
      <p class="Polaris-Heading"><span class="text-capitalize">@yield('title')</span> @yield('bannerTitle')</p>
    </div>
    <div class="Polaris-Banner__Content" id="Banner10Content">
      <p>If you would like to benefit from @yield('title'), you need to <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">@yield('bannerLink')</a></p>
    </div>
  </div>
</div>
@endif

    @php
      $route_name = ['theme_view', 'thankyou','goodbye', 'cancel_subscription','create_subscription','free_trial_expired'];
      $name = Route::currentRouteName();
    @endphp

    @if(!in_array($name, $route_name) && $new_update_theme == 0 && count($store_themes))
        {{-- @if (session('new_version')) --}}
        <!-- New theme update banner -->
    <div class="newThemeVersionBanner Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content" style="display: none;">
      <div class="Polaris-Banner__Dismiss"><button onclick="return new_update_theme_available()"  type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
      </svg></span></span></span></button></div>
      <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
        <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
      </svg></span></div>
      <div>

        <div class="Polaris-Banner__Heading" id="Banner3Heading">
          <p class="Polaris-Heading">New Debutify {{ $version }} update available.</p>
        </div>
        <div class="Polaris-Banner__Content" id="Banner3Content">
          <div class="Polaris-Banner__Actions">
            <div class="Polaris-ButtonGroup">
              <div class="Polaris-ButtonGroup__Item">
                <div class="Polaris-Banner__PrimaryAction">
                  <a href="{{ route('theme_view')}}" class="Polaris-Button Polaris-Button--outline">
                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Add Debutify {{ $version }}</span></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        @endif
    {{-- @endif --}}
