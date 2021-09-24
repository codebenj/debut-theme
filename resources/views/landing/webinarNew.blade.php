@extends('layouts.landing', ['page' => 'webinarNew'])

@section('title','Webinar | Debutify')
@section('description','Join Ricky Hayes’ free dropshipping training course and explore all secrets of building a successful shopify store. Limited free seats available. Enroll now!')

@section('styles')
<style>

@media (max-width: 767px) {

    .row_Header .col:last-child {
        margin-top: 2rem;
        text-align: center;
    }
    .image__start-selling-today {
        margin-bottom: 4rem;
    }

    .section__start-selling-today {
        text-align: center;
    }

    .btn-outline-success__webinar {
        margin-top: 2rem;
    }

}
@media (max-width: 575px) {
    .dots {
        position: absolute;
        bottom: -1rem !important;
        right: 0rem !important;
    }
    .section {
        padding: 2rem 0rem !important;
    }
    .btn_viewMore {
        width: 100%;
    }
}
.webinarSpacer {
    border-bottom: 2px dashed #d1d1d1;
}

.card_upcomingLive {
    padding: 1rem;
    border: solid #ededed 1px;
    background-color: #ffffff;
    height: 100%;
    display: flex;
    justify-content: space-between;;
}
.mediaImage_upcomingLive {
    width: 40px;
    height: 40px;
    border-radius: 50px;
}

.media-body{
    font-size: small;
    font-weight: 500;
}
.media-body p {
    margin: 0px;
}
.card_body_upcomingLive {
    padding-top: 1.5rem;
    padding-left: 0rem;
    padding-right: 0rem;
    padding-bottom: 0rem;
}
.RegisterNowBtn {
    width: 100%;
    font-weight: normal;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1.1rem;

}
.row_upcomingLive .col{
    margin-bottom: 1.5rem;
}
. {
    margin-top: 1rem;
    margin-bottom:0.5rem;
    border-bottom: 2px solid #d1d1d1;
}
.row_upcomingLive-Date {
    text-align: center;
    font-size: small;
}
.row_upcomingLive-Date div:last-child {
    border-left: 2px solid #d1d1d1 ;
}
.text-highlight-underline::before{
    content: '';
    position: absolute;
    border: solid 15px #42ffbb;
    width: 255px;
    border-color: #42ffbb transparent transparent transparent;
    border-radius: 50%;
    z-index: -1;
    top: 145px;
}

.header_description svg {
position:absolute;
bottom: 0px;
}
.header_description p {
    padding:0px;
    margin: 0px;
    display: inline;
}

.header_description div {
    width: 90%;
    word-break: break-word;
}
.webinarlading_search {
    background-color: #f7f4ff;
}
.icons_Ondemand_Webinar {
    position: relative;
    color: #07C88B;
    background-color:#A2F9CF;
    margin-right: 10px;
    font-size: 20px;
    border-radius: 50%;
    top:2px;
}
.media-onDemand {
    display: flex;
    align-items: flex-start;
    align-items: baseline;
    font-size: small;
}
.media {
    display: flex;
    align-items: center;
}
.btn_viewMore {
    color:#5600E3;
    background-color: #f0f0f0;
    padding: 0.375rem 0.75rem;
}
.section__start-selling-today {
    color: #260759;
    background-color: #FAF8FF;
}
.section__start-selling-today svg {
    position: absolute;;
    bottom: 0px;
}
.button__start-selling-today a {
    width: 100%;
    padding-top: 1rem;
    padding-bottom: 1rem;
    font-weight: 500;
}

.btn-outline-success__webinar {
    color: #260759;
    border: #2DFFB3 solid 3px;
}
.webinar__banner-image  img{
    border-radius: 50%;
    width: 105px;
    border:#F7F4FF solid 5px;
    margin-bottom: 1rem;
}
.webinar__banner-image p {

}
.webinar__banner-body {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    border-top-left-radius: inherit;
    border-top-right-radius: inherit;
    color: #ffffff;
    padding-bottom: 0px;
}
.webinar__banner-bg {
    position: absolute;
    top: 0;
}
.webinar__thumbnail-video-play {
    background: white;
    color: #000000;
    display: inline-block;
    border-radius: 2rem;
    padding: 0.7rem 2rem;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    white-space: nowrap;
}
.webinar__play-icon {
    font-size: 2rem;
    color: #5600E3;
    margin-left: 1rem;
}
.webinar__upcoming-thumbnail-play {
    background: white;
    height: 2.5rem;
    width: 2.5rem;
    color: #5600E3;
    display: inline-block;
    border-radius: 50%;
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    white-space: nowrap;
    padding-left: 4px;
    padding-bottom: 1px;
    box-shadow: 0px 0px 0px 8px rgb(255, 255, 255,0.3);
}
.viewmore_hidden {
    display: none;
}
.section {
    padding: 5rem 0rem;
}
.no-wrap {
    white-space: nowrap;
}
.dots {
    position: absolute;
    bottom: -2.4rem;
    right: -1.5rem;
    z-index: -1;
}
.icon__search_con {
    position: absolute;
    top: 23px;
    left: 25px;
    opacity: 0.4;
}
.icon__search_con i {
    font-size: 1.7rem;
}
.search {
    padding-left: 4rem;
}

