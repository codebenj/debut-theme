@extends('layouts.debutify')
@section('title','changelog')
@section('view-changelog','view-changelog')

@section('content')
  @include("components.account-frozen-banner")
  <div class="Polaris-Card">
    <div data-upvoty=""></div>
  </div>
  @include ("components.updates-modal")
@endsection

@section('scripts')
  @parent
  <script type='text/javascript' src='https://debutify.upvoty.com/javascript/upvoty.embed.js'></script>
  <script type='text/javascript'>upvoty.init('render', {'startPage': 'changelog', 'baseUrl': 'debutify.upvoty.com', });</script>
  <script type="text/javascript">
      // ESDK page and bar title
      {{--
      ShopifyTitleBar.set({
          title: 'Changelog',
      });

      --}}
  </script>
@endsection
