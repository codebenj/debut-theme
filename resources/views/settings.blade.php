@extends('layouts.debutify')
@section('title','Billing')
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

#inputExitIntent::-moz-selection { color: #fff}
#inputExitIntent::selection { color: #fff; }

</style>
@endsection

@section('content')
    @include("components.skeleton")
    <div id="dashboard" style="display:none;">
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                            <div class="Polaris-TextContainer">
                                <h2 class="Polaris-Heading">Plan details</h2>
                                <div class="Polaris-Layout__AnnotationDescription">
                                    <p style="margin-bottom:1.2rem">
                                        View our
                                        <a target="_blank" href="/policies/terms-of-service">terms of service</a>
                                        and
                                        <a target="_blank" href="/policies/privacy-policy">privacy policy</a>.
                                    </p>
                                    <p>
                                        <a href="{{route("plans")}}">Compare plans</a>
                                        with different features and rates.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                            <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-Stack Polaris-Stack--distributionFill">
                                        <div class="Polaris-Stack__Item">
                                            <h3 class="Polaris-Heading">Member since</h3>
                                            <span>{{$user_since}}</span>
                                        </div>
                                        <div class="Polaris-Stack__Item">
                                            <h3 class="Polaris-Heading ">Current plan</h3>
                                            @php
                                              if(isset($is_paused) && $is_paused == true){
                                                 $subscription_plan = $paused_plan_name;
                                               }else{
                                                 $subscription_plan = $subscription_plan;
                                               }
                                              @endphp
                                            @if($is_beta_user == true)
                                                <span>BETA</span>
                                            @elseif($trial_days && !$master_shop)
                                                <span> {{$trial_plan}} </span>
                                            @else
                                                @if ($all_addons == 1 || $master_shop)
                                                    @if ($master_shop)
                                                        <span>Master</span>
                                                    @else
                                                        <span>
                                                        {{$subscription_plan}}
                                                         @if($sub_plan) @if($sub_plan == 'month') / Monthly @else / {{$sub_plan}} @endif @endif</span>
                                                    @endif
                                                @else
                                                    <h2 class="Polaris-Heading">Free</h2>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="Polaris-Stack__Item">
                                            <h3 class="Polaris-Heading ">Status</h3>
                                            @if(isset($is_paused) && $is_paused == 1)
                                            <span>Paused</span>
                                            @elseif($trial_days && !$master_shop && $is_beta_user != true)
                                            <span>Trial</span>
                                            @else
                                            <span>Active</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($subscription_plan != 'Master' && $is_beta_user != 1)
                                    <div class="Polaris-Card__Section">
                                    <div class="Polaris-Stack Polaris-Stack--vertical">

                                        @if( $is_paused != 1 )
                                        <div class="Polaris-Stack__Item">
                                            <p>Grow your business by upgrading to the
                                                @if($subscription_plan == 'Freemium')
                                                    Starter
                                                @elseif($subscription_plan == 'Starter')
                                                    Hustler
                                                @elseif($subscription_plan == 'Hustler')
                                                    Master
                                                @else
                                                    Master
                                                @endif
                                                plan</p>
                                        </div>
                                        <div class="Polaris-Stack__Item" >
                                            <ul class="Polaris-List" style="list-style:none; padding-left : 1rem;">
                                                @if($subscription_plan == 'Freemium')
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="25" height="25">
                                                            {{$starterLimit}} Conversion-boosting Add-Ons
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_3-Priority-technical-support.png" width="25" height="25">
                                                            Technical support
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_4-Full-product-research-tool.png" width="25" height="25">
                                                            Basic product research tool
                                                        </p>
                                                    </li>
                                                @elseif($subscription_plan == 'Starter')
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="25" height="25">
                                                            {{$hustlerLimit}} Conversion-boosting Add-Ons
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_3-Priority-technical-support.png" width="25" height="25">
                                                            Technical support
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_4-Full-product-research-tool.png" width="25" height="25">
                                                            Product research tool
                                                        </p>
                                                    </li>
                                                @elseif($subscription_plan == 'Hustler')
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_1-Conversion-boosting-add-on.png" width="25" height="25">
                                                            {{$addon_infos_count}} Conversion-boosting Add-Ons
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_2-Exclusive-traning-courses.png" width="25" height="25">
                                                            Exclusive training courses
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_3-Priority-technical-support.png" width="25" height="25">
                                                            Priority technical support
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_4-Full-product-research-tool.png" width="25" height="25">
                                                            Full product research tool
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_5-Private 1-on-1-mentoring.png" width="25" height="25">
                                                            Private 1-on-1 Mentoring Group
                                                        </p>
                                                    </li>
                                                    <li class="Polaris-List__Item">
                                                        <p>
                                                            <img src="/images/Icon_6-Chance-for 1-on-1-mentoring-call.png" width="25" height="25">
                                                            Chance for 1-on-1 mentoring call
                                                        </p>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        @endif
                                        <div class="Polaris-Stack__Item">
                                            @if(isset($is_paused) && $is_paused == 1)
                                                <button type="button" onclick="window.location='{{ route('unpause_subscription') }}'" class="Polaris-Button Polaris-Button--primary btn-loading"><span class="Polaris-Button__Content "><span class="Polaris-Button__Text">Unpause my plan</span></span></button>
                                            @else
                                            @if($subscription_plan == 'Freemium')
                                            <a href="{{ url('app/plans/Starter?yearly') }}"
                                               class="Polaris-Button Polaris-Button--primary">
                                                <span class="Polaris-Button__Content">
                                                    <span class="Polaris-Button__Text">Upgrade plan</span>
                                                </span>
                                            </a>
                                            @elseif($subscription_plan == 'Starter')
                                                <a href="{{ url('app/plans/Hustler?yearly') }}"
                                                   class="Polaris-Button Polaris-Button--primary">
                                                    <span class="Polaris-Button__Content">
                                                        <span class="Polaris-Button__Text">Upgrade plan</span>
                                                    </span>
                                                </a>
                                            @elseif($subscription_plan == 'Hustler' || $trial_days)
                                                <a href="{{ url('app/plans/Master?yearly') }}"
                                                   class="Polaris-Button Polaris-Button--primary">
                                                    <span class="Polaris-Button__Content">
                                                        <span class="Polaris-Button__Text">Upgrade plan</span>
                                                    </span>
                                                </a>
                                            @endif

                                        @endif
                                        </div>
                                    </div>
                                </div>
                                @else
                                    @if(isset($is_paused) && $is_paused == 1)
                                            <div class="Polaris-Card__Section">
                                                <div class="Polaris-Stack Polaris-Stack--vertical">
                                                    <div class="Polaris-Stack__Item">
                                                        <button type="button" onclick="window.location='{{ route('unpause_subscription') }}'" class="Polaris-Button Polaris-Button--primary btn-loading"><span class="Polaris-Button__Content "><span class="Polaris-Button__Text">Unpause my plan</span></span></button>
                                                        </div>
                                                 </div>
                                            </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(getPaymentPlatform()=='stripe')
        <div class="Polaris-Page-Header--separator"></div>
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                            <div class="Polaris-TextContainer">
                                <h2 class="Polaris-Heading">Payment method</h2>
                                <p class="Polaris-TextStyle--variationSubdued">Manage how you pay your bills in Debutify.</p>
                            </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                            @include("components.account-frozen-banner")
                            <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    @if($card_number != '')
                                        <div class="card-details Polaris-Stack">
                                            <div class="Polaris-Stack__Item">
                                                @if($card_brand == 'Visa')
                                                    <img src="https://js.stripe.com/v3/fingerprinted/img/visa-365725566f9578a9589553aa9296d178.svg"
                                                         style="height: 20px;width: 35px">
                                                @elseif($card_brand == 'Mastercard')
                                                    <img src="https://js.stripe.com/v3/fingerprinted/img/mastercard-4d8844094130711885b5e41b28c9848f.svg"
                                                         style="height: 20px;width: 35px">
                                                @else
                                                    <i class="fa fa-credit-card" aria-hidden="true" style="font-size:20px;margin-top: 5px"></i>
                                                @endif
                                            </div>
                                            <div class="Polaris-Stack__Item">
                                                <div class="Polaris-Stack">
                                                    <h5 class="Polaris-TextStyle--variationStrong Polaris-Stack__Item credit-card-brand"
                                                        style="margin-top: 20px">{{$card_brand}}</h5>
                                                    <span class="Polaris-Badge Polaris-Stack__Item Polaris-Badge--statusSuccess active-badge">Primary</span>
                                                </div>
                                                <p class="Polaris-TextStyle--variationSubdued credit-card-ending">
                                                    ending in <span class="card-ending">{{$card_number}}</span>
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card-details">
                                            <p>Add payment method for purchases and bill in Debutify.</p>
                                        </div>
                                    @endif
                                </div>
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-Stack Polaris-Stack--spacingTight">
                                        <div class="Polaris-Stack__Item" style="margin-left: 10px">
                                            <button type="button" class="Polaris-Button Polaris-Button--plain close-modal btn-replace-credit-card"
                                                    onclick="return openUpdateCardModal();">
                                              <span class="Polaris-Button__Content">
                                                  @if($card_number != '')
                                                <span class="Polaris-Button__Text">Replace credit card</span>
                                                  @else
                                                  <span class="Polaris-Button__Text payment-button-text">Add payment method</span>
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
        @endif
        @if(($subscription_plan == $guru && $is_paused != true) || ($old_plan_name == $guru && $is_beta_user == 1))
            <div class="Polaris-Page-Header--separator"></div>
            <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                            <div class="Polaris-TextContainer">
                                <h2 class="Polaris-Heading">Store licences</h2>
                                <p class="Polaris-TextStyle--variationSubdued">Manage multiple stores licences.
                                    <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                                        <span class="store-count">{{$store_count}}</span>/{{$store_limit}}
                                   </span>
                                </p>
                            </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                            <div class="Polaris-Card">
                                <div class="Polaris-Card__Section">
                                    <div class="Polaris-FormLayout__Item share-licences-section" style="margin-top: 0; margin-left: 0px; @if($store_count == $store_limit) display: none; @endif">
                                        <form action="" method="post" id="addStoreForm" class="">
                                            @csrf
                                            <div class="Polaris-Labelled__LabelWrapper">
                                                <div class="Polaris-Label">
                                                    <label id="LinkedDomainLabel" for="LinkedStore" class="Polaris-Label__Text">Shopify domain</label>
                                                </div>
                                            </div>
                                            <div class="Polaris-Stack Polaris-Stack--spacingTight">
                                                <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                                    <div class="Polaris-TextField primfield">
                                                        <input placeholder="myotherstore.myshopify.com" id="LinkedStore"
                                                               class="Polaris-TextField__Input" min="-Infinity" max="Infinity" step="1" type="url"
                                                               aria-invalid="false" aria-multiline="false" name="childstore" value="">
                                                        <div class="Polaris-TextField__Backdrop"></div>
                                                    </div>
                                                </div>
                                                <div class="Polaris-Stack__Item">
                                                    <button type="button" class="Polaris-Button disable-while-loading save-store" onclick="return addchildstore();">
                                                <span class="Polaris-Button__Content">
                                                  <span class="Polaris-Button__Text">Share licence</span>
                                                </span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="Polaris-Labelled__HelpText"><span>Install Debutify Theme Manager before sharing your licence.</span></div>
                                        </form>
                                    </div>
                                    <div class="Polaris-FormLayout__Item">
                                        <form action="" method="post" id="removestores" class="">
                                            @csrf
                                            <div class="Polaris-Stack child_stores">
                                                @foreach($child_stores as $child_store)
                                                    <div class="Polaris-Stack__Item" id="child_store_section{{$child_store->id}}">
                                                <span class="Polaris-Tag">
                                                  <span title="{{$child_store->store}}" class="Polaris-Tag__TagText">{{$child_store->store}}</span>
                                                  <button type="button" aria-label="Remove Wholesale"
                                                          class="Polaris-Tag__Button disable-while-loading removeLinkedStore{{$child_store->id}}"
                                                          onclick="return removestore('{{$child_store->id}}','{{$child_store->store}}');">
                                                    <span class="Polaris-Icon">
                                                      <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                                        <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd">
                                                        </path>
                                                      </svg>
                                                    </span>
                                                  </button>
                                                </span>
                                                    </div>
                                                @endforeach
                                                <input type="hidden" name="child_store" value="" id="child_store">
                                                <input type="hidden" name="store_id" value="" id="storeid">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if(getPaymentPlatform()=='stripe')
        <div class="Polaris-Page-Header--separator"></div>
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                <div class="Polaris-Layout__AnnotatedSection">
                    <div class="Polaris-Layout__AnnotationWrapper">
                        <div class="Polaris-Layout__Annotation">
                            <div class="Polaris-TextContainer">
                                <h2 class="Polaris-Heading">Bills </h2>
                                <p class="Polaris-TextStyle--variationSubdued">
                                    @if($billingCycle === 'monthly')
                                        Your monthly bill is on 30-days cycle
                                    @elseif($billingCycle === 'quarterly')
                                        Your quarterly bill is on 90-days cycle
                                    @else
                                        Your yearly bill is on 365-days cycle.
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="Polaris-Layout__AnnotationContent">
                            <div class="Polaris-Layout">
                                <div class="Polaris-Layout__Section Polaris-Layout__Section">
                                    <div class="Polaris-Card">
                                        @if($upcoming_invoice == '')
                                            <div class="Polaris-Card__Header">
                                                <h2 class="Polaris-Heading">There are no charges on your upcoming bill</h2>
                                            </div>
                                            <div class="Polaris-Card__Section">
                                                <p>Charges on your upcoming bill show up here.</p>
                                            </div>
                                        @else
                                            <div class="Polaris-Card__Header">
                                                @if( (isset($is_paused) && $is_paused == 1) || $is_beta_user == true)
                                                Current billing cycle: <span class="Polaris-Badge Polaris-Badge--incomplete Polaris-Badge--sizeSmall">Paused</span>
                                                @else
                                                <h2 class="Polaris-Heading">
                                                    Current billing cycle: Billed on {{ date("F d, Y", $upcoming_invoice->next_payment_attempt)}}</h2>
                                                @endif
                                            </div>
                                            <div class="Polaris-Card__Section">
                                                <div class="Polaris-Stack Polaris-Stack--alignmentFill">
                                                    <h2 class="Polaris-Stack__Item Polaris-Stack__Item--fill">Subscription charges</h2>
                                                    <div class="Polaris-Stack__Item">${{ number_format(($upcoming_invoice->amount_due /100), 2, '.', ' ')}}</div>
                                                </div>
                                            </div>
                                            <div class="Polaris-Card__Section">
                                                <div class="Polaris-Stack Polaris-Stack--alignmentFill">
                                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                                        <span class="Polaris-TextStyle--variationStrong">Running total</span>
                                                    </div>
                                                    <div class="Polaris-Stack__Item Polaris-TextStyle--variationStrong">
                                                        ${{ number_format(($upcoming_invoice->amount_remaining /100), 2, '.', ' ')}} USD
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="Polaris-Card">
                                        @if($all_invoices == '')
                                            <div class="Polaris-Card__Header">
                                                <h2 class="Polaris-Heading">There are no any recent bills</h2>
                                            </div>
                                            <div class="Polaris-Card__Section">
                                                <p>Your recent bill show up here.</p>
                                            </div>
                                        @else
                                            <div class="Polaris-Card__Header">
                                                <h2 class="Polaris-Heading">Recent bills</h2>
                                            </div>
                                            <div class="Polaris-Card__Section">
                                                <div class="Polaris-Card__SectionHeader">
                                                    <h3 aria-label="Total Sales Breakdown" class="Polaris-Subheading">Billing cycle</h3>
                                                </div>
                                                <div class="Polaris-ResourceList__ResourceListWrapper">
                                                    <ul class="Polaris-ResourceList" aria-live="polite">
                                                        @foreach ($all_invoices as $invoice)
                                                            <li class="Polaris-ResourceItem__ListItem">
                                                                <div class="Polaris-ResourceItem__ItemWrapper">
                                                                    <div class="Polaris-ResourceItem">
                                                                        <a aria-label="View Sales for Orders" target='_blank' class="Polaris-ResourceItem__Link" tabindex="0" id="PolarisResourceListItemOverlay3" href="{{$invoice->invoice_pdf}}"
                                                                           data-polaris-unstyled="true"></a>
                                                                        <div class="Polaris-ResourceItem__Container">
                                                                            <div class="Polaris-ResourceItem__Content">
                                                                                <div class="Polaris-Stack">
                                                                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">Created {{ date("F d, Y", $invoice->created)}}</div>
                                                                                    <div class="Polaris-Stack__Item" style="margin-top:1.3rem">
                                                                                        <span class="Polaris-Badge active-badge">{{strtoupper($invoice->status)}}</span>
                                                                                    </div>
                                                                                    <div class="Polaris-Stack__Item"> ${{ number_format(($invoice->amount_paid /100), 2, '.', ' ')}} USD</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="Polaris-Card">
                                        @if($account_balance == '')
                                        <div class="Polaris-Card__Header">
                                            <h2 class="Polaris-Heading">There are no credits on your account right now</h2>
                                        </div>
                                        <div class="Polaris-Card__Section">
                                            <p>Your credits will be shown here when you have them.</p>
                                        </div>
                                        @else
                                            <div class="Polaris-Card__Header">
                                                <h2 class="Polaris-Heading">Account balance</h2>
                                            </div>
                                            <div class="Polaris-Card__Section">
                                                <div class="Polaris-Stack Polaris-Stack--alignmentFill">
                                                    <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                                                        <span class="Polaris-TextStyle--variationStrong">Remaining total</span>
                                                    </div>
                                                    <div class="Polaris-Stack__Item Polaris-TextStyle--variationStrong">
                                                        ${{ number_format(( ($account_balance->balance * -1) /100), 2, '.', ' ')}} USD
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
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
    <!-- update card modal -->
    <div id="updateCardModal" class="modal fade-scales" role="dialog" style="display: none">
        <div>
            <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
                <div>
                    <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
                        <div class="Polaris-Modal-Header">
                            <div class="Polaris-Modal-Header__Title">
                                @if($card_number != '')
                                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Replace credit card</h2>
                                @else
                                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Add credit card</h2>
                                @endif
                            </div>
                            <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
                               <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                                 <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                   <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                                 </svg>
                               </span>
                            </button>
                        </div>

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
                                                    <div id="card-elementsub" class="stripe-custom-input"></div>
                                                    <div id="card-errorsub" class="Polaris-Labelled__HelpText" role="alert"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </form>

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
                                                <button type="button" class="Polaris-Button Polaris-Button--primary update-card-btn disable-while-loading" onclick="return updateCardForm();">
                                               <span class="Polaris-Button__Content">
                                                    @if($card_number != '')
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
        <div class="Polaris-Backdrop"></div>
    </div>

    {{--  need to implement this --}}
    {{--  Remove ChildStore Confirmation Modal  --}}
    <div id="removeChildStoreConfirmModal" class="modal fade-scales" style="display: none">
        <div>
            <div class="Polaris-Modal-Dialog__Container undefined" data-polaris-layer="true" data-polaris-overlay="true">
                <div>
                    <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header2" tabindex="-1">
                        <div class="Polaris-Modal-Header">
                            <div id="modal-header2" class="Polaris-Modal-Header__Title">
                                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall removeChildStoreConfirmModalTitle">...</h2>
                            </div><button class="denyOffer Polaris-Modal-CloseButton close-modal disable-while-loading" aria-label="Close"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                      <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                    </svg></span></button>
                        </div>
                        <div class="Polaris-Modal__BodyWrapper">
                            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                <section class="Polaris-Modal-Section">
                                    <p id="removeChildStoreConfirmModalText">
                                        ...
                                    </p>
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
                                                  <span class="Polaris-Button__Text">Never mind</span>
                                                </span>
                                                </button>
                                            </div>
                                            <div class="Polaris-ButtonGroup__Item">
                                                <button type="button" class="Polaris-Button Polaris-Button--destructive disable-while-loading remove-licences-btn"    onclick="return confirmedRemoveChildStore()">
                            <span class="Polaris-Button__Content">
                              <span class="Polaris-Button__Text">Remove</span>
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

