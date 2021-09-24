@extends('layouts.debutify')
@section('title','Add-Ons')
@section('view-add-ons','view-add-ons')

{{--
{{ dd(get_defined_vars()['__data']) }}
--}}

@if($all_addons != 1)
  @section('bannerTitle','available only on Paid plans')
  @section('bannerLink','upgrade to '. $starter .', '. $hustler . ' or '. $guru .' plans')
@elseif($alladdons_plan == $starter && $active_add_ons == $addonLimit)
  @section('bannerTitle','limit has been reached')
  @section('bannerLink','upgrade to '. $hustler . ' or '. $guru .' plans')
@elseif($is_paused)
  @section('bannerTitle','paused')
  @section('bannerLink',' unpause plan')
@endif

@section('styles')
@endsection

@section('content')

<div class="subscriptionPastdueBanner Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner6Heading" aria-describedby="Banner6Content">
  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
        <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
        <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
      </svg></span></div>
  <div>
    <div class="Polaris-Banner__Heading" id="Banner6Heading">
      <p class="Polaris-Heading">This page is being deprecated</p>
    </div>
    <div class="Polaris-Banner__Content" id="Banner6Content">
      <p>All Add-Ons are now directly integrated in Debutify theme 3.0, there is no more need to install/update Add-Ons from this page. This page will keep working for previous theme versions.</p>
    </div>
  </div>
</div>

