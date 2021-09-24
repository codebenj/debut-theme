@extends('layouts.landing')

@section('title','About Debutify Team | Free Shopify Template')
@section('description','Know about the team behind Debutify’s best and high converting free Shopify theme. Build your ecommerce store in minutes. Download free today!')

@section('styles')

<style>
    #memberModal {
      .close-modal {
          z-index: 10;
      }

    @media only screen and (max-width: 656px) {
        .team-img {
            height: 180px;
            width: 180px;
        }
    }

    @media only screen and (min-width: 1200px) {
        .team-img {
            height: 200px;
            width: 200px;
            }
        }
    }
    .team-img {
        object-fit: cover;
        border-radius: 50%;
        height: 200px;
        width: 200px;
    }

    @media only screen and (min-width: 1200px) {
        .team-img {
            height: 250px;
            width: 250px;
        }
    }
</style>
@endsection

@section('content')

<x-landing.jumbotron title="Meet The Team" description="Meet the folks behind your favorite Shopify theme "/>
<section class='debutify-section py-0'>
  <div class="responsive-container-24by11">
    <img class='w-100' src="/images/landing/about-banner.png?v={{config('image_version.version')}}" alt="about banner">
  </div>
</section>

<section class='debutify-section'>
    <div class='container text-center'>
        <h1 class='mb-5'>The Core Values We Uphold</h1>
        <x-landing.values/>
    </div>
</section>

<div class='debutify-section'>
    <div class='container'>
        <ul class="nav nav-pills nav-justified" role="tablist">
            @foreach ($teams as $index => $item)
            <li class="nav-item m-2 debutify-tab">
                <a class="nav-link debutify-tab-link {{$index==0?'active':''}}" data-team-id="{{$item['id']}}" data-toggle="pill" href="#role-{{$index}}">
                    <img class='lazyload' data-src="{{$item['icon_path']}}" alt="{{$item['name']}}" height="40">
                    <p class='lead'>	{{$item['name']}}</p>
                </a>
            </li>
            @endforeach
        </ul>
        <div class='row text-center mt-5'>
            {{--  Data Template --}}
            @foreach ($team_members as $key => $item)
            <div class="debutify-team debutify-team-{{$item['team_id']}} col-xs-12 col-sm-6 col-md-4 col-lg-3 mb-5 d-block" style="{{$key>9 ?'display:none':''}}">
                <div  data-name="{{$item['name']}}" data-position="{{$item['position']}}"  data-image="{{$item['image_url'] ?? $item['default_image']}}"   data-fav_qoute="{{$item['quote_body']}}" data-qoute_by="{{$item['quote_by']}}">
                    <div >
                        <img class='mb-3 team-img rounded-circle lazyload'  data-src="{{$item['image_url'] ?? $item['default_image']}}" alt="{{$item['name']}}">
                    </div>
                    <h4>{{$item['name']}}</h4>
                    <p class='lead'>{{$item['position']}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<section class='debutify-section'>
    <div class='container text-center'>
        <h1 >Want to join the Debutify team?</h1>
        <p class='lead'>We are always hiring new talent! See our job openings. <br class='d-none d-lg-block'>
            Click the button to find out more.
        </p>
        <a href="/career" role='button' class='btn btn-lg btn-primary debutify-hover'>Join Debutify Today</a>
    </div>
</section>

<div class="modal fade" id="memberModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <button data-dismiss="modal" class="close-modal">
                    <i class='fas fa-times'></i>
                </button>

                <div class='row align-items-center mt-2'>
                    <div class='col-md-4 col-xs-12 col-sm-4 text-center text-md-left'>
                        <img id='member-image' class='mb-4 team-img rounded-circle'  src="" alt="">
                    </div>
                    <div class='col-md-8 col-xs-12 col-sm-8 text-center text-md-left'>
                        <h4> <span id='member-name'></span></h4>
                        <p id='member-position' class='mb-4 '></p>

                        <blockquote >
                            <p id='member-fav_qoute'></p>
                            <footer id='member-qoute_by' class="blockquote-footer"></footer>
                        </blockquote>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function() {
        $(document).on("click",".showMember",function() {
            $('#member-name').text($(this).data("name"));
            $('#member-image').attr('src', $(this).data("image"));
            $('#member-position').text($(this).data("position"));
            $('#member-fav_qoute').text($(this).data("fav_qoute") || `Favorite Qoute: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do. `);
            $('#member-qoute_by').text($(this).data("qoute_by") || `qouted by`);
            $('#memberModal').modal('show');
        });

        $(".debutify-tab-link").click(function() {
            $(".debutify-team").removeClass("d-block");
            $(".debutify-team").addClass("d-none");
            $(".debutify-team-" + $(this).data("team-id")).addClass("d-block");
            $(".debutify-team" + $(this).data("team-id")).removeClass("d-none");

            if ($(this).data("team-id") == 0) {
                $(".debutify-team").removeClass("d-none");
                $(".debutify-team").addClass("d-block");
            }
        });
    });
</script>
@endsection