@endsection

@section('scripts')
    @parent
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        // add linked store
        function addchildstore(){
            var store = $('#LinkedStore').val();
            if(store.indexOf(".myshopify.com") >-1){
                $('.primfield').removeClass('Polaris-TextField--error');
            } else{
                $('.primfield').addClass('Polaris-TextField--error');
                return false;
            }
            var child_store = store.substring(0, store.indexOf(".myshopify.com") + '.myshopify.com'.length);
            if (child_store.indexOf("http://") == 0 || child_store.indexOf("https://") == 0) {
                child_store = child_store.replace(/^https?\:\/\//i, "");
            }
            $('#LinkedStore').val(child_store);

            loadingBarCustom();

            var form = document.getElementById("addStoreForm");
            $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
            $('.save-store').addClass('Polaris-Button--loading');
            $('.save-store').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Share licence</span></span>');

            let addChildStore = "{{ route('addchildstore') }}";
            $.ajax({
                url: addChildStore,
                data: $( form ).serialize(),
                type: 'POST',
                cache: false,
                success: function(response){
                    loadingBarCustom(false);
                    $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    $('.save-store').removeClass('Polaris-Button--loading');
                    $('.save-store').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Share licence</span></span>');
                    if(response.status) {
                        let storeId = response.store_id;
                        $('.store-count').html(response.store_count);
                        customToastMessage("Store licence shared successfully.");
                        $('#LinkedStore').val('');
                        let store = response.store;

                        if(response.store_count == {{$store_limit}}){
                            $('.share-licences-section').hide();
                        }

                        $('.child_stores').append('<div class="Polaris-Stack__Item" id="child_store_section'+store.id+'">\n' +
                            '                         <span class="Polaris-Tag">\n' +
                            '                         <span title="'+store.store+'" class="Polaris-Tag__TagText">'+store.store+'</span>\n' +
                            '                           <button type="button" aria-label="Remove Wholesale" class="Polaris-Tag__Button disable-while-loading removeLinkedStore'+store.id+'" onclick="return removestore(\''+store.id+'\',\''+store.store+'\');">\n' +
                            '                             <span class="Polaris-Icon">\n' +
                            '                               <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">\n' +
                            '                                 <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>\n' +
                            '                               </svg>\n' +
                            '                             </span>\n' +
                            '                          </button>\n' +
                            '                        </span>\n' +
                            '</div>');
                    } else {
                        customToastMessage(response.error);
                    }
                }
            });
        }

        // remove linked store
        function removestore(id, store){
            $('#storeid').val(id);
            $('#child_store').val(store);

            $(".removeChildStoreConfirmModalTitle").html("Remove "+store);
            $("#removeChildStoreConfirmModalText").html("Are you sure you want to stop sharing your licence with "+store+"?");
            var modal = $("#removeChildStoreConfirmModal");
            openModal(modal);
        }

        // confirmation remove child store
        function confirmedRemoveChildStore(){
            loadingBarCustom();

            $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
            $('.remove-licences-btn').addClass('Polaris-Button--loading');
            $('.remove-licences-btn').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Remove</span></span>');

            let storeId = $('#storeid').val();
            var form = document.getElementById("removestores");
            let removeChildStore  = "{{ route('removechildstore') }}";
            $.ajax({
                url: removeChildStore,
                data: $( form ).serialize(),
                type: 'POST',
                cache: false,
                success: function(response){
                    loadingBarCustom(false);
                    $('.disable-while-loading').removeClass('Polaris-Button--disabled').prop("disabled", false);
                    $('.removeLinkedStore').removeClass('Polaris-Button--loading');
                    $('.removeLinkedStore').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Share licence</span></span>');
                    $('.remove-licences-btn').removeClass('Polaris-Button--loading');
                    $('.remove-licences-btn').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Remove</span></span>');
                    if(response.status) {
                        $('.store-count').html(response.store_count);

                        if(response.store_count < {{$store_limit}}){
                            $('.share-licences-section').show();
                        }
                        $('#child_store_section'+ storeId).remove();
                        customToastMessage("Store licence removed successfully.");
                    } else {
                        customToastMessage("Something went wrong, please try later.");
                    }
                    var modal = $("#removeChildStoreConfirmModal");
                    closeModal(modal);
                }
            });

            $.ajax({
                url: "/app/addon/removeChildStoreAddons",
                data: $( form ).serialize(),
                type: 'POST',
                cache: false,
                success: function(response){
                }
            });
        }

        // Create a Stripe client.
        var stripe = Stripe('{{ econfig("services.stripe.key") }}');
        // Create an instance of Elements.
        var elements = stripe.elements();
        var elementsub = stripe.elements();

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
        card.mount('#card-elementsub');

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
                    //webpushr custom attribute add_payment_info
                    webpushr('attributes',{"Add Payment Info" : "True"});
                };
                @endif

                    displayError.textContent = '';
            }
        });

        // Update card modal
        function openUpdateCardModal() {

            //show modal
            var modal = $("#updateCardModal");
            openModal(modal);
        }

        function updateCardForm() {
            console.log('updateCardForm');
            stripe.createSource(card).then(function (result) {
                if (result.error) {
                    // Inform the user if there was an error
                    var errorElement = document.getElementById('card-errorsub');
                    errorElement.textContent = result.error.message;
                } else {
                    // Send the source to your server
                    loadingBarCustom();
                    $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
                    $('.update-card-btn').addClass('Polaris-Button--loading');
                    $('.update-card-btn').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Update card</span></span>');
                    stripeSourceHandler(result.source);
                }
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // source update customer
        function stripeSourceHandler(source) {
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
                        $('.update-card-btn').removeClass('Polaris-Button--loading');
                        $('.update-card-btn').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Update Card</span></span>');

                        $('.card-details').addClass('Polaris-Stack');
                        $('.card-details').html('<div class="Polaris-Stack__Item">\n' +
                            '<i class="fa fa-credit-card" aria-hidden="true" style="font-size:20px; margin-top: 5px"></i>\n' +
                            '</div>\n' +
                            '<div class="Polaris-Stack__Item">\n' +
                            '<div class="Polaris-Stack">\n' +
                            '<h5 class="Polaris-TextStyle--variationStrong Polaris-Stack__Item credit-card-brand" style="margin-top: 20px"></h5>\n' +
                            '<span class="Polaris-Badge Polaris-Stack__Item Polaris-Badge--statusSuccess active-badge">Primary</span>\n' +
                            '</div>\n' +
                            '<p class="Polaris-TextStyle--variationSubdued credit-card-ending">\n' +
                            'ending in <span class="card-ending"></span>\n' +
                            '</p>\n' +
                            '</div>');

                        let cardNumber = source.card.last4;
                        let cardBrand = source.card.brand;

                        $('.credit-card-brand').html(cardBrand);
                        $('.card-ending').html(cardNumber);
                        var modal = $("#updateCardModal").closest(".modal");
                        closeModal(modal);
                        customToastMessage(response.message);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    loadingBarCustom(false);
                    customToastMessage("Something went wrong, please try after some time.", false);
                    $('.disable-while-loading').removeClass('Polaris-Button--disabled');
                    $('.update-card-btn').removeClass('Polaris-Button--loading');
                    $('.update-card-btn').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Update Card</span></span>');

                },
            });
        }
        var urlParams = new URLSearchParams(window.location.search);

        if(urlParams.has('update_card')) {
            //show modal
            var modal = $("#updateCardModal");
            openModal(modal);
        }

        $('.dismiss-banner').click(function () {
            var banner = $(this).closest('.Polaris-Banner');
            banner.hide();
        });
    </script>
@endsection