{{-- <div class="betaThemeVersionBanner Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
    <div class="Polaris-Banner__Dismiss"><button type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon">
      <span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><circle cx="10" cy="10" r="9" fill="currentColor"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path></svg>
      </span>
    </div>
    <div>
      <div class="Polaris-Banner__Heading">
        <p class="Polaris-Heading">New Debutify {{ $version }} update available</p>
      </div>
    </div>
  </div> --}}

   @php

    $prior_beta_theme_disable = "";
    if($prior_beta_theme == 0 ){
          $prior_beta_theme_disable = "Polaris-Button--disabled";
    }

    @endphp

  @if($latestupload)
  <!-- Theme uploaded banner -->
  <div style="display:none;" class="themeUploadedBanner Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
    <div class="Polaris-Banner__Dismiss"><button onclick="return closeAlert('themeUploadedBanner')" type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
        </svg></span></div>
    <div>

      <div class="Polaris-Banner__Heading" id="Banner3Heading">
        <p class="Polaris-Heading">You successfully added {{$latestupload->shopify_theme_name}}</p>
      </div>
      <div class="Polaris-Banner__Content" id="Banner3Content">
        <div class="Polaris-Banner__Actions">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <a href="https://{{ $shop_domain}}/admin/themes/{{$latestupload->shopify_theme_id}}/editor" target="_blank" class="Polaris-Button Polaris-Button--outline">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Customize theme</span></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif


  @if(session()->has('addons-updated'))
  <!-- Theme uploaded banner -->
  <div class="themeUploadedBanner Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
    <div class="Polaris-Banner__Dismiss"><button type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
        </svg></span></div>
    <div>

      <div class="Polaris-Banner__Heading" id="Banner3Heading">
        <p class="Polaris-Heading">Debutify Theme Manager Updated</p>
      </div>
      <div class="Polaris-Banner__Content" id="Banner3Content">
        <div class="Polaris-Banner__Actions">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <a href="https://{{ $shop_domain}}/admin/themes/{{$latestupload->shopify_theme_id}}/editor" target="_blank" class="Polaris-Button Polaris-Button--outline">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Customize theme</span></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Addon status banner installed/updated-->
  @if(session()->has('message'))
  <div class="addonInstalledBanner Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
    <div class="Polaris-Banner__Dismiss"><button onclick="return closeAlert('addonInstalledBanner')" type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path>
        </svg></span></div>
    <div>

      <div class="Polaris-Banner__Heading" id="Banner3Heading">
        <p class="Polaris-Heading">{{ session('message') }}</p>
      </div>
      <div class="Polaris-Banner__Content" id="Banner3Content">
        <div class="Polaris-Banner__Actions">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <div class="Polaris-Banner__PrimaryAction">
                <a href="https://{{ $shop_domain}}/admin/themes/{{session('theme_id_cstm')}}/editor" target="_blank" class="Polaris-Button Polaris-Button--outline">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Customize theme</span></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  @if($theme_count > 0)
  <!-- skeleton -->
  <div class="Polaris-SkeletonPage__Page skeleton-wrapper" role="status" aria-label="Page loading">
    <div class="Polaris-SkeletonPage__Content">

      <div class="Polaris-Card">
        <div class="Polaris-Card__Section">
          <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
            <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
              <h2 class="Polaris-Heading">Add-Ons</h2>
            </div>
            <div class="Polaris-Stack__Item">
              <div class="Polaris-ButtonGroup">
                <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--plain">
                  <button style="visibility:hidden;" type="submit" class="Polaris-Button @php echo $prior_beta_theme_disable; @endphp">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Unlock all Add-Ons</span></span>
                    </span>
                  </button>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="Polaris-ResourceList__ResourceListWrapper">
          <ul class="Polaris-ResourceList" aria-live="polite">
            @foreach($global_add_ons as $addon)
            <li class="Polaris-ResourceList__ItemWrapper">
              <div class="">
                <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter">
                  <div class="Polaris-ResourceItem__Owned">
                    <div class="Polaris-ResourceItem__Media">
                      <div style="margin:0;border-radius:50%;overflow:hidden;" class="Polaris-SkeletonThumbnail Polaris-SkeletonThumbnail--sizeSmall Polaris-Avatar__Image"></div>
                    </div>
                  </div>
                  <div class="Polaris-ResourceItem__Content">
                    <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                      <div class="Polaris-SkeletonBodyText"></div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>

      </div>

    </div>
  </div>
  @endif

  <div id="dashboard" @if($theme_count >= 1) style="display:none;" @endif>
    @if($theme_count > 0)
{{--    update app addons banner    --}}

    @if( $is_update_banner_addon )
              <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="PolarisBanner10Heading" aria-describedby="PolarisBanner10Content">
                  <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <path fill-rule="evenodd" d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0zM9 6a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V6zm1 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
        </svg></span></div>
                  <form action="{{route('force_Update_Active_addons')}}" method="post" id="force-all-addon-form">
                      @csrf
                      <div class="Polaris-Banner__ContentWrapper">
                      <div class="Polaris-Banner__Heading" id="PolarisBanner10Heading">
                          <p class="Polaris-Heading">Add-Ons are now WAY faster!</p>
                      </div>
                      <div class="Polaris-Banner__Content" id="PolarisBanner10Content">
                          <ul class="Polaris-List">
                              <li class="Polaris-List__Item">Debutify Theme Manager is currently updating your Add-Ons in order to make them faster.. this process can take several minutes, please be patient.
                              </li>
                          </ul>
                          <div class="Polaris-Banner__Actions">
                              <div class="Polaris-ButtonGroup">
                                  <div class="Polaris-ButtonGroup__Item">
                                      <div class="Polaris-Banner__PrimaryAction"><button type="button" class="Polaris-Button Polaris-Button--outline force_all_addon_update2 disable-while-loading2" onclick="return forceUpdateAllAddons(2);"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Run the adapter</span></span></button></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  </form>
              </div>
    @endif
    <!-- addons list -->
    <div class="Polaris-Card">
      <div class="Polaris-Card__Section">
        <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
          <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
            <h2 class="Polaris-Heading">
              Add-Ons
              @if($all_addons == 1)
              <span class="Polaris-Badge Polaris-Badge--statusSuccess">
                <span class="active-addon">{{$active_add_ons}}</span>/<span class="max-addon">{{$addons_count}}</span>
              </span>
              @endif
            </h2>
          </div>
          <div style="" class="Polaris-Stack__Item">
            <div class="Polaris-ButtonGroup">
            @if($all_addons == 1)
              @if($active_add_ons >= '1')
                <div class="Polaris-ButtonGroup__Item">
                  <button type="button" class="Polaris-Button @php echo $prior_beta_theme_disable; @endphp" onclick="return updateActiveAddons('{{$store_themes[0]->shopify_theme_id}}');">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Text">Bulk update</span>
                    </span>
                  </button>
                </div>
              @endif

              @if($active_add_ons < $addons_count)
                @if($alladdons_plan == $guru || $alladdons_plan == $hustler)
                <div class="Polaris-ButtonGroup__Item">
                  <button type="button" class="Polaris-Button Polaris-Button--primary @php echo $prior_beta_theme_disable; @endphp" onclick="return installAllAddons('{{$store_themes[0]->shopify_theme_id}}');">
                    <span class="Polaris-Button__Content">
                      <span class="Polaris-Button__Text">Bulk install</span>
                    </span>
                  </button>
                </div>
                @endif
              @endif
            @else
              <div class="Polaris-ButtonGroup__Item">
                <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--primary @php echo $prior_beta_theme_disable; @endphp">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Text">Unlock all Add-Ons</span>
                  </span>
                </a>
              </div>
            @endif
            </div>
          </div>
        </div>
      </div>

      <div class="Polaris-ResourceList__ResourceListWrapper">
        <ul class="Polaris-ResourceList" aria-live="polite">
          @foreach($global_add_ons as $addon)
          @if($addon->status == 1)
          <li class="Polaris-ResourceList__ItemWrapper">
            <div class="Polaris-ResourceItem open-modal" onclick='return openAddonModal("{{$addon->id}}","{{$addon->title}}","{{$addon->status}}","{{$addon->title}}", "{{$active_add_ons}}", "{{$all_addons}}","{{$alladdons_plan}}","{{$store_themes[0]->shopify_theme_id}}","{{$addon->subtitle}}");'>
              <a class="Polaris-ResourceItem__Link" aria-describedby="{{$addon->title}}" aria-label="View details for {{ $addon->title}}" tabindex="0" data-polaris-unstyled="true"></a>
              <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" id="{{$addon->title}}">
                <div class="Polaris-ResourceItem__Owned">
                  <div class="Polaris-ResourceItem__Media">
                    <span aria-label="{{$addon->title}}" role="img" class="Polaris-Avatar Polaris-Avatar--styleSix Polaris-Avatar--sizeMedium Polaris-Avatar--hasImage">
                      <img src="/svg/unlock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    </span>
                  </div>
                </div>
                <div class="Polaris-ResourceItem__Content">
                  <h3>
                    <span class="Polaris-TextStyle--variationStrong">{{$addon->title}}</span>
                    @if($all_addons == 1)
                    <span class="Polaris-Badge Polaris-Badge--statusSuccess">Installed</span>
                    @else
                    <span class="Polaris-Badge Polaris-Badge--statusAttention">Paused</span>
                    @endif
                  </h3>
                  <div>{{$addon->subtitle}}</div>
                </div>
              </div>
            </div>
          </li>
          @endif
          @endforeach

          @foreach($global_add_ons as $addon)
          @if($addon->status == 0)
          <li class="Polaris-ResourceList__ItemWrapper">
            <div class="Polaris-ResourceItem open-modal" onclick='return openAddonModal("{{$addon->id}}","{{$addon->title}}","{{$addon->status}}","{{$addon->title}}", "{{$active_add_ons}}", "{{$all_addons}}","{{$alladdons_plan}}","{{$store_themes[0]->shopify_theme_id}}","{{$addon->subtitle}}");'>
              <a class="Polaris-ResourceItem__Link" aria-describedby="{{$addon->title}}" aria-label="View details for {{$addon->title}}" tabindex="0" data-polaris-unstyled="true"></a>
              <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" id="{{$addon->title}}">
                <div class="Polaris-ResourceItem__Owned">
                  <div class="Polaris-ResourceItem__Media">
                    <span aria-label="{{$addon->title}}" role="img" class="Polaris-Avatar Polaris-Avatar--styleSix Polaris-Avatar--sizeMedium Polaris-Avatar--hasImage">
                        <img src="/svg/lock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    </span>
                  </div>
                </div>
                <div class="Polaris-ResourceItem__Content">
                  <h3>
                    <span class="Polaris-TextStyle--variationStrong">{{$addon->title}}</span>
                    @if($all_addons == 1 and $active_add_ons != $addonLimit)
                    @else
                    <span class="Polaris-Badge">Locked</span>
                    @endif
                  </h3>
                  <div>{{$addon->subtitle}}</div>
                </div>
              </div>
            </div>
          </li>
          @endif
          @endforeach
        </ul>
      </div>
    </div>

    <!-- all addons install/update modal -->
    <div id="activeAlladdonModal" class="modal fade-scales" style="display:none;">
      <form action="" method="post" id="all-addon-form">
          @csrf
          <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
              <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">

                <div class="Polaris-Modal-Header">
                  <div id="modal-header13" class="Polaris-Modal-Header__Title">
                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall titl"></h2>
                  </div>
                  <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
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
                      <div class="Polaris-TextContainer mb">
                        <p class="messages"></p>
                      </div>
                      <div class="Polaris-Card installaladns"></div>
                    </section>
                  </div>
                </div>
                 <div class="Polaris-Modal-Footer">
                  <div class="Polaris-Modal-Footer__FooterContent">
                    <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                      <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"></div>
                       <div class="Polaris-Stack__Item">
                        <div class="Polaris-ButtonGroup">

                          <div class="Polaris-ButtonGroup__Item">
                            <div class="Polaris-Select">
                              
                              <select id="themeSelect" class="Polaris-Select__Input disable-while-loading themeselect" aria-invalid="false">
                                {{-- @foreach($store_themes as $theme)
                                <option value="{{ $theme->shopify_theme_id }}">{{ $theme->shopify_theme_name }}</option>
                                @endforeach --}}
                                @php
                                foreach($store_themes as $theme){
                                            
                                                if($theme->is_beta_theme != 1 && $theme->version == '2.0.2'){
                                                  echo '<option value="'.$theme->shopify_theme_id.'">'.$theme->shopify_theme_name.'</option>';
                                                }
                                          
                                      }
                                @endphp
                              </select>
                              <div class="Polaris-Select__Content" aria-hidden="true">
                                <span class="Polaris-Select__SelectedOption"></span>
                                <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
                              </div>
                              <div class="Polaris-Select__Backdrop"></div>
                            </div>
                          </div>
                          <div class="Polaris-ButtonGroup__Item">
                             <button type="button" class="Polaris-Button Polaris-Button--primary update_alladdons btn-loading" onclick="return AllAdonsinstall();">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text btn_html"></span>
                              </span>
                            </button>
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
      </form>
    </div>

    <!-- add-on modal -->
   
    <div id="addonModal" class="modal fade-scale" style="display:none;">
      <form action="" method="post" id="addon-form">
        @csrf

        <div>
          <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
            <div>
              <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">

                <div class="Polaris-Modal-Header">
                  <div id="modal-header11" class="Polaris-Modal-Header__Title">
                    <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall addon-title"></h2>
                  </div>
                  <button type="button" class="Polaris-Modal-CloseButton close-modal disable-while-loading">
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
                      <div class="Polaris-FormLayout">
                        <div class="Polaris-FormLayout__Item">
                          @if($all_addons == 1)
                          <div class="showIfLimitReached showOnUninstalled Polaris-Banner Polaris-Banner--hasDismiss Polaris-Banner--statusWarning Polaris-Banner--withinPage pageBanner" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner10Heading" aria-describedby="Banner10Content">
                            <div class="Polaris-Banner__Dismiss">
                              <button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly dismiss-banner" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
                                </svg></span></span></span>
                              </button>
                            </div>
                            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                <circle fill="currentColor" cx="10" cy="10" r="9"></circle>
                                <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path>
                              </svg></span>
                            </div>
                            <div>
                              <div class="Polaris-Banner__Heading" id="Banner10Heading">
                                <p class="Polaris-Heading"><span class="text-capitalize">@yield('title')</span> @yield('bannerTitle')</p>
                              </div>
                              <div class="Polaris-Banner__Content" id="Banner10Content">
                                <p>If you would like to benefit from @yield('title'), you need to <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">@yield('bannerLink')</a></p>
                              </div>
                            </div>
                          </div>
                          <div class="Polaris-TextContainer">
                            <p>
                              <span class="showOnInstalled">This Add-On is already installed. Go on your theme editor to activate it and edit settings.</span>
                              <span class="showOnUninstalled addon-subtitle"></span>
                              <span class="showIfLimitReached">You have reached your Add-On limit. Upgrade plan to install more Add-Ons.</span>
                            </p>
                          </div>
                          @else
                          <div class="Polaris-TextContainer">
                            <p>To install this Add-Ons, you need to choose a plan.</p>
                          </div>
                          @endif
                          <div class="Polaris-TextContainer video-tutorial" style="margin-top:2rem;">
                            <iframe class="tutorial" width="100%" height="295" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>

                <div class="Polaris-Modal-Footer">
                  <div class="Polaris-Modal-Footer__FooterContent">
                    <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                      <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                        <div class="showOnUninstalled">
                          <a href="{{config('env-variables.APP_DEMO')}}" target="_blank" class="Polaris-Button Polaris-Button--plain disable-while-loading">
                            <span class="Polaris-Button__Content">
                              <span class="Polaris-Button__Text">View demo</span>
                            </span>
                          </a>
                        </div>
                        <div class="showOnInstalled">
                          <button type="button" class="Polaris-Button Polaris-Button--plain link-uninstall disable-while-loading @php echo $prior_beta_theme_disable; @endphp">
                            <span class="Polaris-Button__Content">
                              <span class="Polaris-Button__Text">Uninstall</span>
                            </span>
                          </button>
                          <button type="button" class="Polaris-Button Polaris-Button--plain cancel-link-uninstall disable-while-loading @php echo $prior_beta_theme_disable; @endphp" style="display:none;">
                            <span class="Polaris-Button__Content">
                              <span class="Polaris-Button__Text">Never mind</span>
                            </span>
                          </button>
                        </div>
                      </div>
                      <div class="Polaris-Stack__Item">
                        <div class="Polaris-ButtonGroup">

                          <div class="Polaris-ButtonGroup__Item showIfLimitReached">
                            <button type="button" class="Polaris-Button close-modal disable-while-loading">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Cancel</span>
                              </span>
                            </button>
                          </div>

                          @if($all_addons != 1)
                          <div class="Polaris-ButtonGroup__Item">
                            <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--primary @php echo $prior_beta_theme_disable; @endphp">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Unlock Add-Ons</span>
                              </span>
                            </a>
                          </div>
                          @endif

                          @if($active_add_ons > $addonLimit)
                          <div class="Polaris-ButtonGroup__Item showIfLimitReached btn-upgrade">
                            <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--primary">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Upgrade plan</span>
                              </span>
                            </a>
                          </div>
                          @endif

                          @if($all_addons == 1)
                            <div class="Polaris-ButtonGroup__Item select-theme">
                              <div class="Polaris-Select">
                                <select id="themeSelects" class="Polaris-Select__Input disable-while-loading themeselectcls" aria-invalid="false">
                                  {{-- @foreach($store_themes as $theme)
                                  <option value="{{ $theme->shopify_theme_id }}">{{ $theme->shopify_theme_name }}</option>
                                  @endforeach --}}
                                   @php
                                    foreach($store_themes as $theme){
                                                if($theme->is_beta_theme != 1 && $theme->version == '2.0.2'){
                                                  echo '<option value="'.$theme->shopify_theme_id.'">'.$theme->shopify_theme_name.'</option>';
                                                }
                                          }
                                    @endphp
                                </select>
                                <div class="Polaris-Select__Content" aria-hidden="true">
                                  <span class="Polaris-Select__SelectedOption"></span>
                                  <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
                                </div>
                                <div class="Polaris-Select__Backdrop"></div>
                              </div>
                            </div>

                            @if($active_add_ons < $addonLimit)
                            <!-- dont show if limit reached -->
                            <div class="Polaris-ButtonGroup__Item showOnUninstalled">
                              <button type="button" class="Polaris-Button Polaris-Button--primary activate_addon_next btn-loading @php echo $prior_beta_theme_disable; @endphp" onclick="return AddSubscription();" >
                                <span class="Polaris-Button__Content">
                                  <span class="Polaris-Button__Text">Install Add-On</span>
                                </span>
                              </button>
                            </div>
                            @endif

                            <div class="Polaris-ButtonGroup__Item btn-update showOnInstalled">
                             	<button type="button" class="Polaris-Button Polaris-Button--primary update_addon btn-loading @php echo $prior_beta_theme_disable; @endphp" onclick="return updateaddons();">
                              	<span class="Polaris-Button__Content">
                                  <span class="Polaris-Button__Text">Update Add-On</span>
                                </span>
                              </button>
                            </div>
                          @endif

                          <div class="Polaris-ButtonGroup__Item btn-uninstall" style="display:none;">
                            <button type="button" class="Polaris-Button Polaris-Button--destructive deactivate_addon btn-loading @php echo $prior_beta_theme_disable; @endphp" onclick="return cancelSubscription();">
                              <span class="Polaris-Button__Content">
                                <span class="Polaris-Button__Text">Uninstall Add-On</span>
                              </span>
                            </button>
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
        <div class="Polaris-Backdrop"></div>
      </form>
    </div>
    @else
    <!-- empty state -->
    <div class="Polaris-EmptyState Polaris-EmptyState--withinPage">
      <div class="Polaris-EmptyState__Section">
        <div class="Polaris-EmptyState__DetailsContainer">
          <div class="Polaris-EmptyState__Details">
            <div class="Polaris-TextContainer">
              <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">
                Install up to {{$addons_count}}+ Add-Ons
              </p>
              <div class="Polaris-EmptyState__Content">
                <p>Boost your sales in one-click with our fully integrated conversion hacks.</p>
              </div>
            </div>
            <div class="Polaris-EmptyState__Actions">
              <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                <div class="Polaris-Stack__Item">
                  <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge">
                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Unlock add-ons</span></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="Polaris-EmptyState__ImageContainer"><img src="/svg/empty-state-13.svg" role="presentation" alt="" class="Polaris-EmptyState__Image"></div>
      </div>
    </div>
    @endif
    @if($is_update_banner_addon)
        @include ("components.updates-addons-modal")
    @endif
  </div>
