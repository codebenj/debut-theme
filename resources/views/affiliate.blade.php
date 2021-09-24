@extends('layouts.debutify')
@section('title','affiliate')
@section('view-affiliate','view-affiliate')

@section('styles')
<style>
/* .page-header{
  display: none;
} */
</style>
@endsection

@section('content')
<div id="dashboard">
  @include("components.account-frozen-banner")
  <div class="Polaris-EmptyState Polaris-EmptyState--withinPage">
    <div class="Polaris-EmptyState__Section">
      <div class="Polaris-EmptyState__DetailsContainer">
        <div class="Polaris-EmptyState__Details">
          <div class="Polaris-TextContainer">
            <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">
              Become a Debutify affiliate
            </p>
            <div class="Polaris-EmptyState__Content">
              <p>Refer customers to Debutify and get up to 30% of each customer’s account value</p>
            </div>
          </div>
          <div class="Polaris-EmptyState__Actions">
            <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
              <div class="Polaris-Stack__Item">
                <a href="https://app.impact.com/campaign-promo-signup/Debutify.brand" target="_blank" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Join the affiliate program</span></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-EmptyState__ImageContainer"><img src="/svg/empty-state-14.svg" role="presentation" alt="" class="Polaris-EmptyState__Image"></div>
    </div>
  </div>

  <div class="Polaris-EmptyState">
    <div class="row text-center">
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight layout-item">
          <img src="/svg/illustration-1.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">1. Create an account</h2>
          <p>Create an Affiliate account to get started</p>
        </div>
      </div>
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight layout-item">
          <img src="/svg/illustration-2.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">2. Refer customers</h2>
          <p>Share your unique affiliate link with your network</p>
        </div>
      </div>
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight layout-item">
          <img src="/svg/illustration-10.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">3. Get paid</h2>
          <p>Get up to 30% of the value of accounts you refer – every single month</p>
        </div>
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
          title: 'Affiliate',
      });
      --}}
  </script>
@endsection
