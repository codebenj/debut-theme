@php
$paypal_plan = json_decode($paypal_plan);
$pause_plan_data_plan='';
$pause_plan_data_sub_plan='';
if($pause_plan_data!="")
    {
        $pause_plan_data_plan = $pause_plan_data['plan_name'];
        $pause_plan_data_sub_plan = $pause_plan_data['sub_plan'] == "month"?"Monthly":"";
    }
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr" class="no-js mac chrome desktop page--no-banner page--logo-main page--show page--show card-fields">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height, minimum-scale=1.0, user-scalable=0">
    <meta name="referrer" content="origin">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fav icon ================================================== -->
    <link sizes="192x192" rel="shortcut icon" href="/images/debutify-favicon.png" type="image/png">

    <title>Plan & Subscription</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://unpkg.com/@shopify/polaris@5.10.1/dist/styles.css" />

    <link rel="stylesheet" href="{{ asset('css/app.css?v='.config('env-variables.ASSET_VERSION')) }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css"
          integrity="sha512-wJgJNTBBkLit7ymC6vvzM1EcSWeM9mmOu+1USHaRBbHkm6W9EgM0HY27+UtUaprntaYQJF75rc8gjxllKs5OIQ=="
          crossorigin="anonymous"/>

    @if (config('env-variables.APP_TRACKING'))
        <script>
            window.dataLayer = window.dataLayer || [];
        </script>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-M5BFQ4Q');</script>
        <!-- End Google Tag Manager -->
    @endif
    <style>
        #inputExitIntent{
        outline:none;
        border:none;
        color:#fff;
        height: 0;
        margin: 0;
        padding: 0;
        }

        .terms-action {
            padding: 0px;
        }

        #inputExitIntent::-moz-selection { color: #fff}
        #inputExitIntent::selection { color: #fff; }

        .separator {
            color: grey;
            display: flex;
            align-items: center;
            text-align: center;
        }
        .separator::before, .separator::after {
            content: '';
            flex: 1;
            border-bottom: .1rem solid #0000001c;
        }
        .separator::before {
            margin-right: .25em;
        }
        .separator::after {
            margin-left: .25em;
        }
    </style>

    <!-- Google optimize -->
    <script src="https://www.googleoptimize.com/optimize.js?id=OPT-P8N97L2"></script>

    @if(config('env-variables.IMPACT_ENABLED'))
    {{-- Impact Tag Manager --}}
    <script type="text/javascript">
        (function(a,b,c,d,e,f,g){e['ire_o']=c;e[c]=e[c]||function(){(e[c].a=e[c].a||[]).push(arguments)};f=d.createElement(b);g=d.getElementsByTagName(b)[0];f.async=1;f.src=a;g.parentNode.insertBefore(f,g);})('//d.impactradius-event.com/A2559139-2134-4977-8281-7ed0d8c7c7ef1.js','script','ire',document,window);
    </script>
    {{-- End Impact Tag Manager --}}
    @endif

    <script src="https://www.paypal.com/sdk/js?client-id={{ config('env-variables.PAYPAL_MODE') == 'live' ? config('env-variables.PAYPAL_LIVE_CLIENT_ID') : config('env-variables.PAYPAL_SANDBOX_CLIENT_ID') }}&vault=true&disable-funding=credit,card"></script>
</head>

@php
        $isActivePlan = "";
        $subPlan = "";
        $second_bar = "";
        $active_pause_plan = "";
        if($is_paused == 1){
            if($paused_plan_name == $plan_name){
                $isActivePlan = 1;
                $subPlan = $sub_plan;
                $second_bar = 1;
                $alladdons_plan = $paused_plan_name;
                $active_pause_plan = "Paused Plan";
            }
        }else{
            if($alladdons_plan == $plan_name){
                $isActivePlan = 1;
                $subPlan = $sub_plan;
                $active_pause_plan = "Active Plan";
            }
        }
@endphp


