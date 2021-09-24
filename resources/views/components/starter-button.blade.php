@if($alladdons_plan == $starter)
<button class="Polaris-Button--fullWidth Polaris-Button Polaris-Button--primary btn-loading" onclick="return gotoCheckoutPage('{{strtolower($starter)}}','{{$billingCycle}}')">
  <span class="Polaris-Button__Content">
    <span class="Polaris-Button__Text">Manage my plan</span>
  </span>
</button>
@else
<button class="Polaris-Button--fullWidth Polaris-Button btn-loading @if($all_addons != 1) Polaris-Button--primary @endif" onclick="return gotoCheckoutPage('{{strtolower($starter)}}', 'yearly')">
  <span class="Polaris-Button__Content">
    <span class="Polaris-Button__Text">Choose this plan</span>
  </span>
</button>
@endif
