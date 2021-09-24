<nav class="Polaris-Navigation">
  <div class="Polaris-Navigation__PrimaryNavigation Polaris-Scrollable Polaris-Scrollable--vertical" data-polaris-scrollable="true">

    <div class="nav-plan Polaris-Card__Section--subdued">
      <button style="display:none;" type="button" class="Polaris-Button Polaris-Button--sizeLarge Polaris-Button--fullWidth btn-close-nav" tabindex="0" data-polaris-unstyled="true">
        <span class="Polaris-Button__Content">
          <span class="Polaris-Icon">
            <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path d="M11.414 10l6.293-6.293a.999.999 0 1 0-1.414-1.414L10 8.586 3.707 2.293a.999.999 0 1 0-1.414 1.414L8.586 10l-6.293 6.293a.999.999 0 1 0 1.414 1.414L10 11.414l6.293 6.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path></svg>
          </span>
          Close menu
        </span>
      </button>

      <div class="Polaris-Stack align-items-center">
        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
            <span class="Polaris-TextStyle--variationSubdued">Plan</span>
            @if($trial_days && !$master_shop && !$is_beta_user)
              <span class="Polaris-Badge Polaris-Badge--statusSuccess Polaris-Badge--sizeSmall">Trial</span>
              <h2 class="Polaris-Heading">{{$trial_plan}}</h2>
              @elseif(isset($is_beta_user) && $is_beta_user == 1)
              <span class="Polaris-Badge Polaris-Badge--statusSuccess beta_user_badge" style="margin-top: 0.5em;">
                  BETA
                </span>
                <h2 class="Polaris-Heading">BETA</h2>
              @elseif(isset($is_paused) && $is_paused == 1)
              <span class="Polaris-Badge Polaris-Badge--incomplete Polaris-Badge--sizeSmall">Paused</span>
              <h2 class="Polaris-Heading">{{$paused_plan_name}}</h2>
            @else
              @if ($all_addons == 1 || $master_shop)
                @if ($master_shop)
                  <h2 class="Polaris-Heading">Master</h2>
                @else
                  <h2 class="Polaris-Heading">{{$alladdons_plan}}</h2>
                @endif
              @else
              <h2 class="Polaris-Heading">Free</h2>
              @endif
            @endif
        </div>
        <div class="Polaris-Stack__Item" style="text-align:right;margin-left:0;">
          <a class="Polaris-Button Polaris-Button--primary" tabindex="0" href="{{config('env-variables.APP_PATH')}}plans" data-polaris-unstyled="true">
            <span class="Polaris-Button__Content">
              @if( ($alladdons_plan == $guru) && !$trial_days && !$is_paused)
              <span class="Polaris-Button__Text">My subscription</span>
              @else
              <span class="Polaris-Button__Text">Upgrade</span>
              @endif
            </span>
          </a>
        </div>
      </div>
    </div>

    <ul class="Polaris-Navigation__Section Polaris-Navigation__Section--withSeparator">
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item home-link" tabindex="0" href="{{config('env-variables.APP_PATH')}}" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M7 13h6v6H7z"></path><path d="M19.664 8.252l-9-8a1 1 0 0 0-1.328 0L8 1.44V1a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v5.773L.336 8.252a1.001 1.001 0 0 0 1.328 1.496L2 9.449V19a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9.449l.336.299a.997.997 0 0 0 1.411-.083 1.001 1.001 0 0 0-.083-1.413zM16 18h-2v-5a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v5H4V7.671l6-5.333 6 5.333V18zm-8 0v-4h4v4H8zM4 2h2v1.218L4 4.996V2z" fill-rule="evenodd"></path></svg>
              </span>
            </div>
            @php
              $prior_beta_theme = 0;
              foreach($store_themes as $theme)
              {
                if($theme->version == '2.0.2')
                {
                  $prior_beta_theme = 1;
                }
              }

              if( ($trial_days && !$master_shop && !$is_beta_user) || ($alladdons_plan == $freemium || $alladdons_plan == "") && !$is_paused ){
                    if($prior_beta_theme != 0){
                      $count = 5;
                    }
                    else
                    {
                      $count = 4;
                    }
              }
              else
              {
                if($prior_beta_theme != 0)
                {
                    $count = 4;
                }
                else
                {
                  $count = 3;
                }
              }
            @endphp
            <span class="Polaris-Navigation__Text">
              Dashboard
              @if( isset($steps_completed) && ($steps_completed < $count) )
              <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                <span class="Polaris-VisuallyHidden">Success</span>
                {{ $steps_completed ?? 0 }}/{{$count}}
              </span>
              @endif
            </span>
          </a>
        </div>
      </li>

      
      @php
      $showAddons = false;
      foreach($store_themes as $theme)
      {
        if($theme->version == '2.0.2')
        {
          $showAddons = true;
        }
      }
      @endphp

      @if($showAddons)

      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}add_ons" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path d="M1 1h7v7H1V1zm0 11h7v7H1v-7zm11 0h7v7h-7v-7z" fill="currentColor"></path><path d="M8 11H1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1zm-1 7H2v-5h5v5zM8 0H1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zM7 7H2V2h5v5zm12 4h-7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1v-7a1 1 0 0 0-1-1zm-1 7h-5v-5h5v5zM12 6h2v2a1 1 0 1 0 2 0V6h2a1 1 0 1 0 0-2h-2V2a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Add-Ons

              <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                <span class="active-addon">{{$active_add_ons}}</span>/<span class="max-addon">{{$addons_count}}</span>
              </span>

            </span>
          </a>
        </div>
      </li>
      @endif
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}themes" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M11 1l8 8v8c0 1.104-0.896 2-2 2s-2-0.896-2-2v-6c0 1.104-0.896 2-2 2s-2-0.896-2-2v-10z"></path><path d="M17.979 17c0 0.551-0.448 1-1 1s-1-0.449-1-1v-6c0-0.552-0.447-1-1-1s-1 0.448-1 1c0 0.551-0.448 1-1 1s-1-0.449-1-1v-7.586l6 6v7.586zM8.394 14.929c-1.243 0-2.413 0.484-3.293 1.364l-1.414 1.414c-0.208 0.209-0.505 0.317-0.788 0.29-0.298-0.024-0.561-0.175-0.74-0.424-0.274-0.38-0.191-0.976 0.189-1.356l1.339-1.339c0.941-0.941 1.384-2.188 1.35-3.424l3.483 3.483c-0.042 0-0.083-0.008-0.126-0.008v0zM11.487 15.078l-6.585-6.586 5.077-5.078v7.586c0 1.525 1.148 2.774 2.624 2.962l-1.116 1.116zM19.686 8.293l-8-8c-0.191-0.191-0.447-0.283-0.707-0.283v-0.010c-0.014 0-0.027 0.007-0.041 0.008-0.105 0.004-0.208 0.023-0.31 0.060-0.009 0.004-0.019 0.003-0.028 0.007-0.002 0.001-0.003 0.001-0.004 0.001-0.112 0.047-0.208 0.117-0.294 0.196-0.009 0.009-0.021 0.012-0.030 0.021l-8 8c-0.391 0.391-0.391 1.023 0 1.414 1.035 1.036 1.035 2.722 0 3.757l-1.339 1.339c-1.071 1.072-1.243 2.765-0.398 3.939 0.52 0.722 1.323 1.177 2.202 1.248 0.081 0.007 0.162 0.010 0.243 0.010 0.793 0 1.555-0.313 2.12-0.879l1.414-1.414c1.004-1.005 2.755-1.004 3.758 0 0.187 0.188 0.441 0.293 0.707 0.293s0.52-0.105 0.707-0.293l2.293-2.293v1.586c0 1.654 1.346 3 3 3s3-1.346 3-3v-8c0-0.265-0.105-0.52-0.293-0.707v0z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Theme Library
            @if($new_update_theme == 0)
              <span class="Polaris-Badge Polaris-Badge--statusSuccess Polaris-Badge--sizeSmall">New</span>
            @endif

            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}winning-products" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M19 10c0 4.971-4.029 9-9 9s-9-4.029-9-9c0-4.971 4.029-9 9-9s9 4.029 9 9z"></path><path d="M10 0c-5.514 0-10 4.486-10 10s4.486 10 10 10c5.514 0 10-4.486 10-10s-4.486-10-10-10zM10 18c-4.411 0-8-3.589-8-8s3.589-8 8-8c4.411 0 8 3.589 8 8s-3.589 8-8 8zM9.977 6.999c0.026 0.001 0.649 0.040 1.316 0.708 0.391 0.39 1.024 0.39 1.414 0 0.391-0.391 0.391-1.024 0-1.415-0.603-0.603-1.214-0.921-1.707-1.092v-0.201c0-0.552-0.447-1-1-1-0.552 0-1 0.448-1 1v0.185c-1.161 0.414-2 1.514-2 2.815 0 2.281 1.727 2.713 2.758 2.971 1.115 0.279 1.242 0.384 1.242 1.029 0 0.552-0.448 1-0.976 1.001-0.026-0.001-0.65-0.040-1.317-0.708-0.39-0.39-1.023-0.39-1.414 0-0.39 0.391-0.39 1.024 0 1.415 0.604 0.603 1.215 0.921 1.707 1.092v0.2c0 0.553 0.448 1 1 1 0.553 0 1-0.447 1-1v-0.184c1.162-0.414 2-1.514 2-2.816 0-2.28-1.726-2.712-2.757-2.97-1.115-0.279-1.243-0.384-1.243-1.030 0-0.551 0.449-1 0.977-1z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Product Research
            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item top-link-courses" tabindex="0" href="{{config('env-variables.APP_PATH')}}courses" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M10 19a2 2 0 0 1 2-2h7V1h-7a2 2 0 0 0-2 2 2 2 0 0 0-2-2H1v16h7a2 2 0 0 1 2 2z"></path><path d="M19 0h-7c-.768 0-1.469.29-2 .766A2.987 2.987 0 0 0 8 0H1a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h7a1 1 0 0 1 1 1 1 1 0 1 0 2 0 1 1 0 0 1 1-1h7a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm-1 16h-6c-.352 0-.687.067-1 .179V3a1 1 0 0 1 1-1h6v14zM8 16H2V2h6a1 1 0 0 1 1 1v13.179A2.959 2.959 0 0 0 8 16zM6 4H5a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2zm0 4H5a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2zm8-2h1a1 1 0 1 0 0-2h-1a1 1 0 1 0 0 2zm0 4h1a1 1 0 1 0 0-2h-1a1 1 0 1 0 0 2zm-8 2H5a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Training Courses
            </span>
          </a>
        </div>

        <!-- secondary menu starts -->
        <div class="Polaris-Navigation__SecondaryNavigation Polaris-Navigation__SecondaryNavigation-courses" style="display: none;">
          <div id="PolarisSecondaryNavigation" aria-hidden="false" class="Polaris-Collapsible Polaris-Collapsible--open Polaris-Collapsible--fullyOpen" style="max-height: none;">
            <div>
              <ul class="Polaris-Navigation__List">

                @foreach($courses as $key => $course)
                <li class="Polaris-Navigation__ListItem">
                  <div class="Polaris-Navigation__ItemWrapper">
                    <a data-polaris-unstyled="true" class="Polaris-Navigation__Item course-link-{{ $course->id }}" tabindex="0" aria-disabled="false" href="{{config('env-variables.APP_PATH')}}courses/{{ $course->id }}">
                      <span class="Polaris-Navigation__Text">{{ $course->title }}</span>
                    </a>
                  </div>

                  {{--
                  <!-- Third menu starts -->
                  <div class="Polaris-Navigation__SecondaryNavigation">
                    <div id="PolarisSecondaryNavigation" aria-hidden="false" class="Polaris-Collapsible Polaris-Collapsible--open Polaris-Collapsible--fullyOpen" style="max-height: none;">
                      <div>
                        <ul class="Polaris-Navigation__List">
                          <li class="Polaris-Navigation__ListItem">
                            <div class="Polaris-Navigation__ItemWrapper">
                              <a data-polaris-unstyled="true" class="Polaris-Navigation__Item Polaris-Navigation__Item--selected Polaris-Navigation--subNavigationActive" tabindex="0" aria-disabled="false" href="/admin/products">
                                <span class="Polaris-Navigation__Text">All products</span>
                              </a>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <!-- Third menu ends -->
                  --}}

                </li>
                @endforeach

              </ul>
            </div>
          </div>
        </div>
        <!-- secondary menu ends -->

      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}mentoring" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M7 5h6v10H7z"></path><path d="M19 18a1 1 0 0 1 0 2H1a1 1 0 0 1 0-2h18zm0-18a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1h5V5a1 1 0 0 1 1-1h5V1a1 1 0 0 1 1-1h6zm-5 14h4V2h-4v12zm-6 0h4V6H8v8zm-6 0h4v-4H2v4z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">Mentoring</span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}integrations" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M9 5c0 2.209-1.791 4-4 4s-4-1.791-4-4c0-2.209 1.791-4 4-4s4 1.791 4 4z"></path><path d="M17 4c-1.126 0-2.098 0.631-2.611 1.551l-4.408-0.734c-0.099-2.671-2.287-4.817-4.981-4.817-2.757 0-5 2.243-5 5s2.243 5 5 5c0.384 0 0.754-0.053 1.113-0.135l1.382 3.041c-0.904 0.734-1.495 1.841-1.495 3.094 0 2.206 1.794 4 4 4s4-1.794 4-4c0-0.918-0.323-1.753-0.844-2.429l2.906-3.736c0.297 0.099 0.608 0.165 0.938 0.165 1.654 0 3-1.346 3-3s-1.346-3-3-3zM2 5c0-1.654 1.346-3 3-3s3 1.346 3 3c0 1.654-1.346 3-3 3s-3-1.346-3-3zM7.931 9.031c0.772-0.563 1.374-1.336 1.724-2.241l4.398 0.733c0.070 0.396 0.216 0.764 0.426 1.090l-2.892 3.718c-0.488-0.211-1.023-0.331-1.587-0.331-0.236 0-0.464 0.030-0.688 0.070l-1.381-3.039zM10 18c-1.103 0-2-0.897-2-2s0.897-2 2-2c1.103 0 2 0.897 2 2s-0.897 2-2 2zM17 8c-0.552 0-1-0.448-1-1s0.448-1 1-1c0.552 0 1 0.448 1 1s-0.448 1-1 1z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Integrations
            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}plans" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M4 7l-3 3 9 9 3-3z"></path><path d="M19 0h-9c-.265 0-.52.106-.707.293l-9 9a.999.999 0 0 0 0 1.414l9 9a.997.997 0 0 0 1.414 0l9-9A.997.997 0 0 0 20 10V1a1 1 0 0 0-1-1zm-9 17.586L2.414 10 4 8.414 11.586 16 10 17.586zm8-8l-5 5L5.414 7l5-5H18v7.586zM15 6a1 1 0 1 0 0-2 1 1 0 0 0 0 2"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              <span>Plans</span>
            </span>
          </a>
        </div>
      </li>
      @php


      @endphp
    @if( ($trial_days && !$master_shop && !$is_beta_user) || ($alladdons_plan == $freemium || $alladdons_plan == ""))
      @if(!$is_paused)
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{ route('extended_trial')}}" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M7.74 17.66A2.2 2.2 0 0 0 6.18 17H5.2A2.2 2.2 0 0 1 3 14.8v-1a2.2 2.2 0 0 0-.64-1.55l-.7-.7a2.2 2.2 0 0 1 0-3.12l.7-.7c.4-.41.64-.97.64-1.55v-1C3 3.98 3.98 3 5.2 3h1a2.2 2.2 0 0 0 1.55-.64l.7-.7a2.2 2.2 0 0 1 3.12 0l.7.7c.41.4.97.64 1.55.64h1c1.21 0 2.2.99 2.2 2.2v1c0 .58.23 1.14.64 1.55l.7.7a2.2 2.2 0 0 1 0 3.12l-.7.7a2.2 2.2 0 0 0-.64 1.56v.99a2.2 2.2 0 0 1-2.2 2.2h-1a2.2 2.2 0 0 0-1.55.64l-.7.7a2.2 2.2 0 0 1-3.12 0l-.7-.7z"></path><path d="M19.06 7.73l-.7-.7a1.22 1.22 0 0 1-.35-.85V5.2A3.2 3.2 0 0 0 14.8 2h-1a1.2 1.2 0 0 1-.85-.35l-.7-.7a3.2 3.2 0 0 0-4.53 0l-.7.7a1.2 1.2 0 0 1-.85.35H5.2A3.2 3.2 0 0 0 2 5.19v1c0 .3-.13.62-.35.84l-.7.7a3.2 3.2 0 0 0 0 4.53l.7.7c.22.23.35.54.35.85v1a3.2 3.2 0 0 0 3.2 3.2h1c.31 0 .62.12.84.35l.7.7A3.2 3.2 0 0 0 10 20a3.2 3.2 0 0 0 2.26-.94l.7-.7c.23-.23.53-.35.85-.35h1a3.2 3.2 0 0 0 3.2-3.2v-1c0-.31.13-.62.35-.85l.7-.7a3.2 3.2 0 0 0 0-4.53M12.3 6.3l-6 6a1 1 0 1 0 1.4 1.4l6-6a1 1 0 1 0-1.4-1.4M7.5 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m5.16-.14l-.7.7A3.18 3.18 0 0 0 16 13.8v1c0 .66-.54 1.2-1.2 1.2h-1a3.18 3.18 0 0 0-2.26.94l-.7.7a1.2 1.2 0 0 1-1.7 0l-.7-.7A3.18 3.18 0 0 0 6.18 16H5.2A1.2 1.2 0 0 1 4 14.8v-1c0-.85-.33-1.66-.94-2.26l-.7-.7a1.2 1.2 0 0 1 0-1.7l.7-.7c.6-.6.94-1.41.94-2.27V5.2C4 4.54 4.54 4 5.2 4h1c.85 0 1.65-.33 2.26-.94l.7-.7a1.2 1.2 0 0 1 1.7 0l.7.7a3.18 3.18 0 0 0 2.26.94h1c.66 0 1.2.54 1.2 1.2v1c0 .85.33 1.65.93 2.26l.7.7a1.2 1.2 0 0 1 0 1.7"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              <span>Get extended trial
                <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                    {{ $trial_extend_step_progress }}
                </span>
              </span>
            </span>
          </a>
        </div>
      </li>
      @endif

    @endif

    <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
            <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}billing" data-polaris-unstyled="true">
                <div class="Polaris-Navigation__Icon">
          <span class="Polaris-Icon">
           <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M10 13a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm7-3c0-.53-.064-1.044-.176-1.54L19 7.23l-2.047-3.464-2.106 1.188A6.978 6.978 0 0 0 12 3.292V1H8v2.294a6.99 6.99 0 0 0-2.847 1.662L3.047 3.768 1 7.232 3.176 8.46C3.064 8.955 3 9.47 3 10s.064 1.044.176 1.54L1 12.77l2.047 3.464 2.106-1.188A6.99 6.99 0 0 0 8 16.708V19h4v-2.294a6.99 6.99 0 0 0 2.847-1.662l2.106 1.188L19 12.768l-2.176-1.227c.112-.49.176-1.01.176-1.54z"></path><path d="M19.492 11.897l-1.56-.88a7.63 7.63 0 0 0 .001-2.035l1.56-.88a1 1 0 0 0 .369-1.38L17.815 3.26a1 1 0 0 0-1.353-.363l-1.49.84A8.077 8.077 0 0 0 13 2.587V1a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v1.586a8.072 8.072 0 0 0-1.97 1.152l-1.492-.84a1 1 0 0 0-1.352.36L.14 6.724a1.004 1.004 0 0 0 .369 1.381l1.55.88C2.02 9.325 2 9.665 2 10s.023.675.068 1.017l-1.56.88a1 1 0 0 0-.369 1.372l2.04 3.46c.27.47.87.63 1.35.36l1.49-.844c.6.48 1.26.87 1.97 1.154V19c0 .552.443 1 1 1h4c.55 0 1-.448 1-1v-1.587c.7-.286 1.37-.675 1.97-1.152l1.49.85a.992.992 0 0 0 1.35-.36l2.047-3.46a1.006 1.006 0 0 0-.369-1.38zm-3.643-3.22c.1.45.15.894.15 1.323s-.05.873-.15 1.322c-.1.43.1.873.48 1.09l1.28.725-1.03 1.742-1.257-.71a.988.988 0 0 0-1.183.15 6.044 6.044 0 0 1-2.44 1.42.99.99 0 0 0-.714.96V18H9v-1.294c0-.443-.29-.833-.714-.96a5.985 5.985 0 0 1-2.44-1.424 1 1 0 0 0-1.184-.15l-1.252.707-1.03-1.75 1.287-.73c.385-.22.58-.66.485-1.09A5.907 5.907 0 0 1 4 10c0-.43.05-.874.152-1.322a1 1 0 0 0-.485-1.09L2.38 6.862 3.41 5.12l1.252.707a.998.998 0 0 0 1.184-.15 6.02 6.02 0 0 1 2.44-1.425A1 1 0 0 0 9 3.294V2h2v1.294c0 .442.29.832.715.958.905.27 1.75.762 2.44 1.426.317.306.8.365 1.183.15l1.253-.708 1.03 1.742-1.28.726a.999.999 0 0 0-.48 1.09zM10 6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"></path></svg>
          </span>
                </div>
                <span class="Polaris-Navigation__Text">
                   <span>Billing</span>
                </span>
            </a>
        </div>
    </li>
    </ul>
    <ul class="Polaris-Navigation__Section flex-1">
      <li class="Polaris-Navigation__SectionHeading">
        <span class="Polaris-Navigation__Text">ADDITIONAL LINKS</span>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}changelog" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon animated swing">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M3 15c2-2 2-4 2-7 0-2.762 2.24-5 5-5s5 2.238 5 5c0 3 0 5 2 7H3z"></path><path d="M16 8c0-2.967-2.167-5.432-5-5.91V1c0-.553-.448-1-1-1S9 .447 9 1v1.09C6.167 2.568 4 5.033 4 8c0 2.957 0 4.586-1.707 6.293-.286.286-.372.716-.217 1.09S2.596 16 3 16h4.183c-.114.313-.183.647-.183 1 0 1.654 1.345 3 3 3s3-1.346 3-3c0-.353-.07-.687-.184-1H17c.404 0 .77-.243.924-.617s.07-.804-.217-1.09C16 12.586 16 10.957 16 8zM5.01 14C6 12.208 6 10.285 6 8c0-2.206 1.794-4 4-4s4 1.794 4 4c0 2.285 0 4.208.99 6H5.01zM11 17c0 .552-.45 1-1 1s-1-.448-1-1 .448-1 1-1c.55 0 1 .448 1 1z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              What's New
              <span class="Polaris-Badge Polaris-Badge--statusSuccess Polaris-Badge--sizeSmall">New</span>
            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}support" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="currentColor" d="M10 1a9 9 0 0 0-9 9c0 1.769.518 3.413 1.398 4.804L1 19l4.196-1.398A8.954 8.954 0 0 0 10 19c4.971 0 9-4.029 9-9s-4.029-9-9-9z"></path><path d="M10 0C4.486 0 0 4.486 0 10c0 1.728.45 3.42 1.304 4.924l-1.253 3.76a1.001 1.001 0 0 0 1.265 1.264l3.76-1.253A9.947 9.947 0 0 0 10 20c5.514 0 10-4.486 10-10S15.514 0 10 0zm0 18a7.973 7.973 0 0 1-4.269-1.243.996.996 0 0 0-.852-.104l-2.298.766.766-2.299a.998.998 0 0 0-.104-.851A7.973 7.973 0 0 1 2 10c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8zm0-9a1 1 0 1 0 0 2 1 1 0 0 0 0-2zM6 9a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm8 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Support
            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}feedback" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M9 12H4.5C3.1 12 2 10.901 2 9.5 2 8.1 3.1 7 4.5 7H9v5z"></path><path d="M18 14.6c-2-1.5-4.9-2.3-7-2.6V6.901c2.1-.2 5-1.101 7-2.601v10.3zM9 18H7.651L5.6 14H9v4zm0-6H4.5C3.1 12 2 10.901 2 9.5 2 8.1 3.1 7 4.5 7H9v5zM19 0c-.5 0-1 .5-1 1 0 2-5.1 4-8 4H4.5C2 5 0 7 0 9.5c0 2.1 1.4 3.8 3.3 4.3l2.5 5c.3.7 1 1.2 1.8 1.2H9c1.1 0 2-.9 2-2v-3.9c3 .301 7 2.101 7 3.9 0 .5.5 1 1 1s1-.5 1-1V1c0-.5-.5-1-1-1z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
              Give Feedback
            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="{{config('env-variables.APP_PATH')}}affiliate" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
{{--                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M7.74 17.66A2.2 2.2 0 0 0 6.18 17H5.2A2.2 2.2 0 0 1 3 14.8v-1a2.2 2.2 0 0 0-.64-1.55l-.7-.7a2.2 2.2 0 0 1 0-3.12l.7-.7c.4-.41.64-.97.64-1.55v-1C3 3.98 3.98 3 5.2 3h1a2.2 2.2 0 0 0 1.55-.64l.7-.7a2.2 2.2 0 0 1 3.12 0l.7.7c.41.4.97.64 1.55.64h1c1.21 0 2.2.99 2.2 2.2v1c0 .58.23 1.14.64 1.55l.7.7a2.2 2.2 0 0 1 0 3.12l-.7.7a2.2 2.2 0 0 0-.64 1.56v.99a2.2 2.2 0 0 1-2.2 2.2h-1a2.2 2.2 0 0 0-1.55.64l-.7.7a2.2 2.2 0 0 1-3.12 0l-.7-.7z"></path><path d="M19.06 7.73l-.7-.7a1.22 1.22 0 0 1-.35-.85V5.2A3.2 3.2 0 0 0 14.8 2h-1a1.2 1.2 0 0 1-.85-.35l-.7-.7a3.2 3.2 0 0 0-4.53 0l-.7.7a1.2 1.2 0 0 1-.85.35H5.2A3.2 3.2 0 0 0 2 5.19v1c0 .3-.13.62-.35.84l-.7.7a3.2 3.2 0 0 0 0 4.53l.7.7c.22.23.35.54.35.85v1a3.2 3.2 0 0 0 3.2 3.2h1c.31 0 .62.12.84.35l.7.7A3.2 3.2 0 0 0 10 20a3.2 3.2 0 0 0 2.26-.94l.7-.7c.23-.23.53-.35.85-.35h1a3.2 3.2 0 0 0 3.2-3.2v-1c0-.31.13-.62.35-.85l.7-.7a3.2 3.2 0 0 0 0-4.53M12.3 6.3l-6 6a1 1 0 1 0 1.4 1.4l6-6a1 1 0 1 0-1.4-1.4M7.5 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m5.16-.14l-.7.7A3.18 3.18 0 0 0 16 13.8v1c0 .66-.54 1.2-1.2 1.2h-1a3.18 3.18 0 0 0-2.26.94l-.7.7a1.2 1.2 0 0 1-1.7 0l-.7-.7A3.18 3.18 0 0 0 6.18 16H5.2A1.2 1.2 0 0 1 4 14.8v-1c0-.85-.33-1.66-.94-2.26l-.7-.7a1.2 1.2 0 0 1 0-1.7l.7-.7c.6-.6.94-1.41.94-2.27V5.2C4 4.54 4.54 4 5.2 4h1c.85 0 1.65-.33 2.26-.94l.7-.7a1.2 1.2 0 0 1 1.7 0l.7.7a3.18 3.18 0 0 0 2.26.94h1c.66 0 1.2.54 1.2 1.2v1c0 .85.33 1.65.93 2.26l.7.7a1.2 1.2 0 0 1 0 1.7"></path></svg>--}}
                <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 4.5C5 3.763 5.69 3 6.77 3 7.818 3 9 3.87 9 5.333V6h-.846c-.805 0-1.656-.011-2.306-.25-.302-.112-.498-.253-.621-.413C5.112 5.187 5 4.94 5 4.5zM11.846 6H11v-.667C11 3.87 12.181 3 13.23 3 14.31 3 15 3.763 15 4.5c0 .44-.112.686-.227.837-.123.16-.319.3-.621.412-.65.24-1.5.251-2.306.251zM17 4.5c0 .558-.103 1.06-.306 1.5H18.5A1.5 1.5 0 0120 7.5V10H0V7.5A1.5 1.5 0 011.5 6h1.806A3.547 3.547 0 013 4.5C3 2.47 4.783 1 6.77 1c1.165 0 2.398.546 3.23 1.529C10.832 1.546 12.065 1 13.23 1 15.218 1 17 2.47 17 4.5zM9 20v-8H1v6.5c0 .83.67 1.5 1.5 1.5H9zm2 0v-8h8v6.5c0 .83-.67 1.5-1.5 1.5H11z" fill="#5C5F62"/></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">
{{--              Get Debutify Free--}}
              Rewards
              <span class="Polaris-Badge Polaris-Badge--statusSuccess Polaris-Badge--sizeSmall">New</span>
            </span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="https://www.shopify.com/?ref=debutify&utm_campaign=app" target="_blank" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17 20a1 1 0 0 0 1-1V9.443C19.19 8.75 20 7.475 20 6V5a.99.99 0 0 0-.1-.42L17.896.553A1 1 0 0 0 17 0H3c-.38 0-.725.214-.895.553L.1 4.58A.99.99 0 0 0 0 5v1c0 1.475.81 2.75 2 3.443V19a1 1 0 0 0 1 1h14zM16 8c-1.103 0-2-.897-2-2h4c0 1.103-.897 2-2 2zm0 10h-2v-5a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v5H4v-8a3.99 3.99 0 0 0 3-1.357A3.99 3.99 0 0 0 10 10a3.99 3.99 0 0 0 3-1.357A3.99 3.99 0 0 0 16 10v8zm-8 0h4v-4H8v4zM2 6h4c0 1.103-.897 2-2 2s-2-.897-2-2zm10 0c0 1.103-.897 2-2 2s-2-.897-2-2h4zM3.618 2h12.764l1 2H2.618l1-2z" fill="currentFill" fill-rule="evenodd"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">New Shopify Store</span>
          </a>
        </div>
      </li>
      <li class="Polaris-Navigation__ListItem">
        <div class="Polaris-Navigation__ItemWrapper">
          <a class="Polaris-Navigation__Item" tabindex="0" href="https://heycarson.com/ambassadors?ref=debutify" target="_blank" data-polaris-unstyled="true">
            <div class="Polaris-Navigation__Icon">
              <span class="Polaris-Icon">
                <svg viewBox="0 0 20 20" class="v3ASA" focusable="false" aria-hidden="true"><path fill="currentColor" d="M10 13a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm7-3c0-.53-.064-1.044-.176-1.54L19 7.23l-2.047-3.464-2.106 1.188A6.978 6.978 0 0 0 12 3.292V1H8v2.294a6.99 6.99 0 0 0-2.847 1.662L3.047 3.768 1 7.232 3.176 8.46C3.064 8.955 3 9.47 3 10s.064 1.044.176 1.54L1 12.77l2.047 3.464 2.106-1.188A6.99 6.99 0 0 0 8 16.708V19h4v-2.294a6.99 6.99 0 0 0 2.847-1.662l2.106 1.188L19 12.768l-2.176-1.227c.112-.49.176-1.01.176-1.54z"></path><path d="M19.492 11.897l-1.56-.88a7.63 7.63 0 0 0 .001-2.035l1.56-.88a1 1 0 0 0 .369-1.38L17.815 3.26a1 1 0 0 0-1.353-.363l-1.49.84A8.077 8.077 0 0 0 13 2.587V1a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v1.586a8.072 8.072 0 0 0-1.97 1.152l-1.492-.84a1 1 0 0 0-1.352.36L.14 6.724a1.004 1.004 0 0 0 .369 1.381l1.55.88C2.02 9.325 2 9.665 2 10s.023.675.068 1.017l-1.56.88a1 1 0 0 0-.369 1.372l2.04 3.46c.27.47.87.63 1.35.36l1.49-.844c.6.48 1.26.87 1.97 1.154V19c0 .552.443 1 1 1h4c.55 0 1-.448 1-1v-1.587c.7-.286 1.37-.675 1.97-1.152l1.49.85a.992.992 0 0 0 1.35-.36l2.047-3.46a1.006 1.006 0 0 0-.369-1.38zm-3.643-3.22c.1.45.15.894.15 1.323s-.05.873-.15 1.322c-.1.43.1.873.48 1.09l1.28.725-1.03 1.742-1.257-.71a.988.988 0 0 0-1.183.15 6.044 6.044 0 0 1-2.44 1.42.99.99 0 0 0-.714.96V18H9v-1.294c0-.443-.29-.833-.714-.96a5.985 5.985 0 0 1-2.44-1.424 1 1 0 0 0-1.184-.15l-1.252.707-1.03-1.75 1.287-.73c.385-.22.58-.66.485-1.09A5.907 5.907 0 0 1 4 10c0-.43.05-.874.152-1.322a1 1 0 0 0-.485-1.09L2.38 6.862 3.41 5.12l1.252.707a.998.998 0 0 0 1.184-.15 6.02 6.02 0 0 1 2.44-1.425A1 1 0 0 0 9 3.294V2h2v1.294c0 .442.29.832.715.958.905.27 1.75.762 2.44 1.426.317.306.8.365 1.183.15l1.253-.708 1.03 1.742-1.28.726a.999.999 0 0 0-.48 1.09zM10 6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"></path></svg>
              </span>
            </div>
            <span class="Polaris-Navigation__Text">Hire an Expert</span>
          </a>
        </div>
      </li>
    </ul>
  </div>
</nav>