<body class="template-checkoutPage">
<div class="Polaris-SkeletonPage__Page" role="status" aria-label="Page loading">
    <div class="Polaris-SkeletonPage__Content">
        <div class="Polaris-Layout">
            <div class="Polaris-Layout__Section">
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                            <div class="Polaris-SkeletonBodyText"></div>
                            <div class="Polaris-SkeletonBodyText"></div>
                            <div class="Polaris-SkeletonBodyText"></div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Polaris-Layout__Section Polaris-Layout__Section--secondary">
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                            <div class="Polaris-SkeletonBodyText"></div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card Polaris-Card--subdued">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                            <div class="Polaris-SkeletonBodyText"></div>
                            <div class="Polaris-SkeletonBodyText"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="Checkout-Page" id="Checkout-Page" style="display: none">
    <div class="Polaris-Page">
        <div class="Polaris-Page-Header">
            <div class="Polaris-Page-Header__Row" style="justify-content: flex-start">
                <div class="Polaris-Page-Header__BreadcrumbWrapper Polaris-Page-Header--newDesignLanguage">
                    <nav role="navigation">
                        <a class="Polaris-Breadcrumbs__Breadcrumb" href="{{route('plans')}}" data-polaris-unstyled="true">
                            <span class="Polaris-Breadcrumbs__ContentWrapper">
                                <span class="Polaris-Breadcrumbs__Icon">
                                    <span class="Polaris-Icon">
                                       <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                           <path d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414
                                           0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2z"></path>
                                        </svg>
                                    </span>
                                </span>
                            </span>
                        </a>
                    </nav>
                </div>
                <div class="Polaris-Page-Header__TitleWrapper">
                    <div>
                        <div class="Polaris-Header-Title__TitleAndSubtitleWrapper">
                            <div class="Polaris-Header-Title">
                                <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium setFontWeight">Confirm <span class="plan-name"></span> plan</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Page-Header__RightAlign"></div>
            </div>
        </div>
        <div class="Polaris-Page__Content">
            @include("components.account-frozen-banner", ["class" => "mb-4"])
            <div class="Polaris-Layout">
                <div class="Polaris-Layout__Section">
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Header">
                            <h2 class="Polaris-Heading">Billing cycle</h2>
                        </div>
                        <div class="Polaris-Card__Section">
                            <div>
                                <div class="Polaris-Stack__Item">
                                    <p>
                                        <span class="Polaris-TextStyle--variationSubdued">
                                            Choose how often you'd like to be billed. You can cancel anytime.
                                        </span>
                                    </p>
                                </div>
                                <div class="Polaris-Stack__Item">
                                    <ul class="Polaris-Unlisted-Style">
                                        <li class="Polaris-Unlisted-listed-Style" id="onClickMonthlyRadio">
                                            <span class="Polaris-Unlisted-listed-Span-Style">
                                                <label class="Polaris-Choice" for="paidMonthlyRadio">
                                                    <span class="Polaris-Choice__Control">
                                                        <span class="Polaris-RadioButton" >
                                                            <input name="paymentRadio" id="paidMonthlyRadio" type="radio" class="Polaris-RadioButton__Input"
                                                                   aria-describedby="optionalHelpText"
                                                                   value="monthly" {{ $sub_plan == "month" ? 'checked=checked' : '' }}>
                                                            <span class="Polaris-RadioButton__Backdrop"></span>
                                                            <span class="Polaris-RadioButton__Icon"></span>
                                                        </span>
                                                    </span>
                                                    <span class="Polaris-Choice__Label"> $<span class="monthly-price"></span> USD every 30 days</span>
                                                </label>
                                            </span>
                                            @if($all_addons == 1 && $sub_plan == 'month')
                                                <div class="Polaris-Stack__Item">
                                                    <span class="Polaris-Badge Polaris-Badge--statusInfo active-badge">{{$active_pause_plan}}
                                                    </span>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="Polaris-Unlisted-listed-Style" id="onClickQuarterlyRadio">
                                            <span class="Polaris-Unlisted-listed-Span-Style">
                                                <label class="Polaris-Choice" for="paidQuarterlyRadio">
                                                    <span class="Polaris-Choice__Control">
                                                        <span class="Polaris-RadioButton" >
                                                            <input name="paymentRadio" id="paidQuarterlyRadio" type="radio" class="Polaris-RadioButton__Input"
                                                                   aria-describedby="optionalHelpText"
                                                                   value="quarterly" {{ $sub_plan == "Quarterly" ? 'checked=checked' : '' }}>
                                                            <span class="Polaris-RadioButton__Backdrop"></span>
                                                            <span class="Polaris-RadioButton__Icon"></span>
                                                        </span>
                                                    </span>
                                                    <span class="Polaris-Choice__Label"> $<span class="quarterly-price"></span> USD every 3 months</span>
                                                </label>
                                            </span>
                                            @if($alladdons_plan != $plan_name)
                                                <div class="Polaris-Stack__Item">
                                                    <div>
                                                        <div tabindex="0" aria-controls="Polarispopover6"
                                                             aria-owns="Polarispopover6" aria-expanded="false">
                                                                <span class="Polaris-Button__Content">
                                                                    <span class="Polaris-TextStyle--variationPositive quarterly-discount-badge">Save
                                                                        <span class="quarterly-discount-money"></span>
                                                                    </span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($all_addons == 1 && $sub_plan == 'Quarterly')
                                                <div class="Polaris-Stack__Item">
                                                    <span class="Polaris-Badge Polaris-Badge--statusInfo active-badge">{{$active_pause_plan}}
                                                    </span>
                                                </div>
                                            @endif
                                        </li>
                                        <li class="Polaris-Unlisted-listed-Style" id="onClickYearlyRadio">
                                            <span class="Polaris-Unlisted-listed-Span-Style">
                                                <label class="Polaris-Choice" for="paidAnnuallyRadio">
                                                    <span class="Polaris-Choice__Control">
                                                        <span class="Polaris-RadioButton">
                                                            <input id="paidAnnuallyRadio" name="paymentRadio" type="radio"
                                                                   class="Polaris-RadioButton__Input" aria-describedby="disabledHelpText"
                                                                   value="annually" {{ $sub_plan == 'Yearly' ? 'checked=checked': '' }}>
                                                            <span class="Polaris-RadioButton__Backdrop"></span>
                                                            <span class="Polaris-RadioButton__Icon"></span>
                                                        </span>
                                                    </span>
                                                    <span class="Polaris-Choice__Label">$<span class="annual-price"></span> USD every year</span>
                                                </label>
                                            </span>
                                            @if($alladdons_plan != $plan_name)
                                                <div class="Polaris-Stack__Item">
                                                    <div>
                                                        <div tabindex="0" aria-controls="Polarispopover6"
                                                             aria-owns="Polarispopover6" aria-expanded="false">
                                                                <span class="Polaris-Button__Content">
                                                                    <span class="Polaris-TextStyle--variationPositive annual-discount-badge">Save
                                                                        <span class="annual-discount-money"></span>
                                                                    </span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($all_addons == 1 && $sub_plan == 'Yearly')
                                                <div class="Polaris-Stack__Item">
                                                    <span class="Polaris-Badge Polaris-Badge--statusInfo active-badge">{{ $active_pause_plan }}</span>
                                                </div>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="Polaris-FormLayout__Item">
                                <p class="Polaris-TextStyle--variationPositive save-message-annually" style="margin-bottom:0">
                                    You are saving
                                    <span class="annual-discount-percentage"></span>
                                    with this plan
                                </p>
                                <p class="Polaris-TextStyle--variationPositive save-message-quarterly" style="margin-bottom:0">
                                    You are saving
                                    <span class="quarterly-discount-percentage"></span>
                                    with this plan
                                </p>
                                <p class="Polaris-TextStyle--variationNegative save-message-monthly" style="margin-bottom:0">
                                    Switch to annual billing and save
                                    <span class="annual-discount-percentage"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="Polaris-Card">
                        <div class="Polaris-Card__Header">
                            <h2 class="Polaris-Heading ">Payment method</h2></div>
                        <div class="Polaris-Card__Section ">
                            <div>
                                <div class="Polaris-Stack__Item ">
                                    <p><span class="Polaris-TextStyle--variationSubdued ">Choose how you'd like to pay for Debutify.</span></p>
                                </div>
                                <div class="Polaris-Stack__Item">
                                    <ul class="Payment-Method-Unlisted-Style">
                                        <form action="" method="post" id="StripeForm" class="">
                                            @csrf
                                            <li class="Payment-Method-First-List-Style Payment-Method-Form-List-Style _2AZD4 selected-background" id="onClickPaymentByCreditCard" onclick="paymentMethodChanged('stripe')">
                                                <div class="Payment-Method-List-Div-Style">
                                                    <div class="Polaris-Stack  Polaris-Stack--distributionEqualSpacing  Polaris-Stack--alignmentCenter">
                                                        <div class="Polaris-Stack__Item ">
                                                            <span class="Payment-Method-Form-Span">
                                                                <label class="Polaris-Choice " for="CREDIT_CARD">
                                                                    <span class="Polaris-Choice__Control ">
                                                                        <span class="Polaris-RadioButton">
                                                                            <input id="paymentByCredit" name="methodOfPayment" type="radio" class="Polaris-RadioButton__Input"
                                                                                   aria-describedby="optionalHelpText" value="creditCard">
                                                                            <span class="Polaris-RadioButton__Backdrop"></span>
                                                                            <span class="Polaris-RadioButton__Icon"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="Polaris-Choice__Label ">
                                                                        <span class="Polaris-TextStyle--variationStrong">Credit card</span>
                                                                    </span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="Payment-Method-List-Div-Style" id="creditCardPaymentDiv">
                                                    <div class="Payment-Method-Credit-Card-Div">
                                                        <div class="Polaris-Stack  Polaris-Stack--vertical  Polaris-Stack--spacingLoose ">
                                                            @if($card_number != '')
                                                                <div class="Polaris-TextContainer credit-card-text">
                                                                    @if($card_brand == 'Visa')
                                                                        <img  align="center" src="https://js.stripe.com/v3/fingerprinted/img/visa-365725566f9578a9589553aa9296d178.svg"
                                                                              style="height: 20px;width: 35px">
                                                                    @elseif($card_brand == 'Mastercard')
                                                                        <img  align="center"  src="https://js.stripe.com/v3/fingerprinted/img/mastercard-4d8844094130711885b5e41b28c9848f.svg"
                                                                              style="height: 20px;width: 35px">
                                                                    @else
                                                                        <i class="fa fa-credit-card" aria-hidden="true" style="font-size:20px;margin-top: 5px"></i>
                                                                    @endif Card ending in {{$card_number}}
                                                                </div>

                                                                <div class="Polaris-Stack__Item ">
                                                                    <button class="Polaris-Button  Polaris-Button--plain" type="button" onclick="return openUpdateCardModal();">
                                                                        <span class="Polaris-Button__Content">
                                                                            <span class="Polaris-Button__Text ">Replace credit card</span>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                            @else
                                                                <div class="Polaris-Stack__Item credit-card-text">
                                                                    <p>Add a credit card and use it to pay your bills.</p>
                                                                </div>
                                                                <div class="Polaris-Stack__Item ">
                                                                    <button class="Polaris-Button  Polaris-Button--plain"
                                                                            type="button" onclick="return openUpdateCardModal();">
                                                                                <span class="Polaris-Button__Content">
                                                                                    <span class="Polaris-Button__Text addCreditCardText">Add credit card</span>
                                                                                </span>
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Payment-Method-First-List-Style Payment-Method-Form-List-Style" id="onClickPaymentByPaypal" onclick="paymentMethodChanged('paypal')">
                                                <div class="Payment-Method-List-Div-Style">
                                                    <div class="Polaris-Stack  Polaris-Stack--distributionEqualSpacing Polaris-Stack--alignmentCenter">
                                                        <div class="Polaris-Stack__Item ">
                                                            <span class="Payment-Method-Form-Span">
                                                                <label class="Polaris-Choice" for="paymentByPaypal">
                                                                    <span class="Polaris-Choice__Control ">
                                                                        <span class="Polaris-RadioButton">
                                                                            <input id="paymentByPaypal" name="methodOfPayment" type="radio" class="Polaris-RadioButton__Input"
                                                                                   aria-describedby="optionalHelpText" value="paypal">
                                                                            <span class="Polaris-RadioButton__Backdrop"></span>
                                                                            <span class="Polaris-RadioButton__Icon"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="Polaris-Choice__Label ">
                                                                        <span class="Polaris-TextStyle--variationStrong">
                                                                            <img src="/svg/paypal.svg" alt="PayPal" class="paypal-image-height">
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="Payment-Method-First-List-Style Payment-Method-Form-List-Style" id="onClickPaymentByPaynow" onclick="paymentMethodChanged('paynow')">
                                                <div class="Payment-Method-List-Div-Style">
                                                    <div class="Polaris-Stack  Polaris-Stack--distributionEqualSpacing Polaris-Stack--alignmentCenter">
                                                        <div class="Polaris-Stack__Item ">
                                                            <span class="Payment-Method-Form-Span">
                                                                <label class="Polaris-Choice" for="paymentByPaynow">
                                                                    <span class="Polaris-Choice__Control ">
                                                                        <span class="Polaris-RadioButton">
                                                                            <input id="paymentByPaynow" name="methodOfPayment" type="radio" class="Polaris-RadioButton__Input"
                                                                                   aria-describedby="optionalHelpText" value="paynow">
                                                                            <span class="Polaris-RadioButton__Backdrop"></span>
                                                                            <span class="Polaris-RadioButton__Icon"></span>
                                                                        </span>
                                                                    </span>
                                                                    <span class="Polaris-Choice__Label ">
                                                                        <span class="Polaris-TextStyle--variationStrong">
                                                                            <img class="border p-2 rounded" src="/images/microsoft-pay.png" alt="Microsoft Pay" height="30">
                                                                            <img class="border p-2 rounded" src="/images/apple-pay.png" alt="Apple Pay" height="30">
                                                                            <img class="border p-2 rounded" src="/images/google-pay.png" alt="Google Pay" height="30">
                                                                        </span>
                                                                    </span>
                                                                </label>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                            <input type="hidden" name="payment_cycle" id="payment_cycle" value="" class="payment_cycle" />
                                            <input type="hidden" name="subtotal_price" id="subtotal_price" value="" class="subtotal_price" />
                                            <input type="hidden" name="plan_id" id="plan_id" value="" class="plan_id" />
                                            <input type="hidden" name="sub_plan" id="sub_plan" value="" class="sub_plan" />
                                            <input type="hidden" name="alladdons_plan" id="alladdons_plan" value="{{ $alladdons_plan }}" />
                                            <input type="hidden" name="email" id="email" value="{{ $owner_details['email'] }}" />
                                            <input type="hidden" name="new_coupon" value="" id="addnewcoupon" />
                                        </form>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Layout__Section Polaris-Layout__Section--secondary" id="secondarySection">
                    <div class="Polaris-Card Polaris-Card--newDesignLanguage">
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical ">
                                <div class="Polaris-Stack__Item">
                                    <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><span class="plan-name"></span> Plan</h3></div>
                                <div class="Polaris-Stack__Item">
                                    <p class="Polaris-TextStyle--variationSubdued"  style="margin-bottom:0px">
                                        <span class="Polaris-TextStyle--variationSubdued">
                                            $<span class="plan-price"></span> USD @if($applyTaxes) + tax @endif every
                                            <span class="billing-days"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical">
                                <div class="Polaris-Stack__Item">
                                    @if($all_addons == 1)
                                        <p class="Polaris-TextStyle--variationSubdued" style="margin-bottom:0px">As a result of this plan change, you will be charged a prorated amount of
                                            <b style="font-weight: bolder" >
                                                $<span class="total-price gtm-total-price"></span>
                                                USD
                                            </b> today for your new subscription.
                                        </p>
                                    @else
                                        <p class="Polaris-TextStyle--variationSubdued" style="margin-bottom:0px"> You will be charge an amount of
                                            <b style="font-weight: bolder" >
                                                $<span class="total-price gtm-total-price"></span>
                                                USD
                                            </b>
                                            today for your new subscription.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Card__Section" id="couponCodeDivLabel">
                            <div class="Togggle-Section">
                                <button type="button" class="Coupon-Code-Togggle" id="couponCodeToggle">
                                    <h3 aria-label="Plan details" class="Polaris-Subheading">Coupon Code</h3>
                                    <span class="jGrpH">
                                        <span class="Polaris-Icon Polaris-Icon--colorInkLight Polaris-Icon--isColored Polaris-Icon--newDesignLanguage">
                                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                <path d="M10 14a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 1 1 1.414-1.414L10 11.586l4.293-4.293a.999.999 0 1 1 1.414 1.414l-5
                                                 5A.997.997 0 0 1 10 14z"></path>
                                            </svg>
                                        </span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div id="couponCodeDiv" aria-hidden="false" style="max-height:none;border-bottom:0.1rem solid var(--p-divider, #dfe3e8)"
                             class="Polaris-Collapsible Polaris-Collapsible--open Polaris-Collapsible--fullyOpen">
                            <div>
                                <div class="Polaris-Card__Section Polaris-Card__Section--subdued" >
                                    <div class="ZF-9W">
                                        <span class="Polaris-TextStyle--variationSubdued">
                                            <ul class="Polaris-List" style="list-style: none;padding-left:0px;">
                                                <li class="Polaris-List__Item">
                                                    @if($discount)
                                                        <p class="Polaris-TextStyle--variationSubdued showOnActivePlan">
                                                            <span class="currentCoupon Polaris-Subheading">{{$coupon_name}}</span>
                                                            →
                                                            <span class="couponDescription">
                                                                {{$percent_off}}
                                                                {{$coupon_duration}}
                                                                @if ($coupon_duration_months)
                                                                    {{$coupon_duration_months}} months
                                                                @endif
                                                            </span>
                                                        </p>
                                                    @endif
                                                </li>
                                                <!-- new coupon -->
                                                <li class="Polaris-List__Item hideOnActivePlan">
                                                     <div class="Polaris-Connected">
                                                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                                                          <div class="Polaris-TextField">
                                                              <input id="newCoupon" class="Polaris-TextField__Input" type="text"
                                                                     name="newCoupon"
                                                                     aria-describedby="New coupon"
                                                                     aria-labelledby="New coupon" aria-invalid="false"
                                                                     aria-multiline="false" value="" placeholder="Enter coupon code here">
                                                            <div class="Polaris-TextField__Backdrop"></div>
                                                          </div>
                                                        </div>
                                                     </div>
                                                </li>
                                                <li class="Polaris-List__Item hideOnActivePlan">
                                                    <button type="button" class="Polaris-Button disable-while-loading btn-new-coupon"
                                                            onclick="return applyNewCoupon();" style="width: 100%">
                                                          <span class="Polaris-Button__Content">
                                                            <span class="Polaris-Button__Text">Apply code</span>
                                                          </span>
                                                    </button>
                                                </li>

                                                <!-- subscription coupon -->
                                                <form action="" method="post" id="SubscriptionCouponForm" class="showOnActivePlan" style="display: none">
                                                    @csrf
                                                    <div class="Polaris-Stack Polaris-Stack--spacingTight">
                                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                                            <div class="Polaris-TextField">
                                                                <input id="currentplan_id" type="hidden" name="currentplan_id" value="">
                                                                <input id="subscriptionCoupon" class="Polaris-TextField__Input" type="text" name="subscription_coupon"
                                                                       aria-label="Subscription coupon" aria-labelledby="" aria-invalid="false" value=""  placeholder="Enter coupon code here">
                                                                <div class="Polaris-TextField__Backdrop"></div>
                                                            </div>
                                                        </div>
                                                        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill" >
                                                            <button type="button" class="Polaris-Button disable-while-loading btn-subscription-coupon"
                                                                    onclick="return applySubscriptionCoupon();" style="width:100%">
                                                                <span class="Polaris-Button__Content">
                                                                  <span class="Polaris-Button__Text">Apply coupon</span>
                                                                </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </ul>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingTight">
                                <div class="Polaris-Stack__Item">
                                    <div class="Polaris-Stack Polaris-Stack--distributionEqualSpacing">
                                        <div class="Polaris-Stack__Item"><span>Subtotal</span></div>
                                        <div class="Polaris-Stack__Item">$<span class="plan-price"></span> USD</div>
                                    </div>
                                </div>
                                <div class="Polaris-Stack__Item" id="discountsDiv">
                                    <div class="Polaris-Stack Polaris-Stack--distributionEqualSpacing">
                                        <div class="Polaris-Stack__Item"><span>Discount</span></div>
                                        <div class="Polaris-Stack__Item">-$<span class="discounts"></span> USD</div>
                                    </div>
                                </div>
                                <div class="Polaris-Stack__Item plan-prorated">
                                    <div class="Polaris-Stack Polaris-Stack--distributionEqualSpacing">
                                        <div class="Polaris-Stack__Item"><span>Prorated credit</span></div>
                                        <div class="Polaris-Stack__Item">-$<span class="prorated-amount"></span> USD</div>
                                    </div>
                                </div>
                                <div class="Polaris-Stack__Item" id="prorated-balanceDiv" style="display: none;">
                                    <div class="Polaris-Stack Polaris-Stack--distributionEqualSpacing">
                                        <div class="Polaris-Stack__Item"><span>Account balance</span></div>
                                        <div class="Polaris-Stack__Item">$<span class="prorated-balance"></span> USD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingLoose">
                                <div class="Polaris-Stack__Item">
                                    <div class="Polaris-Stack Polaris-Stack--distributionFill Polaris-Stack--alignmentCenter">
                                        <div class="Polaris-Stack__Item">
                                            <p style="margin-bottom: 0;"><span class="Polaris-TextStyle--variationStrong">Billed now</span></p>
                                        </div>
                                        <div class="Polaris-Stack__Item">
                                            <div class="Polaris-Stack Polaris-Stack--distributionTrailing">
                                                <div class="Polaris-Stack__Item">
                                                    <p style="margin-bottom: 0;">
                                                        <span class="Polaris-TextStyle--variationStrong">
                                                            $<span class="total-price gtm-total-price"></span> USD
                                                            @if($applyTaxes) + tax @endif
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Polaris-Stack__Item" id="paynow-button-container-wrapper">
                                    <div class="Payment-Method-List-Div-Style">
                                        <div id="payment-request-button"><!-- A Stripe Element will be inserted here. --></div>
                                    </div>
                                </div>
                                <div class="Polaris-Stack__Item" id="paypal-button-container-wrapper">
                                    <div id="paypal-button-container"></div>
                                </div>
                                <div class="Polaris-Stack__Item" id="credit-card-button-container-wrapper">
                                    @if($card_number != '')
                                        <button style="width: 100%;" type="button" class="Polaris-Button Polaris-Button--primary disable-while-loading Start-Plan"
                                                onclick="return AllAdonsSubscriptioncard();">
                                                <span class="Polaris-Button__Content">
                                                    <span class="Polaris-Button__Text">Start plan</span>
                                                </span>
                                        </button>
                                    @else
                                        <button class="Polaris-Button Polaris-Button--primary Polaris-Button--disabled disable-while-loading Polaris-Button--fullWidth Start-Plan"
                                                type="button" onclick="return AllAdonsSubscription();">
                                            <span class="Polaris-Button__Content">
                                                <span class="Polaris-Button__Text">Start plan</span>
                                            </span>
                                        </button>
                                    @endif
                                </div>
                                <div class="Polaris-Stack__Item" id="terms-and-condtion-wrapper">
                                    <label class="Polaris-Choice terms-action" for="PolarisCheckboxTerms">
                                       <span class="Polaris-Choice__Control">
                                          <span class="Polaris-Checkbox">
                                             <input id="PolarisCheckboxTerms" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false"
                                                    role="checkbox" aria-checked="false" value="" required><span class="Polaris-Checkbox__Backdrop"></span>
                                             <span class="Polaris-Checkbox__Icon">
                                                <span class="Polaris-Icon">
                                                   <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                      <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.436.436 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                   </svg>
                                                </span>
                                             </span>
                                          </span>
                                        </span>
                                        <span class="Polaris-Choice__Label">
                                            I agree to the
                                            <a id="conditions-link" href="/terms-of-sales" target="_blank" class="Polaris-Link">terms of sales</a>
                                            and
                                            <a href="/terms-of-use" target="_blank" class="Polaris-Link">terms of use</a>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($is_paused == 1)
                <div class="Polaris-Layout__Section Polaris-Layout__Section--secondary" id="pause_plan_section" style="display: none;">
                    <div class="Polaris-Card Polaris-Card--newDesignLanguage">
                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical ">
                                <div class="Polaris-Stack__Item">
                                    <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><span class="plan-name"></span> Plan</h3></div>
                                <div class="Polaris-Stack__Item">
                                    <p class="Polaris-TextStyle--variationSubdued"  style="margin-bottom:0px">
                                        <span class="Polaris-TextStyle--variationSubdued">
                                            $<span class="plan-price"></span> USD @if($applyTaxes) + tax @endif every
                                            <span class="billing-days"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical">
                                <div class="Polaris-Stack__Item">
                                    <p class="Polaris-TextStyle--variationSubdued" style="margin-bottom:0px">
                                        As a result of this plan unpause, you will be charged an amount of
                                        <b style="font-weight: bolder" >
                                            ${{ $next_invoice_total }} USD
                                        </b> on
                                        <b style="font-weight: bolder" >
                                            {{ $next_payment_attempt }}
                                        </b> for your subscription.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="Polaris-Card__Section">
                            <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingLoose">
                                <div class="Polaris-Stack__Item">
                                    <button style="width: 100%;" type="button"
                                            class="Polaris-Button Polaris-Button--primary btn-loading Unpause-Subscription">
                                        <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Unpause my plan</span></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="Polaris-Layout__Section" style="margin-left:0px">
            <div class="Polaris-PageActions">
                <div class="Polaris-Stack Polaris-Stack--spacingTight Polaris-Stack--distributionEqualSpacing">
                    <div class="Polaris-Stack__Item">
                        <div class="Polaris-ButtonGroup">
                            <div class="Polaris-ButtonGroup__Item">
                                <a href="{{route('plans')}}" class="Polaris-Button" style="text-decoration: none">
                                    <span class="Polaris-Button__Content">
                                        <span class="Polaris-Button__Text">Cancel</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="Polaris-Stack__Item">
                        <div class="Polaris-ButtonGroup">
                            <div class="Polaris-ButtonGroup__Item">
                                <form action="" method="post" id="cancel_form">
                                    @csrf
                                    <button style="width: 100%; display: none;" type="button"
                                            class="Polaris-Button Polaris-Button--destructive Delete-Subscription"
                                            onclick="return openCancelModal('{{$store_count}}','{{ $sub_plan }}','{{ $trial_end_date }}');">
                                        <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Delete subscription</span></span>
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- subscription modal -->
<div id="subscriptionModal" class="modal fade-scales" style="display: none">
    <div>
        <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
                <div role="dialog" aria-labelledby="Polarismodal-header16" tabindex="-1" class="Polaris-Modal-Dialog">
                    <div class="Polaris-Modal-Dialog__Modal">
                        <div class="Polaris-Modal-Header">
                            <div id="Polarismodal-header16" class="Polaris-Modal-Header__Title">
                                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Add credit card</h2>
                            </div>
                            <button class="Polaris-Modal-CloseButton" aria-label="Close">
                                <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                        <path d="M11.414 10l6.293-6.293a1 1 0 1 0-1.414-1.414L10 8.586 3.707 2.293a1 1 0 0
                                         0-1.414 1.414L8.586 10l-6.293 6.293a1 1 0 1 0 1.414 1.414L10 11.414l6.293 6.293A.998
                                         .998 0 0 0 18 17a.999.999 0 0 0-.293-.707L11.414 10z">
                                        </path>
                                    </svg>
                                </span>
                            </button>
                        </div>
                        <div class="Polaris-Modal__BodyWrapper">
                            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                <section class="Polaris-Modal-Section">
                                    <div class="Polaris-Stack Polaris-Stack--vertical">
                                        <div class="Polaris-Stack__Item">
                                            <div class="Polaris-FormLayout">
                                                <div class="Polaris-FormLayout__Item">
                                                    <div class="">
                                                        <div class="Polaris-Labelled__LabelWrapper">
                                                            <div class="Polaris-Label">
                                                                <label for="credit_card" class="Polaris-Label__Text">Credit card</label>
                                                            </div>
                                                        </div>
                                                        <div id="card-elementsub" class="stripe-custom-input"></div>
                                                        <div id="card-errorsub" class="Polaris-Labelled__HelpText" role="alert"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="Polaris-Modal-Footer">
                            <div class="Polaris-Modal-Footer__FooterContent">
                                <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                                    <div class="Polaris-Stack__Item">
                                        <div class="Polaris-ButtonGroup">
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="Polaris-Button">
                                                    <span class="Polaris-Button__Content">
                                                        <span class="Polaris-Button__Text">Cancel</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="Polaris-Button Polaris-Button--primary">
                                                    <span class="Polaris-Button__Content">
                                                        <span class="Polaris-Button__Text">Confirm</span>
                                                    </span>
                                                </button>
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
    </div>
    <div class="Polaris-Backdrop"></div>
