@extends('layouts.landing')
@section('title','Our Trusted Shopify Theme Integrations - Debutify')
@section('description','Debutify works with the industry’s leading agencies & technology providers to create amazing experiences for our clients. Learn about our theme .')

@section('content')

{{-- <x-landing.jumbotron title='Debutify Trusted Integrations' description='Check out the awesome freebies and exclusive offers provided by Debutify Integrations!'/> --}}

<section class='debutify-section'>
  <div class="container">
    <div class='text-center'>
      <h1 class='display-3'>Debutify Trusted Integrations</h1>
      <p class='lead  mb-5'>Check out the awesome freebies and exclusive offers provided by Debutify Integrations!</p>
    </div>
    <form id="partner-search" class='mb-4' method="POST" action="{{ route('partners.search') }}">
      {{ csrf_field() }}
      <div class="form-row">
        <div class="col-md-9 mb-3">
          <div class="input-group">
            <div class="input-group-prepend ">
              <label class='input-group-text'>
                <img class="lazyload d-inline-block" data-src="/images/landing/icons/icon-search.svg" alt="icon search" width="25" height="25">
              </label>
            </div>
            <input type="text" class="form-control border-left-0 pl-0" id="search_title" name="search_title" placeholder="Search" value="{{ request()->has('search_title') ? request()->input('search_title') : '' }}">
          </div>
        </div>
        <div class="col-md-3">
          <select class="selectpicker" data-live-search="true" data-width='100%' data-size="5" id="category" name="search_by_category">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            @php
            $selected = request()->get('category') == $category['value'] ? 'selected' : ''
            @endphp
            <option value="{{ $category['value'] }}" {{ $selected }}>{{ $category['text'] }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </form>
    <div id="partners-container" >
      @include('landing.partners-result')
    </div>
  </div>
</section>

<section class='debutify-section'>
  <div class='container text-center'>
    <h1 >Want To Partner Up With Debutify?</h1>
    <p class='mt-4 mb-5'>
      Applications are open! If you're a business operating in the ecommerce, marketing, or any other
      business-related niche — we'd love to work with you. Expand your reach and bring your audience a
      cutting-edge ecommerce solution. Send your application today: Send yours today:
    </p>
    <a href="/career" class='btn btn-primary btn-lg debutify-hover btn-sm-block'>Apply Now</a>
  </div>
</section>

@endsection
@section('scripts')

<script>
window.addEventListener('DOMContentLoaded', function() {
    $("#partner-search").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: "{{ route('partners.search') }}",
          data: {
            search_title: $("#search_title").val(),
            category: $("#category").val(),
          },
          success: function(result) {
            $('#partners-container').html(result.html);
          }
        })
      });
      $("#search_title").keyup($.debounce(function(e) {
        $("#partner-search").submit();
      },500));
      $("#category").change($.debounce(function(e) {
        $("#partner-search").submit();
      },500));
    });
</script>
@endsection
