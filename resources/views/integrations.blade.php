@extends('layouts.debutify')
@section('title','integrations')
@section('view-integrations','view-integrations')

@section('styles')
<style>
/* .page-header{
  display: none;
} */
</style>
@endsection

@unless($alladdons_plan == $hustler || $alladdons_plan == $guru)
  @section('bannerTitle','available only on '. $hustler .' and '. $guru .' plans')
  @section('bannerLink','upgrade to '. $hustler .' or '. $guru. ' plans')
@endunless

@section('content')
<div id="dashboard">
  <div class="Polaris-EmptyState Polaris-EmptyState--withinPage">
    <div class="Polaris-EmptyState__Section">
      <div class="Polaris-EmptyState__DetailsContainer">
        <div class="Polaris-EmptyState__Details">
          <div class="Polaris-TextContainer">
            <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">
              Integrate your apps
            </p>
            <div class="Polaris-EmptyState__Content">
              <p>Connect Debutify theme to your favourite Shopify apps in one-click.</p>
            </div>
          </div>
          <div class="Polaris-EmptyState__Actions">
            <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
              <div class="Polaris-Stack__Item">
                @if($alladdons_plan == $hustler || $alladdons_plan == $guru)
                <a class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge Polaris-Button--disabled" disabled>
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Coming soon</span></span>
                </a>
                @else
                <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Unlock integrations</span></span>
                </a>
                @endif
              </div>
            </div>
          </div>
          <div class="Polaris-EmptyState__FooterContent">
            <div class="Polaris-TextContainer">
              @if($alladdons_plan == $hustler || $alladdons_plan == $guru)
              <p>Your integrations are under development.</p>
              @else
              <p>Soon available on {{$hustler}} and {{$guru}} plans.</p>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-EmptyState__ImageContainer"><img src="/svg/empty-state-15.svg" role="presentation" alt="" class="Polaris-EmptyState__Image"></div>
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
          title: 'Integrations',
      });
      --}}
  </script>
@endsection