</div>

<!-- update card modal -->
<div id="updateCardModal" style="display: none">
    <div>
        <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
                <div role="dialog" aria-labelledby="Polarismodal-header2" tabindex="-1" class="Polaris-Modal-Dialog">
                    <div class="Polaris-Modal-Dialog__Modal">
                        <div class="Polaris-Modal-Header">
                            <div class="Polaris-Modal-Header__Title">
                                @if($card_number != '')
                                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Replace credit card</h2>
                                @else
                                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Add credit card</h2>
                                @endif
                            </div>
                            <button type="button" class="Polaris-Modal-CloseButton updateCardModalClose-modal Close-modal disable-while-loading">
                               <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                                 <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                   <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999
                                   0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                                 </svg>
                               </span>
                            </button>
                        </div>
                        <div class="Polaris-Modal__BodyWrapper">
                            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                <form action="#" method="post" id="updateCardForm" class="Polaris-Modal__BodyWrapper">
                                    @csrf
                                    <div class="Polaris-Modal__BodyWrapper">
                                        <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true" polaris="[object Object]">
                                            <section class="Polaris-Modal-Section">
                                                <div class="Polaris-FormLayout">
                                                    <div class="Polaris-FormLayout__Item">
                                                        <div class="">
                                                            <div class="Polaris-Labelled__LabelWrapper">
                                                                <div class="Polaris-Label">
                                                                    <label for="credit_card" class="Polaris-Label__Text">Credit card information</label>
                                                                </div>
                                                            </div>
                                                            <div id="card-elementsub-update" class="stripe-custom-input">
                                                            </div>
                                                            <div id="card-errorsub-update" class="Polaris-Labelled__HelpText" role="alert"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="Polaris-Modal-Footer">
                            <div class="Polaris-Modal-Footer__FooterContent">
                                <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                                    <div class="Polaris-Stack__Item">
                                        <div class="Polaris-ButtonGroup">
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="Polaris-Button updateCardModalClose-modal Close-modal  disable-while-loading">
                                                   <span class="Polaris-Button__Content">
                                                     <span class="Polaris-Button__Text">Cancel</span>
                                                   </span>
                                                </button>
                                            </div>
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="Polaris-Button Polaris-Button--primary all_addon_subscribe disable-while-loading"
                                                        onclick="return updateCardForm();">
                                                    <span class="Polaris-Button__Content">
                                                        @if($all_addons == 1 || $card_number != '')
                                                           <span class="Polaris-Button__Text">Replace credit card</span>
                                                        @else
                                                           <span class="Polaris-Button__Text">Add credit card</span>
                                                        @endif
                                                  </span>
                                                </button>
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
    </div>
    <div class="Polaris-Backdrop"></div>
</div>

<!-- exit intent modal -->
<div id="exitIntentModal" class="modal fade-scales">
    <div>
        <div class="Polaris-Modal-Dialog__Container undefined" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
            <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header2" tabindex="-1">
                <div class="Polaris-Modal-Header">
                <div id="modal-header2" class="Polaris-Modal-Header__Title">
                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">WAIT! Don't go..</h2>
                </div><button class="Polaris-Modal-CloseButton close-modal disable-while-loading" aria-label="Close"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                    </svg></span></button>
                </div>
                <div class="Polaris-Modal__BodyWrapper">
                <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                    <section class="Polaris-Modal-Section text-center">
                    <div class="Polaris-TextContainer">
                        <img src="/svg/offer.svg" role="presentation" alt="" class="" width="300">
                        <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Unlock 10% off your first month</p>
                        <p class="Polaris-Subheading">One-time-offer ONLY! Your Success Is Just Around The Corner. We Are Here For YOU!</p>
                        <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge acceptExitIntent disable-while-loading">
                        <span class="Polaris-Button__Content">
                            <span class="Polaris-Button__Text">Apply coupon code</span>
                        </span>
                        </button>
                        <p class="Polaris-Subheading"></p>
                        <input id="inputExitIntent" readonly type="text" value="{{ $new_code }}">
                    </div>
                    </section>
                </div>
                </div>
                <div class="Polaris-Modal-Footer">
                <div class="Polaris-Modal-Footer__FooterContent">
                    <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                    <div class="Polaris-Stack__Item">
                        <div class="Polaris-ButtonGroup">
                        <div class="Polaris-ButtonGroup__Item">
                            <button type="button" class="close-modal Polaris-Button disable-while-loading">
                            <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">No thanks</span>
                            </span>
                            </button>
                        </div>
                        <div class="Polaris-ButtonGroup__Item">
                            <button type="button" class="Polaris-Button Polaris-Button--primary acceptExitIntent disable-while-loading">
                            <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Apply coupon code</span>
                            </span>
                            </button>
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
    <div class="Polaris-Backdrop"></div>
