@extends('layouts.debutify')
@section('title','theme library')
@section('view-themes','view-themes')

@section('styles')
<style>
.pricingBanner{
  display: none;
}
</style>
@endsection

@section('content')
{{-- @if (session('new_version')) --}}
<!-- New theme update banner -->
{{-- <div class="newThemeVersionBanner Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
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
{{-- @endif --}}

@if($latestupload)
<!-- Theme uploaded banner -->
<div style="display:none;" class="themeUploadedBanner Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
  <div class="Polaris-Banner__Dismiss"><button type="button" class="dismiss-banner Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
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

@if($theme_count > 0)
<!-- skeleton -->
<div class="Polaris-SkeletonPage__Page skeleton-wrapper" role="status" aria-label="Page loading">
  <div class="Polaris-SkeletonPage__Content">

    <div class="Polaris-Card">

      <div class="Polaris-Card__Section">
        <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
          <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
            <h2 class="Polaris-Heading">Themes</h2>
          </div>
          <div class="Polaris-Stack__Item">
            <div class="Polaris-ButtonGroup">
              <div class="Polaris-ButtonGroup__Item Polaris-ButtonGroup__Item--plain">
                <button style="visibility:hidden;" type="submit" class="Polaris-Button">
                  <span class="Polaris-Button__Content">
                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Add Debutify {{ $version }}</span></span>
                  </span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="Polaris-ResourceList__ResourceListWrapper">
        <ul class="Polaris-ResourceList" aria-live="polite">
          @foreach($store_themes as $theme)
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
  <div class="Polaris-Card">

    <div class="Polaris-Card__Section">
      <div class="Polaris-Stack Polaris-Stack--alignmentBaseline">
        <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
          <h2 class="Polaris-Heading">Themes</h2>
        </div>
        <div class="Polaris-Stack__Item">
          <div class="Polaris-ButtonGroup">
            <div class="Polaris-ButtonGroup__Item">
              <button type="submit" class="Polaris-Button refresh_button btn-loading" onclick="return refreshThemes();">
                <span class="Polaris-Button__Content">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Refresh</span></span>
                </span>
              </button>
            </div>
            <div class="Polaris-ButtonGroup__Item">
              <button type="submit" class="Polaris-Button Polaris-Button--primary" onclick="return openDownloadThemeModal();">
                <span class="Polaris-Button__Content">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Add Debutify {{ $version }}</span></span>
                </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="Polaris-ResourceList__ResourceListWrapper">
      <ul class="Polaris-ResourceList" aria-live="polite">
        @foreach($store_themes as $theme)
        <li class="Polaris-ResourceList__ItemWrapper">
          <div class="Polaris-ResourceItem Polaris-ResourceItem--persistActions open-modal" onclick="return openThemeModal('{{ $theme->shopify_theme_id }}','{{ $theme->shopify_theme_name }}','{{ $shop_domain }}');">
            <a class="Polaris-ResourceItem__Link" aria-describedby="" aria-label="View details for" tabindex="0" data-polaris-unstyled="true"></a>
            <div class="Polaris-ResourceItem__Container Polaris-ResourceItem--alignmentCenter" id="">
              <div class="Polaris-ResourceItem__Owned">
                <div class="Polaris-ResourceItem__Media">
                  <span aria-label="" role="img" class="Polaris-Avatar Polaris-Avatar--styleSix Polaris-Avatar--sizeMedium Polaris-Avatar--hasImage">
                    @if($theme->role == 1)
                    <img src="/svg/unlock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    @else
                    <img src="/svg/lock.svg" class="Polaris-Avatar__Image" alt="" role="presentation">
                    @endif
                  </span>
                </div>
              </div>
              <div class="Polaris-ResourceItem__Content">
                <h3>
                  <span class="Polaris-Heading">{{ $theme->shopify_theme_name }}</span>
                  @if($theme->role == 1)
                  <span class="Polaris-Badge Polaris-Badge--statusSuccess">Live</span>
                  @else
                  <span class="Polaris-Badge">Unpublished</span>
                  @endif
                  @if($theme->is_beta_theme == 1)
                  <span class="Polaris-Badge Polaris-Badge--statusSuccess">BETA</span>
                  @endif
                </h3>
                <div></div>
              </div>
            </div>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  <!-- cutomize theme Modal -->
  <div id="themeModal" class="modal fade-scale" style="display:none;">
    <div>
      <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
        <div>
          <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">
            <div class="Polaris-Modal-Header">
              <div id="modal-header11" class="Polaris-Modal-Header__Title">
                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall theme-title"></h2>
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
                    <p>Click the button below to customize your Debutify theme.</p>
                  </div>
                </section>
              </div>
            </div>

            <div class="Polaris-Modal-Footer">
              <div class="Polaris-Modal-Footer__FooterContent">
                <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                  <div class="Polaris-Stack__Item Polaris-Stack__Item--fill">
                    
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
                      <div class="Polaris-ButtonGroup__Item">
                        <a href="" target="_blank" class="customize_theme close-modal"><button type="button" class="Polaris-Button Polaris-Button--primary">
                          <span class="Polaris-Button__Content">
                            <span class="Polaris-Button__Text">Customize</span>
                          </span>
                        </button></a>
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
  </div>

  <!-- download theme modal -->
  <div id="DownloadThemeModal" class="modal fade-scale" style="display:none;">
    <div>
      <div class="Polaris-Modal-Dialog__Container" data-polaris-layer="true" data-polaris-overlay="true">
        <div>
          <div class="Polaris-Modal-Dialog__Modal" role="dialog" aria-labelledby="modal-header11" tabindex="-1">

            <div class="Polaris-Modal-Header">
              <div id="modal-header11" class="Polaris-Modal-Header__Title">
                <h2 class="Polaris-DisplayText Polaris-DisplayText--sizeSmall">Add Debutify {{ $version }}</h2>
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
                  <div class="Polaris-TextContainer">
                    <p>Copy your current settings (optional)</p>
                  </div>



                  <form id="download_theme_form" method="POST" action="" enctype="multipart/form-data">
                      @csrf


                      <div class="Polaris-Stack Polaris-Stack--distributionFill">

                        
                          <div class="Polaris-Stack__Item" id="Theme-Checkbox-Group-One" style="background-image: linear-gradient(rgba(223, 227, 232, 0.3), rgba(223, 227, 232, 0.3)); margin-top: 2rem;">
                            <label class="Polaris-Choice terms-action" for="Copy-Theme-Settings" style="padding: 0.6em">
                             <span class="Polaris-Choice__Control">
                              <span class="Polaris-Checkbox">
                               <input id="Copy-Theme-Settings" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="1" name="CopyOldSettings" checked="checked"><span class="Polaris-Checkbox__Backdrop"></span>
                               <span class="Polaris-Checkbox__Icon">
                                <span class="Polaris-Icon">
                                 <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.436.436 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                </svg>
                              </span>
                            </span>
                          </span>
                        </span>
                        <span class="Polaris-Choice__Label">
                          Copy theme settings (color, typography, sections, etc)
                        </span>
                      </label>
                    </div>


                          <div class="Polaris-Stack__Item" id="Theme-Checkbox-Group-Two" style="background-image: linear-gradient(rgba(223, 227, 232, 0.3), rgba(223, 227, 232, 0.3)); margin-top: 0.5rem;">
                            <label class="Polaris-Choice terms-action" for="Copy-Custom-Code" style="padding: 0.6em">
                             <span class="Polaris-Choice__Control">
                              <span class="Polaris-Checkbox">
                               <input id="Copy-Custom-Code" type="checkbox" class="Polaris-Checkbox__Input" aria-invalid="false" role="checkbox" aria-checked="false" value="1" name="CopyNewFiles"><span class="Polaris-Checkbox__Backdrop"></span>
                               <span class="Polaris-Checkbox__Icon">
                                <span class="Polaris-Icon">
                                 <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                  <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.436.436 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                </svg>
                              </span>
                            </span>
                          </span>
                        </span>
                        <span class="Polaris-Choice__Label">
                          Copy custom code (3rd party Apps and custom code modifications)
                        </span>
                      </label>
                    </div>


                  
                    <div id="Hide-Theme-Duplicate-Options-One" class="Polaris-Stack__Item" style="margin-top: 0rem; display: none;">
                      <div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="PolarisBanner12Heading" aria-describedby="PolarisBanner12Content">
                        <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorWarning" style="margin-top: 0.3em;"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                          <path fill-rule="evenodd" d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0zM9 6a1 1 0 1 1 2 0v4a1 1 0 1 1-2 0V6zm1 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"></path>
                        </svg></span></div>
                        <div class="Polaris-Banner__ContentWrapper">
                          <div class="Polaris-Banner__Content" style="padding: 0px;">
                            <p>This option might not work for themes with lots of customization. If you encounter any issues, please try again without selecting the "Copy custom code" option.</p>
                          </div>
                        </div>
                      </div>
                      <div id="PolarisPortalsContainer"></div>
                    </div>

                    <div id="Hide-Theme-Duplicate-Options-Two" class="Polaris-Stack__Item">
                      <div class="Polaris-Labelled__LabelWrapper">
                        <div class="Polaris-Label">
                          <label for="Theme-Name" class="Polaris-Label__Text">Select your current theme</label>
                        </div>
                      </div>
                      <div class="Polaris-Select">
                        <select id="themeSelect" name="theme_id" class="Polaris-Select__Input disable-while-loading" aria-invalid="false">
                          @foreach($store_themes as $theme)
                          <option value="{{ $theme->shopify_theme_id }}">{{ $theme->shopify_theme_name }}</option>
                          @endforeach
                        </select>
                        <div class="Polaris-Select__Content" aria-hidden="true">
                          <span class="Polaris-Select__SelectedOption"></span>
                          <span class="Polaris-Select__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true"><path d="M13 8l-3-3-3 3h6zm-.1 4L10 14.9 7.1 12h5.8z" fill-rule="evenodd"></path></svg></span></span>
                        </div>
                        <div class="Polaris-Select__Backdrop"></div>
                      </div>
                      <div class="Polaris-Labelled__HelpText">We'll use this theme to copy your settings</div>
                    </div>
                  


                  <div class="Polaris-Stack__Item" style="width: 100%">
                    <div class="Polaris-Labelled__LabelWrapper">
                      <div class="Polaris-Label">
                        <label for="Theme-Name" class="Polaris-Label__Text">Name your new theme</label>
                      </div>
                    </div>
                    <div class="Polaris-TextField">
                      <input class="Polaris-TextField__Input" type="text" name="Theme-Name" aria-describedby="Theme Name" aria-labelledby="Theme Name" aria-invalid="false" aria-multiline="false" value="Debutify {{ $version }}">
                      <div class="Polaris-TextField__Backdrop"></div>
                    </div>
                    <div class="Polaris-Labelled__HelpText">This new theme will be added to your theme library as unpublished</div>
                  </div>
                  

                  
                  
                </div>
                
              </form>



                </section>
              </div>
            </div>
            <div class="Polaris-Modal-Footer">
              <div class="Polaris-Modal-Footer__FooterContent">
                <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
                  <div class="Polaris-Stack__Item Polaris-Stack__Item--fill"><span class="Polaris-TextStyle--variationSubdued" style="display: none;" id="Adding-Theme-Loading-Text">This process can take up to 10 minutes</span></div>
                  <div class="Polaris-Stack__Item">
                    <div class="Polaris-ButtonGroup">
                      <div class="Polaris-ButtonGroup__Item">
                        <button type="button" class="Polaris-Button close-modal">
                          <span class="Polaris-Button__Content">
                            <span class="Polaris-Button__Text">Cancel</span>
                          </span>
                        </button>
                      </div>
                      <div class="Polaris-ButtonGroup__Item">
                        <button type="button" class="Polaris-Button Polaris-Button--primary download_theme btn-loading" onclick="return themedownload();">
                        <span class="Polaris-Button__Content">
                          <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Add to theme library</span></span>
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
</div>
@else
<!-- empty state -->
<div class="Polaris-EmptyState Polaris-EmptyState--withinPage">
  <div class="Polaris-EmptyState__Section">
    <div class="Polaris-EmptyState__DetailsContainer">
      <div class="Polaris-EmptyState__Details">
        <div class="Polaris-TextContainer">
          <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">
            Download Debutify theme
            <span class="Polaris-Badge Polaris-Badge--statusSuccess">{{ $version }}</span>
          </p>
          <div class="Polaris-EmptyState__Content">
            <p>Start your eCommerce journey with<br class="d-none d-sm-block"> The World's #1 Free Shopify theme.</p>
          </div>
        </div>
        <div class="Polaris-EmptyState__Actions">
          <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
            <div class="Polaris-Stack__Item">
              <form id="download_theme_form1" method="POST" action="" enctype="multipart/form-data">
                @csrf
                {{--                    <button type="submit" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading" onclick="return themedownload_post();">--}}
                  <button type="button" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge download_theme btn-loading" onclick="return themedownload_post();">
                    <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Add to theme library</span></span>
                  </button>
                </form>
              </div>
            </div>
          </div>
          <div class="Polaris-EmptyState__FooterContent">
            <div class="Polaris-TextContainer">
              <p>It will not affect your live store until you publish it.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-EmptyState__ImageContainer"><img src="/svg/empty-state-7.svg" role="presentation" alt="" class="Polaris-EmptyState__Image"></div>
    </div>
  </div>
  {{--<div class="Polaris-EmptyState">
    <div class="row text-center">
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight">
          <img src="/svg/illustration-5.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">1. Forever free</h2>
          <p>Debutify theme will always be 100% free and 100% awesome.</p>
        </div>
      </div>
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight">
          <img src="/svg/illustration-7.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">2. High converting</h2>
          <p>Built for speed and optimized for maximum conversions.</p>
        </div>
      </div>
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight">
          <img src="/svg/illustration-9.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">3. Made by the community</h2>
          <p>We understand what it takes to make a successful Shopify store and we're here to help you do it.</p>
        </div>
      </div>
    </div>
  </div>--}}
  @endif
  {{--    START::  add update add ons model--}}

  @if($is_update_addons)
  {{$is_update_addons}}
  @include ("components.updates-addons-modal")
  @endif
  {{--    END::  add update add ons model--}}
</div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
        // init shopify title bar
        {{--
          ShopifyTitleBar.set({
            title: 'Themes',
          });
          --}}

          $(document).ready(function() {
          // show theme uploaded banner
          var themeBannerView = localStorage.getItem('themeBannerView') || '';
          if (themeBannerView == 'yes') {
            $('.themeUploadedBanner').show();
            localStorage.setItem('themeBannerView','');
          }
        });

        // open theme modal
        function openThemeModal(theme_id,title,shop_domain){
          $('.theme-title').text("Customize "+title);
          $('.customize_theme').attr('href','https://'+shop_domain+'/admin/themes/'+theme_id+'/editor');

          // show modal
          var modal = $("#themeModal");
          openModal(modal);
        }

        // open download theme modal
        function openDownloadThemeModal(){
          // show modal
          @if($is_update_addons)
          if( $(".updateAddons").hasClass("open") ){} else{
            var modal = $("#updateAddonsModal");
            openModal(modal);
          }
          @else
          var modal = $("#DownloadThemeModal");
          openModal(modal);
          @endif
        }

        // refresh theme function
        function refreshThemes(){
          loadingBarCustom();
          var form = document.getElementById('download_theme_form');
          form.setAttribute("action","get_theme_refresh");
          form.submit();
        }

        // theme download > 1
        function themedownload(){
          loadingBarCustom();
          var form = document.getElementById('download_theme_form');
          form.setAttribute("action","{{ route('download_theme_post') }}");
          //$("input#Copy-Custom-Code").attr("disabled", true);
          //$("input#Copy-Theme-Settings").attr("disabled", true);
          $("#Adding-Theme-Loading-Text").show();

          $.ajax({
            url: '/app/theme',
            type: 'POST',
            data: $('#download_theme_form').serialize(),
            success: function(result) {
              loadingBarCustom(false);

              if(result.status == 'ok' && result.is_beta_theme != 1){
                localStorage.setItem('themeBannerView','yes');
                window.location = "{{config('env-variables.APP_PATH')}}add_ons/success";
              }else{
                localStorage.setItem('themeBannerView','yes');
                window.location = "{{config('env-variables.APP_PATH')}}themes";
              }
            }
          });
        }

        // first theme download
        function themedownload_post(){
          loadingBarCustom();
          var form = document.getElementById('download_theme_form1');
          form.setAttribute("action","{{ route('theme_download_post') }}");
          $.ajax({
            url: '/app/theme/download',
            type: 'POST',
            data: $('#download_theme_form1').serialize(),
            success: function(result) {
              loadingBarCustom(false);

              if(result.status == 'ok' && result.is_beta_theme != 1){
                localStorage.setItem('themeBannerView','yes');
                window.location = "{{config('env-variables.APP_PATH')}}add_ons/success";
              }else{
                localStorage.setItem('themeBannerView','yes');
                window.location = "{{config('env-variables.APP_PATH')}}themes";
              }
            }
          });
        }

        $(window).on("load", function() {
          loadingBarCustom(false);
        });


      
        $(document).ready(function(){
          $("#Theme-Checkbox-Group-One").on("click", function(e) {
            if (!$("#Copy-Theme-Settings").is(':checked') && !$("#Copy-Custom-Code").is(':checked')) {
              $("#Hide-Theme-Duplicate-Options-Two").hide();
            }
            else {
              $("#Hide-Theme-Duplicate-Options-Two").show();
            }
          });

          $("#Theme-Checkbox-Group-Two").on("click", function(e) {
            if (!$("#Copy-Theme-Settings").is(':checked') && !$("#Copy-Custom-Code").is(':checked')) {
              $("#Hide-Theme-Duplicate-Options-Two").hide();
            }
            else {
              $("#Hide-Theme-Duplicate-Options-Two").show();
            }

            if (!$("#Copy-Custom-Code").is(':checked')) {
              $("#Hide-Theme-Duplicate-Options-One").hide();
            }
            else {
              $("#Hide-Theme-Duplicate-Options-One").show();
              $("#Hide-Theme-Duplicate-Options-Two").show();
            }
          });
        });
           

      </script>
      @endsection
