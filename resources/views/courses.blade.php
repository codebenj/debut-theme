@extends('layouts.debutify')
@section('title','training courses')
@section('view-courses','view-courses')

@section('styles')
<style>

</style>
@endsection

@section('content')
    @include("components.skeleton")
    <div id="dashboard" style="display:none;">

      @foreach($courses as $key => $course)
      <div class="Polaris-Card">
        <div class="Polaris-MediaCard">
          <div class="Polaris-MediaCard__MediaContainer">
            <div class="Polaris-VideoThumbnail__Thumbnail" style="background-image: url(&quot;{{ $course->image }}&quot;);">
              <a href="/app/courses/{{ $course->id }}" class="Polaris-VideoThumbnail__PlayButton" aria-label="Play video of length 1 minute and 20 seconds">
                <img class="Polaris-VideoThumbnail__PlayIcon" src="data:image/svg+xml;base64,PHN2ZyB2aWV3Qm94PSIwIDAgMzggMzgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0xOSAxQzkuMDYgMSAxIDkuMDU3IDEgMTljMCA5Ljk0IDguMDU3IDE4IDE4IDE4IDkuOTQgMCAxOC04LjA1NyAxOC0xOCAwLTkuOTQtOC4wNTctMTgtMTgtMTh6IiBmaWxsPSIjZmZmIi8+PHBhdGggZD0iTTE5IDFDOS4wNiAxIDEgOS4wNTcgMSAxOWMwIDkuOTQgOC4wNTcgMTggMTggMTggOS45NCAwIDE4LTguMDU3IDE4LTE4IDAtOS45NC04LjA1Ny0xOC0xOC0xOHoiIGZpbGw9Im5vbmUiIHN0cm9rZT0iI2I1YjViNSIvPjxwYXRoIGQ9Ik0xNSAxMS43MjNjMC0uNjA1LjctLjk0MiAxLjE3My0uNTY0bDEwLjkzIDcuMjE1YS43Mi43MiAwIDAxMCAxLjEyOGwtMTAuOTMgNy4yMTZBLjcyMy43MjMgMCAwMTE1IDI2LjE1M3YtMTQuNDN6IiBmaWxsLW9wYWNpdHk9Ii41NTciLz48L3N2Zz4K" alt="">
              </a>
              <!-- <p class="Polaris-VideoThumbnail__Timestamp">1:20</p> -->
            </div>
          </div>
          <div class="Polaris-MediaCard__InfoContainer d-flex align-items-center">
            <div class="Polaris-Card__Section">
              <div class="Polaris-Stack Polaris-Stack--vertical Polaris-Stack--spacingTight">
                <div class="Polaris-Stack__Item">
                  <div class="Polaris-MediaCard__Heading">
                    <h2 class="Polaris-Heading">{{ $course->title }}</h2>
                  </div>
                </div>
                <div class="Polaris-Stack__Item">
                  <p>{{ $course->description }}</p>
                </div>
                <div class="Polaris-Stack__Item">
                  <div class="Polaris-MediaCard__ActionContainer">
                    <div class="Polaris-ButtonGroup">
                      <div class="Polaris-ButtonGroup__Item">
                        <div class="Polaris-MediaCard__PrimaryAction">
                          <a href="/app/courses/{{ $course->id }}" class="Polaris-Button">
                            <span class="Polaris-Button__Content">
                              <span class="Polaris-Button__Text">Watch course</span>
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach

    </div>
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
      // ESDK page and bar title
      {{--
      ShopifyTitleBar.set({
          title: 'Courses',
      });
      --}}
  </script>
@endsection