</div>
<!-- offer discount modal -->
<div id="offerDiscountModal" style="display: none">
    <div>
        <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
                <div role="dialog" aria-labelledby="Polarismodal-header2" tabindex="-1" class="Polaris-Modal-Dialog">
                    <div class="Polaris-Modal-Dialog__Modal">
                        <div class="Polaris-Modal-Header">
                            <div id="modal-header2" class="Polaris-Modal-Header__Title">
                                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">WAIT! Don't go..</h2>
                            </div><button class="denyOffer Polaris-Modal-CloseButton close-modal disable-while-loading" aria-label="Close"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                      <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                    </svg></span></button>
                        </div>
                        <div class="Polaris-Modal__BodyWrapper">
                            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                <section class="Polaris-Modal-Section text-center" style="text-align:center">
                                    <div class="Polaris-TextContainer">
                                        <img src="/svg/offer.svg" role="presentation" alt="" class="" width="300">
                                        <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Unlock 50% off your monthly subscription for 3 months</p>
                                        <p class="Polaris-Subheading">One-time-offer ONLY! Your Success Is Just Around The Corner. We Are Here For YOU!</p>
                                        <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge acceptOffer disable-while-loading">
                                            <span class="Polaris-Button__Content">
                                              <span class="Polaris-Button__Text">Claim offer now</span>
                                            </span>
                                        </button>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <div class="Polaris-Modal-Footer">
                            <div class="Polaris-Modal-Footer__FooterContent">
                                <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                                    <div class="Polaris-Stack__Item">
                                        <div class="Polaris-ButtonGroup">
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="close-modal Polaris-Button denyOffer disable-while-loading">
                                                    <span class="Polaris-Button__Content">
                                                      <span class="Polaris-Button__Text">No thanks</span>
                                                    </span>
                                                </button>
                                            </div>
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="Polaris-Button Polaris-Button--primary acceptOffer disable-while-loading">
                                                    <span class="Polaris-Button__Content">
                                                      <span class="Polaris-Button__Text">Claim offer now</span>
                                                    </span>
                                                </button>
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
    </div>
    <div class="Polaris-Backdrop"></div>
</div>
 <?php
    if ($alladdons_plan == $starter) {
      $addon = 3;
    }else{
      $addon = 28;
    }
    ?>
<!-- cancel subscription modal -->
<div id="confirmCancelSubscriptionModal" style="display: none">
    <div>
        <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
                <div role="dialog" aria-labelledby="Polarismodal-header2" tabindex="-1" class="Polaris-Modal-Dialog">
                    <div class="Polaris-Modal-Dialog__Modal">
                        <div class="Polaris-Modal-Header">
                            <div id="modal-header2" class="Polaris-Modal-Header__Title">
                                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Plan cancellation</h2>
                            </div>
                            <button class="confirmCancelSubscriptionModalClose-modal Close-modal Polaris-Modal-CloseButton disable-while-loading" aria-label="Close">
                            <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                      <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999
                                      0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                                </svg>
                            </span>
                            </button>
                        </div>
                        <div class="Polaris-Modal__BodyWrapper">
                            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                <section class="Polaris-Modal-Section">
                                   <div class="Polaris-Labelled__HelpText" id="PolarisTextField2HelpText">


                        @if($alladdons_plan == $starter)
                                <span>Canceling your plan will remove Debutify's <b>premium</b> features from your store - including All Conversion-boosting Add-Ons, Technical support, Basic product research tool, and more.</span>
                        @endif

                        @if($alladdons_plan == $hustler)
                                <span>Canceling your plan will remove Debutify's <b>premium</b> features from your store - including All Conversion-boosting Add-Ons, Technical support, Product research tool, and more.</span>
                        @endif

                        @if($alladdons_plan == $guru)
                            <span>Canceling your plan will remove Debutify's <b>premium</b> features from your store - including All Conversion-boosting Add-Ons, Exclusive training courses, Priority technical support, Full product research tool, Private 1-on-1 Mentoring Group, Chance for 1-on-1 mentoring call to private mentoring group and more.</span>
                        @endif

                        </div>
                        <h4 class="mt-4">Are you sure you'd like to continue?</h4>
                                </section>
                            </div>
                        </div>

                        <div class="Polaris-Modal-Footer showOnActivePlann">
                            <div class="Polaris-Modal-Footer__FooterContent">
                              <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                                <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">

                                  <button id="cancel-btn" class="Polaris-Button  Polaris-Button--plain" type="button"> <span class="Polaris-Button__Content">
                                        <span class="Polaris-Button__Text ">Yes, take me to cancellation page</span>
                                        </span>
                                 </button>
                                </div>
                                <div class="Polaris-Stack__Item">
                                  <div class="Polaris-ButtonGroup">
                                    <div class="Polaris-ButtonGroup__Item btn-update">
                                      <button type="button" class="Polaris-Button Polaris-Button--primary btn-loading" onclick="return window.location= '{{ route('plans')}}' ">
                                        <span class="Polaris-Button__Content">
                                          <span class="Polaris-Button__Text">No, take me  back</span>
                                        </span>
                                      </button>
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
    </div>
    <div class="Polaris-Backdrop"></div>
</div>




<!-- Uninstall Addon modal -->
@php
if($plan_name == $starter)
{
    $addonsLimit = $starterLimit;
}
elseif($plan_name == $hustler)
{
    $addonsLimit = $hustlerLimit;
}
else
{
    $addonsLimit = $guruLimit;
}

@endphp
 <div id="uninstalladdonModal" class="modal fade-scales" role="dialog">
   <div>
     <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
       <div>
         <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
           <div class="Polaris-Modal-Header">
             <div class="Polaris-Modal-Header__Title">
               <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">{{$plan_name}} plan Add-Ons limit ({{$addonsLimit}}) exceeded</h2>
             </div>
             <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
               <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                 <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                   <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                 </svg>
               </span>
             </button>
           </div>
           <form action="{{ route('delete_multipl_addons') }}" method="post" id="uninstalladdonForm" class="Polaris-Modal__BodyWrapper" style="display: unset;">
             @csrf
             @php
             $base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
            $url = $base_url . $_SERVER["REQUEST_URI"];
            @endphp
             <input type="hidden" name="referrer_url" value="{{$url}}">

             <div class="Polaris-Modal__BodyWrapper">
               <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true" polaris="[object Object]">
                 <section class="Polaris-Modal-Section">
                   <p class="mb">Please uninstall {{$active_add_ons - $addonsLimit}} Add-Ons to be able to select the {{$plan_name}} plan.</p>
                   <div class="Polaris-Card">
                     <ul class="Polaris-OptionList__Options" id="PolarisOptionList9-0" aria-multiselectable="true">
                      @foreach($global_add_ons as $key=>$addon)
                        @if($addon->status == 1)
                        <li class="Polaris-OptionList-Option" tabindex="-1">
                          <label for="PolarisOptionList9-0-{{$key}}" class="Polaris-OptionList-Option__Label">
                            <div class="Polaris-OptionList-Option__Checkbox">
                              <div class="Polaris-OptionList-Checkbox">
                                <input id="PolarisOptionList9-0-{{$key}}" name=addons[] type="checkbox" class="Polaris-OptionList-Checkbox__Input" aria-checked="false" value="{{$addon->id}}">
                                <div class="Polaris-OptionList-Checkbox__Backdrop"></div>
                                <div class="Polaris-OptionList-Checkbox__Icon">
                                  <span class="Polaris-Icon">
                                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path></svg>
                                  </span>
                                </div>
                              </div>
                            </div>{{$addon->title}}
                          </label>
                        </li>
                        @endif
                      @endforeach
                    </ul>
                  </div>
                </section>
              </div>
            </div>

            <div class="Polaris-Modal-Footer">
             <div class="Polaris-Modal-Footer__FooterContent">
               <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                  <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                  <div class="Polaris-Stack__Item">
                   <div class="Polaris-ButtonGroup">
                     <div class="Polaris-ButtonGroup__Item">
                       <button type="button" class="Polaris-Button close-modal disable-while-loading">
                         <span class="Polaris-Button__Content">
                           <span class="Polaris-Button__Text">Cancel</span>
                         </span>
                       </button>
                     </div>
                     <div class="Polaris-ButtonGroup__Item">
                       <button type="button" class="Polaris-Button Polaris-Button--primary uninstall_Addon disable-while-loading" onclick="return uninstalladdonForm();">
                         <span class="Polaris-Button__Content">
                           <span class="Polaris-Button__Text">Uninstall Add-Ons</span>
                         </span>
                       </button>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
          </form>

         </div>
       </div>
     </div>
   </div>
   <div class="Polaris-Backdrop"></div>
 </div>


<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>

<script type="text/javascript" src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous"></script>

<!-- LinkMink -->
<script src="https://cdn.linkmink.com/lm-js/2.2.0/lm.js"></script>

<script src="/js/jquery.exitintent.min.js?v=" <?=config('env-variables.ASSET_VERSION')?>></script>
<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">

    function uninstalladdonForm(){
        var val = [];
        $(':checkbox:checked').each(function(i){
            val[i] = $(this).val();
        });
        if(val.length > 0){
            var form = document.getElementById('uninstalladdonForm');
            loadingBarCustom();
            $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
            $('.uninstall_Addon').addClass('Polaris-Button--loading');
            $('.uninstall_Addon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Uninstall Add-Ons</span></span>');
            form.submit();
        }
        else
        {
            customToastMessage("Please select Add-Ons to uninstall", false);
        }
    }

    $('.skeleton-wrapper,.Polaris-SkeletonPage__Page').css('display','none');
    $('#Checkout-Page').css('display','block');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#couponCodeToggle').click(function () {
        var couponCodeDiv = document.getElementById("couponCodeDiv");
        if (couponCodeDiv.style.display === "none") {
            $("#couponCodeDiv" + ("> i")).removeClass("ion-ios-arrow-down").addClass("ion-ios-arrow-up");
            couponCodeDiv.style.display = "block";
        } else {
            $("#couponCodeDiv" + ("> i")).removeClass("ion-ios-arrow-up").addClass("ion-ios-arrow-down");
            couponCodeDiv.style.display = "none";
        }
    });

    $(".confirmCancelSubscriptionModalClose-modal").click(function (){
        $("#confirmCancelSubscriptionModal").hide();
        $("body").removeClass("modal-open");

    })
    $(".updateCardModalClose-modal ").click(function (){
        $("#updateCardModal").hide();
        $("body").removeClass("modal-open");

    })