@endsection

@section('scripts')
    @parent
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
      // init shopify title bar
      {{--
      ShopifyTitleBar.set({
          title: 'Add-Ons',
      });
      --}}

      $(document).ready(function() {
        // show theme uploaded banner
        var themeBannerView = localStorage.getItem('themeBannerView') || '';
        if (themeBannerView == 'yes') {
          $('.themeUploadedBanner').show();
          localStorage.setItem('themeBannerView','');
        }
        loadingBarCustom(false);
      });

      // close modal
      $('.close-modal').click(function(){
        $('.link-uninstall').show();
        $('.btn-update').show();
        $('.cancel-link-uninstall').hide();
        $('.btn-uninstall').hide();
        $('.tutorial').attr("src","");
      });

      // link uninstall click
      $('.link-uninstall').click(function(){
        $('.link-uninstall').hide();
        $('.btn-update').hide();
        $('.select-theme').hide();
        $('.cancel-link-uninstall').show();
        $('.btn-uninstall').show();
        $(".btn-upgrade").hide();
      });

      // cancel link uninstall click
      $('.cancel-link-uninstall').click(function(){
        $('.link-uninstall').show();
        $('.btn-update').show();
        $('.select-theme').show();
        $('.cancel-link-uninstall').hide();
        $('.btn-uninstall').hide();
        $(".btn-upgrade").show();
      });

      // theme select
      $("select.themeselectcls").change(function(){
        var selectedtheme = $(this).children("option:selected").val();
        $('#theme_id').val(selectedtheme);
      });
      $("select.themeselect").change(function(){
        var selectedtheme= $(this).children("option:selected").val();
        $('#theme_ids').val(selectedtheme);
      });

      // open modal - install all add-ons
      function installAllAddons(themesid){
          @if($is_update_banner_addon)
              if( $(".updateAddons").hasClass("open") ){} else{
                  var bulkmodal = $("#updateAddonsModal");
                  openModal(bulkmodal);
              }
          @else
                var form = document.getElementById('all-addon-form');
                if ($('#all-addon-form').find('#theme_ids').length) {
                  //$('#all-addon-form').find('#theme_ids').val(themesid);
                } else {
                  var theme_id = themesid;
                  var hiddenInput = document.createElement('input');
                  hiddenInput.setAttribute('type', 'hidden');
                  hiddenInput.setAttribute('name', 'theme_id');
                  hiddenInput.setAttribute('id', 'theme_ids');
                  hiddenInput.setAttribute('value', theme_id);
                  form.appendChild(hiddenInput);
                }

                $('.titl').html('Bulk install Add-Ons');
                $('.messages').html('Install selected Add-Ons. This process can take several minutes.');
                $('.btn_html').html('Install Add-Ons');
        var optionList = '<ul class="Polaris-OptionList__Options" id="PolarisOptionList9-0" aria-multiselectable="true">@foreach($global_add_ons as $key=>$addon) @if($addon->status != 1) <li class="Polaris-OptionList-Option" tabindex="-1"><label for="PolarisOptionList9-0-{{$key}}" class="Polaris-OptionList-Option__Label"><div class="Polaris-OptionList-Option__Checkbox"><div class="Polaris-OptionList-Checkbox"><input id="PolarisOptionList9-0-{{$key}}" name=addons[] type="checkbox" class="Polaris-OptionList-Checkbox__Input" aria-checked="false" value="{{$addon->id}}" checked="checked"><div class="Polaris-OptionList-Checkbox__Backdrop"></div><div class="Polaris-OptionList-Checkbox__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path></svg></span></div></div></div>{{$addon->title}}</label></li> @endif @endforeach</ul>';
              $('.installaladns').html(optionList);
                $("#activeAlladdonModal").addClass('open');
                $('#activeAlladdonModal').css('display','block');
                form.setAttribute("action","{{ route('install_All_addons') }}");

                // show modal
                var modal = $("#activeAlladdonModal");
                openModal(modal);
        @endif
      }

      // open modal - update all add-on
      function updateActiveAddons(themesid){
          @if($is_update_banner_addon)
              if( $(".updateAddons").hasClass("open") ){} else{
                  var bulkmodal = $("#updateAddonsModal");
                  openModal(bulkmodal);
              }
          @else
                var form = document.getElementById('all-addon-form');
                if ($('#all-addon-form').find('#theme_ids').length) {
                 // $('#all-addon-form').find('#theme_ids').val(themesid);
                } else {
                  var theme_id = themesid;
                  var hiddenInput = document.createElement('input');
                  hiddenInput.setAttribute('type', 'hidden');
                  hiddenInput.setAttribute('name', 'theme_id');
                  hiddenInput.setAttribute('id', 'theme_ids');
                  hiddenInput.setAttribute('value', theme_id);
                  form.appendChild(hiddenInput);
                }
                var optionList = '<ul class="Polaris-OptionList__Options" id="PolarisOptionList9-0" aria-multiselectable="true">@foreach($global_add_ons as $key=>$addon) @if($addon->status == 1)<li class="Polaris-OptionList-Option" tabindex="-1"><label for="PolarisOptionList9-0-{{$key}}" class="Polaris-OptionList-Option__Label"><div class="Polaris-OptionList-Option__Checkbox"><div class="Polaris-OptionList-Checkbox"><input id="PolarisOptionList9-0-{{$key}}" name=addons[] type="checkbox" class="Polaris-OptionList-Checkbox__Input" aria-checked="false" value="{{$addon->id}}" checked="checked"><div class="Polaris-OptionList-Checkbox__Backdrop"></div><div class="Polaris-OptionList-Checkbox__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path></svg></span></div></div></div>{{$addon->title}}</label></li> @endif @endforeach</ul>';
                $('.titl').html('Bulk update Add-Ons');
                $('.messages').html('Update selected Add-Ons. This process can take several minutes.');
                $('.btn_html').html('Update Add-Ons');
                $('.installaladns').html(optionList);
                form.setAttribute("action","{{ route('update_Active_addons') }}");

                // show modal
                var modal = $("#activeAlladdonModal");
                openModal(modal);
          @endif
      }

      // open modal - add-on
      function openAddonModal(addon_id, addon_name, status, title, active_add_ons, all_addons, alladdons_plan, themes, subtitle){
          @if($is_update_banner_addon)
              // if( !status ){
                  if( $(".updateAddons").hasClass("open") ){} else{
                      var modal = $("#updateAddonsModal");
                      openModal(modal);
                  }
              // }else{
              //    showAddonModel(addon_id, addon_name, status, title, active_add_ons, all_addons, alladdons_plan, themes, subtitle);
              // }
          @else
              showAddonModel(addon_id, addon_name, status, title, active_add_ons, all_addons, alladdons_plan, themes, subtitle);
          @endif
      }

      function showAddonModel(addon_id, addon_name, status, title, active_add_ons, all_addons, alladdons_plan, themes, subtitle){
          // old stripe form
          var form = document.getElementById('addon-form');
          if ($('#addon-form').find($('input[name="addon_id"]')).length) {
              $('input[name="addon_id"]').val(addon_id);
              $('input[name="addon_name"]').val(addon_name);
          } else{
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'addon_id');
              hiddenInput.setAttribute('value', addon_id);
              form.appendChild(hiddenInput);
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'addon_name');
              hiddenInput.setAttribute('value', addon_name);
              form.appendChild(hiddenInput);
          }
          if ($('#addon-form').find('#theme_id').length) {} else {
              var hiddenInput = document.createElement('input');
              hiddenInput.setAttribute('type', 'hidden');
              hiddenInput.setAttribute('name', 'theme_id');
              hiddenInput.setAttribute('id', 'theme_id');
              hiddenInput.setAttribute('value', themes);
              form.appendChild(hiddenInput);
          }

          var addonLimit = {{$addonLimit}};

          // addon installed
          if(status == 1){
              $('.showOnUninstalled').hide();
              $('.showOnInstalled').show();
              $('.showIfLimitReached').hide();
              $('.select-theme').show();

              if (all_addons != 1){
                  $('.showOnUninstalled').hide();
                  $('.showOnInstalled').show();
                  $('.showIfLimitReached').show();
                  $('.select-theme').hide();
              }
          }
          // addon uninstalled
          else{
              $('.showOnUninstalled').show();
              $('.showOnInstalled').hide();
              $('.showIfLimitReached').hide();
              $('.select-theme').show();

              if(active_add_ons >= addonLimit){
                  $('.showOnUninstalled').show();
                  $('.showOnInstalled').hide();
                  $('.showIfLimitReached').show();
                  $('.select-theme').hide();
              }
          }

          // set title/subtitle
          $('.addon-title').text(title);
          $(".addon-subtitle").text(subtitle);

          // set video
          @include("components.video-addons")

          $('.tutorial').attr("src","https://www.youtube.com/embed/" + videoSource);

          if(videoSource){
              $(".video-tutorial").show();
          } else{
              $(".video-tutorial").hide();
          }

          //show modal
          var modal = $("#addonModal");
          openModal(modal);
      }
      // install add-on
      function AddSubscription(){
          loadingBarCustom();
          var form = document.getElementById('addon-form');
          form.setAttribute("action","{{ route('install_addons') }}");
          form.submit();
      }

      // uninstall add-on
      function cancelSubscription(){
        console.log('cancelSubscription');
        loadingBarCustom();
        var form = document.getElementById('addon-form');
        form.setAttribute("action","{{ route('delete_addons') }}");
        form.submit();
      }

      // update add-on
      function updateaddons(){
        console.log('updateaddons');
        loadingBarCustom();
        var form = document.getElementById('addon-form');
        form.setAttribute("action","{{ route('update_addons') }}");
        form.submit();
      }

      // install/update all add-ons
      function AllAdonsinstall(){
        console.log('AllAdonsinstall');
        loadingBarCustom();
        var form = document.getElementById('all-addon-form');
        form.submit();
      }
    </script>
@endsection

<script>
    function forceUpdateAllAddons(){
        loadingBarCustom();

        $('.disable-while-loading').addClass('Polaris-Button--disabled').prop("disabled", true);
        $('.force_all_addon_update').addClass('Polaris-Button--loading');
        $('.force_all_addon_update').html('<span class="Polaris-Button__Content"><span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorWhite Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span><span role="status"><span class="Polaris-VisuallyHidden">Loading</span></span></span><span class="Polaris-Button__Text">Run the adapter</span></span>');

        var form = document.getElementById('force-all-addon-form');
        form.submit();
    }
</script>
