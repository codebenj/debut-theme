<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <link rel="canonical" href="https://debutify.com/admin/dashboard">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="theme-color" content="#5600e3">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="author" content="Debutify">
  @if(config('env-variables.BLOCK_CRAWLER'))<meta name="robots" content="noindex">@endif

  <!-- Fav icon ================================================== -->
  <link sizes="192x192" rel="shortcut icon" href="/images/debutify-favicon.png" type="image/png">

  <title>Debutify Admin</title>

  <!-- App style -->
  <link rel="stylesheet" href="{{ asset('css/app.css?v='.config('env-variables.ASSET_VERSION')) }}">
  <!-- Plugin style -->
  <link href="{{ asset('css/tagsinput.css?v='.config('env-variables.ASSET_VERSION')) }}" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.css">

  <!-- Styles -->
  <link href="{{ asset('css/tokenize2.min.css?v='.config('env-variables.ASSET_VERSION')) }}" rel="stylesheet">
  <link href="{{ asset('css/tagsinput.css?v='.config('env-variables.ASSET_VERSION')) }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css?v='.config('env-variables.ASSET_VERSION')) }}">  <style type="text/css">
    .swal2-container.fade.in {
      opacity: 1;
    }

    .notification {
  color: #000000;
  text-decoration: none;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}

.notification .badge {
  position: absolute;
  border-radius: 50%;
}

.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
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
  @yield('styles')
  @yield('titleee')