</script>
<script>
function paymentMethodChanged(method){
    let paypal = $('#paymentByPaypal');
    let stripe = $('#paymentByCredit');
    let secondarySection = $('#secondarySection');
    //method=="paypal"? secondarySection.hide():secondarySection.show();
}
</script>
<script type="text/javascript">

    // clear session storage item
    sessionStorage.removeItem('addPaymentInfo');
    sessionStorage.removeItem('initiateCheckoutMonthly');
    sessionStorage.removeItem('initiateCheckoutYearly');
    sessionStorage.removeItem("exitIntenShown");
    var urlParams = new URLSearchParams(window.location.search);
    var cancelClicked = false;
    var paymentRequestButtonSupported = false;

    // open update card modal if coming from /update-card view
    $(window).ready(function () {
        if (sessionStorage.getItem("updateCard")) {
            openUpdateCardModal();
            sessionStorage.removeItem('updateCard');
        }
    });

    $(document).ready(function() {
        if ($("#paidMonthlyRadio:checked").length) {
            $("#paidMonthlyRadio").click();
        }

        if ($("#paidAnnuallyRadio:checked").length) {
            $("#paidAnnuallyRadio").click();
        }
    });

    $('#cancel-btn').click(function () {
        if (!cancelClicked) {
            cancelClicked = true;
            window.location = '{{ route('goodbye') }}';
        }
    });

    $('.link-uninstall').click(function () {
        $('.link-uninstall').hide();
        $('.btn-update').hide();
        $('.cancel-link-uninstall').show();
        $('.btn-uninstall').show();
    });

    $('.cancel-link-uninstall').click(function () {
        $('.link-uninstall').show();
        $('.btn-update').show();
        $('.cancel-link-uninstall').hide();
        $('.btn-uninstall').hide();
    });

    $('.close-modal').click(function(){
        var modal = $("#exitIntentModal").closest(".modal");
        closeModal();
    });

    // exit intent modal
    console.log("all_addons ",'{{$all_addons}}');
    console.log("theme_count ",'{{$theme_count}}');
    @if ($all_addons != 1 && $theme_count != 0)
        function openExitIntent(){
          let selectedPaymentMethod = $('input[name="methodOfPayment"]:checked').val();
          if (sessionStorage.exitIntenShown || selectedPaymentMethod == 'paypal') {} else {
            //show modal
            if( $(".modal").hasClass("open") ){} else{
              var modal = $("#exitIntentModal");
              openModal(modal);
              sessionStorage.setItem("exitIntenShown", "true");
            }
          }
        }

        $(".acceptExitIntent").click(function(){
          $("#inputExitIntent").focus();
          $("#inputExitIntent").select();
          document.execCommand('copy');
          $("#newCoupon").val($("#inputExitIntent").val());
          $(".btn-new-coupon").click();
          // close modal
          var modal = $("#exitIntentModal").closest(".modal");
          closeModal(modal);
        });


        if(!getCookie('discount-code')) {
            $.exitIntent("enable");

            $(document).bind("exitintent", function() {
                openExitIntent();
            });

            $(window).blur(function(e) {
                if($("iframe").is(":focus")){}else{
                    openExitIntent();
                }
            });
        }
    @endif

    // claim offer trigger
    function claimYearlyOffer() {
        $(".Polaris-DataTable__Table .Polaris-Button--primary").trigger("click");
    }

    // coupons for active subscriptions
    function applySubscriptionCoupon() {
        var subscriptionCouponInput = $('#subscriptionCoupon');
        var couponValue = subscriptionCouponInput.val();
        var exitCode = "{{$exit_code}}";
        var newCode = "{{$new_code}}";
        // empty
        if (!couponValue) {
            customToastMessage("No coupon code entered", false);
            return false;
        }
        // prevent coupons offered to new customers only (coupons only for active subscriptions)
        if (couponValue == "20FOR20K" || couponValue == "DEBUTIFYFIFTY") {
            subscriptionCouponInput.val("");
            customToastMessage("Coupon code not applicable to active subscriptions", false);
                return false;
        }
        $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('.btn-subscription-coupon').addClass('Polaris-Button--loading');
        $('#onClickPaymentByCreditCard').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('#onClickPaymentByPaypal').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('#onClickPaymentByPaynow').addClass('Polaris-Button--disabled').prop("disabled", true);

        $('.btn-subscription-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Apply coupon</span></span>');
        // prevent monthly coupons to be used on yearly plans (coupons only for monthly subscriptions)
        if ($("#paidAnnuallyRadio").is(':checked')) {
            $.ajax({
                url: "/app/getcoupon",
                data: {'new_coupon': couponValue},
                type: 'POST',
                cache: false,
                success: function (response) {
                    loadingBarCustom(false);
                    $('#onClickPaymentByCreditCard').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    $('#onClickPaymentByPaypal').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    $('#onClickPaymentByPaynow').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    if(response == 'invalid coupon code') {
                        $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                        $('.btn-subscription-coupon').removeClass('Polaris-Button--loading');
                        $('.btn-subscription-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Apply coupon</span></span>');
                        customToastMessage("Invalid coupon code", true);
                        return false;
                    }
                    if (response.coupon_duration_months != null || response.coupon_duration_months > 0) {
                        subscriptionCouponInput.val("");
                        customToastMessage("Coupon code not applicable to yearly plans", false);
                        $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                        $('.btn-subscription-coupon').removeClass('Polaris-Button--loading');
                        $('.btn-subscription-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Apply coupon</span></span>');
                        return false;
                    } else {
                        if(selectedPaymentMethod !== 'paypal'){
                            sendToApplySubscriptionCoupon(couponValue);
                        }
                    }
                }
            });
        } else {
            if(selectedPaymentMethod !== 'paypal'){
                sendToApplySubscriptionCoupon(couponValue);
            }
        }
    }

    // send request to apply subscription coupon
    function sendToApplySubscriptionCoupon(coupon) {
        loadingBarCustom();
        if (coupon) {
            $("#subscriptionCoupon").val(coupon);
        }
        var plan_id = $('#plan_id').val();
        $('#currentplan_id').val(plan_id);
        $.ajax({
            url: "/app/applycoupon",
            data: {'subscription_coupon': coupon},
            type: 'POST',
            cache: false,
            success: function (response) {
                loadingBarCustom(false);
                if(response == 'invalid coupon code.') {
                    $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    $('.btn-subscription-coupon').removeClass('Polaris-Button--loading');
                    $('.btn-subscription-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Apply coupon</span></span>');
                    customToastMessage("Invalid coupon code", false);
                    return false;
                } else {
                    customToastMessage("Coupon code applied.");
                    window.location.href = "{{config('env-variables.APP_PATH')}}";
                }
            },
        });
    }

    // coupons for new subscriptions
    function applyNewCoupon() {
        $('#discountsDiv').hide();
        var coupon = $('#newCoupon').val();
        var newCouponInput = $('#newCoupon');
        var couponValue = newCouponInput.val();
        var exitCode = "{{$exit_code}}";
        var newCode = "{{$new_code}}";
        var annual_price = $('#subtotal_price').val();

        let selectedPaymentMethod = $('input[name="methodOfPayment"]:checked').val();
        if(!selectedPaymentMethod){
            return false;
        } else {
            if(selectedPaymentMethod == 'paypal'){
                customToastMessage("Coupon code not applicable for Paypal payment method", false);
                return false;
            }
        }

        // empty
        if (!couponValue) {
            customToastMessage("No coupon code entered", false);
                return false;
        }

        @if($all_addons != 1)
        // prevent coupons offered to existing customers only (coupons only for active subscriptions)
        if (couponValue == exitCode || couponValue == "STAYSAFE30") {
            $('#newCoupon').val('');
            customToastMessage("Coupon code not applicable to new subscriptions", false);
                return false;
        }
        @endif

        loadingBarCustom();

        $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('#onClickPaymentByCreditCard').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('#onClickPaymentByPaypal').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('#onClickPaymentByPaynow').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('.btn-new-coupon').addClass('Polaris-Button--loading');
        $('.btn-new-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Apply coupon</span></span>');

        $.ajax({
            url: "/app/getcoupon",
            data: {'new_coupon': couponValue},
            type: 'POST',
            cache: false,
            success: function (response) {
                $('.plan-discount').show();
                loadingBarCustom(false);
                $('#onClickPaymentByCreditCard').removeClass('Polaris-Button--disabled').prop("disabled", false);
                $('#onClickPaymentByPaypal').removeClass('Polaris-Button--disabled').prop("disabled", false);
                $('#onClickPaymentByPaynow').removeClass('Polaris-Button--disabled').prop("disabled", false);
                // prevent monthly coupons to be used on yearly plans (coupons only for monthly subscriptions)
                if ($("#paidAnnuallyRadio").is(':checked')) {
                    if (response.coupon_duration_months != null || response.coupon_duration_months > 0) {
                        customToastMessage("Coupon code not applicable to yearly plans", false);
                        // recalculate total price if there's a prorated amount
                        $('.showOnnewcoupon').html('');
                        dis = 0;
                        $('.plan-discount').hide();
                        if ($(".prorated-amount").text()) {
                            var t = $('.total-price').text();
                            total = parseFloat(t) - dis;
                            if (total < 0) {
                                $('.total-price').text("0.00");
                            } else {
                                $('.total-price').text(total.toFixed(2));
                            }
                        } else {
                            total = annual_price - dis;
                            $('.total-price').text(total.toFixed(2));
                        }

                        $('.subtotal').text(annual_price);
                        if(dis > 0){
                            $('.discounts').text(dis.toFixed(2));
                            $('.discountsDiv').show();
                        } else {
                            $('.discountsDiv').hide();
                        }

                        $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                        $('.btn-new-coupon').removeClass('Polaris-Button--loading');
                        $('.btn-new-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Apply coupon</span></span>');
                        return false;
                    }
                }
                var total = '';
                var discount = '';
                var percent_off = '';
                var coupon_name = '';
                var coupon_duration = '';
                var coupon_duration_months = '';
                if (response.status) {
                    coupon_name = response.coupon_name;
                    coupon_duration = response.coupon_duration;
                    if(getCookie('discount-code')=='' || getCookie('discount-code')==undefined || coupon_name != '')
                    {
                        setCookie('discount-code',coupon_name,60);
                    }
                    if (coupon_duration == 'repeating') {
                        coupon_duration = 'for';
                    }
                    coupon_duration_months = response.coupon_duration_months;
                    if (coupon_duration_months) {
                        coupon_duration_months = coupon_duration_months + ' months';
                    } else {
                        coupon_duration_months = '';
                    }
                    if (response.percent_off) {
                        discount = annual_price * response.percent_off / 100;
                        percent_off = response.percent_off + '% off';
                    } else {
                        discount = response.amount_off / 100;
                        var percent_off_1 = response.amount_off / 100;
                        var percent_off_2 = percent_off_1.toFixed(2);
                        percent_off = 'US$' + percent_off_2 + ' off';
                    }
                    $('#addnewcoupon').val(coupon_name);
                    $('.showOnnewcoupon').html('<span class="newcouponDescription"> → ' + percent_off + ' ' + coupon_duration + ' ' + coupon_duration_months + '</span>');
                    $('#discountsDiv').show();
                    customToastMessage(response.status);
                } else {
                    $('.showOnnewcoupon').html('');
                    discount = 0;
                    $('.plan-discount').hide();
                    customToastMessage("Invalid coupon code", false);
                }
                // recalculate total price if there's a prorated amount
                if ($(".prorated-amount").text()) {
                    var toatal = $('.total-price').text();
                    const proratedBalance = parseInt($('.prorated-balance').text());
                    $('.prorated-balance').text(proratedBalance + discount);
                    total = parseInt(toatal) - discount;

                    if (total < 0) {
                        $('.total-price').text("0.00");
                    } else {
                        $('.total-price').text(total.toFixed(2));
                    }
                } else {
                    total = annual_price - discount;
                    $('.total-price').text(total.toFixed(2));
                }

                $('.subtotal').text(annual_price);

                if(discount > 0){
                    $('.discounts').text(discount.toFixed(2));
                    $('.discountsDiv').show();
                } else {
                    $('.discountsDiv').hide();
                }
                $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                $('.btn-new-coupon').removeClass('Polaris-Button--loading');
                $('.btn-new-coupon').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Apply coupon</span></span>');
            }
        });
    }

    let subPlan = '';
    let isActivePlan = '';

    isActivePlan = '{{ $isActivePlan }}';
    subPlan = '{{ $subPlan }}';

    // alert(isActivePlan);

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function deleteCookie(name) {
        document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }


    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
            function(m,key,value) {
                vars[key] = value;
            });
        return vars;
    }

    var code = getUrlVars()["code"];
    if( code ) {
        setCookie('discount-code', code, 60);
    }

    @if($plan_name == $starter)
       setSubscriptionValues('{{$master_shop}}', '{{$starter}}', '{{$starterPriceMonthly}}', '{{$starterPriceQuarterly}}', '{{$starterPriceAnnually}}', '{{$starteridMonthly}}', '{{$starteridQuarterly}}', '{{$starteridAnnually}}', '{{$active_add_ons}}', '{{$starterLimit}}', isActivePlan, subPlan, '{{$all_addons}}');

    @elseif($plan_name == $hustler)
      setSubscriptionValues('{{$master_shop}}', '{{$hustler}}', '{{$hustlerPriceMonthly}}', '{{$hustlerPriceQuarterly}}', '{{$hustlerPriceAnnually}}', '{{$hustleridMonthly}}', '{{$hustleridQuarterly}}', '{{$hustleridAnnually}}', '{{$active_add_ons}}', '{{$hustlerLimit}}', isActivePlan, subPlan, '{{$all_addons}}');

    @elseif($plan_name == $guru)
      setSubscriptionValues('{{$master_shop}}', '{{$guru}}', '{{$guruPriceMonthly}}', '{{$guruPriceQuarterly}}', '{{$guruPriceAnnually}}', '{{$guruidMonthly}}', '{{$guruidQuarterly}}', '{{$guruidAnnually}}', '{{$active_add_ons}}', '{{$guruLimit}}', isActivePlan, subPlan, '{{$all_addons}}');
    @endif

    // all add-ons subscription
    function setSubscriptionValues(master_shop, plan_name, monthly_price, quarterly_price, annual_price, monthly_id, quarterly_id, annual_id, active_add_ons, plan_limit, active_plan, sub_plan, all_addons) {
        // Setup modal elements
        $('.plan-name').text(plan_name);
        $('.payment_cycle').val(plan_name);
        $('.annual-price').text((annual_price * 1).toFixed(2));
        $('.quarterly-price').text((quarterly_price * 1).toFixed(2));
        $('.monthly-price').text((monthly_price * 1).toFixed(2));
        $(".annual-discount-money").text("$" + ((monthly_price * 12) - annual_price).toFixed(2) + " USD");
        $(".quarterly-discount-money").text("$" + ((monthly_price * 12) - (quarterly_price * 4)).toFixed(2) + " USD");
        $(".annual-discount-percentage").text(((annual_price / (monthly_price * 12)) * 100).toFixed(0) + "%");
        $(".quarterly-discount-percentage").text(100 - (((quarterly_price * 4) / (monthly_price * 12)) * 100).toFixed(0) + "%");
        $('#discountsDiv').hide();
        $('#newCoupon').val('');
        $('.plan-discount').hide();
        $('.showOnnewcoupon').html('');
        $('#addnewcoupon').val('');
        $("#paymentByCredit").prop('checked', true); //Need to hide for paypal coupon code
        var trialdays = '{{$trial_days}}';

        var price_data = '';
        window.dataLayer = window.dataLayer || [];
        if (plan_name == '{{$starter}}') {
            price_data = '19';
        } else if (plan_name == '{{$hustler}}') {
            price_data = '47';
        } else {
            price_data = '97';
        }

        // product click event
        dataLayer.push({
            'ecommerce': {
                'currencyCode': 'USD',
                'click': {
                    'products': [{
                        'name': plan_name,        // is required
                        'id': monthly_id,          // is required
                        'price': price_data
                    }]
                }
            },
            'event': 'EE-event',
            'EE-event-category': 'Enhanced Ecommerce',
            'EE-event-action': 'Product Clicks',
            'EE-event-non-interaction': 'False',
        });

        // show notice if it's a managed store
        if (master_shop) {
            customToastMessage("This store's subscription is managed by " + master_shop, false);
            window.location="{{ route('plans') }}";
        }

        // show notice if too many addons to downgrade
        if (parseInt(active_add_ons) > parseInt(plan_limit)) {
            customToastMessage("Too many Add-Ons activated to downgrade plan", false, 3000);
            $('.Start-Plan').hide();
            openModal($("#uninstalladdonModal"));
           // return false;
        }

        // setPlanDetails
        var subMonthly = "monthly";
        var subQuarterly = "quarterly";
        var subYearly = "yearly";
        const monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        function setPlanDetails(showPlan, callback = undefined) {
            // reset values
            $('#discountsDiv').hide();
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

                    $.ajax({
                        url: "/app/prorateamount",
                        data: {'plan_id': plan_id},
                        type: 'POST',
                        cache: false,
                        success: function (response) {
                            response_prorated_amount = response.prorated_amount;
                            prorated_amount = response_prorated_amount * -1; // 28200

                            if (prorated_amount) {
                                var total = plan_price - prorated_amount;
                                if(prorated_amount != 0 ){
                                    $(".plan-prorated").show();
                                }
                                if((prorated_amount - plan_price) > 0){
                                    $(".prorated-balance").text((total * -1).toFixed(2));
                                    $("#prorated-balanceDiv").show();
                                } else {
                                    $("#prorated-balanceDiv").hide();
                                }


                                if (total > 0) {
                                    $('.total-price').text((total).toFixed(2));
                                } else {
                                    $('.total-price').text("0.00");
                                    $(".plan-balance").show();
                                }

                                $(".prorated-amount").text(prorated_amount.toFixed(2));
                            }

                            if(callback != undefined)
                                callback()
                        }
                    });
                }else if(callback != undefined){
                    callback();
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

                        $('.Delete-Subscription').show();
                        $('.Unpause-Subscription').show();
                        $('.Validation-message').hide();
                        $('.Start-Plan').hide();

                        $('#secondarySection').hide();
                        $('#pause_plan_section').show();
                    } else if (sub_plan == 'month' || sub_plan == 'Quarterly') {
                        $('.showOnActivePlan').hide();
                        $('.hideOnActivePlan').show();

                        $('.Delete-Subscription').hide();
                        $('.Unpause-Subscription').hide();
                        $('.Start-Plan').show();

                        $('#secondarySection').show();
                        $('#pause_plan_section').hide();
                    }
                }

                @if (config('env-variables.APP_TRACKING'))
                // initiate checkout tracking - annually
                    if (sub_plan != 'Yearly') {
                        if (sessionStorage.getItem("initiateCheckoutYearly")) {
                        } else {
                            var subscriptionValue = annual_price;
                            var subscriptionId = annual_id;
                            window.dataLayer.push({
                                'subscriptionValue': subscriptionValue,
                                'subscriptionId': subscriptionId,
                                'event': 'initiate_checkout'
                            });
                            sessionStorage.setItem('initiateCheckoutYearly', 'yes');
                        }
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

                        $('.Delete-Subscription').show();
                        $('.Unpause-Subscription').show();
                        $('.Validation-message').hide();
                        $('.Start-Plan').hide();

                        $('#secondarySection').hide();
                        $('#pause_plan_section').show();
                    } else if (sub_plan == 'month' || sub_plan == 'Yearly') {
                        $('.showOnActivePlan').hide();
                        $('.hideOnActivePlan').show();

                        $('.Delete-Subscription').hide();
                        $('.Unpause-Subscription').hide();
                        $('.Start-Plan').show();

                        $('#secondarySection').show();
                        $('#pause_plan_section').hide();
                    }
                }

                @if (config('env-variables.APP_TRACKING'))
                // initiate checkout tracking - quarterly
                    if (sub_plan != 'Quarterly') {
                        if (sessionStorage.getItem("initiateCheckoutQuarterly")) {
                        } else {
                            var subscriptionValue = quarterly_price;
                            var subscriptionId = quarterly_id;
                            window.dataLayer.push({
                                'subscriptionValue': subscriptionValue,
                                'subscriptionId': subscriptionId,
                                'event': 'initiate_checkout'
                            });
                            sessionStorage.setItem('initiateCheckoutQuarterly', 'yes');
                        }
                    }
                @endif
            } else if (showPlan == "monthly") { // show monthly
                $("#paidMonthlyRadio").prop('checked', true);
                $('.plan-price').text((monthly_price * 1).toFixed(2));
                $('.total-price').text((monthly_price * 1).toFixed(2));
                $(".billing-days").text("month");
                $(".save-message-monthly").show();

                // stripe form
                $('#plan_id').val(monthly_id);
                $("#subtotal_price").val(monthly_price);
                $('#sub_plan').val("month");
                // stripe form end

                // get proration
                getProration(monthly_id, monthly_price);

                if (active_plan == 1) {
                    if (sub_plan == 'Yearly' || sub_plan == 'Quarterly') {
                        $('.showOnActivePlan').hide();
                        $('.hideOnActivePlan').show();

                        $('.Delete-Subscription').hide();
                        $('.Unpause-Subscription').hide();
                        $('.Start-Plan').show();

                        $('#secondarySection').show();
                        $('#pause_plan_section').hide();

                    } else if (sub_plan == 'month') {
                        $('.showOnActivePlan').show();
                        $('.hideOnActivePlan').hide();

                        $('.Delete-Subscription').show();
                        $('.Unpause-Subscription').show();
                        $('.Start-Plan').hide();

                        $('#secondarySection').hide();
                        $('#pause_plan_section').show();
                    }
                }

                @if (config('env-variables.APP_TRACKING'))
                    // initiate checkout tracking - monthly
                    if (sub_plan != 'month') {
                        if (sessionStorage.getItem("initiateCheckoutMonthly")) {
                        } else {
                            var subscriptionValue = monthly_price;
                            var subscriptionId = monthly_id;
                            window.dataLayer.push({
                                'subscriptionValue': subscriptionValue,
                                'subscriptionId': subscriptionId,
                                'event': 'initiate_checkout'
                            });
                            sessionStorage.setItem('initiateCheckoutMonthly', 'yes');
                        }

                    }
                @endif
            }
        }

        // active plan for url params
        if (active_plan == 1) {
            if(urlParams.get('billing') == 'monthly') {
                if("{{$all_addons}}" == 1 && "{{$sub_plan}}" == 'month' && "{{$second_bar}}" != 1){
                    $("#secondarySection").hide();
                }
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickMonthlyRadio").addClass('selected-background');
                setPlanDetails(subMonthly);
            } else if (urlParams.get('billing') == 'quarterly') {
                if("{{$all_addons}}" == 1 && "{{$sub_plan}}" == 'Quarterly' && "{{$second_bar}}" != 1){
                    $("#secondarySection").hide();
                }
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").addClass('selected-background');
                setPlanDetails(subQuarterly);
                $('.quarterly-discount-badge').hide();
            } else {
                if("{{$all_addons}}" == 1 && "{{$sub_plan}}" == 'Yearly' && "{{$second_bar}}" != 1) {
                    $("#secondarySection").hide();
                }
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickYearlyRadio").addClass('selected-background');
                setPlanDetails(subYearly);
                $('.annual-discount-badge').hide();
            }
            $('.active-badge').show();
        } else {
            if(urlParams.get('billing') == 'monthly') {
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickMonthlyRadio").addClass('selected-background');
                if(getCookie('discount-code') != "") {
                    $('#newCoupon').val(getCookie('discount-code'));
                    setPlanDetails(subMonthly, applyNewCoupon);
                } else {
                    setPlanDetails(subMonthly);
                }
            } else if(urlParams.get('billing') == 'quarterly') {
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").addClass('selected-background');
                if(getCookie('discount-code') != "") {
                    $('#newCoupon').val(getCookie('discount-code'));
                    setPlanDetails(subQuarterly, applyNewCoupon);
                } else {
                    setPlanDetails(subQuarterly);
                }
            } else {
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickYearlyRadio").addClass('selected-background');
                if(getCookie('discount-code') != "") {
                    $('#newCoupon').val(getCookie('discount-code'));
                    setPlanDetails(subYearly, applyNewCoupon);
                } else {
                    setPlanDetails(subYearly);
                }
            }
            $('.annual-discount-badge').show();
            $('.active-badge').hide();
        }

        $("#onClickPaymentByCreditCard").on("click", function(e){
            let current_plan = $('input[name="paymentRadio"]:checked').val(); //p-check
            if (current_plan==="annually"){
                setPlanDetails(subYearly);
            }
            if (current_plan==="quarterly"){
                setPlanDetails(subQuarterly);
            }
            if (current_plan==="monthly"){
                setPlanDetails(subMonthly);
            }
            // console.log("current_plan cc",current_plan);
            e.preventDefault();
            $('#credit-card-button-container-wrapper').show();
            $('#paypal-button-container-wrapper').hide();
            $("#paypal-button-container").hide();
            $("#paymentByCredit").prop('checked', true);
                // $('.Start-Plan').show();
            $("#onClickPaymentByPaypal").removeClass('selected-background');
            $("#paypalPaymentDiv").hide();
            $("#creditCardPaymentDiv").show();
            $("#onClickPaymentByCreditCard").addClass('selected-background');
            $("#couponCodeDivLabel").show();
            $("#couponCodeDiv").show();
            $("#onClickPaymentByPaynow").removeClass('selected-background');
            $('#paynow-button-container-wrapper').hide();
            if(getCookie('discount-code') != ""){
                $('#newCoupon').val(getCookie('discount-code'));
                applyNewCoupon();
                // deleteCookie('discount-code');
            }
        })
        $("#onClickPaymentByPaypal").on("click", function(e){
            let current_plan = $('input[name="paymentRadio"]:checked').val(); //p-check
            if (current_plan==="annually"){
                setPlanDetails(subYearly);
            }
            if (current_plan==="quarterly"){
                setPlanDetails(subQuarterly);
            }
            if (current_plan==="monthly"){
                setPlanDetails(subMonthly);
            }
            // console.log("current_plan pp",current_plan);
            e.preventDefault();
            $('#paypal-button-container-wrapper').show();
            $("#paypal-button-container").show();
            $('#credit-card-button-container-wrapper').hide();
            $("#paymentByPaypal").prop('checked', true);
            $("#onClickPaymentByCreditCard").removeClass('selected-background');
            $("#onClickPaymentByPaypal").addClass('selected-background');
            $("#couponCodeDivLabel").hide();
            $("#couponCodeDiv").hide();
            $("#onClickPaymentByPaynow").removeClass('selected-background');
            $('#paynow-button-container-wrapper').hide();
            if(getCookie('discount-code') != ""){
                $('#newCoupon').val(getCookie('discount-code'));
                applyNewCoupon();
                // deleteCookie('discount-code');
            }

        })
        $("#onClickPaymentByPaynow").on("click", function(e){
            let current_plan = $('input[name="paymentRadio"]:checked').val(); //p-check
            if (current_plan==="annually"){
                setPlanDetails(subYearly);
            }
            if (current_plan==="quarterly"){
                setPlanDetails(subQuarterly);
            }
            if (current_plan==="monthly"){
                setPlanDetails(subMonthly);
            }
            // console.log("current_plan pn",current_plan);
            e.preventDefault();
            $("#onClickPaymentByPaynow").addClass('selected-background');
            $('#paynow-button-container-wrapper').show();
            $("#paymentByPaynow").prop('checked', true);
            $("#paypal-button-container").hide();
            $('#credit-card-button-container-wrapper').hide();
            $("#onClickPaymentByCreditCard").removeClass('selected-background');
            $("#onClickPaymentByPaypal").removeClass('selected-background');
            $("#couponCodeDivLabel").show();
            $("#couponCodeDiv").show();
            if(getCookie('discount-code') != ""){
                $('#newCoupon').val(getCookie('discount-code'));
                applyNewCoupon();
                // deleteCookie('discount-code');
            }
        })
        let selectedPaymentMethod ;
        $("#onClickMonthlyRadio").on("click", function(e){
            e.preventDefault();
            selectedPaymentMethod = $('input[name="methodOfPayment"]:checked').val();
            if((all_addons == 1) && (sub_plan == 'month') && ("{{$alladdons_plan}}" == "{{$plan_name}}")){
                $("#secondarySection").hide();
                $("#paidMonthlyRadio").prop('checked', true);
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickMonthlyRadio").addClass('selected-background');
                $(".save-message-monthly").show();
                $(".save-message-annually").hide();
                $(".save-message-quarterly").hide();
                $('.Delete-Subscription').show();
                $('.Unpause-Subscription').show();

                $('#secondarySection').hide();
                $('#pause_plan_section').show();

                @if($is_paused == 1)
                    setPlanDetails(subMonthly);
                @endif
            } else {
                selectedPaymentMethod == "paypal" ? $('#paypal-button-container-wrapper').show() :$('#paypal-button-container-wrapper').hide();
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickMonthlyRadio").addClass('selected-background');
                if(getCookie('discount-code') != ""){
                    $('#newCoupon').val(getCookie('discount-code'));
                    setPlanDetails(subMonthly, applyNewCoupon);
                    // deleteCookie('discount-code');
                } else if($('#newCoupon').val() != ""){
                    setPlanDetails(subMonthly, applyNewCoupon);
                } else {
                    setPlanDetails(subMonthly);
                }

                //  if(selectedPaymentMethod !='paypal')
                //  {
                //     $("#secondarySection").show();
                // }
            }
            togglePaymentRequestButton();
        });

        $("#onClickQuarterlyRadio").on("click", function(e){
            e.preventDefault();
            selectedPaymentMethod = $('input[name="methodOfPayment"]:checked').val();
            if(("{{$all_addons}}" == 1) && ("{{$sub_plan}}" == 'Quarterly') && ("{{$alladdons_plan}}" == "{{$plan_name}}")){
                selectedPaymentMethod == "paypal" ? $('#paypal-button-container-wrapper').show() :$('#paypal-button-container-wrapper').hide();
                $("#secondarySection").hide();
                $("#paidQuarterlyRadio").prop('checked', true);
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").addClass('selected-background');
                $(".save-message-monthly").hide();
                $(".save-message-annually").hide();
                $(".save-message-quarterly").show();
                $('.Delete-Subscription').show();
                $('.Unpause-Subscription').show();

                $('#secondarySection').hide();
                $('#pause_plan_section').show();

                @if($is_paused == 1)
                    setPlanDetails(subQuarterly);
                @endif
            } else {
                selectedPaymentMethod == "paypal" ? $('#paypal-button-container-wrapper').show() :$('#paypal-button-container-wrapper').hide();
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickYearlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").addClass('selected-background');
                if(getCookie('discount-code') != ""){
                    $('#newCoupon').val(getCookie('discount-code'));
                    setPlanDetails(subQuarterly, applyNewCoupon);
                    // deleteCookie('discount-code');
                } else if($('#newCoupon').val() != ""){
                    setPlanDetails(subQuarterly, applyNewCoupon);
                } else {
                    setPlanDetails(subQuarterly);
                }
            }

            togglePaymentRequestButton();
        });

        $("#onClickYearlyRadio").on("click", function(e){
            e.preventDefault();
            selectedPaymentMethod = $('input[name="methodOfPayment"]:checked').val();
             if(("{{$all_addons}}" == 1) && ("{{$sub_plan}}" == 'Yearly') && ("{{$alladdons_plan}}" == "{{$plan_name}}")){
                selectedPaymentMethod == "paypal" ? $('#paypal-button-container-wrapper').show() :$('#paypal-button-container-wrapper').hide();
                $("#secondarySection").hide();
                $("#paidAnnuallyRadio").prop('checked', true);
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickYearlyRadio").addClass('selected-background');
                $(".save-message-monthly").hide();
                $(".save-message-quarterly").hide();
                $(".save-message-annually").show();
                $('.Delete-Subscription').show();
                $('.Unpause-Subscription').show();

                $('#secondarySection').hide();
                $('#pause_plan_section').show();

                @if($is_paused == 1)
                    setPlanDetails(subYearly);
                @endif
            } else {
                selectedPaymentMethod == "paypal" ? $('#paypal-button-container-wrapper').show() :$('#paypal-button-container-wrapper').hide();
                $("#onClickMonthlyRadio").removeClass('selected-background');
                $("#onClickQuarterlyRadio").removeClass('selected-background');
                $("#onClickYearlyRadio").addClass('selected-background');
                if(getCookie('discount-code') != ""){
                    $('#newCoupon').val(getCookie('discount-code'));
                    setPlanDetails(subYearly, applyNewCoupon);
                    // deleteCookie('discount-code');
                } else if($('#newCoupon').val() != ""){
                    setPlanDetails(subYearly, applyNewCoupon);
                } else {
                    setPlanDetails(subYearly);
                }
                // if(selectedPaymentMethod !='paypal')
                // {
                //     $("#secondarySection").show();
                // }
            }

            togglePaymentRequestButton();
        });

        // set form action
        var form = document.getElementById('StripeForm');
        form.setAttribute("action", "{{ route('all_subscription') }}");
    }

    // cancel subscription
    function openCancelModal(store_count, subplan, trialdays) {
        var currentCoupon = "{{$coupon_name}}";
        var exitCode = "{{$exit_code}}";

        // offer discount
        function offerDiscount() {
            $(".acceptOffer").click(function () {
                $("#subscriptionCoupon").val(exitCode);
                applySubscriptionCoupon(exitCode);
                $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
                $('.acceptOffer').addClass('Polaris-Button--loading');
                $('.acceptOffer').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Claim offer now</span></span>');
            });

            $(".denyOffer").click(function () {
                $("#offerDiscountModal").hide()
                cancel();
            });

            // show modal
            var modal = $("#confirmCancelSubscriptionModal");
            openModal(modal);
        }

        // cancel
        function cancel() {
            var message = "Are you sure you want to cancel your subscription? This action cannot be reversed.";
            if (store_count > 0) {
                message = "Are you sure you want to cancel your subscription? All linked store's subscriptions will also be canceled. This action cannot be reversed.";
            }

            var form = document.getElementById('cancel_form');
            form.setAttribute("action", "{{ route('cancel_all_subscription') }}");

            $("#confirmCancelSubscriptionModalText").html(message);
            var modal = $("#confirmCancelSubscriptionModal");
            openModal(modal);
        }

        setTimeout(function () {
            if (subplan == "month" && currentCoupon != exitCode) {
                offerDiscount();
            } else {
                cancel();
            }
        }, 100);
    }

    // Update card modal
    function openUpdateCardModal() {

        if(!$('#paymentByCredit').prop('checked')) {
            return;
        }

        //show modal
        var modal = $("#updateCardModal");
        openModal(modal);
    }

    function togglePaymentRequestButton() {
        if ($("#secondarySection").is(":visible") && paymentRequestButtonSupported) {
            // $(".separator").show();
             $("#payment-request-button").show();
            // $(".payment-method-image").show();
        } else {
            // $(".separator").hide();
             $("#payment-request-button").hide();
            // $(".payment-method-image").hide();
        }
    }

    <!-- Stripe -->
    // Create a Stripe client.
    var stripe = Stripe('{{ config("services.stripe.key") }}');
    // Create an instance of Elements.
    var elements = stripe.elements();
    var elementsub = stripe.elements();
    var paymentRequest = stripe.paymentRequest({
        country: 'US',
        currency: 'usd',
        total: {
            label: $('#payment_cycle').val() + " Subscription",
            amount: parseInt($(".total-price").first().text().replace('.', '')),
        },
        requestPayerName: true,
        requestPayerEmail: true,
    });
    var prButton = elements.create('paymentRequestButton', {
        paymentRequest: paymentRequest,
    });

    // Update price on button click
    prButton.on('click', function(event) {
        if ($("#secondarySection").is(":visible") && !$('#PolarisCheckboxTerms').is(':checked')) {
            customToastMessage("Please Agree To Terms of sales and terms of use", false);
            event.preventDefault();
        }

        paymentRequest.update({
            total: {
                label: $('#payment_cycle').val() + " Subscription",
                amount: parseInt($(".total-price").first().text().replace('.', '')),
            },
        });
    });

    // Check the availability of the Payment Request API first.
    paymentRequest.canMakePayment().then(function(result) {
        if (result) {
            paymentRequestButtonSupported = true;
            prButton.mount('#payment-request-button');
            $(".separator").show();
        } else {
            document.getElementById('payment-request-button').style.display = 'none';
            $(".separator").hide();
        }

        togglePaymentRequestButton();
    });

    paymentRequest.on('token', function(event) {
        const token = event.token

        if (token) {
            stripeSourceHandler(token, true); // Update Card
        }

        event.complete('success'); // Completes the transaction and closes Google/Apple pay
    });

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    @if($all_addons != 1)
        var cardsub = elementsub.create('card', {style: style});
        cardsub.mount('#card-elementsub');
        cardsub.addEventListener('change', function (event) {
            var displayError = document.getElementById('card-errorsub');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {

                @if (config('env-variables.APP_TRACKING'))
                //add payment info tracking
                    if (sessionStorage.getItem("addPaymentInfo")) {
                    } else {
                        window.dataLayer.push({'event': 'add_payment_info'});
                        sessionStorage.setItem('addPaymentInfo', 'yes');
                    }
                @endif
                    displayError.textContent = '';
            }
        });
    @endif
    card.mount('#card-elementsub-update');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errorsub');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            @if (config('env-variables.APP_TRACKING'))
            //add payment info tracking
            if(sessionStorage.getItem("addPaymentInfo")){} else{
                window.dataLayer.push({'event': 'add_payment_info'});
                sessionStorage.setItem('addPaymentInfo','yes');
            };
            @endif

            displayError.textContent = '';
        }
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token, form_id) {
        console.log("stripeTokenHandler");
        // Insert the token ID into the form so it gets submitted to the server
        var form = document.getElementById(form_id);
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('id', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        try {
            var lmref = lmFinished()
            var linkminkInput = document.createElement('input');
            linkminkInput.setAttribute('type', 'hidden');
            linkminkInput.setAttribute('name', 'linkminkRef');
            linkminkInput.setAttribute('value', lmref);
            form.appendChild(linkminkInput);
        } catch (error) {
            console.error(error);
        }
        ;
        // Submit the form
        form.submit();
    }

    // change subscription plan
    function AllAdonsSubscriptioncard() {

        if ($('#PolarisCheckboxTerms').is(':checked')) {
            var form = document.getElementById('StripeForm');
            loadingBarCustom();

            $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
            $('.Start-Plan').addClass('Polaris-Button--loading');
            $('.Start-Plan').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Start plan</span></span>');

            // get total value after coupon code
            var subscriptionValue = $(".gtm-total-price").text();

            // checkout event
            dataLayer.push({
                'ecommerce': {
                    'currencyCode': 'USD',
                    'checkout': {
                        'actionField': {'step': 1, 'option': sub_plan.value},
                        'products': [{
                            'name': form.elements['payment_cycle'].value,        // is required
                            'id': form.elements['plan_id'].value,       // is required
                            'price': form.elements['subtotal_price'].value,
                            'quantity': 1            // quantity of the products
                        }]
                    }
                },
                'event': 'EE-event',
                'EE-event-category': 'Enhanced Ecommerce',
                'EE-event-action': 'Checkout',
                'EE-event-non-interaction': 'False',
            });

            form.submit();
        } else {
            customToastMessage("Please Agree To Terms of sales and terms of use", false);
        }
    }

    // create new subscription plan
    function AllAdonsSubscription() {
        if ($('#PolarisCheckboxTerms').is(':checked')) {
            var form = document.getElementById('StripeForm');
            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error.
                    var errorElement = document.getElementById('card-errorsub');
                    errorElement.textContent = result.error.message;
                } else {
                    loadingBarCustom();

                    $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
                    $('.Start-Plan').addClass('Polaris-Button--loading');
                    $('.Start-Plan').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Start plan</span></span>');

                    // get total value after coupon code
                    var subscriptionValue = $(".gtm-total-price").text();

                    // checkout event
                    dataLayer.push({
                        'ecommerce': {
                            'currencyCode': 'USD',
                            'checkout': {
                                'actionField': {'step': 1, 'option': sub_plan.value},
                                'products': [{
                                    'name': form.elements['payment_cycle'].value,        // is required
                                    'id': form.elements['plan_id'].value,       // is required
                                    'price': form.elements['subtotal_price'].value,
                                    'quantity': 1            // quantity of the products
                                }]
                            }
                        },
                        'event': 'EE-event',
                        'EE-event-category': 'Enhanced Ecommerce',
                        'EE-event-action': 'Checkout',
                        'EE-event-non-interaction': 'False',
                    });

                    setTimeout(function () {
                        // Send the token to your server.
                        stripeTokenHandler(result.token, 'StripeForm');
                    }, 100);
                }
            });
        } else {
            customToastMessage("Please Agree To Terms of sales and terms of use", false);
        }
    }

    // update card - deprecated, replaced by customer source
    function updateCardForm() {
        stripe.createSource(card).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errorsub-update');
                errorElement.textContent = result.error.message;
            } else {
                @if($card_number == '')
                    loadingBarCustom(false);
                    let cardNumber = result.source.card.last4;
                    let cardBrand = result.source.card.brand;

                    $('.credit-card-text').html(cardBrand + ' Card ending in ' + cardNumber);
                    var modal = $("#updateCardModal").closest(".modal");
                    $('.addCreditCardText').text("Replace Credit Card");
                    $('.Start-Plan').removeClass('Polaris-Button--disabled');
                    $("#updateCardModal").hide();
                    closeModal(modal);
                @else

                // Send the source to your server
                loadingBarCustom();
                    $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
                    $('.all_addon_subscribe').addClass('Polaris-Button--loading');
                    $('.all_addon_subscribe').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Update card</span></span>');
                    stripeSourceHandler(result.source);
                @endif
            }
        });
    }

    // source update customer
    function stripeSourceHandler(source, isPaymentRequestButton) {
        console.log("stripeSourceHandler");

        var updateCardUrl = '{{ route('updatecreditCard') }}';
        $.ajax({
            url: updateCardUrl,
            data: {'stripeToken': source.id},
            type: 'POST',
            cache: false,
            success: function (response) {
                    loadingBarCustom(false);
                    $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    $('.all_addon_subscribe').removeClass('Polaris-Button--loading');
                    $('.all_addon_subscribe').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Update Card</span></span>');

                    let cardNumber = source.card.last4;
                    let cardBrand = source.card.brand;

                    $('.credit-card-text').html(cardBrand + ' Card ending in ' + cardNumber);
                    var modal = $("#updateCardModal").closest(".modal");
                    closeModal(modal);
                    $("#updateCardModal").hide();
                    customToastMessage(response.message);

                    if (isPaymentRequestButton) {
                        $('.addCreditCardText').text("Replace Credit Card");

                        if (response.message == 'Payment Method Updated Successfully.') {
                            loadingBarCustom();
                            $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
                            $('.Start-Plan').addClass('Polaris-Button--loading');
                            $('.Start-Plan').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Start plan</span></span>');
                            stripeTokenHandler(source, 'StripeForm'); // Start Plan
                        }
                    }

                    return false;
            }
        });
    }

    /** from debutify page **/

    function loadingBarCustom(start = true) {
        if (start == true) {
            if (typeof rotate !== 'undefined') {
                $('.Polaris-Frame-Loading').css('display', 'none');
                clearTimeout(rotate);
            }
            loadBarRecursive();
            $('.Polaris-Frame-Loading').css('display', 'block');
        } else {
            $('.Polaris-Frame-Loading').css('display', 'none');
            if (typeof rotate !== 'undefined') {
                clearTimeout(rotate);
            }
        }
    }

    function customToastMessage(message, success = true, timeout = 1000) {
        if (success) {
            var bgColor = 'black';
            var textColor = 'white';
        } else {
            var bgColor = '#DE3618';
            var textColor = 'white';
        }
        setTimeout(function () {
            $.toast({
                text: "<p class='toast-text'>" + message + "</p>",
                showHideTransition: 'slide',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 1,
                position: 'bottom-center',
                textAlign: 'center',
                loader: false,
                bgColor: bgColor,
                textColor: textColor
            });
        }, timeout);
    }

    function loadBarRecursive(thumb = 1) {
        rotate = setTimeout(function () {
            if (thumb < 20) {
                loadBarRecursive(thumb + (Math.floor(Math.random() * 100) / 10));
            } else if (thumb > 70) {
                loadBarRecursive(thumb + 0.1);
            } else {
                loadBarRecursive(thumb + (Math.floor(Math.random() * 10) / 10));
            }
            $('.Polaris-Frame-Loading__Level').css('transform', 'scaleX(' + (thumb / 100) + ')');
        }, 1000);
    }

    // close modal
    function closeModal(modal) {
        if (modal) {
            modal.removeClass('open').hide();
            //code by Anil to stop the iframe video, when the modal is closed
            if (modal.contents().find('iframe').length) {
                modal.contents().find('iframe').attr("src", modal.find('iframe').attr("src").replace("autoplay=1", "autoplay=0"));
            }
        } else {
            $(".modal").removeClass('open').hide();
        }
        $("body").removeClass("modal-open");

        // plan page
        $('.link-uninstall').show();
        $('.btn-update').show();
        $('.cancel-link-uninstall').hide();
        $('.btn-uninstall').hide();
        $('.radio-button').off("click");
        $('.tutorial').attr("src", "");

        // course view
        sessionStorage.removeItem('initiateCheckoutMonthly');
        sessionStorage.removeItem('initiateCheckoutYearly');
    }

    // open modal
    function openModal(modal) {
        setTimeout(function () {
            $("body").addClass("modal-open");
            modal.addClass('open').show();
        }, 10);
    }
    //unpause subscription

    $(".Unpause-Subscription").click(function(){

            $('.Unpause-Subscription').addClass('Polaris-Button--disabled').prop("disabled", true);
            $('.Unpause-Subscription').addClass('Polaris-Button--loading');
            $('.Unpause-Subscription').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Start plan</span></span>');
            window.location='{{ route('unpause_subscription') }}';
    })




