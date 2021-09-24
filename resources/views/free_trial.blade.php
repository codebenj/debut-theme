@extends('layouts.debutify')
@section('title','Thank you')
@section('thank-you','thank-you')
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
  .icon-hover {
    position: absolute;
    width: 100%;
    height: 100%;
    display: flex !important;
    justify-content: center;
    align-items: center;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    cursor: pointer;
  }
  .relative{
    position: relative;
  }
  .Polaris-Modal__Body .Polaris-Choice {
    color: #637381;
    display: flex;
    align-items: center;
  }
  button.Polaris-Modal-CloseButton.close-modal {
    position: absolute;
    right: 15px;
    top: 10px;
  }
  .Polaris-Modal-Header.text-center {
    position: relative;
  }
</style>
@endsection
@section('content')

<div id="dashboard">
  @if(request()->get('upgrade_plan') == null)

  <section class="plan-upgradingSection">
    <div class="Polaris-Card">
      <div class="Polaris-CalloutCard__Container">
        <div class="Polaris-Card__Section">
          <div class="row justify-content-center">
            <div class="col-md-10">
              <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeExtraLarge font-weight-normal text-center mt-5">Your trial has expired.</h2>

              <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall mt-5 text-center">
                <p>
                  You are no longer able to use <strong>Add-Ons, Training Courses,<br> or Product Research,</strong>
                  and you will be downgraded to <br>Debutify Free.
                </p>
                <p>(Customer will no longer see your conversion Add-Ons.)</p>
                <p>Choose your preferred plan now for as low as $19/month <br>to keep using your favorite features.</p>
              </div>
              <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued text-center mt-5  w-75 mx-auto row justify-content-center border p-5 rounded">
                <div class="media pl-5 pr-5 text-left">
                  <img src="/images/73x73.png" class="mr-4 rounded-circle">
                  <div class="media-body">
                    <p class="Polaris-TextStyle--variationStrong mt-2 mb-3"><strong style="color:#000;">LabCut Denmark</strong>
                      <i class="fas fa-star text-success"></i></p>
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
                <p class="Polaris-TextStyle--variationSubdued"><i>Probably one of the most powerful themes out there with unique features and completed into one solid system. Free is good but upgrade to get some of the best features.</i></p>
              </div>

              <div class="row mb-3 text-center mt-5">
                <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-title="Jordan Welch" data-subtitle="Serial entrepreneur, digital marketer & 7-Figure store owner" class="d-block relative testimonialModal">
                            <span class="fab fa-youtube fa-3x text-primary icon-hover" aria-hidden="true"></span>
                            <img src="../images/new/v3.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“The <strong>highest conversion rates…</strong> the <strong>highest page speeds…</strong> Debutify ranks among the top ones”</p>
                        <p class="text-muted small">— <strong>Jordan Welch,</strong> serial entrepreneur, digital marketer & 7-Figure store owner</p>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-title="Marc Chapon" data-subtitle="7-figure e-commerce entrepreneur & Youtuber" class="d-block relative testimonialModal">
                            <span class="fab fa-youtube fa-3x text-primary icon-hover" aria-hidden="true"></span>
                            <img src="../images/new/v4.png" alt="" class="img-fluid rounded shadow mb-3 lazyload w-100" />
                        </a>
                        <p>“Everything you need to test & scale your store efficiently. <strong>The best free theme by far</strong>”</p>
                        <p class="text-muted small">— <strong>Marc Chapon,</strong> 7-figure e-commerce entrepreneur & Youtuber</p>
                    </div>
                <div class="col-md-4 col-sm-6 mb-3">
                  <a href="javascript:void(0);" data-toggle="modal" data-title="James Beattie" data-subtitle="CEO, ecom insiders; 7-figure entrepreneur &amp; Youtuber" class="d-block relative testimonialModal">
                    <span class="fab fa-youtube fa-3x text-primary icon-hover" aria-hidden="true"></span>
                    <img src="../images/new/v9.jpg" alt="" class="img-fluid rounded shadow mb-3 w-100 lazyload">
                  </a>
                  <p>“From 2-3% conversion rate to <strong>5% on a new branded Shopify store</strong> with optimizations in the theme”</p>
                  <p class="text-muted small">— <strong>James Beattie,</strong> ceo, ecom insiders; 7-figure entrepreneur &amp; Youtuber</p>
                </div>
              </div>


              <div id="testimonialModal" class="modal fade-scales">
                <div>
                  <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
                    <div>
                      <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
                        <div class="Polaris-Modal-Header">
                          <div id="modal-header2" class="Polaris-Modal-Header__Title">
                               <h5 class="testimonial-title Polaris-DisplayText Polaris-DisplayText--sizeMedium mb-0"></h5>
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
                                <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">
                                  <section class="Polaris-Modal-Section">
                                    <div class="embed-responsive embed-responsive-16by9">
                                      <iframe class="embed-responsive-item testimonial-iframe" width="560" height="315" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
                                         <button type="button" class="close-modal Polaris-Button">
                                            <span class="Polaris-Button__Content">
                                            <span class="Polaris-Button__Text">Close</span>
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
        <div class="Polaris-Backdrop"></div>
        </div>

              @include("components.trial_plan")

              <div class="text-center">
                <button class="Polaris-Button Polaris-Button--plain opennothanksModal" onclick="return no_thanks_free_model();">
                  <span class="mt-4 Polaris-Button__Content"><span class="Polaris-Button__Text Polaris-Plain-Link">No thanks, I'll stay on the Free version</span></span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- upgrade warning popup 1 --}}
  <div id="upgrade_warning" class="modal fade-scales">
    <div>
      <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
        <div>
          <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
            <div class="Polaris-Modal-Header text-center border-0">
              <div id="modal-header12" class="Polaris-Modal-Header__Title">
                <h2 class="Polaris-DisplayText--sizeLarge text-center mb-1"> Are you sure? </h2>
              </div>
              <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
                <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                  <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                    <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd" fill="#637381"/>
                  </svg>
                </span>
              </button>
            </div>
            <div class="Polaris-Modal__BodyWrapper">
              <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical text-center" data-polaris-scrollable="true" style="padding: 2rem;">
                <div class="Polaris-Banner__Ribbon">
                  <span class="Polaris-Icon Polaris-Icon--isColored Polaris-Icon--hasBackdrop mb-5" style="display: inline-block;"><svg width="30px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 11a1 1 0 102 0V9a1 1 0 10-2 0v2zm0 4a1 1 0 102 0 1 1 0 00-2 0zm8.895 1.549l-7-14.04c-.339-.679-1.45-.679-1.79 0l-7 14.04A1.004 1.004 0 003 18h14a1 1 0 00.895-1.451z" fill="#eec200"/></svg>
                  </span>
                </div>
                <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                  <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Debutify Free comes without high-converting Add-Ons. <br>Downgrading may <b>severely hurt</b> your sales.</p>
                  <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Why not keep your favorite Add-Ons?</p>
                  <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Take this discount and <b>upgrade to any plan at 10% off.</b><br> Just click the button below and choose your preferred <br>plan -- your discount will be automatically applied.</p>
                </div>
                <div class="mt-5">
                  <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge" id="close_focus_plan"><span class="Polaris-Button__Content" onclick=" return show_plan_price_model(); "><span class="Polaris-Button__Text">Yes! I want to upgrade and save 10%!</span></span></button>
                </div>
                <div class="mt-4">
                  <a href="" class="Polaris-Button Polaris-Button--plain free_version_model">
                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text Polaris-Plain-Link">No thanks, I'll still take the Free version</span></span>
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
  {{-- upgrade warning popup 1 --}}
  {{-- upgrade warning popup 2 --}}
  <div id="upgrade_warning_success" class="modal fade-scales">
    <div>
      <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
        <div>
          <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1" style="max-width: 70rem;">
            <div class="Polaris-Modal-Header text-center">
              <div id="modal-header12" class="Polaris-Modal-Header__Title">
                <h2 class="Polaris-DisplayText--sizeLarge text-center">Thank you for trying out<br> Debutify Master!</h2>
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
              <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical text-center" data-polaris-scrollable="true" style="padding: 2rem;">
                <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued">
                  <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">We hope you've enjoyed your free trial <i class="far fa-smile"></i></p>
                  <p class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">We're working around the clock to make Debutify better <br> for you. Your feedback is what drives us! Can you let us <br> know why you chose not to upgrade?</p>
                </div>
                <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSdLP_WlYfBOgGTZkYin3MJKe3J_2iMeRA5JEelqLnLdaENwzQ/viewform?embedded=true" width="640" height="709" frameborder="0" marginheight="0" marginwidth="0">Loading…</iframe>
  <div class="mt-5">
    <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge btn-loading px-5" onclick="window.location='{{ route('free_trial_expired') }}?upgrade_plan=free_confirmation'"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Switch to free</span></span></button>
  </div>
  <a href="" class="Polaris-Button Polaris-Button--plain upgrade_plan" data-dismiss="modal">
    <span class="mt-4 Polaris-Button__Content"><span class="Polaris-Button__Text Polaris-Plain-Link">Actually, I want to upgrade!</span></span>
  </a>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="Polaris-Backdrop"></div>
