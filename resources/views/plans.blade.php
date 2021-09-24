@extends('layouts.debutify')
@section('title','plans')
@section('view-plans','view-plans')

@section('styles')
<style>
.Polaris-Page{
  max-width: 100%;
}
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


.mentoring-card-header {
  padding-bottom: 2rem;
}

#inputExitIntent::-moz-selection { color: #fff}
#inputExitIntent::selection { color: #fff; }

</style>
@endsection

@section('content')
  @include("components.skeleton")

    <div id="dashboard" style="display:none;">
    @include("components.account-frozen-banner")

       @php
       if(isset($is_paused) && $is_paused == true){ 
           $alladdons_plan = $paused_plan_name;
        }
       @endphp
      <!-- endif -->
      
        @if($current_plan && ($is_paused != 1 || $has_taken_free_subscription != 1) && $is_beta_user != 1)
        <div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite"
             aria-labelledby="PolarisBanner6Heading" aria-describedby="PolarisBanner6Content">
                <div class="Polaris-Banner__Dismiss">
                    <button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly dismiss-banner" aria-label="Dismiss notification">
                        <span class="Polaris-Button__Content">
                            <span class="Polaris-Button__Icon">
                                <span class="Polaris-Icon">
                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                        <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997
                                        0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>
                    </button>
                </div>
                <div class="Polaris-Banner__Ribbon">
                    <span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 20c5.514 0 10-4.486 10-10S15.514 0 10 0 0 4.486 0 10s4.486 10 10 10zm1-6a1 1 0 1 1-2 0v-4a1 1 0 1 1 2 0v4zm-1-9a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
                        </svg>
                    </span>
                </div>
                <div class="Polaris-Banner__ContentWrapper">
                    <div class="Polaris-Banner__Heading" id="PolarisBanner6Heading">

                        <p class="Polaris-Heading">You are currently on the <strong class="pricing__plan-name highlight __web-inspector-hide-shortcut__">{{$alladdons_plan}}</strong> plan and you are billed {{$billingCycle}}.</p>
                    </div>
                    <div class="Polaris-Banner__Content" id="PolarisBanner6Content">
                        @if ($all_addons == 1 && $sub_plan == "month" && empty($master_shop))
                            <p>
                                Did you know you can save more than
                                <strong class="pricing__plan-name highlight __web-inspector-hide-shortcut__">
                                @if($alladdons_plan === "Master")
                                    ${{ ($guruPriceMonthly * 12) - $guruPriceAnnually }}
                                    @elseif($alladdons_plan === "Hustler")
                                    ${{ ($hustlerPriceMonthly * 12 ) - $hustlerPriceAnnually }}
                                    @elseif($alladdons_plan === "Starter")
                                    ${{ ($starterPriceMonthly * 12) - $starterPriceAnnually  }}
                                @endif
                                USD </strong> simply by upgrading to the yearly plan?
                            </p>
                            <div class="Polaris-Banner__Actions">
                                <div class="Polaris-ButtonGroup">
                                    <div class="Polaris-ButtonGroup__Item">
                                        <div class="Polaris-Banner__PrimaryAction">
                                            <a href="{{ route("checkout", strtolower($alladdons_plan))}}?yearly" style="text-decoration:none">
                                                <button type="button" class="Polaris-Button Polaris-Button--outline">
                                                    <span class="Polaris-Button__Content">
                                                        <span class="Polaris-Button__Text">Upgrade now and save</span>
                                                    </span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif ($all_addons == 1 && $sub_plan == "year" && empty($master_shop))
                            <div class="Polaris-Banner__Actions">
                                <div class="Polaris-ButtonGroup">
                                    <div class="Polaris-ButtonGroup__Item">
                                        <div class="Polaris-Banner__PrimaryAction">
                                            <a href="{{ route("checkout", strtolower($guru))}}?yearly" style="text-decoration:none">
                                                <button type="button" class="Polaris-Button Polaris-Button--outline">
                                                    <span class="Polaris-Button__Content">
                                                        <span class="Polaris-Button__Text">Manage billing</span>
                                                    </span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endif


      @if($previous_plan)
      <!---Previus Subscription -->
      <div class="Polaris-Banner Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner2Heading" aria-describedby="Banner2Content">
        <div class="Polaris-Banner__Dismiss"><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly dismiss-banner" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                    <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                  </svg></span></span></span></button></div>
        <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
              <path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></
                    path>
              <path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path>
            </svg></span></div>
        <div>
          <div class="Polaris-Banner__Heading" id="Banner2Heading">
            <p class="Polaris-Heading">Your {{$alladdons_plan}} subscription price is still at ${{$previous_plan}}/{{$sub_plan}}</p>
          </div>
          <div class="Polaris-Banner__Content" id="Banner2Content">
            <p>Rest assured, pricing change below will not affect your active plan.</p>
          </div>
        </div>
      </div>
      @endif

      <div class="Polaris-Page__Content">
        <div class="Polaris-Card" style="overflow:initial;">
          <div class="">
            <div class="Polaris-DataTable">

              <!-- table start-->
              <table class="Polaris-DataTable__Table">

                <!-- thead start-->
                <thead>

                  <tr class="Polaris-DataTable__TableRow">
                    <!-- image header -->
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header Polaris-DataTable__Cell--firstColumn" scope="col">
                      <img src="/svg/empty-state.svg" class="img-fluid" alt="">
                    </th>

                    @php  
                        if(isset($is_paused) && $is_paused == true){ 
                           $activate_plan = "Paused plan";
                         }else{
                           $activate_plan = "Active plan";
                         }
                    @endphp

                    <!-- freemium-->
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header" scope="col">
                      @if($all_addons != 1 && !$trial_days)
                      <div class="badge-wrapper">
                        <span class="Polaris-Badge Polaris-Badge--statusInfo">{{ $activate_plan }}</span>
                      </div>
                      @endif
                      <div class="Polaris-TextContainer">
                        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">Free</h3>
                        <p class="Polaris-TextStyle--variationSubdued">Only the basics</p>
                        <h3 class="Polaris-Heading">
                          $
                          <span class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">0</span>
                          /month
                        </h3>
                        <div class="sm-show">
                          @include("components.freemium-button")
                        </div>
                      </div>
                    </th>

                                           

                    <!-- starter-->
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header" scope="col">
                      @if($alladdons_plan == $starter)
                      <div class="badge-wrapper">
                        <span class="Polaris-Badge Polaris-Badge--statusInfo">{{ $activate_plan }}</span>
                      </div>
                      @endif
                      <div class="Polaris-TextContainer">
                        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">{{$starter}}</h3>
                        <p class="Polaris-TextStyle--variationSubdued">Great for starters</p>
                        <h3 class="Polaris-Heading plan-starter-price">
                          $
                          <span class="Polaris-DisplayText Polaris-DisplayText--sizeMedium price">{{$starterPriceMonthly+0}}</span>
                          /month
                        </h3>
                        <h3 class="Polaris-Heading plan-starter-discount-price Polaris-VisuallyHidden">
                          <span style="text-decoration: line-through;" class="Polaris-TextStyle--variationSubdued">$
                            {{$starterPriceMonthly+0}} /month
                          </span>
                          <br/>
                          <span >$
                            <span style="font-weight: 600;" class="Polaris-DisplayText Polaris-DisplayText--sizeMedium discounted-price">{{$starterPriceMonthly/2}}</span>
                            /month
                          </span>
                          <br/>
                        </h3>
                        <span class="Polaris-TextStyle--variationSubdued discounted-price-terms Polaris-VisuallyHidden" style="font-weight: normal;">
                          *First 3 months only
                        </span>
                        <div class="sm-show">
                          @include("components.starter-button")
                        </div>
                      </div>
                    </th>

                    <!-- hustler -->
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header" scope="col">
                      <div class="badge-wrapper">
                        @if($alladdons_plan == $hustler)
                        <span class="Polaris-Badge Polaris-Badge--statusInfo">{{ $activate_plan }}</span>
                        @else
                        <span class="Polaris-Badge Polaris-Badge--statusSuccess">Most popular</span>
                        @endif
                      </div>
                      <div class="Polaris-TextContainer">
                        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">{{$hustler}}</h3>
                        <p class="Polaris-TextStyle--variationSubdued">Perfect for businesses</p>
                        <h3 class="Polaris-Heading plan-hustler-price ">
                          $
                          <span class="Polaris-DisplayText Polaris-DisplayText--sizeMedium price">{{$hustlerPriceMonthly+0}}</span>
                          /month
                        </h3>
                        <h3 class="Polaris-Heading plan-hustler-discount-price Polaris-VisuallyHidden">
                          <span style="text-decoration: line-through;" class="Polaris-TextStyle--variationSubdued">$
                            {{$hustlerPriceMonthly+0}} /month
                          </span>
                          <br/>
                          <span >$
                            <span style="font-weight: 600;" class="Polaris-DisplayText Polaris-DisplayText--sizeMedium discounted-price">{{$hustlerPriceMonthly/2}}</span>
                            /month
                          </span>
                          <br/>
                        </h3>
                        <span class="Polaris-TextStyle--variationSubdued discounted-price-terms Polaris-VisuallyHidden" style="font-weight: normal;">
                          *First 3 months only
                        </span>
                        <div class="sm-show">
                          @include("components.hustler-button")
                        </div>
                      </div>
                    </th>

                    <!-- guru -->
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--header" scope="col">
                      @if($alladdons_plan == $guru)
                      <div class="badge-wrapper">
                        <span class="Polaris-Badge Polaris-Badge--statusInfo">{{ $activate_plan }}</span>
                      </div>
                      @endif
                      <div class="Polaris-TextContainer">
                        <h3 class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">{{$guru}}</h3>
                        <p class="Polaris-TextStyle--variationSubdued">Made for experts</p>
                        <h3 class="Polaris-Heading plan-master-price">
                          $
                          <span class="Polaris-DisplayText Polaris-DisplayText--sizeMedium price">{{$guruPriceMonthly+0}}</span>
                          /month
                        </h3>
                        <h3 class="Polaris-Heading plan-master-discount-price Polaris-VisuallyHidden">
                          <span style="text-decoration: line-through;" class="Polaris-TextStyle--variationSubdued">$
                            {{$guruPriceMonthly+0}} /month
                          </span>
                          <br/>
                          <span >$
                            <span style="font-weight: 600;" class="Polaris-DisplayText Polaris-DisplayText--sizeMedium discounted-price">{{$guruPriceMonthly/2}}</span>
                            /month
                          </span>
                          <br/>
                        </h3>
                        <span class="Polaris-TextStyle--variationSubdued discounted-price-terms Polaris-VisuallyHidden" style="font-weight: normal;">
                          *First 3 months only
                        </span>
                        <div class="sm-show">
                          @include("components.guru-button")
                        </div>
                      </div>
                    </th>
                  </tr>
                </thead>

                <!-- tbody -->
                <tbody>
                  <!-- plans -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow plan-row">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M4 7l-3 3 9 9 3-3z"></path><path d="M19 0h-9c-.265 0-.52.106-.707.293l-9 9a.999.999 0 0 0 0 1.414l9 9a.997.997 0 0 0 1.414 0l9-9A.997.997 0 0 0 20 10V1a1 1 0 0 0-1-1zm-9 17.586L2.414 10 4 8.414 11.586 16 10 17.586zm8-8l-5 5L5.414 7l5-5H18v7.586zM15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2"></path></svg>
                          </span>
                        </span>
                        Plans
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total">
                      @include("components.freemium-button")
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total">
                      @include("components.starter-button")
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total">
                      @include("components.hustler-button")
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total">
                      @include("components.guru-button")
                    </th>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Store licence</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">1</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">1</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">1</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">{{$store_limit + 1}}</td>
                  </tr>

                  <!-- themes -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M11 1l8 8v8c0 1.104-0.896 2-2 2s-2-0.896-2-2v-6c0 1.104-0.896 2-2 2s-2-0.896-2-2v-10z"></path><path d="M17.979 17c0 0.551-0.448 1-1 1s-1-0.449-1-1v-6c0-0.552-0.447-1-1-1s-1 0.448-1 1c0 0.551-0.448 1-1 1s-1-0.449-1-1v-7.586l6 6v7.586zM8.394 14.929c-1.243 0-2.413 0.484-3.293 1.364l-1.414 1.414c-0.208 0.209-0.505 0.317-0.788 0.29-0.298-0.024-0.561-0.175-0.74-0.424-0.274-0.38-0.191-0.976 0.189-1.356l1.339-1.339c0.941-0.941 1.384-2.188 1.35-3.424l3.483 3.483c-0.042 0-0.083-0.008-0.126-0.008v0zM11.487 15.078l-6.585-6.586 5.077-5.078v7.586c0 1.525 1.148 2.774 2.624 2.962l-1.116 1.116zM19.686 8.293l-8-8c-0.191-0.191-0.447-0.283-0.707-0.283v-0.010c-0.014 0-0.027 0.007-0.041 0.008-0.105 0.004-0.208 0.023-0.31 0.060-0.009 0.004-0.019 0.003-0.028 0.007-0.002 0.001-0.003 0.001-0.004 0.001-0.112 0.047-0.208 0.117-0.294 0.196-0.009 0.009-0.021 0.012-0.030 0.021l-8 8c-0.391 0.391-0.391 1.023 0 1.414 1.035 1.036 1.035 2.722 0 3.757l-1.339 1.339c-1.071 1.072-1.243 2.765-0.398 3.939 0.52 0.722 1.323 1.177 2.202 1.248 0.081 0.007 0.162 0.010 0.243 0.010 0.793 0 1.555-0.313 2.12-0.879l1.414-1.414c1.004-1.005 2.755-1.004 3.758 0 0.187 0.188 0.441 0.293 0.707 0.293s0.52-0.105 0.707-0.293l2.293-2.293v1.586c0 1.654 1.346 3 3 3s3-1.346 3-3v-8c0-0.265-0.105-0.52-0.293-0.707v0z"></path></svg>
                          </span>
                        </span>
                        Themes
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Debutify theme</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>

                  <!-- support -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M10 1a9 9 0 0 0-9 9c0 1.769.518 3.413 1.398 4.804L1 19l4.196-1.398A8.954 8.954 0 0 0 10 19c4.971 0 9-4.029 9-9s-4.029-9-9-9z"></path><path d="M10 0C4.486 0 0 4.486 0 10c0 1.728.45 3.42 1.304 4.924l-1.253 3.76a1.001 1.001 0 0 0 1.265 1.264l3.76-1.253A9.947 9.947 0 0 0 10 20c5.514 0 10-4.486 10-10S15.514 0 10 0zm0 18a7.973 7.973 0 0 1-4.269-1.243.996.996 0 0 0-.852-.104l-2.298.766.766-2.299a.998.998 0 0 0-.104-.851A7.973 7.973 0 0 1 2 10c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8zm0-9a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM6 9a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm8 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path></svg>
                          </span>
                        </span>
                        Support
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Help Center</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Community</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Technical</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Priority support</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>

                  <!-- addons -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path d="M1 1h7v7H1V1zm0 11h7v7H1v-7zm11 0h7v7h-7v-7z" fill="currentColor"></path><path d="M8 11H1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1zm-1 7H2v-5h5v5zM8 0H1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zM7 7H2V2h5v5zm12 4h-7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1zm-1 7h-5v-5h5v5zM12 6h2v2a1 1 0 1 0 2 0V6h2a1 1 0 1 0 0-2h-2V2a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2z"></path></svg>
                          </span>
                        </span>
                        Add-Ons
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-TextStyle--variationStrong">0</th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-TextStyle--variationStrong">{{$starterLimit}}</th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-TextStyle--variationStrong">{{$hustlerLimit}}</th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-TextStyle--variationStrong">{{$addon_infos_count}}</th>
                  </tr>

                  @foreach($addon_infos as $addon)
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3>
                        <span class="Polaris-TextStyle--variationStrong">{{$addon->name}}</span>
                        <span class="fas fa-question-circle ml-1 text-muted question-icon" onclick='return addonVideo("{{$addon->name}}","{{$addon->description}}","{{$addon->wistia_video_id}}");'></span>
                      </h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell @if($loop->iteration > $starterLimit) plan-disabled @endif">@include("components.icon-yes")</td>
                     <td class="Polaris-DataTable__Cell @if($loop->iteration > $hustlerLimit) plan-disabled @endif">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  @endforeach

                  <!-- product research -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M19 10c0 4.971-4.029 9-9 9s-9-4.029-9-9c0-4.971 4.029-9 9-9s9 4.029 9 9z"></path><path d="M10 0c-5.514 0-10 4.486-10 10s4.486 10 10 10c5.514 0 10-4.486 10-10s-4.486-10-10-10zM10 18c-4.411 0-8-3.589-8-8s3.589-8 8-8c4.411 0 8 3.589 8 8s-3.589 8-8 8zM9.977 6.999c0.026 0.001 0.649 0.040 1.316 0.708 0.391 0.39 1.024 0.39 1.414 0 0.391-0.391 0.391-1.024 0-1.415-0.603-0.603-1.214-0.921-1.707-1.092v-0.201c0-0.552-0.447-1-1-1-0.552 0-1 0.448-1 1v0.185c-1.161 0.414-2 1.514-2 2.815 0 2.281 1.727 2.713 2.758 2.971 1.115 0.279 1.242 0.384 1.242 1.029 0 0.552-0.448 1-0.976 1.001-0.026-0.001-0.65-0.040-1.317-0.708-0.39-0.39-1.023-0.39-1.414 0-0.39 0.391-0.39 1.024 0 1.415 0.604 0.603 1.215 0.921 1.707 1.092v0.2c0 0.553 0.448 1 1 1 0.553 0 1-0.447 1-1v-0.184c1.162-0.414 2-1.514 2-2.816 0-2.28-1.726-2.712-2.757-2.97-1.115-0.279-1.243-0.384-1.243-1.030 0-0.551 0.449-1 0.977-1z"></path></svg>
                          </span>
                        </span>
                        Product research
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Oportunity level</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Bronze</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Silver</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Gold</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Weekly products</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">15</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">25</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">30</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Videos</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Images</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Prices</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Spy tools</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Audiences</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Interest targeting</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Descriptions</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Expert opinion</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>

                  <!-- courses -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M10 19a2 2 0 0 1 2-2h7V1h-7a2 2 0 0 0-2 2 2 2 0 0 0-2-2H1v16h7a2 2 0 0 1 2 2z"></path><path d="M19 0h-7c-.768 0-1.469.29-2 .766A2.987 2.987 0 0 0 8 0H1a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h7a1 1 0 0 1 1 1 1 1 0 1 0 2 0 1 1 0 0 1 1-1h7a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm-1 16h-6c-.352 0-.687.067-1 .179V3a1 1 0 0 1 1-1h6v14zM8 16H2V2h6a1 1 0 0 1 1 1v13.179A2.959 2.959 0 0 0 8 16zM6 4H5a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2zm0 4H5a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2zm8-2h1a1 1 0 1 0 0-2h-1a1 1 0 1 0 0 2zm0 4h1a1 1 0 1 0 0-2h-1a1 1 0 1 0 0 2zm-8 2H5a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2z"></path></svg>
                          </span>
                        </span>
                        Training Courses
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                  </tr>
                  @foreach($courses as $course)
                  <?php
                  $plans = explode(',', $course->plans);
                  $isGuru = false; $isHustler = false; $isStarter = false; $isFreemium = false;
                  foreach($plans as $plan){
                    if($plan == 'master'){
                      $isGuru = true;
                    }
                    if($plan == 'Hustler'){
                      $isHustler = true;
                    }
                    if($plan == 'Starter'){
                      $isStarter = true;
                    }
                    if($plan == 'Freemium'){
                      $isFreemium = true;
                    }
                  }
                  ?>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3>
                        <span class="Polaris-TextStyle--variationStrong">{{$course->title}}</span>
                      </h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">
                      @if($isStarter)
                        @include("components.icon-yes")
                      @else
                        @include("components.icon-no")
                      @endif
                    </td>
                    <td class="Polaris-DataTable__Cell">
                      @if($isHustler)
                        @include("components.icon-yes")
                      @else
                        @include("components.icon-no")
                      @endif
                    </td>
                    <td class="Polaris-DataTable__Cell">
                      @if($isGuru)
                        @include("components.icon-yes")
                      @else
                        @include("components.icon-no")
                      @endif
                    </td>
                  </tr>
                  @endforeach

                  <!-- mentoring -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M7 5h6v10H7z"></path><path d="M19 18a1 1 0 0 1 0 2H1a1 1 0 0 1 0-2h18zm0-18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h5V5a1 1 0 0 1 1-1h5V1a1 1 0 0 1 1-1h6zm-5 14h4V2h-4v12zm-6 0h4V6H8v8zm-6 0h4v-4H2v4z"></path></svg>
                          </span>
                        </span>
                        Mentoring
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Private 1-On-1 mentoring Facebook group</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Chance to win a 1-On-1 private live mentoring call with Ricky Hayes for 30 minutes</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-yes")</td>
                  </tr>

                  <!-- integrations -->
                  <tr class="Polaris-DataTable__TableRow Sticky__tableRow">
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total Polaris-DataTable__Cell--firstColumn">
                      <span class="table-section-title Polaris-Heading">
                        <span class="Polaris-Navigation__Icon">
                          <span class="Polaris-Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M9 5c0 2.209-1.791 4-4 4s-4-1.791-4-4c0-2.209 1.791-4 4-4s4 1.791 4 4z"></path><path d="M17 4c-1.126 0-2.098 0.631-2.611 1.551l-4.408-0.734c-0.099-2.671-2.287-4.817-4.981-4.817-2.757 0-5 2.243-5 5s2.243 5 5 5c0.384 0 0.754-0.053 1.113-0.135l1.382 3.041c-0.904 0.734-1.495 1.841-1.495 3.094 0 2.206 1.794 4 4 4s4-1.794 4-4c0-0.918-0.323-1.753-0.844-2.429l2.906-3.736c0.297 0.099 0.608 0.165 0.938 0.165 1.654 0 3-1.346 3-3s-1.346-3-3-3zM2 5c0-1.654 1.346-3 3-3s3 1.346 3 3c0 1.654-1.346 3-3 3s-3-1.346-3-3zM7.931 9.031c0.772-0.563 1.374-1.336 1.724-2.241l4.398 0.733c0.070 0.396 0.216 0.764 0.426 1.090l-2.892 3.718c-0.488-0.211-1.023-0.331-1.587-0.331-0.236 0-0.464 0.030-0.688 0.070l-1.381-3.039zM10 18c-1.103 0-2-0.897-2-2s0.897-2 2-2c1.103 0 2 0.897 2 2s-0.897 2-2 2zM17 8c-0.552 0-1-0.448-1-1s0.448-1 1-1c0.552 0 1 0.448 1 1s-0.448 1-1 1z"></path></svg>
                          </span>
                        </span>
                        Integrations
                      </span>
                    </th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                    <th class="Polaris-DataTable__Cell Polaris-DataTable__Cell--total"></th>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Klaviyo</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Coming soon</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Coming soon</td>
                  </tr>
                  <tr class="Polaris-DataTable__TableRow">
                    <td class="Polaris-DataTable__Cell Polaris-DataTable__Cell--firstColumn">
                      <h3><span class="Polaris-TextStyle--variationStrong">Smsbump</span></h3>
                    </td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell">@include("components.icon-no")</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Coming soon</td>
                    <td class="Polaris-DataTable__Cell Polaris-TextStyle--variationStrong">Coming soon</td>
                  </tr>

                </tbody>
              </table><!-- table end -->

            </div>
          </div>
        </div><!-- card end -->
      </div><!-- page layout end -->

      <div class="Polaris-Card">
        <div class="Polaris-Card__Header mentoring-card-header">
          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
              <h2 class="Polaris-Heading">Frequently asked questions
              </h2>
              <p>We know you have some questions in mind, we've tried to list the most important ones!</p>
            </div>
          </div>
        </div>
        <div class="Polaris-ResourceList__ResourceListWrapper">
          <ul class="Polaris-ResourceList" aria-live="polite">
            @foreach ($faqs as $faq)
            <li class="Polaris-ResourceList__ItemWrapper">
              <div class="Polaris-ResourceItem">
                <button onclick="faqClicked(event, '{{ $faq->id }}')" id="faq-list-{{ $faq->id }}" class="Polaris-ResourceItem__Link" tabindex="0" data-polaris-unstyled="true"></button>
                <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter">
                  <div class="Polaris-ResourceItem__Owned">
                    <div class="Polaris-FooterHelp__Icon"><span class="Polaris-Icon Polaris-Icon--colorTeal Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9" fill="#ffffff"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4a1 1 0 1 0 0 2 1 1 0 1 0 0-2m0-10C8.346 4 7 5.346 7 7a1 1 0 1 0 2 0 1.001 1.001 0 1 1 1.591.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path></svg></span></div>
                  </div>
                  <div class="Polaris-ResourceItem__Content">
                    {{ $faq->title }}
                  </div>
                  <span class="faq-icon-container">
                    <i id="faq-icon-{{ $faq->id }}" class="fa fa-chevron-down mrr-5 faq-icon" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
              <div id="faq-content-{{ $faq->id }}" class="Polaris-Card__Section faq-content" style="display: none;">
                <div class="Polaris-Stack Polaris-Stack--vertical ">
                  <div class="Polaris-Stack__Item">
                    <p class="Polaris-TextStyle--variationSubdued"  style="margin-bottom:0px">
                      <span class="Polaris-TextStyle--variationSubdued">
                        {{ $faq->content }}
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>

    <!-- addon video modal -->
    <div id="videoModal" class="modal fade-scales">
      <div>
        <div class="Polaris-Modal-Dialog__Container undefined" data-polaris-layer="true" data-polaris-overlay="true">
          <div>
            <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header2" tabindex="-1">
              <div class="Polaris-Modal-Header">
                <div id="modal-header2" class="Polaris-Modal-Header__Title">
                  <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall addon-title"></h2>
                </div><button class="Polaris-Modal-CloseButton close-modal" aria-label="Close"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                      <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                    </svg></span></button>
              </div>
              <div class="Polaris-Modal__BodyWrapper">
                <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                  <section class="Polaris-Modal-Section">
                    <div class="Polaris-TextContainer">
                      <p class="addon-subtitle"></p>
                    </div>
                    <div class="Polaris-TextContainer video-tutorial" style="margin-top:2rem;">
                      <iframe class="tutorial" width="100%" height="295" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
                        <div class="Polaris-ButtonGroup__Item"><button type="button" class="close-modal Polaris-Button"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Close</span></span></button></div>
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
@endsection

