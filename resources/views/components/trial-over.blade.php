<style>
button.Polaris-Modal-CloseButton.close-modal {
    position: absolute;
    right: 15px;
    top: 10px;
}
.Polaris-Modal-Header.text-center {
    position: relative;
}
</style>
<div id="freetrial_expired" class="modal fade-scales">
  <div>
    <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
      <div>
        <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
          <div class="Polaris-Modal-Header text-center border-0">
            <div id="modal-header12" class="Polaris-Modal-Header__Title">
                <img class="logo default-logo img-fluid" src="/images/landing/debutify-logo-dark.svg" width="200" alt="Debutify" itemprop="logo">
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
            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical text-center" data-polaris-scrollable="true" style="padding: 4rem;">
              <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">{{ $shopify_shop_data['shop_owner'] }}, your trial has expired.</h2>

              <div class="" style="display: flex;justify-content: center;align-items: center;" tabindex="0" role="alert" aria-live="polite" aria-labelledby="PolarisBanner6Heading" aria-describedby="PolarisBanner6Content">
                  <div class="mr-3"><span class="Polaris-Icon Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9 11a1 1 0 102 0V9a1 1 0 10-2 0v2zm0 4a1 1 0 102 0 1 1 0 00-2 0zm8.895 1.549l-7-14.04c-.339-.679-1.45-.679-1.79 0l-7 14.04A1.004 1.004 0 003 18h14a1 1 0 00.895-1.451z" fill="#eec200"/>
                      </svg></span>
                    </div>
                  <div class="">
                    <div class="Polaris-Banner__Heading" id="PolarisBanner6Heading">
                      <p class="Polaris-Heading">Debutify requires your immediate attention</p>
                    </div>
                  </div>
                </div>

              <div class="mt-5">
              <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading" onclick="return window.location='{{ route('free_trial_expired') }}'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes! I want to upgrade now!</span></span></button>
            </div>
            <a href="{{ route('home') }}" class="Polaris-Button Polaris-Button--plain close-modal closeNothanksModal" data-dismiss="modal">
              <span class="mt-4 Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, I'll will use free version</span></span>
            </a>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="Polaris-Backdrop"></div>
</div>

<div id="freetrial_expired_two_days" class="modal fade-scales">
  <div>
    <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
      <div>
        <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1" style="max-width: 74rem;">
          <div class="Polaris-Modal-Header text-center">
            <div id="modal-header12" class="Polaris-Modal-Header__Title">
                <img class="logo default-logo img-fluid" src="/images/landing/debutify-logo-dark.svg" width="200" alt="Debutify" itemprop="logo">
             
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
            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical text-center" data-polaris-scrollable="true" style="padding: 4rem;">
            
                 @if($trial_days <= 1)
                  <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">Your free trial ends today</h2>
                  @elseif($trial_days == 2)
                  <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">{{$fname}}</span>, your trial ends tomorrow</h2>
                  @elseif($trial_days == 3)
                  <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">{{$fname}}</span>, your trial ends in less than 72 hours</h2>
                  @elseif($trial_days >= 4 && $trial_days <= 7)
                  <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">Your @if($is_beta_user == true) BETA @else Master @endif trial ends in {{$trial_days}} days</h2>
                  @elseif($trial_days == 8)
                  <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">{{$fname}}, Your trial is halfway finished</h2>
                  @else
                  <h2 class="Polaris-DisplayText--sizeLarge text-center mb-4">{{$trial_days}} days left on your free trial</h2>
                  @endif
              <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">

               @if($trial_days <= 1)
                    <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><span class="text-capitalize">{{$fname}}</span>, you only have a few hours until you're downgraded to free. Choose a plan now to avoid losing everything you've built with Debutify. Cancel anytime in 30 days.</p>
                @elseif($trial_days == 2)
                    <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Once your free trial is over, you will be downgraded to Free. Choose a plan today to keep building your store. Cancel anytime in 30 days.</p>
                @elseif($trial_days == 3)
                    <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Don't lose everything you've worked on. Pick any plan today, <b>starting as low as $19/mo.</b> Cancel anytime in 30 days.</p>
                @elseif($trial_days >= 4 && $trial_days <= 7)
                    <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><span class="text-capitalize">{{$fname}}</span>, your trial is almost over. Choose a plan today to keep building your store. <b>Starting as low as $19/mo.</b></p>
                @elseif($trial_days == 8)
                    <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><span class="text-capitalize">{{$fname}}</span>, your trial is halfway done! To avoid losing your favorite features, pick a plan today. <b>Starting as low as $19/mo.</b></p>
                @else
                    <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall"><span class="text-capitalize">{{$fname}}</span>, your free @if($is_beta_user == true) BETA @else Master @endif  trial ends in {{$trial_days}} days. Choose your plan now to avoid losing your favorite features.</p>
                @endif

             </div>

            <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued mt-5" style="border: 0.1rem solid var(--p-border, #c4cdd5); padding: 45px; border-radius: 5px;display: flex; justify-content: center; flex-wrap: wrap;"> <div class="media pl-5 pr-5">
                <img src="/images/73x73.png" class="mr-4 rounded-circle">
                <div class="media-body text-left">
                  <p class="Polaris-TextStyle--variationStrong mt-2 mb-3" style="color:#000;"><strong>LabCut Denmark</strong></p>
                  <p class="text-warning">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                  </p>
                  <p class="Polaris-TextStyle--variationStrong mt-2 mb-3" style="color: #000; font-weight: 100;">Nov 1, 2020 </p>
                </div>
              </div>
              <p class="Polaris-TextStyle--variationSubdued"><i>Probably one of the most powerful themes out there with unique featires and completed into one solid system. Free is good but upgrade to get some of the best features.</i></p>
            </div>

            <div class="mt-5">
              <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading" onclick="return window.location = '{{ route('plans')}}'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Yes! I want to upgrade now!</span></span></button>
            </div>
            <div class="mt-4">
            <a href="" class="Polaris-Button Polaris-Button--plain close-modal closeNothanksModal" data-dismiss="modal">
              <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">No thanks, I'll let my trial expire</span></span>
            </a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="Polaris-Backdrop"></div>
</div>
@section('scripts')
<script>

var left_days = '{{ $trial_days }}';
var alladdons_plan = '{{ $db_plan_name }}';
var freemium = '{{ $freemium }}';
var trial_over_page = '{{ route('free_trial_expired') }}';
if(left_days == ''){
  left_days = 0;
} 

// alert(left_days);

      $(document).ready(function(){
         var free_trial_expired_redirect = localStorage.getItem("free_trial_expired_redirect");
          if(left_days == 0 && (alladdons_plan == "" || alladdons_plan == "Freemium")){ 
              if(free_trial_expired_redirect == '' || free_trial_expired_redirect == null){
                // var modal = $("#freetrial_expired");
                // openModal(modal);
                window.location.href = trial_over_page;
                localStorage.setItem("free_trial_expired_redirect",1);
              }

          }

          // var modal_opened =localStorage.getItem("modal_opened"); 
          var modal_opened = getCookie('trial_modal_opened');

          if(left_days == 1 || left_days > 1 && alladdons_plan == ""){
              if(modal_opened == '' || modal_opened == null){
                var modal = $("#freetrial_expired_two_days");
                openModal(modal);
                // localStorage.setItem("modal_opened",1);
                  var cname =  'trial_modal_opened';
                  var cvalue = 1;
                  var exdays = 1;
                  var d = new Date();
                  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                  var expires = "expires="+d.toUTCString();
                  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
              }
          }

        // } // popup time

      }) // document ready  
  </script>
@endsection