@extends('layouts.landing')

@section('title', "Debutify Login")
@section('description',"")
@section('content')

<div class='container-fluid'>
    <div class='row vh-100 align-items-center justify-items-center'>
        <div class='col-lg-4  h-100 d-flex align-items-center justify-content-center'>
            <div >
                <a href="/">
                    <img class='lazyload'data-src="/images/landing/debutify-logo-dark.svg" width="275" height="60"  alt="Debutify Logo" />
                </a>
                <h1 class='display-4 mt-5 font-weight-light'>Log in</h1>
                <p class='lead  text-mid-light'>Continue to your store</p>

                @if (session()->has('error'))
                <div class="text-danger">
                    <strong>Oops! An error has occured:</strong> {{ session('error') }}
                </div>
                @endif

                @if($redirect_access)
                <div class='small'>
                    <i class='fas fa-info-circle'></i> Your session has expired. Please login again.
                </div>
                @endif

                <form action="{{ route('authenticate') }}">
                    {{ csrf_field() }}


                    <div class='form-group my-5'>
                        <label for='shop'>Store address</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <label class='input-group-text' for='shop'>
                                    <img class="lazyloaded d-inline-block" src="/images/landing/icons/icon-home.svg" alt="icon Home"/>
                                </label>
                            </div>
                            <input required autofocus pattern="[^.\s]+\.myshopify\.com" type="text" class='form-control border-left-0 pl-2' name="shop" id="shop" placeholder="myshop.myshopify.com">
                        </div>
                    </div>
                    <button type="submit" class='btn btn-primary px-5 btn-sm-block'>Login</button>
                </form>

                <p class='mt-3 lead'>New to Debutify? <a class='text-primary' href="/" >Start for free</a> </p>
            </div>
        </div>
        <div class='col-lg-8 bg-light  h-100 d-lg-flex d-none align-items-center justify-content-center'>

            <img  class='lazyload img-fluid' data-src="/images/landing/login-main.png"  alt="main">

            <div class='position-absolute w-100 py-3' style="bottom: 0px;">
                <div class='text-center text-mid-light small'>
                    <a class='text-mid-light' href="https://help.debutify.com/en/" target="_blank"> Help center</a>
                    <span class='mx-2'>|</span>
                    <a class='text-mid-light' href="/contact">Support</a>
                    {{-- <span class='mx-2'>|</span>
                    <a class='text-mid-light' href="#">Status</a> --}}
                    <span class='mx-2'>|</span>
                    <a class='text-mid-light' href="https://feedback.debutify.com/" target="_blank">Roadmap</a>
                    <span class='mx-2'>|</span>
                    <a class='text-mid-light' href="/privacy-policy">Privacy Policy</a>
                    <span class='mx-2'>|</span>
                    <a class='text-mid-light' href="/terms">Terms of Use</a>
                    {{-- <span class='mx-2'>|</span>
                    <a class='text-mid-light' href="/terms-of-service">Terms of service </a> --}}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    document.addEventListener("DOMContentLoaded", function(){
        var shopDomain = localStorage.getItem("shopDomain");
        if(shopDomain){
            $("#shop").val(shopDomain);
        }


    });

</script>

@endsection
