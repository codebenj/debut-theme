@extends('layouts.debutify')
@section('title','mentoring')
@section('view-mentoring','view-mentoring')

@php
if($all_addons == 1 || $master_shop)
{
  if($master_shop)
  {
      $shop_plan = $guru;
      $alladdons_plan = $guru;
  }
}
@endphp

@if($alladdons_plan != $guru)
  @section('bannerTitle','available only on the '. $guru .' plan')
  @section('bannerLink','upgrade to the '. $guru .' plan')
@endif

@section('styles')
@endsection

@section('content')

@include("components.skeleton")

<div id="dashboard" style="display:none;">
	@if($mentoringWinnercount > 0)
  <!--Mentoring Call Winner -->
  <div class="Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner8Heading" aria-describedby="Banner8Content">
    <div class="Polaris-Banner__Dismiss"><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
        </svg></span></div>
    <div>
      <div class="Polaris-Banner__Heading" id="Banner8Heading">
        <p class="Polaris-Heading">Congratulation <span class="text-capitalize">{{$fname}}</span>, you are the winner of the week!</p>
      </div>
      <div class="Polaris-Banner__Content" id="Banner8Content">
        <p>Click the button below and let our support team schedule your free 30 minutes call with Ricky Hayes himself.</p>
        <div class="Polaris-Banner__Actions">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <button type="button" class="Polaris-Button Polaris-Button--outline claim-call">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Claim my free call</span>
                  </span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
	@endif

  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section">
        <div class="Polaris-CalloutCard">
          <div class="Polaris-CalloutCard__Content">
            <div class="Polaris-CalloutCard__Title">
              <h2 class="Polaris-Heading">
                Paid Dropshipping Mentorship With E-commerce Mentoring X Debutify
              </h2>
            </div>
            <div class="Polaris-TextContainer">
              <p>
                Join E-commerce Mentoring's hands-on mentorship program and learn our premium step-by-step system for succeeding as a dropshipper in any niche.
              </p>
            </div>
            <div class="Polaris-CalloutCard__Buttons">
              <a onclick="contactTagAdd()" class="Polaris-Button Polaris-Button--primary" href="https://www.e-commercementoring.com/debutify" target="_blank" data-polaris-unstyled="true">
                <span class="Polaris-Button__Content"><span>Apply Now</span></span>
              </a>
            </div>
          </div>
          <img src="/svg/security.svg" alt="" class="Polaris-CalloutCard__Image">
        </div>
      </div>
    </div>
  </div>

  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
      <div class="Polaris-Card__Section">
        <div class="Polaris-CalloutCard">
          <div class="Polaris-CalloutCard__Content">
            <div class="Polaris-CalloutCard__Title">
              <h2 class="Polaris-Heading">
                Private 1-On-1 mentoring Facebook group
                <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                  Master plan
                </span>
              </h2>
            </div>
            <div class="Polaris-TextContainer">
              <p>Learn from the best in the industry and join our exclusive community to skyrocket your sales</p>
            </div>
            <div class="Polaris-CalloutCard__Buttons">
              @if($alladdons_plan == $guru)
                <a class="Polaris-Button Polaris-Button--primary" href="https://www.facebook.com/groups/569596487183386/" target="_blank" data-polaris-unstyled="true">
                  <span class="Polaris-Button__Content"><span>Access mentoring group</span></span>
                </a>
              @else
                <a class="Polaris-Button Polaris-Button--primary" href="{{config('env-variables.APP_PATH')}}plans" data-polaris-unstyled="true">
                  <span class="Polaris-Button__Content"><span>Unlock mentoring group</span></span>
                </a>
              @endif
            </div>
          </div>
          <img src="/svg/security.svg" alt="" class="Polaris-CalloutCard__Image">
        </div>
      </div>
    </div>
  </div>

  <div class="Polaris-Card">
    <div class="Polaris-CalloutCard__Container">
    	<div class="Polaris-Card__Section">
        <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
          <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
            <h2 class="Polaris-Heading">
              Mentoring call winners
            </h2>
          </div>
          <div class="Polaris-Stack__Item">
            <div class="Polaris-ButtonGroup">
              <div class="Polaris-ButtonGroup__Item">
                @if($alladdons_plan != $guru)
                <a href="{{config('env-variables.APP_PATH')}}plans" type="button" class="Polaris-Button Polaris-Button--primary">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Unlock mentoring calls</span>
                  </span>
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-ResourceList__ResourceListWrapper">
        <ul class="Polaris-ResourceList" aria-live="polite">
        @foreach($mentoringWinners as $mentoringWinner)
          <li class="Polaris-ResourceList__ItemWrapper">
            <div class="Polaris-ResourceItem" data-href=""><a aria-describedby="341" aria-label="View details for Mae Jemison" class="Polaris-ResourceItem__Link" tabindex="0" id="ResourceListItemOverlay{{$mentoringWinner->id}}" href="" data-polaris-unstyled="true"></a>
              <div class="Polaris-ResourceItem__Container" id="{{$mentoringWinner->id}}">
                <div class="Polaris-ResourceItem__Owned">
                  <div class="Polaris-ResourceItem__Media"><span aria-label="Mae Jemison" role="img" class="Polaris-Avatar Polaris-Avatar--sizeMedium"><span class="Polaris-Avatar__Initials"><svg class="Polaris-Avatar__Svg" viewBox="0 0 40 40">
                          <path fill="currentColor" d="M8.28 27.5A14.95 14.95 0 0120 21.8c4.76 0 8.97 2.24 11.72 5.7a14.02 14.02 0 01-8.25 5.91 14.82 14.82 0 01-6.94 0 14.02 14.02 0 01-8.25-5.9zM13.99 12.78a6.02 6.02 0 1112.03 0 6.02 6.02 0 01-12.03 0z"></path>
                        </svg></span></span></div>
                </div>
                <div class="Polaris-ResourceItem__Content">
                  <h3><span class="Polaris-TextStyle--variationStrong text-capitalize">{{$mentoringWinner->name}}</span></h3>
                  <div>{{$mentoringWinner->city}}, {{$mentoringWinner->country}}</div>
                </div>
                <?php
                  $now = \Carbon\Carbon::now();
                  $from = \Carbon\Carbon::parse($mentoringWinner->created_at);
                  $days = $from->diffInDays($now);
                ?>
                <div class="Polaris-ButtonGroup">
                  <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--plain">
                    <span>Won {{ $days }} days ago</span>
                  </div>
                </div>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

</div>
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
    // ESDK page and bar title
    {{--
    ShopifyTitleBar.set({
        title: 'Mentoring',
    });
    --}}
    
    function contactTagAdd() {
      $.ajax({
        url: "{{ route('contact_tag_add') }}",
        data: {'_token': '{{ csrf_token() }}'},
        type: 'POST',
        cache: false,
        success: function(response) {
          console.log(response)
        }
    });
    }
  </script>
@endsection