</head>
<body>

  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">

      <div class="container-fluid">
        @php
            if(empty($roles)){
              $roles = array();
            }
        @endphp
        <a class="navbar-brand" href="{{ route('dashboard') }}">
          <img class="logo default-logo" src="/images/landing/debutify-logo-dark.svg" width="200" alt="Debutify" itemprop="logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin_login_form') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            </li>
            @endif
            @else

            @php
            $roles = json_decode(Auth::user()->user_role,true);
            if(empty($roles)){
              $roles = array();
            }
            @endphp
            @if( (in_array('users', $roles)) ||  (in_array('products', $roles)) ||  (in_array('courses', $roles)) ||  (in_array('themes', $roles)) ||  (in_array('updates', $roles)) ||  (in_array('partners', $roles)) || (in_array('frequently asked questions', $roles))  )

            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="far fa-bookmark"></i> </i></i> {{ __('Debutify Theme') }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    @if (in_array('users', $roles))
                          <a class="nav-link" href="{{ route('users') }}"><span class="fas fa-users"></span> Users  </a>
                    @endif

                    @if (in_array('products', $roles))
                        <a class="nav-link" href="{{ route('products') }}"><span class="fas fa-funnel-dollar"></span> Products</a>
                    @endif
                    @if (in_array('courses', $roles))
                         <a class="nav-link" href="{{ route('courses') }}"><span class="fas fa-book"></span> Courses</a>
                    @endif
                    @if (in_array('themes', $roles))
                         <a class="nav-link" href="{{ route('themes') }}"><span class="fas fa-book"></span> Themes</a>
                    @endif
                    @if (in_array('updates', $roles))
                        <a class="nav-link" href="{{ route('updates') }}"><span class="fas fa-bell"></span> Updates</a>
                    @endif
                    @if (in_array('partners', $roles))
                         <a class="nav-link" href="{{ route('partners') }}"><span class="fas fa-handshake"></span> Integrations</a>
                    @endif

                    @if (in_array('frequently asked questions', $roles))
                        <a class="nav-link" href="{{ route('frequently-asked-questions.index') }}"><span class="fas fa-question-circle"></span> FAQ</a>
                     @endif


                </div>
            </li>
            @endif


           @if(in_array('extend_trial_show', $roles))
           <li class="nav-item dropdown">
                <a id="navbarDropdown1" class="nav-link dropdown-toggle notification" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{-- <i class="fas fa-wrench"></i> {{ __('Extend trial request') }} <span class="caret"></span> --}}
                     {{-- <i class="fas fa-coin"></i><span>Extend trial request</span> --}}
                   <i class="fab fa-freebsd"></i> {{ __('Extend trial') }} <span class="caret"></span>

                  <span class="badge badge-success">{{ $posts= App\UserExtendTrialRequest::where('extend_trial_status','pending')->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
                        @if (in_array('extend_trial_show', $roles))
                            <a class="dropdown-item" href="{{ route('extend_trial_show') }}">
                              <i class="fas fa-external-link-square-alt"></i>  {{ __('Extend Trial Feature') }}
                            </a>
                            <a class="dropdown-item notification" href="{{ route('extend_feature_request') }}">
                                 <i class="fas fa-external-link-alt"></i> {{ __('Extend Trial Request') }}
                                  <span class="badge badge-success">{{ $posts= App\UserExtendTrialRequest::where('extend_trial_status','pending')->count() }}</span>
                            </a>
                        @endif
                </div>
            </li>
            @endif

            @if (in_array('cms', $roles))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('show_cms_dashboard') }}"><i class="fa fa-sitemap" aria-hidden="true"></i> CMS</a>
            </li>
           @endif

           @if( (in_array('blogs', $roles) ) ||  (in_array('podcasts', $roles)) ||  (in_array('youtube vidoes', $roles)) || (in_array('addons_reports', $roles)) )

            <li class="nav-item dropdown">
                <a id="navbarDropdown2" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fas fa-wrench"></i> {{ __('Resources') }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">
                    @if (in_array('blogs', $roles))
                        <a class="dropdown-item" href="{{ route('blogs') }}">
                            <i class="fas fa-blog"></i> {{ __('Blogs') }}
                        </a>
                    @endif
                    @if (in_array('podcasts', $roles))
                        <a class="dropdown-item" href="{{ route('podcasts') }}">
                            <i class="fas fa-podcast"></i> {{ __('Podcasts') }}
                        </a>
                    @endif
                    @if (in_array('youtube videos', $roles))
                        <a class="dropdown-item" href="{{ route('videos') }}">
                            <i class="fab fa-youtube"></i> {{ __('Videos') }}
                        </a>
                    @endif
                    @if (in_array('webinar', $roles))
                    <a class="dropdown-item" href="{{ route('admin.webinars.index') }}">
                      <i class="fas fa-tv"></i> {{ __('Webinar') }}
                    </a>
                    @endif
                    @if (in_array('addons_reports', $roles))
                    <a class="dropdown-item" href="{{ route('addons_report') }}">
                      <i class="fas fa-th"></i> {{ __('Add-Ons Report') }}
                    </a>
                    @endif
                </div>
            </li>
            @endif


           <li class="nav-item dropdown">
            <a id="navbarDropdown3" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <span class="fas fa-user"></span> {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown3">
                @if (in_array('admin users Management', $roles))
                <a class="dropdown-item" href="{{ route('admin-user') }}">
                <i class="fas fa-users"></i> {{ __('Admin Users Management') }}
                </a>
                @endif

              <a class="dropdown-item" href="{{ route('admin_logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
             <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('admin_logout') }}" method="GET" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<main class="py-4">
  <div class="container-fluid">
    @yield('content')
  </div>
</main>
</div>

<!-- App js -->
<script src="{{ asset('js/app.js?v='.config('env-variables.ASSET_VERSION')) }}"></script>

<script type="text/javascript" src="{{ asset('js/tagsinput.min.js?v='.config('env-variables.ASSET_VERSION')) }}"></script>
<!-- jQuery ajax/UI-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ckeditor/adapters/jquery.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/5.0.7/sweetalert2.min.js"></script>
<script type="text/javascript" src="{{ asset('js/pekeUpload.min.js?v='.config('env-variables.ASSET_VERSION')) }}"></script>
<script type="text/javascript" src="{{ asset('js/tokenize2.min.js?v='.config('env-variables.ASSET_VERSION')) }}"></script>

<script>
  function setAutoPublishDateVisibility(isActive, resetValue) {
    if (resetValue) {
      $("#auto_publish_at").val("");
      $("#auto_publish_time").val("");
    }

    if (isActive == 1) {
      $("#auto_publish_at_container").hide();
    } else {
      $("#auto_publish_at_container").show();
    }
  }
</script>

@yield('scripts')
</body>
</html>
