
@extends('layouts.landing')

@section('title',"Debutify - World's Smartest Shopify Theme. Free 14-day Trial")
@section('description','Turn your store into a sales machine with Debutify - best free Shopify theme. High-converting, premium design and 24/7 live support. Download free today')
@section('content')

<section class='debutify-section'>
  <div class='container'>
    <div class='row row_banner align-items-center'>
      <div class='col-lg-6 cont_banner'>
        <h1 class="">
          Make  <span class='debutify-underline'>The Most</span><br class='d-none d-lg-block'> Out Of Debutify
        </h1>
        <p class='my-4' >Learn how to use all Debutify’s features<br class='d-none d-lg-block'> to maximize your leads, conversions,<br class='d-none d-lg-block'> and grow your business.</p>
      </div>
      <div class='col-lg-6 banner_txt'>
        <div class='position-relative'>
          <img data-aos="zoom-in" data-aos-delay="1800" class='position-absolute lazyload prop prop-right' data-src="/images/landing/props-dots-primary.svg" style="bottom:-30px; right:5%" alt="dots-primary">
          <img data-aos="zoom-in" data-aos-delay="600" class=" w-100 lazyload" data-src="/images/landing/landing_group.png" alt="rectangle">
        </div>
      </div>
    </div>
  </div>
</section>
<x-landing.dash/>

<section class='debutify-section'>
  <div class='container'>
    <h1 class='text-center mb-5'>Upcoming  Live Webinars</h1>
    <div class='row text-center'>
      @foreach ([0,1,2] as $item)
      <div class="col-lg-4 col-md-6 mb-3">
        <div class="card h-100 shadow">
          <div class="card-body">
            <a class='text-black' href="#">
              <img alt="landing_blog.png" class="w-100 mb-3 rounded w-100 lazyload" data-src="/images/landing/landing_blog.png" >
              <h5 class='font-weight-bold blog-title'>Webinar Title Goes Here</h5>
            </a>
            <div class="badge-pill font-weight-light position-relative text-left pl-5" style="font-size: 12px;">
              <img class="position-absolute" data-src="/images/joseph-ianni.png" style="left:-15px;top:-8px;" width="50" height="50" alt="" src="/images/joseph-ianni.png">
                Presented by Joseph Live in 4d 3h
            </div>
          </div>

          <div class="card-footer pl-10 pr-10">
            <button type="button" class="w-100 btn btn-sm mb-3 btn-primary " >
              Register now
            </button>
            <hr class='m-0'>
            <div class=' my-2'>
              <i class="far fa-calendar-alt"></i> Apr 02 2021  &nbsp; |  &nbsp;
              <i class="far fa-file-alt	" ></i> 3 hr
            </div>
          </div>

        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>

<section class='debutify-section pt-0'>
  <div class='container'>
    <h1 class='text-center mb-2'>On-Demand Webinars</h1>
    <p class='text-center lead mb-5'>Play instantly -- Completely free</p>
    <div class='row text-center'>
      <div class="col-md-12 mb-5">
        <form method="POST" action="">
          {{ csrf_field() }}

          <div class='row'>

            <div class="col-md-5 mb-3 mb-md-0">
              <input type="text" class="form-control " name="search_title" placeholder="Search..." value="">
            </div>
            <div class="col mb-3 mb-md-0">

              <select class="form-control " name="search_by_category" data-size="8" data-live-search="true">
                <option value="">Category</option>
                <option value="blog">blog</option>
                <option value="blog">Make Money Online</option>
              </select>
            </div>
            <div class="col mb-3 mb-md-0">
              <select class="form-control " data-size="8" name="search_by_tag" data-live-search="true">
                <option selected value="">Tag</option>
                <option selected value="sample">sample</option>
              </select>
            </div>
          </div>

          <input type="submit" name="" id="" hidden>
        </form>
      </div>
      @foreach ([0,1,2,3,4,5] as $item)
      <div class="col-lg-4 col-md-6 mb-5">
        <div class="card h-100 shadow">
          <div class="card-body">
            <a class='text-black' href="#">
              <img alt="landing_blog.png" class="w-100 mb-3 rounded w-100 lazyload" data-src="/images/landing/landing_blog.png" >
              <h5 class='font-weight-bold blog-title' style="">Webinar Title Goes Here</h5>
            </a>

            <div class='d-flex align-items-center mb-3' style="font-size: 13px;">
              <img class='lazyload mr-2' data-src="/images/landing/cta-check.svg" alt="" width="20" height="20">
              Sed egestasnte et vulputat
            </div>
            <div class='d-flex align-items-center mb-3' style="font-size: 13px;">
              <img class='lazyload mr-2' data-src="/images/landing/cta-check.svg" alt="" width="20" height="20">
              Morbi interdum mollis ela
            </div>
            <div class='d-flex align-items-center mb-3' style="font-size: 13px;">
              <img class='lazyload mr-2' data-src="/images/landing/cta-check.svg" alt="" width="20" height="20">
              Phasellus lacinia magna
            </div>
            <div class="badge-pill font-weight-light position-relative text-left pl-5" style="font-size: 12px;">
              <img class="position-absolute" data-src="/images/joseph-ianni.png" style="left:-15px;top:-8px;" width="50" height="50" alt="" src="/images/joseph-ianni.png">
                Presented by Joseph Live in 4d 3h
            </div>
          </div>

          <div class="card-footer pl-10 pr-10">
            <button type="button" class="w-100 btn btn-sm  mb-3 btn-primary " >
              Register now
            </button>
          </div>

        </div>
      </div>
      @endforeach
    </div>
    <div class="text-center">
      <button type="button" class="btn btn-sm text-primary btn-light">View More</button>
    </div>

  </div>
</section>

<x-landing.dash/>
<section class='debutify-section' style="">
  <div class='container'>
    <h1 class='text-center mb-2'>We're looking for new webinar guests!</h1>
    <p class='text-center lead'>Apply to collaborate with us today.</p>
    <div class='text-center'>
      <button type="button" class='download-cta debutify-hover btn btn-lg btn-sm-block mr-3 mb-3 btn-primary'>
         Apply now <span class="fas fa-arrow-right" aria-hidden="true"></span>
      </button>
    </div>

  </div>
</section>

@endsection

@section('styles')
<style>
  @media only screen and (max-width:768px){
    .row.row_banner {flex-direction: column-reverse;}
    .cont_banner {margin-top: 40px;}
  }
</style>
@endsection
