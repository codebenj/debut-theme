@extends('layouts.landing')
@section('title','thank you for downloading Debutify Theme Manager!')
@section('description','Haven\'t downloaded Debutify Awesome Free Shopify theme yet? Click the button below to download it now!')

@section('content')


<section class='debutify-section'>
    <div class='container'>

        <h1 class="display-4 text-center mb-5">Thanks For Choosing <span class="debutify-underline-sm">Debutify!</span></h1>

        <h1 class="mb-4 text-center">Here’s how to complete your installation:</h1>

        <div class='row justify-content-center'>
            <div class='col-md-9'>

                        <div class='rounded overflow-hidden bg-primary'>
                            <x-landing.wistia-video-player type='inline' embedId="6n9yzl26r8"/>
                        </div>

                        <p class="text-center my-5">
                            Press "Install unlisted app", and cue your favorite <br class='d-none d-lg-block'> feel-good tunes while Debutify installs.
                        </p>

                        <div class='card bg-primary mb-5'>
                            <div class='card-body text-center text-md-left'>
                                <img class="img-fluid lazyload mb-3" data-src="images/landing/debutify-logo-white2.png" alt="">

                                <div class="row align-items-center text-white">
                                    <div class="col-md-9">
                                        <p class="mt-4 ">
                                            <strong>Debutify will never read your customer or product information.</strong> It is entirely confidential to you. For more info on which permissions Debutify uses, read this <a href="/privacy-policy" class="text-white"><u>help article</u></a>.
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-center order-first order-md-last">
                                        <img class="img-fluid lazyload" width="85" data-src="images/landing/icon-privacy.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='row justify-content-center'>
                            <div class='col-lg-9'>

                                <h1 class="mb-4 text-center">Installation Cancelled?</h1>

                                        <p class='lead text-center'>Enter your Shopify URL and complete the installation:</p>
                                        <form id="formShop2" class="form-horizontal" method="POST" action="{{ route('authenticate') }}">
                                            {{ csrf_field() }}

                                            <div class="form-group">
                                                <input class="form-control" required type="text" name="shop" id="shop" placeholder="storename.myshopify.com" onkeyup="this.value = this.value.toLowerCase();">
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Finish Installation
                                            </button>
                                        </form>

                                        <div class='row mt-5 mb-4 no-gutters' >
                                            <div class='col-4'>
                                                <div class='w-100 debutify-badge1' data-rw-badge1="22396" data-aos="zoom-in" data-aos-delay="1000"></div>
                                            </div>
                                            <div class='col-4'>
                                                <div class='w-100 debutify-badge1' data-rw-badge1="22415" data-aos="zoom-in" data-aos-delay="1200"></div>
                                            </div>
                                            <div class='col-4'>
                                                <div class='w-100 debutify-badge1' data-rw-badge1="22416" data-aos="zoom-in" data-aos-delay="1400"></div>
                                            </div>
                                        </div>

                                    </form>
                                  </div>
                              </div>
                            </div>
                          </div>

                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<script>
    window.addEventListener('DOMContentLoaded', function() {

        var shopDomain = localStorage.getItem("shopDomain");
        if(shopDomain){
            $("#shop").val(shopDomain);
        }

        @if (config('app.env') == 'production' || config('app.env') == 'staging')
        //initiate download tracking
        if(sessionStorage.getItem("initiateDownload")){} else{
            window.dataLayer.push({'event': 'initiate_download'});
            sessionStorage.setItem('initiateDownload','yes');
        };
        @endif


        $("#formShop2").one('submit', function(e) {
            e.preventDefault();

            @if (config('app.env') == 'production' || config('app.env') == 'staging')
                //webpushr custom attribute complete_registration
                webpushr('attributes',{"Complete Registration" : "True"});
                //complete registration tracking
                window.dataLayer.push({'event': 'complete_registration'});
                @endif
            $(this).submit();
        });
        
       
    });
</script>
@endsection
