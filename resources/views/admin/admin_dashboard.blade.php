@extends('layouts.admin')

@section('styles')

<style>


.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
}

.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}

a.card_anchor {
    text-decoration: none;
    color: #fff;
    cursor: pointer;
}

</style>
@endsection

@section('content')
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="row">
        @php
         if(empty($roles)){
          $roles = array('s');
            @endphp
            <div class="col-md-12 col-xl-12">
                 <div class="card bg-c-blue order-card">
                    <div class="card-block text-center">
                        <h6 class="m-b-20">You don't have any permissions.</h6>
                    </div>
                  </div>
             </div>
            @php
        }
        @endphp
    	@if(in_array('users', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <a href="{{ route('users') }}" class="card_anchor">
                <div class="card-block">
                    <h6 class="m-b-20">Users</h6>
                    <h2 class="text-right"><span class="fas fa-users f-left"></span> <span>{{ $user_data['users']}}</span></h2>
                </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('products', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <a href="{{ route('products') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Products</h6>
                        <h2 class="text-right"><span class="fas fa-funnel-dollar f-left"></span><span>{{ $user_data['products']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('courses', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <a href="{{ route('courses') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Courses</h6>
                        <h2 class="text-right"><span class="fas fa-book f-left"></span><span>{{ $user_data['course']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('themes', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <a href="{{ route('themes') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Themes</h6>
                        <h2 class="text-right"><span class="fas fa-palette f-left"></span><span>{{ $user_data['themes']}}</span></h2>
                        {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                    </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('updates', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <a href="{{ route('updates') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Updates</h6>
                        <h2 class="text-right"><span class="fas fa-bell f-left"></span><span>{{ $user_data['updates']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('podcasts', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <a href="{{ route('podcasts') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Podcasts</h6>
                        <h2 class="text-right"><span class="fas fa-podcast f-left"></span><span>{{ $user_data['podcasts']}}</span></h2>
                        {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                    </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('blogs', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <a href="{{ route('blogs') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Blogs</h6>
                        <h2 class="text-right"><span class="fas fa-blog f-left"></span><span>{{ $user_data['blogs']}}</span></h2>
                        {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                    </div>
                </a>
            </div>
        </div>
        @endif


    	@if(in_array('partners', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <a href="{{ route('partners') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Integrations</h6>
                        <h2 class="text-right"><span class="fas fa-handshake f-left"></span><span>{{ $user_data['partners']}}</span></h2>
                        {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                    </div>
                </a>
            </div>
        </div>
        @endif

    	@if(in_array('admin users Management', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <a href="{{ route('admin-user') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Admin Users Managements</h6>
                        <h2 class="text-right"><span class="fas fa-user f-left"></span><span>{{ $user_data['admin_user']}}</span></h2>
                        {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if(in_array('frequently asked questions', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <a href="{{ route('frequently-asked-questions.index') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">FAQ</h6>
                        <h2 class="text-right">
                            <span class="fas fa-question-circle f-left"></span>
                            <span>{{ $user_data['faq']}}</span>
                        </h2>
                    </div>
                </a>
            </div>
        </div>
        @endif


        @if(in_array('youtube videos', $roles))
            <div class="col-md-4 col-xl-3">
                <div class="card bg-c-pink order-card">
                    <a href="{{ route('videos') }}" class="card_anchor">
                        <div class="card-block">
                            <h6 class="m-b-20">Youtube Videos</h6>
                            <h2 class="text-right"><span class="fas fa-play f-left"></span><span>{{ $user_data['youtube_videos']}}</span></h2>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        @if(in_array('extend_trial_show', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <a href="{{ route('extend_trial_show') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Extend Trial</h6>
                        <h2 class="text-right"><span class="fas fa-freebsd f-left"></span><span>{{ $user_data['extend_trial']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if(in_array('cms', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <a href="{{ route('show_cms_dashboard') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">CMS</h6>
                        <h2 class="text-right"><span class="fas fa-sitemap f-left"></span><span>{{ $user_data['cms']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if(in_array('addons', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <a href="{{ route('addons.index') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Add-Ons</h6>
                        <h2 class="text-right"><span class="fas fa-plus-square f-left"></span><span>{{ $user_data['addons']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if(in_array('team_members', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-pink order-card">
                <a href="{{ route('team-members.index') }}" class="card_anchor">
                    <div class="card-block">
                        <h6 class="m-b-20">Meet The Team</h6>
                        <h2 class="text-right"><span class="fas fa-users f-left"></span><span>{{ $user_data['team_members']}}</span></h2>
                    </div>
                </a>
            </div>
        </div>
        @endif

        @if(in_array('webinar', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-blue order-card">
                <a href="{{ Route('admin.webinars.index') }}" class="card_anchor">
                <div class="card-block">
                    <h6 class="m-b-20">Webinar</h6>
                    <h2 class="text-right"><span class="fas fa-tv f-left"></span> <span>{{ $user_data['webinar']}}</span></h2>
                </div>
                </a>
            </div>
        </div>
        @endif

        @if(in_array('addons_reports', $roles))
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-yellow order-card">
                <a href="{{ route('addons_report') }}" class="card_anchor">
                <div class="card-block">
                    <h6 class="m-b-20">Add-Ons Report</h6>
                    <h2 class="text-right"><span class="fas fa-th f-left"></span> <span>{{ $user_data['addons_reports']}}</span></h2>
                </div>
                </a>
            </div>
        </div>
        @endif

	</div>
</div>
@endsection

@section('scripts')

<script>
  $(document).ready(function() {

    src = "{{ route('users_search') }}";
    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    query : request.term
                },
                success: function(result) {
                  if(result.status == 'success'){
                    var html = result.html;
                    $('.all-users').html(html);
                  }
                }
            });
        },
        minLength: 0,
    });
  });

  function changefreeaddons(){
    var form = document.getElementById('free_Addons_form');
    form.submit();
  }
  function addfreetrial(){
    var form = document.getElementById('free_trialdays_form');
    form.submit();
  }
</script>
@endsection