</script>

@if(config('env-variables.IMPACT_ENABLED'))
<script type="text/javascript">
    ire('identify', {customerId: '{{$customer_id}}', customerEmail: '{{$customer_email_sha1}}'});
</script>
@endif

<script>
    function removePaypalButton(){
        let content = $('#paypal-button-container').find(".paypal-buttons");
        $(content[0]).remove();
    }
    function initPaypalButton(plan){
            let monthlyPlanCode = '{{$paypal_plan->monthly}}'
            let quarterlyPlanCode = '{{$paypal_plan->quarterly}}'
            let annuallyPlanCode ='{{$paypal_plan->annually}}'
            let is_paused = '{{$is_paused}}'
            let pause_plan_data_plan = '{{$pause_plan_data_plan}}'
            let pause_plan_data_sub_plan = '{{$pause_plan_data_sub_plan}}'
            let shopName = '{{$shop_name}}'
            console.log("shop name is ",shopName);
            // console.log(monthlyPlanCode, annuallyPlanCode);
            paypal.Buttons({
                style: {
                    shape: 'rect',
                    color: 'white',
                    layout: 'vertical',
                    label:  'pay',
                },
                // onInit is called when the button first renders
                onInit: function(data, actions) {
                    let termsAndCondtionCheckbox = document.querySelector('#PolarisCheckboxTerms')
                    // Disable the buttons if terms and condition box is already not checked
                    if(termsAndCondtionCheckbox.checked && is_paused == 0){
                        actions.enable();
                    }else {
                        actions.disable();
                    }


                    // Listen for changes to the checkbox
                    termsAndCondtionCheckbox.addEventListener('change', function(event) {
                            // Enable or disable the button when it is checked or unchecked
                        if (event.target.checked && is_paused==0) {
                                actions.enable();
                            } else {
                                actions.disable();
                            }
                        });
                },

                // onClick is called when the button is clicked
                onClick: function() {

                    // Show a validation error if the checkbox is not checked
                    if (!document.querySelector('#PolarisCheckboxTerms').checked) {
                        customToastMessage("Please Agree To Terms of sales and terms of use", false);
                    }
                    if(is_paused==1)
                    {
                        if( pause_plan_data_plan != "" && pause_plan_data_sub_plan != ""){
                            customToastMessage(`Please Unpause ${pause_plan_data_plan} ${pause_plan_data_sub_plan} Subscription to continue`, false);
                        }else {
                            customToastMessage("Please Unpause the Paused Subscription to continue", false);
                        }
                    }
                },
                createSubscription: function(data, actions) {
                    if (plan=='monthly') {
                        return actions.subscription.create({
                            'plan_id': monthlyPlanCode,
                            'custom_id': shopName,
                        });
                    } else if (plan=='quarterly') {
                        return actions.subscription.create({
                            'plan_id': quarterlyPlanCode,
                            'custom_id': shopName,
                        });
                    } else {
                        return actions.subscription.create({
                            'plan_id': annuallyPlanCode,
                            'custom_id': shopName,
                        });
                    }
                },
                onApprove: function(data, actions) {
                    window.location.replace('/paypal/success?sub_id='+data.subscriptionID+'&ba_token='+data.billingToken+'&orderID='+data.orderID);
                    //alert('You have successfully created subscription ' + data.subscriptionID);
                }
            }).render('#paypal-button-container');
    }
    initPaypalButton();

    $('#onClickMonthlyRadio, #onClickYearlyRadio, #onClickQuarterlyRadio').on("click",function(event){
        let parentMonth = $('#onClickMonthlyRadio');
        let parentQuarterly = $('#onClickQuarterlyRadio');
        let currentElement = $(event.target);
        if (parentMonth.is(currentElement)||
            parentMonth.is(currentElement.parent()) ||
            parentMonth.is(currentElement.parent().parent()) ||
            parentMonth.is(currentElement.parent().parent().parent()) ||
            parentMonth.is(currentElement.parent().parent().parent().parent()) ||
            parentMonth.is(currentElement.parent().parent().parent().parent().parent())
        ) {
            initPaypalButton('monthly');
        } else if (parentQuarterly.is(currentElement)||
            parentQuarterly.is(currentElement.parent()) ||
            parentQuarterly.is(currentElement.parent().parent()) ||
            parentQuarterly.is(currentElement.parent().parent().parent()) ||
            parentQuarterly.is(currentElement.parent().parent().parent().parent()) ||
            parentQuarterly.is(currentElement.parent().parent().parent().parent().parent())
        ) {
            initPaypalButton('quarterly');
        } else {
            initPaypalButton('annually');
        }
        removePaypalButton();
    });
    $(document).ready(function(){
        $('#paynow-button-container-wrapper').hide();
        let paypalPaymentSection = $('#onClickPaymentByPaypal');
        let paynowPaymentSection = $('#onClickPaymentByPaynow');
        let stripePaymentSection =$('#onClickPaymentByCreditCard');
        let currentPaymentPlatform = '{{getPaymentPlatform()}}';
        let currentSubscriptionStatus = '{{$subscription_status}}';
        let isSubscriptionEndingSoon = '{{isSubscriptionEndingSoon(3)}}';
        //console.log(currentPaymentPlatform)
        //console.log(currentSubscriptionStatus)
        let status = null;
        //if subscription is paused
        @if($is_paused)
            if(currentPaymentPlatform=='stripe'){
            stripePaymentSection.show();
            paynowPaymentSection.show();
            stripePaymentSection.click();

            paypalPaymentSection.hide();
            }
            else{
            stripePaymentSection.hide();
            paynowPaymentSection.hide();

            paypalPaymentSection.show();
            paypalPaymentSection.click();
        }
        @else
        if( '{{isset($subscription_status)}}' && currentPaymentPlatform=='stripe')
        {
            //stripePaymentSection.click();
            status = 'stripe:'+currentSubscriptionStatus;
        }
        if( '{{isset($subscription_status)}}' && currentPaymentPlatform=='paypal')
        {
            paypalPaymentSection.click();
            status = 'paypal:'+currentSubscriptionStatus;
        }

        //hiding the other payment option incase of active subscription and subscription not ending soon (with in 3 days).
        if(status=='stripe:active' && !isSubscriptionEndingSoon)
        {
            paypalPaymentSection.hide();
        }
        if(status=='paypal:active' && !isSubscriptionEndingSoon)
        {
            stripePaymentSection.hide();
            paynowPaymentSection.hide();
        }
        @endif
        // let selectedPaymentMethod = $('input[name="methodOfPayment"]:checked').val();
        // console.log("currently selected Method is ",selectedPaymentMethod);
        // console.log("cookie value for discount code ",getCookie('discount-code'));
        // console.log("cookie value for discount code ",setCookie('discount-code','',60));
        // console.log("cookie value after clearing ",getCookie('discount-code'));

    })
</script>
</body>
</html>
