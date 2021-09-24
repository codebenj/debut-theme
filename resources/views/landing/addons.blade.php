@extends('layouts.landing')

@section('title','Debutify Shopify Add-Ons')
@section('description','Debutify lets you choose among 28 premium Add-Ons for your free Shopify theme. Quick and easy setup. Add them to your store now')
@section('content')

<section class='debutify-section'>
  <div class='container'>
    <div class='row'>
      <div class='col-lg-6'>
        <h1 class='display-3 text-lg-left text-center'>
          Conversion <br class='d-none d-lg-block'> <span class='debutify-underline-md'>Boosters</span>
        </h1>
        <h4 class='my-4 text-reset'>Debutify’s Growing Arsenal Of Sales Boosting <span class='text-nowrap'>  Add-Ons</span></h4>
        <p class='lead'>A collection of {{$nbAddons}}  (and counting) battle-tested “boosters” that can significantly increase your conversion rates and set your sales dashboard on fire.</p>
      </div>
      <div class='col-lg-6 order-first order-lg-last'>
        <div class="responsive-container-4by3">
            <img class='img-fluid' src="/images/landing/above-the-fold-addon.png?v={{config('image_version.version')}}" alt="above the fold addon">
        </div>
      </div>
    </div>
  </div>

  <div class='text-center p-3'>

    <x-landing.download-btn class='btn btn-primary debutify-hover  btn-lg rounded' cta="X"  label='Get The Full Arsenal When You Try <br/> Debutify—Free For 14 Days '/>

    <p class='my-3 text-mid-light'>
      {{$nbShops_range['week']}} ecommerce owners signed in the last week alone! <br class='d-none d-lg-block'>
      No credit card required. No coding needed. 1-click installation.
    </p>

    <img class='lazyload' data-src="/images/landing/norton.png" alt="">
  </div>
</section>

<section class='debutify-section'>
  <div class='container'>
    <div class='text-center'>
      <p class='lead'>
        Why pay for different and expensive third-party Add-Ons <br class='d-none d-lg-block'> if you can have them…
      </p>

      <h1 class='display-4 my-4'>
        All In One Place
      </h1>

      <p class='lead'>
        No more integration issues and “dirty” coding problems that <br class='d-none d-lg-block'> only slow down your store. Scroll down to see the full lineup.
      </p>
      <div class='text-center responsive-container-4by3'>
        <img class='lazyload img-fluid' data-src="/images/landing/addons-all-in-one.png?v={{config('image_version.version')}}" alt="addon all in one">
      </div>
    </div>
  </div>
</section>




<section class='debutify-section'>
  <div class='container'>
    <div class='text-center'>
      <h2 class='font-weight-lighter'>Introducing</h2>
      <h1 class='display-4'>
        The Smart Way To Scale
      </h1>

      <p class='lead'>
        Cutting-edge persuasive technology, seamless design, and  <br class='d-none d-md-block'>
        amazing support... Combined with our in-the-trenches   <br class='d-none d-md-block'>
        8-figure ecommerce results…
      </p>

      <p class='lead mb-4'>
        It’s our secret sauce that can give you the best possible   <br class='d-none d-md-block'>
        chance of success.</p>
        <div class="responsive-container-20by10">
          <img class='lazyload d-block m-auto img-fluid' style="width: 700px;right:0;" data-src="/images/landing/addons-smart-way-infinite-animat.svg?v={{config('image_version.version')}}" alt="Addon Pyramid">
        </div>
        <br>


        <x-landing.download-btn class='btn btn-primary debutify-hover btn-lg rounded' cta="X"  label='Get Smart. Convert More. Download Now!'/>

        <p class='my-4 lead'>
          <b>{{$nbShops_range['week']}} </b> ecommerce owners signed in the last week alone! <br class='d-none d-md-block'>
          No credit card required. No coding needed. <br class='d-none d-md-block'>
          1-click installation.
        </p>

        <img class='lazyload mt-4' data-src="/images/landing/norton.png" alt="">

      </div>
    </div>
  </div>

  <div class='debutify-section'>
    <div class='container'>
      <div class='text-center'>
          <h2 class="mb-0"><span class='debutify-underline-sm'>Save</span> More Than</h2>
            <h1 class='display-4 mb-0'>$3,000.00 Per Year</h1>
            <h2 class="mb-0">In App Subscription Fees</h2>
        <p class='my-5 lead'>
          {{$nbAddons}} fully-optimized apps for maximum speed and conversion… <br class='d-none d-md-block'>
          in one complete package… absolutely free when you try <br class='d-none d-md-block'>
          Debutify today.
        </p>

        <x-landing.addons id='1'/>
      </div>
    </div>
  </div>
</section>


<section class='debutify-section'>
  <div class='container'>
    <div class='text-center'>
      <h1 class='display-4'>Tested And Proven Effective By Our <br class='d-none d-lg-block'> Resident 8-Figure Brand Owner</h1>
      <p class='lead my-4'>
        You’re not getting apps created on a whim by people who <br class='d-none d-lg-block'>
        know nothing about growing ecom brands. Every Conversion <br class='d-none d-lg-block'>
        Booster is used and vetted by ecommerce experts with more <br class='d-none d-lg-block'>
        than 8-figures in results.
      </p>
    </div>


    <div class='bg-light mt-5 rounded overflow-hidden'>
      <div class='row no-gutters'>
        <div class='col-md-7 d-flex align-items-center'>
          <div class='py-4 px-5 text-lg-left text-center'>
            <h3 class='font-weight-lighter'>
              <i> “Debutify isn't just a theme... it's like an intricate timepiece made by master craftsmen giving your business unrivaled performance, elegant design, and cutting-edge conversion technology.”</i>
            </h3>
            <p class='lead mt-5'>
              <b>Ricky Hayes</b> <br>
              8-Figure Business Owner & Mentor
            </p>
          </div>
        </div>
        <div class='col-md-5 order-first order-lg-last'>
          <div class="responsive-container-1by1">
            <img class='w-100 img-fluid lazyload' data-src="/images/landing/addons-ricky-hayes.png?v={{config('image_version.version')}}" alt="rick hayes">
          </div>
        </div>
      </div>
    </div>

    <div class='bg-light mt-5 rounded overflow-hidden'>
      <div class='row no-gutters'>
        <div class='col-md-5'>
          <div class="responsive-container-1by1">
            <img class='w-100 img-fluid lazyload' data-src="/images/landing/addons-kamil-satar.png?v={{config('image_version.version')}}" alt="kamil satar">
          </div>
        </div>

        <div class='col-md-7 d-flex align-items-center'>
          <div class='p-5 text-lg-left text-center'>
            <h3 class='font-weight-lighter'>
              <i> “The conversion rates are amazing, the Add-Ons are amazing... it’s changed my life and my store”</i>
            </h3>
            <p class='lead mt-4'>
              <b>Kamil Sattar</b> <br>
              The Ecom King, Youngest Forbes Business Council Member
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<section class="debutify-section">
  <div class='container text-center'>
    <x-landing.addons id='2'/>
  </div>
</section>

@endsection
@section('styles')
  <style>
  .debutify-addons  .shadow, .single-content img {
    box-shadow: unset !important;
    border: unset;
    padding: 0 !important;
}
</style>
@endsection
