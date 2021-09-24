@if($trial_days && !$master_shop && $is_beta_user != true) 
<!--Trial activated banner -->
    @if($trial_days <= 3)
    <div id="sticky" style="display: none;" class="banner-trial Polaris-Banner Polaris-Banner--statusCritical Polaris-Banner--withinPage Polaris-Banner--hasDismiss" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner2Heading" aria-describedby="Banner2Content">
    @elseif($trial_days >= 4 && $trial_days <= 7)
    <div id="sticky" style="display: none;" class="banner-trial Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage Polaris-Banner--hasDismiss" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner2Heading" aria-describedby="Banner2Content">
    @elseif($trial_days == 8)
    <div id="sticky" style="display: none;" class="banner-trial Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--withinPage Polaris-Banner--hasDismiss" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner2Heading" aria-describedby="Banner2Content">
    @else
    <div id="sticky" style="display: none;" class="banner-trial Polaris-Banner Polaris-Banner--withinPage Polaris-Banner--hasDismiss" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner2Heading" aria-describedby="Banner2Content">
    @endif
    <!--Dismiss Icon-->
        <div class="Polaris-Banner__Dismiss">
            <button type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Icon">
                        <span class="Polaris-Icon">
                          <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                            <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                          </svg>
                        </span>
                      </span>
                    </span>
            </button>
        </div>
        <!--Banner Ribbon-->
        <div class="Polaris-Banner__Ribbon">
            @if($trial_days <= 3)
                <span class="Polaris-Icon Polaris-Icon--colorRedDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><circle fill="currentColor" cx="10" cy="10" r="9"></circle><path d="M2 10c0-1.846.635-3.543 1.688-4.897l11.209 11.209A7.954 7.954 0 0 1 10 18c-4.411 0-8-3.589-8-8m14.312 4.897L5.103 3.688A7.954 7.954 0 0 1 10 2c4.411 0 8 3.589 8 8a7.952 7.952 0 0 1-1.688 4.897M0 10c0 5.514 4.486 10 10 10s10-4.486 10-10S15.514 0 10 0 0 4.486 0 10"></path></svg></span>
            @elseif($trial_days >= 4 && $trial_days <= 7)
                <span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><circle fill="currentColor" cx="10" cy="10" r="9"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path></svg></span>
            @elseif($trial_days == 8)
                <span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><circle fill="currentColor" cx="10" cy="10" r="9"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path></svg></span>
            @else
                <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></svg></span>
            @endif
        </div>

        <div>
            <!--Banner Heading-->
            <div class="Polaris-Banner__Heading" id="Banner2Heading">
                @if($trial_days <= 1)
                    <p class="Polaris-Heading">Your free trial ends today</p>
                @elseif($trial_days == 2)
                    <p class="Polaris-Heading"><span class="text-capitalize">{{$fname}}</span>, your trial ends tomorrow</p>
                @elseif($trial_days == 3)
                    <p class="Polaris-Heading"><span class="text-capitalize">{{$fname}}</span>, your trial ends in less than 72 hours</p>
                @elseif($trial_days >= 4 && $trial_days <= 7)
                    <p class="Polaris-Heading">Your Master trial ends in {{$trial_days}} days</p>
                @elseif($trial_days == 8)
                    <p class="Polaris-Heading">You're halfway through your free trial</p>
                @else
                    <p class="Polaris-Heading">{{$trial_days}} days left on your free trial</p>
                @endif
            </div>
            <!--Banner Text-->
            <div class="Polaris-Banner__Content" id="Banner2Content">
                @if($trial_days <= 1)
                    <p><span class="text-capitalize">{{$fname}}</span>, you only have a few hours until you're downgraded to free. Choose a plan now to avoid losing everything you've built with Debutify. Cancel anytime in 30 days.</p>
                @elseif($trial_days == 2)
                    <p>Once your free trial is over, you will be downgraded to Free. Choose a plan today to keep building your store. Cancel anytime in 30 days.</p>
                @elseif($trial_days == 3)
                    <p>Don't lose everything you've worked on. Pick any plan today, <b>starting as low as $19/mo.</b> Cancel anytime in 30 days.</p>
                @elseif($trial_days >= 4 && $trial_days <= 7)
                    <p><span class="text-capitalize">{{$fname}}</span>, your trial is almost over. Choose a plan today to keep building your store. <b>Starting as low as $19/mo.</b></p>
                @elseif($trial_days == 8)
                    <p><span class="text-capitalize">{{$fname}}</span>, your free trial is half way done! To avoid losing your favorite features, pick a plan today. <b>Starting as low as $19/mo.</b></p>
                @else
                    <p><span class="text-capitalize">{{$fname}}</span>, your free Master trial ends in {{$trial_days}} days. Choose your plan now to avoid losing your favorite features.</p>
            @endif
            <!--Banner CTAs-->
                <div class="Polaris-Banner__Actions">
                    <div class="Polaris-ButtonGroup">
                        <div class="Polaris-ButtonGroup__Item">
                            <div class="Polaris-Banner__PrimaryAction">
                                @if($trial_days <= 3)
                                    <a href="/app/plans" class="Polaris-Button Polaris-Button--outline">
                                      <span class="Polaris-Button__Content">
                                        <span class="Polaris-Button__Text">Choose plan now</span>
                                      </span>
                                    </a>
                                    <button type="button" class="Polaris-Button Polaris-Button--plain ml-1">
                                        <a href="/app/support" class="Polaris-Button Polaris-Button--outline">
                                          <span class="Polaris-Button__Content">
                                            <span class="Polaris-Button__Text">Contact support</span>
                                          </span>
                                        </a>
                                    </button>
                                @elseif($trial_days <= 7)
                                    <a href="/app/plans" class="Polaris-Button Polaris-Button--outline">
                                        <span class="Polaris-Button__Content">
                                          <span class="Polaris-Button__Text">Compare plans now</span>
                                        </span>
                                    </a>
                                    @if($active_add_ons <= 0 && $trial_days > 7)
                                        <a href="/app/plans" class="Polaris-Button Polaris-Button--plain ml-1">
                                            <span class="Polaris-Button__Content">
                                              <span class="Polaris-Button__Text">Choose plan now</span>
                                            </span>
                                        </a>
                                    @else
                                        <a href="/app/courses" class="Polaris-Button Polaris-Button--plain ml-1">
                                            <span class="Polaris-Button__Content">
                                              <span class="Polaris-Button__Text">Watch marketing courses</span>
                                            </span>
                                        </a>
                                    @endif
                                @else
                                    @if($active_add_ons <= 0)
                                        <a href="/app/plans" class="Polaris-Button Polaris-Button--outline">
                                            <span class="Polaris-Button__Content">
                                              <span class="Polaris-Button__Text">Choose plan now</span>
                                            </span>
                                        </a>
                                    @else
                                        <a href="/app/courses" class="Polaris-Button Polaris-Button--outline">
                                            <span class="Polaris-Button__Content">
                                              <span class="Polaris-Button__Text">Watch marketing courses</span>
                                            </span>
                                        </a>
                                    @endif
                                    <a href="/app/winning-products" class="Polaris-Button Polaris-Button--plain ml-1">
                                        <span class="Polaris-Button__Content">
                                          <span class="Polaris-Button__Text">Find winning products</span>
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