@php 
$unpause_message = false;
if(Session::has('unpause_subscription')){
$unpause_message = "Plan successfully unpaused";
}
@endphp


@section('scripts')
    @parent
    <script src="/js/jquery.exitintent.min.js?v=" <?=config('env-variables.ASSET_VERSION')?>></script>
    <script type="text/javascript">
        let addonsPlan = '{{$alladdons_plan}}';
        var master_shop = '{{$master_shop}}';
        var is_beta_user = '{{$is_beta_user}}';

        $(document).ready(function(){
          var unpause_message = "{{ $unpause_message }}";
          if(unpause_message){
             customToastMessage("Plan successfully unpaused");
          }
        })
        $(window).on("load", function () {
              // loadingBarCustom(false);
              // product impresssions event
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
                'ecommerce': {
                    'currencyCode': 'USD',
                    'impressions': [
                        {
                            'name': 'Starter',     // product name (is required)
                            'id': '{{$starteridMonthly}}',           // product id (SKU) (is required)
                            'price': '19'          // price of one product unit (plan)
                        },
                        {
                            'name': 'Hustler',
                            'id': '{{$hustleridMonthly}}',
                            'price': '47'
                        },
                        {
                            'name': 'Master',
                            'id': '{{$guruidMonthly}}',
                            'price': '97'
                        }]
                },
                'event': 'EE-event',
                'EE-event-category': 'Enhanced Ecommerce',
                'EE-event-action': 'Product Impressions',
                'EE-event-non-interaction': 'True',
            });
          });
        function gotoCheckoutPage(plan, billingCycle) {
          @if($store_count > 0)
          // check: remove linked stores before downgrading plan
          if (plan != "{{strtolower($guru)}}") {
              customToastMessage("Remove linked stores to downgrade plan", false);
              return;
          }
          @endif

          var master_shop = '{{$master_shop}}';
          if (master_shop) {
            customToastMessage("This store's subscription is managed by " + master_shop, false);
          }
          else {
            window.location.href = "/app/plans/"+plan+'?billing='+billingCycle;
          }
        }

      if (master_shop) {
        customToastMessage("This store's subscription is managed by " + master_shop, false);
        $('.Sticky__tableRow .Polaris-Button--fullWidth').each(function(){
          $(this).addClass("Polaris-Button--disabled");
          // $(this).parent().addClass("Polaris-Button--disabled");
          // $(this).parent().attr('href', 'javascript:void(0);');
        })
      }
      if (is_beta_user == 1) {
        customToastMessage("This store is currently on Beta Plan.", false);
        $('.Sticky__tableRow .Polaris-Button--fullWidth').each(function(){
          $(this).addClass("Polaris-Button--disabled");
          
        })
      }

      function faqClicked(e, faqId) {
        e.preventDefault();
        $('.faq-content').slideUp();
        $('.faq-icon').removeClass();
        $('.faq-icon-container > i').addClass('fa fa-chevron-down mrr-5 faq-icon');

        if ($('#faq-content-' + faqId).is(':hidden')) {
          $('#faq-content-' + faqId).slideDown();
          $('#faq-icon-' + faqId).addClass('fa fa-chevron-up mrr-5 faq-icon');
        }
      }

      // addon video modal
      function addonVideo(title,subtitle, videoSource){
        $('.tutorial').attr("src","https://www.youtube.com/embed/" + videoSource);

        $(".addon-title").text(title);
        $(".addon-subtitle").text(subtitle);

        if(videoSource){
          $(".video-tutorial").show();
        } else{
          $(".video-tutorial").hide();
        }

        // show modal
        var modal = $("#videoModal");
        openModal(modal);
      }

        $('.dismiss-banner').click(function () {
            var banner = $(this).closest('.Polaris-Banner');
            banner.hide();
        });

        $(document).ready(function(){
          var autoDiscountcode = getCookie('discount-code');

          if (!autoDiscountcode) {
            return;
          }

          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          $.ajax({
            url: "/app/getcoupon",
            data: { 'new_coupon': autoDiscountcode },
            type: 'POST',
            cache: false,
            success: function (response) {
              if (response == 'invalid coupon code' || !response.status) {
                customToastMessage("Invalid coupon code", true);
                return;
              }

              $(".price").each((index, element) => {
                var discount = '';
                var coupon_duration_months = response.coupon_duration_months;

                if (response.coupon_duration === 'repeating') {
                  var text_to_append = coupon_duration_months > 1 ? ' months only' : ' month only';
                  coupon_duration_months = '*First ' + coupon_duration_months + text_to_append;
                } else if (response.coupon_duration === 'once') {
                  coupon_duration_months = '*First month only';
                } else {
                  coupon_duration_months = '';
                }


                if (response.percent_off) {
                  discount = $(element).text() * response.percent_off / 100;
                } else {
                  discount = response.amount_off / 100;
                }

                $(".discounted-price:eq(" + index + ")").text(($(element).text() - discount).toFixed(2));
                $(".discounted-price-terms:eq(" + index + ")").text(coupon_duration_months);
              })

              customToastMessage(response.status);

              $('.plan-starter-price').addClass('Polaris-VisuallyHidden');
              $('.plan-starter-discount-price').removeClass('Polaris-VisuallyHidden');
              $('.plan-hustler-price').addClass('Polaris-VisuallyHidden');
              $('.plan-hustler-discount-price').removeClass('Polaris-VisuallyHidden');
              $('.plan-master-price').addClass('Polaris-VisuallyHidden');
              $('.plan-master-discount-price').removeClass('Polaris-VisuallyHidden');
              $(".discounted-price-terms").removeClass('Polaris-VisuallyHidden');
            }
          });
        })
    </script>
@endsection
