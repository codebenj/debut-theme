{{--
@php
$breadcrumb = '';
$breadcrumb2 = '';
$breadcrumb_url = '';
$breadcrumb2_url = '';
$actual_link = explode("/", "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

//echo '<pre>';
//print_r($actual_link);
//exit();

if(empty($actual_link[2])){
  $breadcrumb = 'Dashboard';
  $breadcrumb_url = '/app'; 
}
else{
  switch($actual_link[2]){
    case 'add_ons':
      $breadcrumb = 'Add-Ons';
      $breadcrumb_url = '/app/add_ons'; 
      break;

    case 'themes':
      $breadcrumb = 'Themes';
      $breadcrumb_url = '/app/themes'; 
      break;

    case 'winning-products':
      $breadcrumb = 'Winning Products';
      $breadcrumb_url = '/app/winning-products'; 
      break;

    case 'courses':
      $breadcrumb = 'Courses';
      $breadcrumb_url = '/app/courses'; 
      break;

    case 'mentoring':
      $breadcrumb = 'Mentoring';
      $breadcrumb_url = '/app/mentoring'; 
      break;

    case 'integrations':
      $breadcrumb = 'Integrations';
      $breadcrumb_url = '/app/integrations'; 
      break;

    case 'plans':
      $breadcrumb = 'Plans';
      $breadcrumb_url = '/app/plans'; 
      break;

    case 'changelog':
      $breadcrumb = 'Changelog';
      $breadcrumb_url = '/app/changelog'; 
      break;

    case 'support':
      $breadcrumb = 'Support';
      $breadcrumb_url = '/app/support'; 
      break;

    case 'feedback':
      $breadcrumb = 'Feedback';
      $breadcrumb_url = '/app/feedback'; 
      break;

    case 'affiliate':
      $breadcrumb = 'Affiliate';
      $breadcrumb_url = '/app/affiliate'; 
      break;
  }
}
@endphp
<style type="text/css">
  .Polaris-Page-Header__Navigation{
    margin-top: 20px;
  }
  .Polaris-Breadcrumbs__Breadcrumb{
    float: left;
    font-size: 1.2em;
  }
  .breadcrumb-by-debutify{
    font-size: 1.2em;
  }
  @media only screen and (max-width: 768px) {
    .breadcrumb-link-first, .breadcrumb-link-second, .breadcrumb-by-debutify{
      display: none;
    }
    .Polaris-Page-Header__Navigation{
      margin-top: 40px;
    }
  }
</style>
<div class="Polaris-Page-Header__Navigation">
  <div class="Polaris-Page-Header__BreadcrumbWrapper">
    <nav role="navigation">
      
      <a class="Polaris-Breadcrumbs__Breadcrumb" href="/app" data-polaris-unstyled="true">
        <span class="Polaris-Breadcrumbs__ContentWrapper">
          <span class="Polaris-Breadcrumbs__Icon">
            <span class="Polaris-Icon">
              <img src="/images/debutify_icon.png" class="Polaris-Icon__Svg">
            </span>
          </span>
          <span class="Polaris-Breadcrumbs__Content" style="margin-left: 5px;">{{ config('shopify-app.app_name') }}</span>
        </span>
      </a>
      @if($breadcrumb)
      <a class="Polaris-Breadcrumbs__Breadcrumb breadcrumb-link-first" style="margin-top: -5px; margin-left: 5px;" href="{{ $breadcrumb_url }}" data-polaris-unstyled="true">
         / {{ $breadcrumb }}
      </a>
      @endif

      @if($breadcrumb2)
      <a class="Polaris-Breadcrumbs__Breadcrumb breadcrumb-link-second" style="margin-top: -5px; margin-left: 12px;" href="/app" data-polaris-unstyled="true">
         / {{ $breadcrumb2 }}
      </a>
      @endif

    </nav>
  </div>
  <div class="Polaris-Page-Header__PaginationWrapper breadcrumb-by-debutify">
    <span style="color: #637381">
      by Debutify
    </span>
  </div>
</div>      
--}}