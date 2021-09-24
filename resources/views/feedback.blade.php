@extends('layouts.debutify')
@section('title','feedback')
@section('view-feedback','view-feedback')

@section('styles')
<style>
.pollly-embed{
  margin-top:2rem;
}
.pricingBanner{
  display: none;
}
</style>
@endsection

@section('content')
@include("components.account-frozen-banner")
{{-- <div id="dashboard">
  <div class="pollly-embed text-center" data-id="Pv8OBjmO"></div>
</div> --}}
<div data-upvoty></div>

@endsection
<script type='text/javascript' src='https://feedback.debutify.com/javascript/upvoty.embed.js'></script>

@section('scripts')
  @parent
  <script src="https://poll.ly/scripts/embed.js"></script>
  <script type="text/javascript">
      // ESDK page and bar title
      {{--
      ShopifyTitleBar.set({
          title: 'Feedback',
      });
      --}}
      upvoty.init('render', {
      'ssoToken': '{{ $ssoToken }}',
      'baseUrl': 'feedback.debutify.com',
      });
  </script>
@endsection