</style>
@endsection

@section('content')
<script src="https://event.webinarjam.com/register/n67znt5/embed-button"></script>
<div class="webinar">
    <!-- Header -->
    <section class="section">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 d-flex justify-content-center row_Header">
                <div class="col order-md-2 round">
                    <div class='position-relative'>
                        <div class="card" style="box-shadow: 0px 5px 5px 0px rgba(0, 0, 0, 0.238)" >
                            <div class="card-body position-relative webinar__banner-body" style="background-image: url('{{ asset('images/debutify-webinarbanner.png')}}');">
                                {{-- <img src="{{ URL::to('/') }}/images/debutify-webinarbanner.png" class='card-img-top' alt=""> --}}
                                <div class=text-center>
                                <div class='d-flex d-flex justify-content-center mb-2'>
                                    <div class='d-flex d-flex justify-content-start'>
                                    <img src="{{ URL::to('/') }}/images/debutify-logo-icon.png"  width="30px" height="30px" class='mr-1'>
                                    <h6 class='text-light'>Debutify</h6>
                                    </div>
                                </div>
                                <h4 class='mb-3 text-light'>WEBINAR TOPIC</h4>
                                <div class="row webinar__banner-image">
                                    <div class="col-6">
                                    <img src="{{ URL::to('/') }}/images/conorcurlewis.webp" alt="">
                                    <p>Connor Curlewis</p>
                                    </div>
                                    <div class="col-6">
                                    <img src="{{ URL::to('/') }}/images/joseph.webp" alt="">
                                    <p>Joseph Ianni</p>
                                    </div>
                                </div>
                                </div>
                                <div class='webinar__thumbnail-video-play d-flex align-items-center'> <b>Play now</b> <i class="fa fa-play-circle webinar__play-icon" aria-hidden="true"></i> </div>
                            </div>
                            <div class="card-footer text-center p-3" style="border-radius: inherit;">
                                <p><b>Webinar name</b></p>
                            </div>
                        </div>
                    </div>
                    <div class='dots'> <img src="{{ URL::to('/') }}/images/Group_720.png" width="100%"> </div>
                    </div>
                    <div class="col order-md-1 header_description d-flex align-items-center justify-content-center">
                        <div>
                            <div class='position-relative w-100'>
                            <h1 class="text-center-sm">
                                Make <span class='debutify-underline-lg no-wrap' >The Most</span>
                            </h1>
                        </div>
                        <h1 class="text-center-sm">  Out Of Debutify </h1>
                        <p>Learn how to use all Debutify's features to maximize your leads, conversions, and grow your business.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-landing.dash/>
    {{-- upcoming live --}}
    <section class='section pb-0'>
        <div class="container">
            <div class='text-center header'>
                <h2 class='mb-5'>Upcoming Live Webinars</h2>
            </div>
            <div>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4 row_upcomingLive">
                    @if($upcomings)
                        @foreach ($upcomings as $upcoming)
                            <?php
                                $releaseDate_time = new DateTime($upcoming->release_date);
                                $dateToday = new DateTime(date('M d Y'));
                                $releaseDate = date_format($releaseDate_time,'M d Y');
                                $liveIn = date_diff($releaseDate_time, $dateToday);
                            ?>
                            <div class="col">
                                <div class="card rounded card_upcomingLive border border-light shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $upcoming->image }}" class="card-img-top rounded mb-4" alt="..."/>
                                        <div class="webinar__upcoming-thumbnail-play d-flex justify-content-center align-items-center">
                                            <i class="fa fa-play" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <p class='text-center'><b>{{ $upcoming->title }}</b></p>
                                    <div class="media mb-4 d-flex align-items-center">
                                        <img src="{{ $upcoming->admin_user->profile_image }}" class='img-fluid mediaImage_upcomingLive mr-3' alt="...">
                                        <div class="media-body ">
                                            <p class="mt-0">Presented By</p>
                                            <p>{{ $upcoming->admin_user->name }}</p>
                                            <p class="mt-0">Live In {{ $liveIn->format('%a') }} Days</p>
                                        </div>
                                    </div>

                                    <div>
                                        <div>
                                            <a href="" class='btn btn-primary RegisterNowBtn'>Register Now</a>
                                        </div>
                                        <div class="my-3 border-bottom">

                                        </div>
                                        <div class="row row_upcomingLive-Date text-muted">
                                            <div class="col-7 px-1">
                                                <i class="far fa-calendar-alt mr-1"></i> {{ $releaseDate  }}
                                            </div>
                                            <div class="col-5 px-1">
                                                <i class="far fa-file-alt mr-1"></i> {{ $upcoming->duration }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- On-demand webinars --}}
    <section class="section">
        <div class="container">
            <div class="webinar_section_header text-center mb-5">
                <h2>On-Demand Webinars</h2>
                <p class='mb-5'>Play instantly -- Completely free</p>
                <div class="form-group position-relative">
                    <div class='icon__search_con'><i class="fa fa-search " aria-hidden="true"></i></div><input type="text" id="search" name="q" class="search form-control form-control-lg webinarlading_search" placeholder="Search" >
                </div>
            </div>
            <div class='webinar_section_body' id='OndemandWebinars'>
                <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4 row_upcomingLive mb-4" id='webinar__viewmore'>

                @if($webinars)
                    @foreach ($webinars as $webinar)
                    <div class="col">
                    <div class="card rounded card_upcomingLive">
                        <div class="position-relative">
                        <img src="{{ $webinar->image }}" class="card-img-top rounded mb-4" alt="..."/>
                        <div class="webinar__upcoming-thumbnail-play d-flex justify-content-center align-items-center">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </div>
                        </div>


                        {{-- <div class="card-body card_body_upcomingLive"> --}}
                        <p class='text-center'><b>{{ $webinar->title }}</b></p>
                        <div>
                            <div class="media-onDemand">
                            <i class="far fa-check-circle icons_Ondemand_Webinar"></i>
                            <p class="mt-0">seg adistante el vulpotat</p>
                            </div>

                            <div class="media-onDemand">
                            <i class="far fa-check-circle icons_Ondemand_Webinar"></i>
                            <p class="mt-0">seg adistante el vulpotat</p>
                            </div>

                            <div class="media-onDemand">
                            <i class="far fa-check-circle icons_Ondemand_Webinar"></i>
                            <p class="mt-0">seg adistante el vulpotat</p>
                            </div>
                        </div>
                        <div class="media mb-3 d-flex align-items-center">
                            <img src="{{ $webinar->admin_user->profile_image }}" class="mr-3 img-fluid mediaImage_upcomingLive"  alt="...">
                            <div class="media-body">
                            <p class="mt-0">Presented By {{ $webinar->admin_user->name }}</p>
                            </div>
                        </div>
                        <div>
                            <a href="" class='btn btn-primary RegisterNowBtn'>Register Now</a>
                        </div>
                        {{-- </div> --}}
                    </div>
                    </div>
                    @endforeach
                    <div class='viewmore_hidden'>
                    {{ $webinars->links() }}
                    </div>
                @endif
                </div>
            </div>
            <div class="text-center">
                @if ($webinars->links())
                    <button class="btn btn_viewMore">View more</button>
                @endif
            </div>
        </div>
    </section>

    <x-landing.dash/>

    {{-- New webinar guest --}}
    <section class="section">
        <div class="container text-center">
            <div>
                <h2>We're looking for new webinar guest!</h2>
                <p>Apply to collaborate with us today.</p>
                <a href="#" class='btn btn-primary  btn-md font-weight-normal mt-4'>Apply now <i class="fa fa-arrow-right arrow-icons__webinar" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  $(document).ready(function() {

    src = "{{ route('landing.webinar_search') }}";
    $("#search").autocomplete({
        source: function(request, response) {

            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    query : request.term
                },
                success: function(result) {
                  if(result.status == 'success') {
                    var html = result.html;
                    $('#OndemandWebinars').html(html);
                  }
                  if(!$(result.html).find('.pagination').html()) {
                    $('.btn_viewMore').css('display','none')
                  }
                  else {
                    $('.btn_viewMore').css('display','inline')
                  }
                }
            });
        },
        minLength: 0,
    });
  });

  $(function() {
  $(".btn_viewMore").click(function() {
    var $ul = $("ul.pagination li").last();
    var $posts = $("#webinar__viewmore");
    var find = ($ul.find("a[aria-label='Next »']").attr("href"));
    if($ul.last().attr('aria-disabled')) {
      console.log('End of view more');
    }
    else {
      if(find){
        $.get($ul.find("a[aria-label='Next »']").attr("href"), function(response) {
           $posts.append(
               $(response).find("#webinar__viewmore").html()
           );
            var hideViewMore = $(response).find('ul.pagination li').last();
            if(hideViewMore.last().attr('aria-disabled')) {
              $('.btn_viewMore').css('display','none')
            }
      });
      }
      else {
        console.log('End of view more');
        $('.btn_viewMore').css('display','none')
      }
    }
  });
});
  </script>
@endsection
