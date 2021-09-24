@extends('layouts.debutify')
@section('title','Extended Trial')
@section('view-onboarding','view-onboarding')

<style type="text/css">
  .extend_title{
    min-height: 100px;
  }
  .polaris_drop_zone svg {
    width: 40px;
  }
  
</style>

@section('content')
@php
$complete_step = 0;
$progress_bar = 0;
foreach($extend_features as $extend_feature){
  if($extend_feature->extend_trial_status == "approved"){
    $complete_step++;
  }
}
if($extend_trial_feature_count != 0){
$progress_bar = $complete_step*100/$extend_trial_feature_count;
}
@endphp

<div id="dashboard">
@if($extend_trial_feature_count != 0)
  <div class="Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
      <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
      <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
    </svg></span></div>
    <div>
      <div class="Polaris-Banner__Heading" id="Banner3Heading">
        <p class="Polaris-Heading">Get a chance to win 1 free month of Debutify Master when you complete all challenges!</p>
      </div>
    </div>
  </div>
@endif  

  <div class="Polaris-Card winning-product-card-overlay">
   <div class="Polaris-Card__Header mentoring-card-header">
    <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
      <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
        <h2 class="Polaris-Heading">Your extend trial progress
          <span class="Polaris-Badge Polaris-Badge--statusSuccess">
            <span class="Polaris-VisuallyHidden">Success</span>
            {{ $trial_extend_step_progress }}
          </span>
        </h2>
        {{-- <p>Let's get you up and running so you can get more sales and grow your Shopify store</p> --}}
        <br>
        <div class="Polaris-ProgressBar Polaris-ProgressBar--sizeMedium"><progress class="Polaris-ProgressBar__Progress" max="100"></progress>
          <div class="Polaris-ProgressBar__Indicator" style="width: @php echo $progress_bar.'%'; @endphp">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="Polaris-Card__Section">
    <div class="Polaris-Stack__Item text-center">
      <div class="all-products">
        <div class="row" style="position:relative;">
          @if(isset($extend_features) && !empty($extend_features))
          @php $test = 0; @endphp
          @foreach($extend_features as $extend_feature)
          @php
                                // $total = $test;
          $extend_disable_btn ="";
          if($extend_feature->extend_trial_status == "pending"){
            $extend_btn = 'Pending Confirmation';
            $extend_disable_btn = 'Polaris-Button--disabled';
          }elseif($extend_feature->extend_trial_status == "approved"){
            $extend_btn = 'Approved';
            $extend_disable_btn = 'Polaris-Button--disabled';
            $test++;
          }elseif($extend_feature->extend_trial_status == "rejected"){
            $extend_btn = 'Extend Trial';
          }else{
            $extend_btn = 'Extend trial';
          }
          @endphp

          <div class="col col-12 col-md-4">
            <div class="Polaris-Card product-card h-100">
              <div class="Polaris-CalloutCard__Container">
                <div class="Polaris-Card__Section">
                  <div class="Polaris-CalloutCard__Content grid-product-wrapper">
                    <div class="Polaris-TextContainer Polaris-TextContainer--spacingTight d-flex">
                      <span class="Polaris-Badge Polaris-Badge--statusSuccess" style="margin: 0 auto;">
                        {{ $extend_feature->extend_trial_days }} days extended trial
                      </span>
                    </div>
                    <div class="Polaris-TextContainer extend_title mt-5">
                      <h2 class="Polaris-Heading grid-product-title flex-fill">{{$extend_feature->name}}</h2>
                      <div class="Polaris-TextContainer" style="word-break: break-word;">
                        <p class="update-subtitle">{!! isset($extend_feature->description) ? $extend_feature->description : ""  !!} </p>
                      </div>
                    </div>
                    <div class="Polaris-CalloutCard__Buttons mt-5">
                      <button class="Polaris-Button--fullWidth Polaris-Button Polaris-Button--primary {{ $extend_disable_btn }} extend_feature_btn" data-name="{{$extend_feature->name}}" data-description="{{$extend_feature->description}}" data-extendday="{{$extend_feature->extend_trial_days}}" data-id="{{$extend_feature->id}}">
                        <span class="Polaris-Button__Content">
                          <span class="Polaris-Button__Text">
                            {{ $extend_btn }}
                          </span>
                        </span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          @endforeach
          @endif

        </div>        
      </div>
    </div>
  </div>


  <div id="extends_trial_model" class="modal fade-scale open" style="display: none;">
    <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
      <div>
        <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
          <div class="Polaris-Modal-Header">
            <div id="modal-header11" class="Polaris-Modal-Header__Title">
              <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall feature-title"></h2>
            </div>
            <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
              <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                  <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                </svg>
              </span>
            </button>
          </div>

          <div class="Polaris-Modal__BodyWrapper polaris_drop_zone">
            <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true" polaris="[object Object]">
              <section class="Polaris-Modal-Section">
                <div class="Polaris-FormLayout">
                  <div class="Polaris-FormLayout__Item">
                    <div class="Polaris-TextContainer">
                      <p>
                        <span class="showOnUninstalled feature-description" style="word-break: break-word;"></span>
                      </p>
                      <div class="form-group">
                        <h3 class="sizeExtraLarge mb-4" style="font-weight: 700;">Please upload your proof of completion below, you will receive your extended trial as soon as we have confirmed your request</h3>

                        <label class="d-block" for="interest">Please upload one image <small class="text-muted">( jpeg | jpg | png | gif )</small></label>
                        <input type="file" class="form-control-file" id="p_logo" name="p_logo" accept="image/x-png,image/gif,image/jpeg">
                      </div>


                      <form id="post_feature_data" method="POST" action="{{ route('user_feature')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="feature_proof_image" id="feature_proof_image" value="">
                        <input type="hidden" name="extend_feature_id" id="extend_feature_id" value="">
                      </form>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>

          <div class="Polaris-Modal-Footer">
                  <div class="Polaris-Modal-Footer__FooterContent">
                    <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                      <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                      </div>
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
                            <button type="button" class="Polaris-Button Polaris-Button--primary extend_request_btn btn-loading Polaris-Button--disabled">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Request extended trial</span></span>
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
      </div>

    </div>  {{-- dashboard id --}}
    
    @endsection
    @php
    $request_res = "";
    if(session('extend_request')){
      $request_res = session('extend_request');
    }
    @endphp

    @section('scripts')

    <script type="text/javascript" src="{{ asset('js/pekeUpload.min.js?v='.config('env-variables.ASSET_VERSION')) }}"></script>

    <script type="text/javascript">
      $('.extend_feature_btn').click(function(event){
        event.preventDefault();
        var feature_name = $(this).attr('data-name');
        var feature_description = $(this).attr('data-description');
        var feature_extendday = $(this).attr('data-extendday');
        var feature_id = $(this).attr('data-id');
        $('#extend_feature_id').val(feature_id)
        $('.feature-title').html(feature_name);
        $('.feature-description').html(feature_description);
              // $('.feature-title').html(feature_name);
              var modal = $("#extends_trial_model");
              openModal(modal);
              loadingBarCustom(false);
            })


      $(document).ready(function() {
        var extend_request = "{{ $request_res }}";
        if(extend_request == "ok"){
          customToastMessage("Request successfully sent");
        }
        
        $('#p_logo').click(function(e) {e.target.value = '';});
        $("#p_logo").pekeUpload({
          notAjax:false,
          url:"{{ route('upload_feature_proof') }}",
          data:{ '_token' : '{{ csrf_token() }}' },
          allowedExtensions:"jpeg|jpg|png|gif",
          showPreview:true,
          dragMode:true,
          polaris:true,
          onSubmit:false,
          bootstrap:true,
          delfiletext:"Delete",
          limit:'1',
          showPercent: true,
          limitError:"One File Uploaded Already.",
          dragText:"",
          onFileSuccess:function(file,data){
            $("input[name='feature_proof_image']").val(data.url);
            $(".extend_request_btn").removeClass('Polaris-Button--disabled');
          }
        });

      });

      $('.extend_request_btn').click(function(event){
        event.preventDefault();
        var feature_name = $('#feature_proof_image').val();
        var form = document.getElementById('post_feature_data');
        form.submit();

      })


    </script>
    @endsection
