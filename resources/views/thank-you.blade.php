@extends('layouts.debutify')
@section('title', 'Thank you')
@section('thank-you', 'thank-you')

@section('styles')
    <style>
        #dashboard {
            min-height: 80vh;
        }

        .Polaris-Page-Header,
        .Polaris-FooterHelp {
            display: none;
        }

        .page-container {
            margin-left: 0px;
        }

        .main {
            margin-top: 0px;
        }

    </style>
    @if (config('env-variables.APP_TRACKING'))
        <img src="https://www.shareasale.com/sale.cfm?tracking={{ $tracking }}&amount={{ $amount }}&merchantID=100711&transtype=sale"
            width="1" height="1">
    @endif
@endsection

@section('content')
    <div id="dashboard">
        <!-- subscription form hidden-->
        <form action="" method="post" id="StripeForm" class="d-none">
            @csrf
            <input type="hidden" name="payment_cycle" id="payment_cycle" value="" class="payment_cycle" />
            <input type="hidden" name="subtotal_price" id="subtotal_price" value="" class="subtotal_price" />
            <input type="hidden" name="plan_id" id="plan_id" value="" class="plan_id" />
            <input type="hidden" name="sub_plan" id="sub_plan" value="" class="sub_plan" />
            <input type="hidden" name="alladdons_plan" id="alladdons_plan" value="{{ $alladdons_plan }}" />
            <input type="hidden" name="email" value="{{ $owner_detail }}" />
            <input type="hidden" name="new_coupon" value="" id="addnewcoupon" />

        </form>
        <!-- subscription modal -->

        @if (!session('subscription_upsell'))
            <h1> {{ session('error') }}</h1>
        @endif
        @if (!session('subscription_upsell'))
            <section class="plan-upgradingSection @if ($payment_method=='paypal' ) d-none @endif">
                <div class="Polaris-Card">
                    <div class="Polaris-CalloutCard__Container">
                        <div class="Polaris-Card__Section">
                            <button class="Polaris-Button Polaris-Button--plain mt-4 closeNothanksModal d-none"
                                id="gotoPaypalThankyou">
                                <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, I don't
                                        want to save money</span></span>
                            </button>
                            @if ($alladdons_plan == $starter)
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <h2 class="Polaris-DisplayText--sizeLarge text-center">Congratulations on upgrading
                                            to Debutify {{ $alladdons_plan }}! </h2>

                                        <p class="Polaris-DisplayText--sizeSmall text-center mt-5 mb-5">Unlock 30
                                            sales-boosting Add-Ons, and get access to 390+, winning products with Debutify
                                            Hustler — Now at <strong>30% off</strong> <br>(exclusive one-time offer)</p>
                                        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                                            <p>
                                                Get significantly more sales with 30 sales-boosting Add-Ons, and discover
                                                hundreds of winning products you can sell now with the Product Research
                                                tool.
                                            </p>
                                            <p>
                                                Enjoy your first {{ $first_month_or_year }} of Debutify Hustler at 30% off —
                                                get Hustler now for a low fee of just ${{ $difference }} (save
                                                ${{ $savings }}) Take advantage of this one-time offer and upgrade now.
                                            </p>
                                        </div>

                                        <div class="media pl-5 pr-5 mb-5 mt-5">
                                            <img src="/images/testimonials.png" class="mr-4 rounded-circle">
                                            <div class="media-body">
                                                <p class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </p>
                                                <p class="Polaris-TextStyle--variationStrong font-italic mt-2 mb-3">Only a
                                                    few days into the theme but has been a great transition from the
                                                    Debutify theme. Support have been extremely helpful in the change over.
                                                </p>
                                                
                                                <p class="Polaris-TextStyle--variationSubdued">Alex Serrano, Debutify
                                                    Hustler user</p>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            @if (getPaymentPlatform() == 'stripe')
                                                <p class="Polaris-TextStyle--variationSubdued mb-5">One-time discount -- you
                                                    may not receive this offer again</p>
                                                <div class="d-none showOnClick"
                                                    style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                                                    <button type="button"
                                                        class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading Polaris-Button--disabled Polaris-Button--loading"
                                                        disabled=""><span class="Polaris-Button__Content"><span
                                                                class="Polaris-Button__Spinner"><span
                                                                    class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg
                                                                        viewBox="0 0 20 20"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z">
                                                                        </path>
                                                                    </svg></span><span role="status"><span
                                                                        class="Polaris-VisuallyHidden">Loading</span></span></span><span
                                                                class="Polaris-Button__Text">Yes! I want to upgrade to
                                                                {{ $next_plan }} and save
                                                                ${{ $savings }}</span></span></button>
                                                </div>

                                                <div
                                                    style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

                                                    <button type="button"
                                                        class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading"
                                                        onclick="return makePaymentDirect('{{ $master_shop }}','{{ $hustler }}','{{ $hustlerPriceMonthly }}','{{ $hustlerPriceQuarterly }}','{{ $hustlerPriceAnnually }}','{{ $hustleridMonthly }}','{{ $hustleridQuarterly }}','{{ $hustleridAnnually }}','{{ $active_add_ons }}','{{ $hustlerLimit }}','0','{{ $sub_plan }}','{{ $all_addons }}','8864215630', this);"><span
                                                            class="Polaris-Button__Content"><span
                                                                class="Polaris-Button__Text">Yes! I want to upgrade to
                                                                {{ $next_plan }} and save
                                                                ${{ $savings }}</span></span></button>

                                                </div>
                                            @endif
                                            <button class="Polaris-Button Polaris-Button--plain mt-4 @if (getPaymentPlatform()=='paypal' ) closeNothanksModal @else opennothanksModal @endif">
                                                <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No
                                                        thanks, I don't want to save money</span></span>
                                            </button>
                                        </div>


                                    </div>
                                </div>
                        </div>
                @endif


        @if ($alladdons_plan == $hustler)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="Polaris-DisplayText--sizeLarge text-center">You're one step away from enjoying Debutify's
                        highest-converting plan</h2>
                    <p class="Polaris-DisplayText--sizeSmall text-center mt-5 mb-5">Your Hustler plan unlocks a tiny portion
                        of the "Master" features your store needs to sell 4, 5 or 6 figures a month. Get the Master plan now
                        at whopping <strong>40% OFF</strong>
                    <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                        <p>
                            {{ $fname }}, your store is now rocking Debutify {{ $alladdons_plan }}. But you're
                            still missing out on Debutify's most popular features. {{ $alladdons_plan }} unlocks only a
                            tiny portion of the features your store needs to sell 4, 5 or 6 figures a month.
                            In fact, you're still missing out on…
                        </p>
                        <ul class="Polaris-List">
                            <li class="Polaris-List__Item">Exclusive mentoring courses, teaching you how to grow your store
                                to 7-figure profit from scratch (Facebook Ads, Google Ads, Shopify store setup, SMS
                                marketing, email marketing and more — all explained inside)</li>
                            <li class="Polaris-List__Item">Priority full support via Facebook, email and 24/7 live chat</li>
                            <li class="Polaris-List__Item">Chance to receive 1-on-1 live mentoring calls with Ricky Hayes,
                                8-figure dropshipper, where he reviews your store and helps you fix your product pages,
                                marketing and ads</li>
                        </ul>
                        <p>All these great features are unlocked in Debutify Master. And judging by our 8,930 Master users,
                            for these features alone you should be upgrading now. But, the benefits of Master don't even
                            stop there…</p>
                        <ul class="Polaris-List">
                            <li class="Polaris-List__Item">You will become a member of the exclusive "Ecom Gods 1-on-1
                                Private Mentoring Group" where Ricky Hayes answers all your questions and gives advice for
                                your store. You can even get your store reviewed by other 6 & 7-figure dropshipping experts
                                — your new group colleagues</li>
                            <li class="Polaris-List__Item">You'll get access to the full Product Research tool, revealing
                                hundreds of golden winning products (complete with an AliExpress link, images, competing
                                stores, Facebook interest targeting and more all included) — with new products added nearly
                                every day…</li>
                        </ul>
                        <p>And did we tell you that Debutify Master users are some of the most successful dropshippers in
                            the world… living life on their own terms.
                            Liel L. has hit well over $552.52k per month in revenue. Silas Nielsen's store brought in over
                            $5,000,000 in sales, and Valentina I. has made over $3M in revenue with her store…</p>
                    </div>
                    <div class="row mt-1 mb-5">
                        <div class="col-md-4"><img class="img-fluid mx-auto d-block" src="/images/ss-month.png"></div>
                        <div class="col-md-4"><img class="img-fluid mx-auto d-block" src="/images/ss-yesterday.png"></div>
                        <div class="col-md-4"><img class="img-fluid mx-auto d-block" src="/images/ss-today.png"></div>
                    </div>
                    <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                        <p>Take the opportunity now to get Debutify's most comprehensive, highest-converting Master plan at
                            a whopping 40% off in your {{ $first_month_or_year }}.</p>
                        <p>Upgrade now for just ${{ $difference }} and save ${{ $savings }}! Upgrade to Master now,
                            while this offer is still valid.</p>
                    </div>
                    <div class="media pl-5 pr-5 mb-5 mt-5">
                        <img src="/images/73x73.png" class="mr-4 rounded-circle">
                        <div class="media-body">
                            <p class="text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </p>
                            <p class="Polaris-TextStyle--variationStrong font-italic mt-2 mb-3">Mirza and Adil are always
                                very helpful and give their best to find the solution and resolve the problem. Thank you.
                            </p>
                            <p class="Polaris-TextStyle--variationSubdued">Moneera Joy Dayrit , Debutify Master user</p>
                        </div>
                    </div>
                    <div class="text-center">
                        @if (getPaymentPlatform() == 'stripe')
                            <p class="Polaris-TextStyle--variationSubdued mb-5">One-time discount -- you may not receive
                                this offer again</p>
                            <div class="d-none showOnClick"
                                style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

                                <button type="button"
                                    class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading Polaris-Button--disabled Polaris-Button--loading"
                                    disabled=""><span class="Polaris-Button__Content"><span
                                            class="Polaris-Button__Spinner"><span
                                                class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z">
                                                    </path>
                                                </svg></span><span role="status"><span
                                                    class="Polaris-VisuallyHidden">Loading</span></span></span><span
                                            class="Polaris-Button__Text">Yes! I want to upgrade to {{ $next_plan }} and
                                            save ${{ $savings }}</span></span></button>

                            </div>
                            <div
                                style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

                                <button type="button"
                                    class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading"
                                    onclick="return makePaymentDirect('{{ $master_shop }}','{{ $guru }}','{{ $guruPriceMonthly }}','{{ $guruPriceQuarterly }}','{{ $guruPriceAnnually }}','{{ $guruidMonthly }}','{{ $guruidQuarterly }}','{{ $guruidAnnually }}','{{ $active_add_ons }}','{{ $guruLimit }}','0','{{ $sub_plan }}','{{ $all_addons }}','4156088664',this);"><span
                                        class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes! I want to
                                            upgrade to {{ $next_plan }} and save
                                            ${{ $savings }}</span></span></button>

                            </div>
                        @endif
                        <button class="Polaris-Button Polaris-Button--plain mt-4 @if (getPaymentPlatform()=='paypal' ) closeNothanksModal @else opennothanksModal @endif">
                            <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, I don't want
                                    to save money</span></span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if ($alladdons_plan == $guru)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="Polaris-DisplayText--sizeLarge text-center">Congrats! Your store is now running Debutify
                        Master!</h2>
                </div>
            </div>

            <div class="Polaris-Card__Section">
                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                            <p>
                                Congratulations, {{ $fname }}! You've made the right choice by upgrading to Debutify
                                Master.
                            </p>

                            <p>You now have access to Debutify {{ $alladdons_plan }} features.</p>
                        </div>
                        <div class="row text-center mt-4 mb-5">
                            @if ($alladdons_plan == $starter)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('theme_addons') }}" class="text-body d-block">
                                        <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">5 Conversion-boosting Add-Ons</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('technical_support') }}" class="text-body d-block">
                                        <img src="/images/Icon_3-Priority-technical-support.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Technical support</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('winning_products') }}" class="text-body d-block">
                                        <img src="/images/Icon_4-Full-product-research-tool.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Basic product research tool</p>
                                    </a>
                                </div>
                            @endif
                            @if ($alladdons_plan == $hustler)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('theme_addons') }}" class="text-body d-block">
                                        <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">30 Conversion-boosting Add-Ons
                                        </p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('technical_support') }}" class="text-body d-block">
                                        <img src="/images/Icon_3-Priority-technical-support.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Technical support</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('winning_products') }}" class="text-body d-block">
                                        <img src="/images/Icon_4-Full-product-research-tool.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Product research tool</p>
                                    </a>
                                </div>
                            @endif
                            @if ($alladdons_plan == $guru)
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('theme_addons') }}" class="text-body d-block">
                                        <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">{{ $addon_infos_count }}
                                            Conversion-boosting Add-Ons</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('app_courses') }}" class="text-body d-block">
                                        <img src="/images/Icon_2-Exclusive-traning-courses.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Exclusive training courses</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('technical_support') }}" class="text-body d-block">
                                        <img src="/images/Icon_3-Priority-technical-support.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Priority technical support</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('winning_products') }}" class="text-body d-block">
                                        <img src="/images/Icon_4-Full-product-research-tool.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Full product research tool</p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('mentoring') }}" class="text-body d-block">
                                        <img src="/images/Icon_5-Private 1-on-1-mentoring.png" width="60" height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Private 1-on-1 Mentoring Group
                                        </p>
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('mentoring') }}" class="text-body d-block">
                                        <img src="/images/Icon_6-Chance-for 1-on-1-mentoring-call.png" width="60"
                                            height="60">
                                        <p class="Polaris-TextStyle--variationStrong mt-2">Chance for 1-on-1 mentoring call
                                        </p>
                                    </a>
                                </div>
                            @endif

                        </div>

                        <div class="Polaris-TextStyle--variationSubdued mb-5">
                            <p>
                                Learn how to use your brand-new features by following our YouTube channel:</p>
                        </div>
                        <div class="text-center">
                            <a target="_blank"
                                href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w?sub_confirmation=1"
                                href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w?sub_confirmation=1"
                                class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge mb-4">
                                <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Subscribe to
                                        Debutify Youtube Channel</span></span>
                            </a>
                            <div>
                                <a href="{{ config('env-variables.APP_PATH') }}" class="Polaris-Button Polaris-Button--plain">
                                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, take
                                            me to the Dashboard</span></span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endif
    </div>
    </div>

    </section>
    @endif

    <section class='plan-activeSection @if (!session(' subscription_upsell') && $payment_method
        !='paypal' ) d-none @endif'>
        <div class="Polaris-Card">
            <div class="Polaris-CalloutCard__Container">
                <div class="Polaris-Card__Section">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">Debutify {{ $alladdons_plan }} is
                                active on your store!</h2>
                            <div class="Polaris-TextStyle--variationSubdued">
                                <p>You now have access to Debutify {{ $alladdons_plan }} features.</p>
                            </div>
                            <div class="row text-center mt-4 mb-5">
                                @if ($alladdons_plan == $starter)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('theme_addons') }}" class="text-body d-block">
                                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">5 Conversion-boosting Add-Ons
                                            </p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('technical_support') }}" class="text-body d-block">
                                            <img src="/images/Icon_3-Priority-technical-support.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Technical support</p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('winning_products') }}" class="text-body d-block">
                                            <img src="/images/Icon_4-Full-product-research-tool.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Basic product research tool
                                            </p>
                                        </a>
                                    </div>
                                @endif
                                @if ($alladdons_plan == $hustler)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('theme_addons') }}" class="text-body d-block">
                                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">30 Conversion-boosting
                                                Add-Ons</p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('technical_support') }}" class="text-body d-block">
                                            <img src="/images/Icon_3-Priority-technical-support.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Technical support</p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('winning_products') }}" class="text-body d-block">
                                            <img src="/images/Icon_4-Full-product-research-tool.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Product research tool</p>
                                        </a>
                                    </div>
                                @endif
                                @if ($alladdons_plan == $guru)
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('theme_addons') }}" class="text-body d-block">
                                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">{{ $addon_infos_count }}
                                                Conversion-boosting Add-Ons</p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('app_courses') }}" class="text-body d-block">
                                            <img src="/images/Icon_2-Exclusive-traning-courses.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Exclusive training courses
                                            </p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('technical_support') }}" class="text-body d-block">
                                            <img src="/images/Icon_3-Priority-technical-support.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Priority technical support
                                            </p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('winning_products') }}" class="text-body d-block">
                                            <img src="/images/Icon_4-Full-product-research-tool.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Full product research tool
                                            </p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('mentoring') }}" class="text-body d-block">
                                            <img src="/images/Icon_5-Private 1-on-1-mentoring.png" width="60" height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Private 1-on-1 Mentoring
                                                Group</p>
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <a href="{{ route('mentoring') }}" class="text-body d-block">
                                            <img src="/images/Icon_6-Chance-for 1-on-1-mentoring-call.png" width="60"
                                                height="60">
                                            <p class="Polaris-TextStyle--variationStrong mt-2">Chance for 1-on-1 mentoring
                                                call</p>
                                        </a>
                                    </div>
                                @endif

                            </div>
                            <div class="Polaris-TextStyle--variationSubdued mb-5">
                                <p>
                                    Learn how to use your brand-new features by following our YouTube channel:</p>
                            </div>
                            <div class="text-center">
                                <a target="_blank"
                                    href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w?sub_confirmation=1"
                                    class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge mb-4">
                                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Subscribe to
                                            Debutify Youtube Channel</span></span>
                                </a>
                                <div>
                                    <a href="{{ config('env-variables.APP_PATH') }}" class="Polaris-Button Polaris-Button--plain">
                                        <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks,
                                                take me to the Dashboard</span></span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

    <div id="nothanksModal" class="modal fade-scales">
        <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">

                <div class="Polaris-Modal__BodyWrapper">
                    <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical text-center"
                        data-polaris-scrollable="true" style="padding: 6rem;">
                        @if ($alladdons_plan == $starter)
                            <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">Are you sure you want to miss this
                                opportunity?</h2>
                        @endif
                        @if ($alladdons_plan == $hustler)
                            <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">Are you sure? Upgrade now and save
                                <del>${{ $savings }} </del>${{ $savings_extra10 }}</h2>
                        @endif


                        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                            @if ($alladdons_plan == $starter)
                                <p>Upgrade to Debutify Hustler now at <del>30% off</del> 40% off in your
                                    {{ $first_month_or_year }}! a low fee of just ${{ $difference_extra10 }} for 390+
                                    winning products and all conversion-boosting apps! </p>
                                <p>Take this opportunity now and save ${{ $savings_extra10 }}!</p>
                            @endif
                            @if ($alladdons_plan == $hustler)
                                <p>Get the Debutify's highest-converting features, premium training courses and membership
                                    now at <del><strong>40% off</strong></del>
                                    <span class="text-primary"><strong>50% off</strong></span> in your first
                                    {{ $first_month_or_year }}!
                                </p>
                                <p>Take this opportunity now and save <strong>${{ $savings_extra10 }}!</strong></p>
                            @endif

                        </div>
                        <div class="mb-5 mt-5">
                            <img src="/images/users1.png" class="mr-4 rounded-circle">
                            <img src="/images/users2.png" class="mr-5 rounded-circle">
                            <img src="/images/users3.png" class="mr-4 rounded-circle">
                            <p class="text-uppercase text-muted mt-2"><strong>{{ $user_count }} users have taken this
                                    offer</strong></p>
                        </div>
                        <div class="d-none showOnClick"
                            style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
                            <button type="button"
                                class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading Polaris-Button--disabled Polaris-Button--loading"
                                disabled=""><span class="Polaris-Button__Content"><span
                                        class="Polaris-Button__Spinner"><span
                                            class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z">
                                                </path>
                                            </svg></span><span role="status"><span
                                                class="Polaris-VisuallyHidden">Loading</span></span></span><span
                                        class="Polaris-Button__Text">Yes! I want to upgrade to Hustler and save
                                        $14.10</span></span></button>
                        </div>
                        @if ($alladdons_plan == $starter)
                            <div
                                style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

                                <button type="button"
                                    class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading"
                                    onclick="return makePaymentDirect('{{ $master_shop }}','{{ $hustler }}','{{ $hustlerPriceMonthly }}','{{ $hustlerPriceQuarterly }}','{{ $hustlerPriceAnnually }}','{{ $hustleridMonthly }}','{{ $hustleridQuarterly }}','{{ $hustleridAnnually }}','{{ $active_add_ons }}','{{ $hustlerLimit }}','0','{{ $sub_plan }}','{{ $all_addons }}','4156088664', this);"><span
                                        class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes! I want to
                                            upgrade to {{ $next_plan }} and save
                                            ${{ $savings_extra10 }}</span></span></button>
                            </div>
                            <button
                                class="closeNothanksModal Polaris-Button Polaris-Button--plain Polaris-Modal-CloseButton">
                                <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, I still
                                        don't want Hustler</span></span>
                            </button>
                    </div>
                    @endif
                    @if ($alladdons_plan == $hustler)
                        <div
                            style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">

                            <button type="button"
                                class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading"
                                onclick="return  makePaymentDirect('{{ $master_shop }}','{{ $guru }}','{{ $guruPriceMonthly }}','{{ $guruPriceQuarterly }}','{{ $guruPriceAnnually }}','{{ $guruidMonthly }}','{{ $guruidQuarterly }}','{{ $guruidAnnually }}','{{ $active_add_ons }}','{{ $guruLimit }}','0','{{ $sub_plan }}','{{ $all_addons }}','6037353105',this);">
                                <span
                                    class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes! I want to
                                        upgrade to {{ $next_plan }} and save
                                        ${{ $savings_extra10 }}</span></span></button>
                        </div>
                        <a href="#" class="Polaris-Button Polaris-Button--plain closeNothanksModal mt-4"
                            data-dismiss="modal">
                            <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, I still
                                    don't want Master</span></span>
                        </a>
                </div>

                @endif

            </div>

        </div>

    </div>
    <div class="Polaris-Backdrop"></div>
    </div>

    </div>

    </div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        @if (config('env-variables.APP_TRACKING'))
            //purchase tracking
            window.dataLayer.push({
            'dlv_ii_customerId':'{{ $customer_id }}',
            {{-- 'dlv_ii_orderId': '{{$tracking}}', --}}
            'dlv_ii_orderId': '{{ $subscription_id }}',
            'dlv_ii_customerEmail': '{{ $customer_email_sha1 }}',
            'dlv_ii_orderPromoCode': '{{ $coupon }}',
            'dlv_ii_subTotal': '{{ $amount }}',
            'dlv_ii_category': '{{ $sub_plan }}',
            'dlv_ii_sku': '{{ $alladdons_plan }}',
        
            'subscriptionValue': {{ $amount }},
            'event': 'purchase',
            'subscription_id': '{{ $subscription_id }}',
        
            });
        @endif

        @if (config('env-variables.APP_TRACKING'))
            //subscribe tracking
            window.dataLayer.push({
            'dlv_ii_customerId':'{{ $customer_id }}',
            {{-- 'dlv_ii_orderId': '{{$tracking}}', --}}
            'dlv_ii_orderId': '{{ $subscription_id }}',
            'dlv_ii_customerEmail': '{{ $customer_email_sha1 }}',
            'dlv_ii_orderPromoCode': '{{ $coupon }}',
            'dlv_ii_subTotal': '{{ $amount }}',
            'dlv_ii_category': '{{ $sub_plan }}',
            'dlv_ii_sku': '{{ $alladdons_plan }}',
        
            'subscriptionValue': {{ $amount }},
            'event': 'subscribe',
            'subscription_id': '{{ $subscription_id }}'
            });
        @endif

        // purchase event
        var variant = '';
        @if ($sub_plan == 'month' || $sub_plan == 'Month')
            variant = 'Monthly';
        @elseif ($sub_plan == 'Quarterly' || $sub_plan == 'quarterly')
            variant = 'Quarterly';
        @elseif ($sub_plan == 'Yearly' || $sub_plan == 'yearly')
            variant = 'Annually';
        @endif

        window.dataLayer = window.dataLayer || [];
        dataLayer.push({
            'ecommerce': {
                'currencyCode': 'USD',
                'purchase': {
                    'actionField': {
                        'id': '{{ $tracking }}', // Transaction ID (is required)
                        'revenue': '{{ $revenue }}', // Total transaction value (incl. tax and shipping)
                        'tax': '{{ $tax }}', // Tax amount
                        'coupon': '{{ $coupon }}',
                        'affiliation': '{{ $subscription_id }}'
                    },
                    'products': [{
                        'name': '{{ $alladdons_plan }}', // is require
                        'id': '{{ $plan_id }}', // is required
                        'price': '{{ $amount }}',
                        'variant': variant,
                        'quantity': 1
                    }]
                }
            },

            'event': 'EE-event',
            'EE-event-category': 'Enhanced Ecommerce',
            'EE-event-action': 'Purchase',
            'EE-event-non-interaction': 'False',
        });

        // init shopify title bar
        {{-- ShopifyTitleBar.set({
          title: 'Thank you',
        }); --}}
        $(".opennothanksModal").click(function() {
            var modal = $("#nothanksModal");
            openModal(modal);
        })



        $(".closeNothanksModal").click(function() {
            var modal = $("#nothanksModal").closest(".modal");
            $('.plan-activeSection').removeClass("d-none");
            $('.plan-upgradingSection').addClass("d-none");
            $(".modal").removeClass('open').hide();
            $("body").removeClass("modal-open"); // plan page
            // closeModal(modal);
        });

        $(window).on("load", function() {
            loadingBarCustom(false);
        });


        // all add-ons subscription
        function makePaymentDirect(master_shop, plan_name, monthly_price, quarterly_price, annual_price, monthly_id,
            quarterly_id, annual_id, active_add_ons, plan_limit, active_plan, sub_plan, all_addons, couponCode, sender) {
            //  sender.disabled = true;

            sender.style.display = 'none';
            var domElement = $(sender).parent().parent().parent();


            domElement.find(".showOnClick").removeClass("d-none");
            domElement.find(".spinner-Polaris").removeClass('d-none');
            // Setup modal elements
            // alert(sub_plan);
            $('.plan-name').text(plan_name);
            $('.payment_cycle').val(plan_name);
            $('.annual-price').text((annual_price * 1).toFixed(2));
            $('.quarterly-price').text((quarterly_price * 1).toFixed(2));
            $('.monthly-price').text((monthly_price * 1).toFixed(2));
            $(".annual-discount-money").text("$" + ((monthly_price * 12) - annual_price).toFixed(2) + " USD");
            $(".annual-discount-percentage").text(((annual_price / (monthly_price * 12)) * 100).toFixed(0) + "%");
            $(".quarterly-discount-money").text("$" + ((monthly_price * 12) - (quarterly_price * 4)).toFixed(2) + " USD");
            $(".quarterly-discount-percentage").text(100 - (((quarterly_price * 4) / (monthly_price * 12)) * 100).toFixed(
                0) + "%");
            $('.discounts').text('0.00');
            $('#newCoupon').val('');
            $('.plan-discount').hide();
            $('.showOnnewcoupon').html('');
            $('#addnewcoupon').val('');
            var trialdays = '{{ $trial_days }}';

            // show notice if it's a managed store
            if (master_shop) {
                customToastMessage("This store's subscription is managed by " + master_shop, false);
                {{-- toastNotice = Toast.create(ShopifyApp, {
              message: "This store's subscription is managed by "+master_shop,
              duration: 3000,
              isError: true,
            });
            toastNotice.dispatch(Toast.Action.SHOW); --}}
                return false;
            }
            // hide linked domains if not guru plan
            if (plan_name != "{{ $guru }}") {
                $('.sectionLinkedStore').hide();
            } else {
                $('.sectionLinkedStore').show();
            }

            // setPlanDetails
            var subMonthly = "monthly";
            var subQuarterly = "quarterly";
            var subYearly = "yearly";

            function setPlanDetails(showPlan) {
                // reset values
                $('.discounts').text('0.00');
                $('#newCoupon').val('');
                $('.plan-discount').hide();
                $('.showOnnewcoupon').html('');
                $('#addnewcoupon').val('');
                $('.showOnActivePlan').hide();
                $('.hideOnActivePlan').show();
                $(".plan-prorated").hide();
                $(".plan-balance").hide();
                $(".save-message-monthly").hide();
                $(".save-message-quarterly").hide();
                $(".save-message-annually").hide();

                // calculate proration of subscription for upgrade/downgrade
                function getProration(id, price) {

                    if (all_addons == 1) {
                        var plan_id = id;
                        var plan_price = price;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: "/app/prorateamount",
                            data: {
                                'plan_id': plan_id
                            },
                            type: 'POST',
                            cache: false,
                            success: function(response) {
                                prorated_amount = response.prorated_amount;
                                prorated_amount = prorated_amount * -1;

                                if (prorated_amount) {
                                    var total = plan_price - prorated_amount;
                                    $(".plan-prorated").show();
                                    if (total > 0) {
                                        $('.total-price').text((total).toFixed(2));
                                    } else {
                                        $('.total-price').text("0.00");
                                        $(".plan-balance").show();
                                        $(".prorated-balance").text((total * -1).toFixed(2));
                                    }
                                    $(".prorated-amount").text((prorated_amount).toFixed(2));
                                }
                            }
                        });
                    }
                }

                // show yearly
                if (showPlan == "yearly") {
                    $("#paidAnnuallyRadio").prop('checked', true);
                    $('.plan-price').text((annual_price * 1).toFixed(2));
                    $('.total-price').text((annual_price * 1).toFixed(2));
                    $(".billing-days").text("year");
                    $(".save-message-annually").show();

                    // stripe form
                    $('#plan_id').val(annual_id);
                    $("#subtotal_price").val(annual_price);
                    $('#sub_plan').val("Yearly");
                    // stripe form end

                    // get proration
                    getProration(annual_id, annual_price);

                    if (active_plan == 1) {
                        if (sub_plan == 'Yearly') {
                            $('.showOnActivePlan').show();
                            $('.hideOnActivePlan').hide();
                        } else if (sub_plan == 'month') {
                            $('.showOnActivePlan').hide();
                            $('.hideOnActivePlan').show();
                        }
                    }

                    @if (config('env-variables.APP_TRACKING'))
                        // initiate checkout tracking - annually
                        if(sub_plan != 'Yearly'){
                        if(sessionStorage.getItem("initiateCheckoutYearly")){} else{
                        var subscriptionValue = annual_price;
                        var subscriptionId = annual_id;
                        window.dataLayer.push({
                        'subscriptionValue': subscriptionValue,
                        'subscriptionId': subscriptionId,
                        'event': 'initiate_checkout'
                        });
                        sessionStorage.setItem('initiateCheckoutYearly','yes');
                        };
                        }
                    @endif
                } else if (showPlan == "quarterly") {
                    $("#paidQuarterlyRadio").prop('checked', true);
                    $('.plan-price').text((quarterly_price * 1).toFixed(2));
                    $('.total-price').text((quarterly_price * 1).toFixed(2));
                    $(".billing-days").text("quarter");
                    $(".save-message-quarterly").show();

                    // stripe form
                    $('#plan_id').val(quarterly_id);
                    $("#subtotal_price").val(quarterly_price);
                    $('#sub_plan').val("Quarterly");
                    // stripe form end

                    // get proration
                    getProration(quarterly_id, quarterly_price);

                    if (active_plan == 1) {
                        if (sub_plan == 'Quarterly') {
                            $('.showOnActivePlan').show();
                            $('.hideOnActivePlan').hide();
                        } else if (sub_plan == 'month') {
                            $('.showOnActivePlan').hide();
                            $('.hideOnActivePlan').show();
                        }
                    }

                    @if (config('env-variables.APP_TRACKING'))
                        // initiate checkout tracking - quarterly
                        if(sub_plan != 'Quarterly'){
                        if(sessionStorage.getItem("initiateCheckoutQuarterly")){} else{
                        var subscriptionValue = quarterly_price;
                        var subscriptionId = quarterly_id;
                        window.dataLayer.push({
                        'subscriptionValue': subscriptionValue,
                        'subscriptionId': subscriptionId,
                        'event': 'initiate_checkout'
                        });
                        sessionStorage.setItem('initiateCheckoutQuarterly','yes');
                        };
                        }
                    @endif
                } else if (showPlan == "monthly") { // show monthly
                    $("#paidMonthlyRadio").prop('checked', true);
                    $('.plan-price').text((monthly_price * 1).toFixed(2));
                    $('.total-price').text((monthly_price * 1).toFixed(2));
                    $(".billing-days").text("30 days");
                    $(".save-message-monthly").show();

                    // stripe form
                    $('#plan_id').val(monthly_id);
                    $("#subtotal_price").val(monthly_price);
                    $('#sub_plan').val("month");
                    // stripe form end

                    // get proration
                    getProration(monthly_id, monthly_price);

                    if (active_plan == 1) {
                        if (sub_plan == 'Yearly') {
                            $('.showOnActivePlan').hide();
                            $('.hideOnActivePlan').show();
                        } else if (sub_plan == 'month') {
                            $('.showOnActivePlan').show();
                            $('.hideOnActivePlan').hide();
                        }
                    }

                    @if (config('env-variables.APP_TRACKING'))
                        // initiate checkout tracking - monthly
                        if(sub_plan != 'month'){
                        if(sessionStorage.getItem("initiateCheckoutMonthly")){} else{
                        var subscriptionValue = monthly_price;
                        var subscriptionId = monthly_id;
                        window.dataLayer.push({
                        'subscriptionValue': subscriptionValue,
                        'subscriptionId': subscriptionId,
                        'event': 'initiate_checkout'
                        });
                        sessionStorage.setItem('initiateCheckoutMonthly','yes');
                        };
                        }
                    @endif
                }
            }

            // active plan

            if (sub_plan == 'Yearly') {
                setPlanDetails(subYearly);
                $('.annual-discount-badge').hide();
            } else if (sub_plan == 'Quarterly') {
                setPlanDetails(subQuarterly);
            } else if (sub_plan == 'month') {
                setPlanDetails(subMonthly);
            }
            $('.active-badge').show();

            $("#paidAnnuallyRadio").on("click", function() {
                setPlanDetails(subYearly);
            });

            $("#paidQuarterlyRadio").on("click", function() {
                setPlanDetails(subQuarterly);
            });

            // on click monthly
            $("#paidMonthlyRadio").on("click", function() {
                setPlanDetails(subMonthly);
            });
            $('#addnewcoupon').val(couponCode);
            // set form action
            var form = document.getElementById('StripeForm');

            form.setAttribute("action", "{{ route('upsell_subscription') }}");
            form.submit();

            return false;
        }


        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        $(document).ready(function() {
            setCookie('discount-code', 'BLACKFRIDAY50', 0);
        });

    </script>

    {{-- <script type="text/javascript"> --}}
    {{-- window.dataLayer = window.dataLayer || []; --}}
    {{-- dataLayer.push({ --}}
    {{-- dlv_ii_customerId:'{{$customer_id}}', --}}
    {{-- dlv_ii_orderId: '{{$tracking}}', --}}
    {{-- dlv_ii_customerEmail: '{{$customer_email_sha1}}', --}}
    {{-- dlv_ii_orderPromoCode: '{{$coupon}}', --}}
    {{-- dlv_ii_subTotal: '{{$amount}}', --}}
    {{-- dlv_ii_category: '{{$sub_plan}}', --}}
    {{-- dlv_ii_sku: '{{$alladdons_plan}}', --}}
    {{-- }); --}}
    {{-- </script> --}}
@endsection
