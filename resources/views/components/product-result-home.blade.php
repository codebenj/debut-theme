<div class="row" style="position:relative;">
@if(count($products) > 0)
  @foreach($products as $product)
  <div class="col col-12 col-md-4">
    <div class="Polaris-Card product-card">
      @include("components.loader")
      <div class="Polaris-CalloutCard__Container">
        <div class="Polaris-Card__Section">
          <div class="Polaris-CalloutCard">
            <div class="Polaris-CalloutCard__Content grid-product-wrapper">

              @if($product->video)
              <span class="fas fa-play-circle video-icon"></span>
              @endif

              @if($product->new_product)
              <span class="Polaris-Badge Polaris-Badge--statusSuccess Polaris-Badge--sizeSmall new-product">New</span>
              @endif

              <div class="container-product-img rounded mb-4">
                <a href="{{config('env-variables.APP_PATH')}}winning-products">
                  <img src="{{$product->image}}" width="100%" class="grid-product-img img-fluid rounded" alt="">
                </a>
              </div>

              <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight d-flex">
                <h2 class="Polaris-Heading grid-product-title flex-fill">{{$product->name}}</h2>
                <h2 class="Polaris-Heading mt-0 ml-2 Polaris-TextStyle--variationPositive">${{$product->profit}}</h2>
              </div>

              <div class="Polaris-CalloutCard__Buttons">
                <a href="{{config('env-variables.APP_PATH')}}winning-products" class="Polaris-Button Polaris-Button--primary Polaris-Button--fullWidth" data-polaris-unstyled="true">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">View product</span>
                  </span>
                </a>

                <p class="Polaris-Caption text-center Polaris-TextStyle--variationSubdued mb-0 mt-3">
                  Added
                  @if($product->days > 0)
                   {{$product->days}} days ago
                  @else
                  just now
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
    {{--
    <!-- product modal -->
    <div id="productModal" class="modal custom-modal fade-scales" role="dialog">
      <div>
       <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
         <div>
           <div class="Polaris-Modal-Dialog__Modal Polaris-Modal-Dialog--sizeLarge" role="dialog" aria-labelledby="modal-header11" tabindex="-1">

             <div class="Polaris-Modal-Header">
               <div class="Polaris-Modal-Header__Title">
                 <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">
                   <span class="product-name"></span>
                   <span class="product-saturation"></span>
                 </h2>
               </div>
               <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
                 <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                   <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                     <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                   </svg>
                 </span>
               </button>
             </div>

             <div class="Polaris-Modal__BodyWrapper">
               <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true" polaris="[object Object]">
                 <section class="Polaris-Modal-Section">

                  <div class="Polaris-Layout">
                    <div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">
                      <!-- video -->
                      <div class="Polaris-Card video-card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Video</h3>
                          </div>
                          <div class="product-video"></div>
                        </div>
                      </div>
                      <!-- images -->
                      <div class="Polaris-Card image-card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Images</h3>
                          </div>
                          <img src="" alt="" width="100%" class="product-img img-fluid rounded">
                        </div>
                      </div>
                    </div>
                    <!-- prices -->
                    <div class="Polaris-Layout__Section Polaris-Layout__Section--oneHalf">
                      <div class="Polaris-Card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Prices</h3>
                          </div>
                          <div class="d-flex">
                            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight flex-fill">
                              <p><span>Profit margin → </span> <strong class="Polaris-TextStyle--variationPositive">$<span class="product-profit"></span></strong></p>
                              <p><span>Breakeven point → </span> <strong><span class="product-breakeven"></span></strong></p>
                            </div>
                            <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight flex-fill">
                              <p><span>AliExpress cost → </span> <strong class="Polaris-TextStyle--variationNegative">$<span class="product-cost"></span></strong></p>
                              <p><span>Reselling price → </span> <strong>$<span class="product-price"></span></strong></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- spy tools -->
                      <div class="Polaris-Card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Spy tools</h3>
                          </div>
                          @if($alladdons_plan == $starter)
                          <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinContentContainer" tabindex="0" role="alert" aria-live="polite" aria-describedby="Banner6Content">
                            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                  <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                                </svg></span></div>
                            <div>
                              <div class="Polaris-Banner__Content" id="Banner6Content">
                                <p>The spy tools section is only available on {{$hustler}} and {{$guru}} plans. <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">Upgrade plan</a></p>
                              </div>
                            </div>
                          </div>
                          @else
                          <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight spytools"></div>
                          @endif
                        </div>
                      </div>
                      <!-- audiences -->
                      <div class="Polaris-Card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Audiences</h3>
                          </div>
                          @if($alladdons_plan == $starter)
                          <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinContentContainer" tabindex="0" role="alert" aria-live="polite" aria-describedby="Banner6Content">
                            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                  <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                                </svg></span></div>
                            <div>
                              <div class="Polaris-Banner__Content" id="Banner6Content">
                                <p>The audiences section is only available on {{$hustler}} and {{$guru}} plans. <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">Upgrade plan</a></p>
                              </div>
                            </div>
                          </div>
                          @else
                          <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                            <p><span>Age → </span> <strong><span class="product-age"></span></strong></p>
                            <p><span>Gender → </span> <strong><span class="product-gender"></span></strong></p>
                            <p><span>Placement → </span> <strong><span class="product-placement"></span></strong></p>
                          </div>
                          @endif
                        </div>
                      </div>
                      <!-- interest targeting -->
                      <div class="Polaris-Card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Interest targeting</h3>
                          </div>
                          @if($alladdons_plan == $starter)
                          <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinContentContainer" tabindex="0" role="alert" aria-live="polite" aria-describedby="Banner6Content">
                            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                  <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                                </svg></span></div>
                            <div>
                              <div class="Polaris-Banner__Content" id="Banner6Content">
                                <p>The interest targeting section is only available on {{$hustler}} and {{$guru}} plans. <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">Upgrade plan</a></p>
                              </div>
                            </div>
                          </div>
                          @else
                          <div class="Polaris-Stack Polaris-Stack--spacingTight interest_target"></div>
                          @endif
                        </div>
                      </div>
                      <!-- description -->
                      <div class="Polaris-Card description-card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Product description</h3>
                          </div>
                          @if($alladdons_plan != $guru)
                          <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinContentContainer" tabindex="0" role="alert" aria-live="polite" aria-describedby="Banner6Content">
                            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                  <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                                </svg></span></div>
                            <div>
                              <div class="Polaris-Banner__Content" id="Banner6Content">
                                <p>The product description section is only available on the {{$guru}} plan. <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">Upgrade plan</a></p>
                              </div>
                            </div>
                          </div>
                          @else
                          <p class="product-description"></p>
                          @endif
                        </div>
                      </div>
                      <!-- expert opinion -->
                      <div class="Polaris-Card opinion-card">
                        <div class="Polaris-Card__Section Polaris-Card__Section--subdued">
                          <div class="Polaris-Card__SectionHeader">
                            <h3 class="Polaris-Heading">Expert opinion</h3>
                          </div>

                          @if($alladdons_plan != $guru)
                          <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinContentContainer" tabindex="0" role="alert" aria-live="polite" aria-describedby="Banner6Content">
                            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                  <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                                </svg></span></div>
                            <div>
                              <div class="Polaris-Banner__Content" id="Banner6Content">
                                <p>The expert opinion section is only available on the {{$guru}} plan. <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">Upgrade plan</a></p>
                              </div>
                            </div>
                          </div>
                          @else
                          <p class="product-opinion"></p>
                          @endif
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
                         <button type="button" class="Polaris-Button close-modal">
                           <span class="Polaris-Button__Content">
                             <span class="Polaris-Button__Text">Cancel</span>
                           </span>
                         </button>
                       </div>
                       <div class="Polaris-ButtonGroup__Item">
                         <a href="" target="_blank" class="Polaris-Button Polaris-Button--primary product-aliexpress">
                           <span class="Polaris-Button__Content">
                             <span class="Polaris-Button__Text">View product</span>
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
      <div class="Polaris-Backdrop"></div>
    </div>
    --}}
@else
  <div class="col col-12 col-md-12 no-results">
    <div class="Polaris-Card">
      <div class="Polaris-CalloutCard__Container">
        <div class="Polaris-Card__Section">
          <div class="Polaris-CalloutCard">
            <div class="Polaris-CalloutCard__Content">
              <div class="container-product-img rounded mb-4">
                <img src="{{ config('env-variables.APP_URL') }}/svg/empty-state-2.svg" width="100%" class="img-fluid rounded" alt="empty-state">
              </div>
              <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight">
                <p>No results found..</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      @include("components.loader")
    </div>
  </div>
@endif
</div>