@extends('layouts.debutify')
@section('title', $course->title)
@section('breadcrumbs_title','Courses')
@section('breadcrumbs_link','courses')

@section('view-course','view-course')

@section('styles')
<style>
.img-course{
  /* object-fit: cover;
  height: 200px!important; */
}
video{
  max-width: 100%;
  width:100%;
}
.toggleModule{
  /* cursor: pointer; */
}
span.lesson-count {
  float: right;
}
</style>
@endsection


<?php
$shop_plan = $alladdons_plan;
if($all_addons == 1 || $master_shop) {
  if($master_shop && !$is_paused) {
      $shop_plan = $guru;
      $alladdons_plan = $guru;
  }
}
?>
@unless(in_array(lcfirst($shop_plan), $course->sub_plans))
  @unless( $shop_plan == 'Master' )
      @section('bannerTitle','available only on the '. $course->plans .' plan')
      @section('bannerLink','upgrade to the '. $course->plans .' plan')
  @endunless
@endunless

@section('content')
  @include("components.skeleton")

  <div id="dashboard" style="display:none;">
    <p class="mb layout-item">{{ $course->description }}</p>

    {{--
    @if($course->image != null || $course->image != '')
    <div class="Polaris-Card">
      <div class="Polaris-CalloutCard__Container">
        <div class="Polaris-Card__Section">
          <div class="Polaris-CalloutCard">
            <div class="Polaris-CalloutCard__Content">
              <img src="{{ $course->image }}" class="img-fluid rounded img-course" height="200" width="100%" alt="{{ $course->title }}">
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
    --}}

    <!-- Modules -->
    @foreach($course->modules as $module)
    <div class="Polaris-Card">

      <div class="Polaris-Card__Section toggleModule">
        <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
          <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
            <h2 class="Polaris-Heading">
              {{ $module->title }}
              <span class="Polaris-Badge Polaris-Badge--statusSuccess Polaris-Badge--sizeSmall lesson-count">
              {{ count($module->steps) }}
              @if(count($module->steps) > 1)
              lessons
              @else
              lesson
              @endif
              </span>
            </h2>
            <p>{{ $module->description }}</p>
          </div>
        </div>
      </div>

      <!-- Lessons -->
      @if(count($module->steps) > 0)
      <div class="Polaris-ResourceList__ResourceListWrapper stepContainer" style="">
        <ul class="Polaris-ResourceList" aria-live="polite">
          @foreach($module->steps as $key => $step)
          <li class="Polaris-ResourceList__ItemWrapper module">
            <div class="Polaris-ResourceItem Polaris-ResourceItem--persistActions open-modal"
            @if(in_array(lcfirst($shop_plan), $course->sub_plans))
            onclick="return openLessonModal('lessonsModal{{ $key }}{{ $step->module_id }}');"
            @endif
            >
              <a class="Polaris-ResourceItem__Link" aria-describedby="" aria-label="View details for" tabindex="0" data-polaris-unstyled="true"></a>
              <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" id="">
                <div class="Polaris-ResourceItem__Owned">
                  <div class="Polaris-ResourceItem__Media">
                    @if(in_array(lcfirst($shop_plan), $course->sub_plans))
                    <span aria-label="" role="img" class="custom-avatar Polaris-Avatar Polaris-Avatar--styleSix Polaris-Avatar--sizeMedium Polaris-Avatar--hasImage">
                      <img src="/svg/illustration-13.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    </span>
                    @else
                    <span aria-label="" role="img" class="Polaris-Avatar Polaris-Avatar--styleSix Polaris-Avatar--sizeMedium Polaris-Avatar--hasImage">
                      <img src="/svg/lock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    </span>
                    @endif
                  </div>
                </div>
                <div class="Polaris-ResourceItem__Content">
                  <h3>
                    <span class="Polaris-Heading">{{ $step->title }}</span>
                  </h3>
                  <div>{{ $step->description }}</div>
                </div>
              </div>
            </div>
          </li>
          @endforeach
        </ul>
      </div>
      @endif
    </div><!-- card -->
    @endforeach

    @if(in_array(lcfirst($shop_plan), $course->sub_plans))
    @foreach($course->modules as $module)
      <!-- lesson Modal -->
      @if(count($module->steps) > 0)
      @foreach($module->steps as $key => $step)
      <div id="lessonsModal{{ $key }}{{ $step->module_id }}" class="modal fade-scale lessons-modal" style="display:none;">
        <div>
          <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
              <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">

                <div class="Polaris-Modal-Header">
                  <div id="modal-header11" class="Polaris-Modal-Header__Title">
                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall module-title">{{ $step->title }}</h2>
                  </div>
                  <button type="button" class="Polaris-Modal-CloseButton close-modal">
                    <span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored">
                      <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                        <path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                      </svg>
                    </span>
                  </button>
                </div>

                <div class="Polaris-Modal__BodyWrapper">
                  <div class="Polaris-Modal__Body Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true" polaris="[object Object]">
                    <section class="Polaris-Modal-Section">
                      <div class="Polaris-TextContainer">

                        @if($step->description != '')
                        <p>{{ $step->description }}</p>
                        @endif

                        @if($step->video1 != '' && $step->video1 != null)
                        <p>
                          <video controls class="rounded course-video" controlsList="nodownload" disablepictureinpicture>
                            <source src="{{ $step->video1 }}" type="video/mp4">
                          </video>
                        </p>
                        @endif
                        @if($step->video2 != '' && $step->video2 != null)
                        <p>
                          <strong>Attachment: </strong>
                          <a href="{{ $step->video2  }}" download>
                            {{ $step->video2 }}
                          </a>
                        </p>
                        @endif
                      </div>
                    </section>
                  </div>
                </div>

                <div class="Polaris-Modal-Footer">
                  <div class="Polaris-Modal-Footer__FooterContent">
                    <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                      <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                        @unless ($loop->first)
                        <button type="button" class="Polaris-Button Polaris-Button--plain close-modal" onclick="return openLessonModal('lessonsModal{{ $key-1 }}{{ $step->module_id }}');">
                          <span class="Polaris-Button__Content">
                            <span class="Polaris-Button__Text">Previous lesson</span>
                          </span>
                        </button>
                        @endunless
                      </div>
                      <div class="Polaris-Stack__Item">
                        <div class="Polaris-ButtonGroup">
                          <div class="Polaris-ButtonGroup__Item">
                            <button type="button" class="Polaris-Button close-modal">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Cancel</span>
                              </span>
                            </button>
                          </div>
                          @unless ($loop->last)
                          <div class="Polaris-ButtonGroup__Item">
                            <button type="button" class="Polaris-Button Polaris-Button--primary close-modal" onclick="return openLessonModal('lessonsModal{{ $key+1 }}{{ $step->module_id }}');">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Next lesson</span>
                              </span>
                            </button>
                          </div>
                          @endunless
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="Polaris-Backdrop"></div>
      </div>
      @endforeach
      @endif
    @endforeach
    @endif
  </div>
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
      {{--
      var breadcrumb = Button.create(ShopifyApp, { label: "@yield('breadcrumbs_title')" });
      breadcrumb.subscribe(Button.Action.CLICK, () => {
        ShopifyApp.dispatch(Redirect.toApp({ path: "{{config('env-variables.APP_PATH')}}@yield('breadcrumbs_link')" }));
      });
      ShopifyTitleBar.set({
          title: '{{ $course->title }}',
          breadcrumbs: breadcrumb
      });
      --}}
      // open download theme modal
      function openLessonModal(moduleModal){
        // show modal
        var modal = $("#"+moduleModal);
        openModal(modal);

        // play video
        modal.find(".course-video").trigger("play");
      }

      // $(document).ready(function(){
      //   $(".toggleModule").on("click",function(){
      //     var $this = $(this);
      //     var module = $this.next(".stepContainer");
      //     if( module.is(":visible") ){
      //       $(".stepContainer").hide();
      //     } else{
      //       $(".stepContainer").hide();
      //       module.show();
      //     }
      //   })
      // });
  </script>
@endsection
