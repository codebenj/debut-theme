@extends('layouts.landing')
@section('title','FAQs | Debutify Shopify Theme')
@section('description','Go through our FAQ section in case you have any query about Debutify’s free shopify theme. Get in touch through our contact form if you have more questions.')

@section('content')

<x-landing.jumbotron title='Frequently Asked Questions' description='We know you have some questions in mind, so we’ve tried to list the most important ones!'/>

<section class='debutify-section'>
    <div class='container'>
        <x-landing.faq/>
    </div>
</section>

<section class='debutify-section'>
    <div class='container text-center'>
        <h1 class='display-4'>
            Couldn't Find What You're Looking For?
        </h1>
        <p class='lead'>Ask our support team to help you out!</p>

        <a role='button' href='/contact'  type="button" class='btn btn-lg btn-primary debutify-hover'>
            Contact Us
        </a>
    </div>
</section>

@endsection
