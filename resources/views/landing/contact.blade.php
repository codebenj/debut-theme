@extends('layouts.landing')
@section('title',"Contact Debutify | World's Best Free Shopify Theme")
@section('description','Feel free to get in touch in case of any query about Debutify’s free shopify theme. Fill our online contact form and we will get back to you ASAP')

@section('content')


<section class='debutify-section'>
    <div class='container'>
        <div class='text-center'>
            <h1 class='display-3'>
                <span class='debutify-underline-lg'>Contact Us</span>
            </h1>
            <p class='my-5'>Need help from our support, or have a business inquiry? Send us a message below. <br class='d-none d-lg-block'> Get in touch with our team, we're here to help.</p>
        </div>
        <div class='card shadow p-lg-3'>
            <div class='card-body'>
                @if(session('success'))
                    <div class="alert alert-success text-center" role="alert">
                        <strong>Thank you for contacting us!</strong> We will answer under 48h.
                    </div>
                @endif

                <form action="/contacted" method="post" accept-charset="utf-8" id="contact_form">
                    @csrf
                    <div class="form-group">
                        <input type="Name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}"  placeholder="Your Name *" required autofocus>
                        @if($errors->has('name'))
                            <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" placeholder="Your Email Address *" required>
                        @if($errors->has('email'))
                            <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone"  placeholder="Your Phone Number " required>
                        @if($errors->has('phone'))
                            <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" name="help" required>
                            <option value="">What do you need help with?</option>
                            <option value="1">Debutify Theme Manager</option>
                            <option value="2">Debutify Theme</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="selectpicker form-control"  name="hear" required>
                            <option value="">How did you hear about us?</option>
                            <option value="1">Google Search</option>
                            <option value="2">Word of Mouth</option>
                            <option value="3">Social Media Profiles</option>
                            <option value="4">Email</option>
                            <option value="5">Others</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" rows='3' required name="message" placeholder="Message">{{ old('message') }}</textarea>
                        @if($errors->has('message'))
                            <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                        @endif
                    </div>

                    <small class='recaptcha-privacy-terms'>
                        This site is protected by reCAPTCHA and the Google
                        <a href="https://policies.google.com/privacy">Privacy Policy</a> and
                        <a href="https://policies.google.com/terms">Terms of Service</a> apply.
                    </small>

                    <input id="btnSubmit" type="submit" style="display: none;">
                    <button  class="btn btn-sm-block btn-primary my-3 px-4 g-recaptcha debutify-hover"  data-sitekey="{{ config('services.recaptcha.site_key') }}"  data-callback='onSubmit'
                    >Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>


<section class='debutify-section'>
    <div class='container'>
        <div class='text-center'>
            <h1>Frequently Asked Questions</h1>
            <p class='mt-4 mb-5'>We know you have some questions in mind, we’ve tried to list the most important ones!</p>
        </div>
        <x-landing.faq/>
    </div>
</section>

@endsection

@section('scripts')

<script>
    function onSubmit(token) {
        document.getElementById('btnSubmit').click();
    }

    document.addEventListener("DOMContentLoaded", function()
    {
        if (debutify_app_tracking && @json(session()->has('success')))
        {
            window.dataLayer.push({'event': 'contact'});
        }
    });
</script>

@endsection
