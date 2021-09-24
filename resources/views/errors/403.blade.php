@extends('layouts.landing')

@section('title', __('Forbidden'))
@section('code', '403')

@section('content')
<section class="py-5">
    <div class='container text-center'>
      <div class="responsive-container-20by10 mb-4 mb-md-0">
        <img class='lazyload img-fluid' style="width:100%;max-width: 50%;margin:0 auto;right:0;" data-src="/images/40X.svg?v={{config('image_version.version')}}">
      </div>
        <h1 class="font-weight-bolder mb-4">ERROR 403: Forbidden</h1>
        <p class="mb-5">
            Ooops! Something went wrong. <br class="d-none d-sm-block">
            Return to the home page to continue browsing.
        </p>
        <a role="button" class="btn btn-lg btn-sm-block mb-3 btn-primary debutify-hover" href="/">
            Return to Homepage
        </a>
    </div>
</section>
@endsection
@section('styles')
<style>
@media only screen and (max-width:426px){
    img {max-width: 100% !important;}
}
</style>
@endsection