</div>
{{-- upgrade warning popup 2 --}}
@endif
@if(request()->get('upgrade_plan') != null && !empty(request()->get('upgrade_plan') == "free_confirmation"))
<section class="subscription-cancel">
  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section p-5">
        <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge mb-5 text-center">Thank you for trying out <br>Debutify Master! </h2>
        <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall text-center">
          <p>
            You're now using <b>Debutify Free</b> -- free forever! You'll <br>receive an email notification in your inbox.
          </p>
          <p>
            If you ever change your mind, you can always upgrade <br> from the <a href="{{ route('plans')}}">Plans page.</a></p>
            <p>
              Want to upgrade, but not sure which plan is best for you?<br>Schedule a free call with our Phone Support Specialist to <br> get help.
            </p>
          </div>
          <div class="text-center mt-5">
            <button type="button" class="Polaris-Button Polaris-Button--primary download_theme btn-loading Polaris-Button--sizeLarge" onclick="window.location='{{ route("support") }}'">
              <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Schedule a call</span></span></button>
            </div>
          </div>
          <div class="text-center">
            <h2 class="Polaris-DisplayText--sizeLarge text-center mb-5">Want a chance to win Master<br>free for lifetime?</h2>
            <div class="Polaris-TextContainer Polaris-TextStyle--variationSubdued Polaris-DisplayText--sizeSmall text-center">
              <p>
                Subscribe to our YouTube channel to automatically enter <br> our monthly giveway -- for a chance to win Starter,
                <br> Hustler or Master free for lifetime!
              </p>
            </div>
            <div class="text-center mb-4 mt-5">
              <a class="Polaris-Button Polaris-Button--primary download_theme Polaris-Button--sizeLarge" href="https://www.youtube.com/channel/UCm4-k3TAP2OPGZo47o-qZ5w?sub_confirmation=1" target="_blank">
              <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Subscribe now</span></span></a>
            </div>
              <div class="text-center pb-5">
                <a href="{{ route('home')}}">Go to Dashboard</a>
              </div>
          </div>
        </div>
      </div>
    </section>
    @endif
  </div>
  @endsection
  @section('scripts')
  @parent
    <script type="text/javascript">
        let addonsPlan = '{{$alladdons_plan}}';
        var master_shop = '{{$master_shop}}';

        function gotoCheckoutPage(plan, billingCycle) {

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

      // addon video modal
      function addonVideo(title,subtitle){
        @include("components.video-addons")

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
     
// all plan btn trial page
$(".upgrade_plan_btn").click(function() {
  var plan_name = $(this).attr('plan-type');
  $(".upgrade_popup_btn").attr('plan-type', plan_name);
  $(".thank_you_upgrade_btn").attr('plan-type', plan_name);
})
// second last upgrade popup btn
$(".free_version_model").click(function(e) {
  e.preventDefault();
  var modal = $("#upgrade_warning");
  closeModal(modal);
  var modal = $("#upgrade_warning_success");
  openModal(modal);
})
// close model and show upgrade plan
$(".upgrade_plan").click(function(e) {
  e.preventDefault();
  var modal = $("#upgrade_warning_success");
  closeModal(modal);
  var elmnt = document.getElementById("free_trial_plan_section");
  elmnt.scrollIntoView();
})
// warning model
function no_thanks_free_model() {
  var modal = $("#upgrade_warning");
  openModal(modal);
}

function show_plan_price_model(){
  $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
  $.ajax({
      type : 'get',
      url : "{{URL::to('app/generate10coupon')}}",
      data: {"_token": "{{ csrf_token() }}"},
      dataType: 'json',
      success:function(result){
         if(result.status =='success'){
          // alert(result); setCookie('discount-code', 'BLACKFRIDAY50', 60);
          var cname =  'discount-code';
          var cvalue = result.coupon_code;
          var exdays = 2;
          var d = new Date();
          d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
          var expires = "expires="+d.toUTCString();
          document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
      }
    });
  var modal = $("#upgrade_warning");
  closeModal(modal);
  var elmnt = document.getElementById("free_trial_plan_section");
  elmnt.scrollIntoView();
}

          $(document).ready(function() {

                $('.testimonialModal').click(function(event){
                          var title = $(this).attr('data-title');
                          var subtitle = $(this).attr('data-subtitle');
                          @include("components.video-testimonials");
                          $('.testimonial-iframe').attr("src", "https://www.youtube.com/embed/" + testimonialSource + "?autoplay=1");
                          $(".testimonial-title").text(title);
                          $(".testimonial-subtitle").text(subtitle);
                          if (testimonialSource) {
                            $(".video-testimonial").show();
                          } else {
                            $(".video-testimonial").hide();
                          }
                          var model = $('#testimonialModal');
                          openModal(model);

                });

              $('#testimonialModal').on('hide.bs.modal', function(e) {
                $('.testimonial-iframe').attr("src", "");
              });

              var $checks = $('input[name="feedbackcheckbox"]');
                $checks.click(function() {
                   $checks.not(this).prop("checked", false);
                });


});  
</script>
@endsection