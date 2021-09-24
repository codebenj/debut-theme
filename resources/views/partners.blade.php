@extends('layouts.debutify')
@section('title','Partners')

@section('styles')
<style type="text/css">
  
  .Polaris-Layout__Section--oneThird
  {
    width: 31%;
    max-width: 31%;
  }
  @media (max-width: 1080px) 
  {
    .Polaris-Layout__Section--oneThird
    {
      width: 44%;
      max-width: 44%;
    }
  }
  @media (max-width: 556px) 
  {
    .Polaris-Layout__Section--oneThird
    {
      width: 90%;
      max-width: 90%;
    }
  }
  .top-right-partner-offer
  {
    margin-right: 0px;
    margin-left: auto !important;
  }
  .offer-notice-btn
  {
    background-color: #5C4BE2;
    color: #fff;
    padding: 5px;
  }
  .offer-notice-btn:hover
  {
    background-color: #5C4BE2;
    color: #fff;
    text-decoration: none;
  }
</style>
@endsection

@section('content')
  @include("components.account-frozen-banner")
  
  @if(session()->has('message'))
  <div class="addonInstalledBanner Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
    <div class="Polaris-Banner__Dismiss"><button onclick="return closeAlert('addonInstalledBanner')" type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
        </svg></span></div>
    <div>

      <div class="Polaris-Banner__Heading" id="Banner3Heading">
        <p class="Polaris-Heading">{{ session('message') }}</p>
      </div>
      <div class="Polaris-Banner__Content" id="Banner3Content">
        <div class="Polaris-Banner__Actions">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <a href="https://{{ $shop_domain}}/admin/themes/{{session('theme_id_cstm')}}/editor" target="_blank" class="Polaris-Button Polaris-Button--outline">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Customize theme</span></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  

  @if(!count($partners))
  <div class="Polaris-EmptyState Polaris-EmptyState--withinPage">
    <div class="Polaris-EmptyState__Section">
      <div class="Polaris-EmptyState__DetailsContainer">
        <div class="Polaris-EmptyState__Details">
          <div class="Polaris-TextContainer">
            <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">
              Debutify trusted partners
            </p>
            <div class="Polaris-EmptyState__Content">
              <p>Debutify works with the industry’s leading agencies and technology providers to create amazing experiences for our clients.</p>
            </div>
          </div>
          <div class="Polaris-EmptyState__Actions">
            <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
              <div class="Polaris-Stack__Item">

                <a class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge Polaris-Button--disabled" disabled>
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Coming soon</span>
                  </span>
                </a>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-EmptyState__ImageContainer"><img src="/svg/empty-state-15.svg" role="presentation" alt="" class="Polaris-EmptyState__Image"></div>
    </div>
  </div>

  @else

  <div class="Polaris-Layout">
    <div class="Polaris-Layout__Section Polaris-Layout__Section--fullWidth mb-4">
      <div class="Polaris-TextContainer text-center">
        <p class="Polaris-DisplayText Polaris-DisplayText--sizeExtraLarge">
          Debutify trusted partners
        </p>
        <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium Polaris-TextStyle--variationSubdued">
          Debutify works with the industry’s leading agencies and technology providers to create amazing experiences for our clients.
        </p>
        </div>
      </div>
    
    @foreach($partners as $partner)
    <div class="Polaris-Layout__Section Polaris-Layout__Section--oneThird">
      <div class="Polaris-Card">
        <div class="Polaris-Card__Header">
          <div class="Polaris-Stack ">
            <div class="Polaris-Stack__Item" >
              <div class="Polaris-Stack__Item__Container">
                <div class="Polaris-Stack__Item__Owned">
                  <div class="Polaris-Stack__Item__Media"><span class="Polaris-Thumbnail Polaris-Thumbnail--sizeMedium"><img src="{{$partner->logo}}" alt="{{$partner->name}}" class="Polaris-Thumbnail__Image"></span></div>
                </div>
              </div>
            </div>
            <div class="Polaris-Stack__Item top-right-partner-offer">
              <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                <span class="Polaris-VisuallyHidden">Success</span>{{$partner->offer_description}}
              </span>
            </div>
          </div>
        </div>
        <div class="Polaris-Card__Section">
          <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
            <h2 class="Polaris-Heading">{{$partner->name}}</h2>
          </div>
          <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
             <p>{!! $partner->description !!}</p>
          </div>
          <br/>
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item showIfLimitReached btn-upgrade">
              <a href="{{$partner->link}}" class="Polaris-Button Polaris-Button--primary">
                <span class="Polaris-Button__Content">
                  <span class="Polaris-Button__Text">Continue</span>
                </span>
              </a>
            </div>
            <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--plain">
              <a href="{{$partner->link}}" class="Polaris-Button Polaris-Button--plain">
                <button type="button" class="Polaris-Button Polaris-Button--plain">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Learn more</span>
                  </span>
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif

@endsection

@section('scripts')
  @parent
  <script src="https://js.stripe.com/v3/"></script>
  <script type="text/javascript">
    {{--
    ShopifyTitleBar.set({
      title: 'Partners',
    });
    --}}
  </script>
@endsection
