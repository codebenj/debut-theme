@extends('layouts.debutify')
@section('title','product research')
@section('view-winning-products','view-winning-products')



@if($all_addons != 1)
@section('bannerTitle','available only on Paid plans')
@section('bannerLink','upgrade to '. $starter .', '. $hustler . ' or '. $guru .' plans')
@endif

@section('styles')
<style>
.container-product-img{
  width: 100%;
  padding-top: 100%;
  position: relative;
  overflow: hidden;
}
.grid-product-img{
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
.grid-product-wrapper{
  overflow: hidden;
}
.grid-product-title{
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.video-icon{
  position: absolute;
  top:10px;
  left: 10px;
  color:#6371c7;
  background-color: #fff;
  border-radius: 100%;
  overflow: hidden;
  z-index: 10;
  font-size: 20px;
  border: 2px solid #fff;
}
.new-product{
  position: absolute;
  top:10px;
  right: 10px;
  z-index: 10;
}
.pagination .Polaris-Button{
  min-width: 54px;
}
.grid-product-img{
  cursor: pointer;
}
.no-results p{
  text-align: center;
}
.no-results .container-product-img {
    padding-top: 0;
}
.no-results .Polaris-TextContainer.Polaris-TextContainer--spacingTight.d-flex {
    justify-content: center;
}
.no-results .container-product-img.rounded img {
    max-width: 50%;
    margin: 0px auto 0px;
    position: relative;
    display: block;
}
</style>
@endsection

@section('content')

@include("components.skeleton")

@php
if($all_addons == 1 || $master_shop)
{
  if($master_shop && !$is_paused)
  {
    $shop_plan = $guru;
    $alladdons_plan = $guru;
  }
}
@endphp

<div id="dashboard" style="display:none;">
@if($all_addons == 1 && !$is_paused)

  @include("components.product-filters")

  @if($alladdons_plan != $guru)
  <div class="upgradeAlert Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-describedby="Banner14Content">
    <div class="Polaris-Banner__Dismiss"><button onclick="return closeAlert('upgradeAlert')" type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path>
              </svg></span></span></span></button></div>
    <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle cx="10" cy="10" r="9" fill="currentColor"></circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path>
        </svg></span></div>
    <div>
      <div class="Polaris-Banner__Content" id="Banner14Content">
        <p>
          Get access to
          @if($alladdons_plan == $starter)
          <span class="Polaris-TextStyle--variationStrong">Silver</span> and
          @endif
          <span class="Polaris-TextStyle--variationStrong">Gold</span> oportunity level products when
          <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Link Polaris-Link--monochrome">upgrading to the {{$guru}} plan</a>
        </p>
      </div>
    </div>
  </div>
  @endif

  <div class="all-products">
    @include("components.product-result")
  </div>
  @else
  <!-- empty state -->
  <div class="Polaris-EmptyState Polaris-EmptyState--withinPage">
    <div class="Polaris-EmptyState__Section">
      <div class="Polaris-EmptyState__DetailsContainer">
        <div class="Polaris-EmptyState__Details">
          <div class="Polaris-TextContainer">
            <p class="Polaris-DisplayText Polaris-DisplayText--sizeMedium">
              Browse winning products
            </p>
            <div class="Polaris-EmptyState__Content">
              <p>Use our product research tool and save time finding winning products on-the-go.</p>
            </div>
          </div>
          <div class="Polaris-EmptyState__Actions">
            <div class="Polaris-Stack Polaris-Stack--alignmentCenter">
              <div class="Polaris-Stack__Item">
                <a href="{{config('env-variables.APP_PATH')}}plans" class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeLarge">
                  <span class="Polaris-Button__Content"><span class="Polaris-Button__Text">Unlock product research</span></span>
                </a>
              </div>
            </div>
          </div>
          <div class="Polaris-EmptyState__FooterContent">
            <div class="Polaris-TextContainer">
              <p>20+ hand-picked products added every week.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="Polaris-EmptyState__ImageContainer"><img src="/svg/empty-state-10.svg" role="presentation" alt="" class="Polaris-EmptyState__Image"></div>
    </div>
  </div>

  <div class="Polaris-EmptyState">
    <div class="row text-center">
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight layout-item">
          <img src="/svg/illustration-4.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">1. Unique products</h2>
          <p>Each of our products is hand-picked by our expert product analyst. No robots, no automation.</p>
        </div>
      </div>
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight layout-item">
          <img src="/svg/illustration-11.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">2. Advanced spy tools</h2>
          <p>Spy on competitor's websites, live Facebook ads, Google trends, YouTube video, Google trends and more.</p>
        </div>
      </div>
      <div class="col-sm">
        <div class="Polaris-TextContainer  Polaris-TextContainer--spacingTight layout-item">
          <img src="/svg/illustration-6.svg" alt="" class="img-fluid" style="height:100px">
          <h2 class="Polaris-Heading">3. Product analysis</h2>
          <p>Hand-written product description, Profit margin calculation, Facebook ad interests and more.</p>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
      // ESDK page and bar title
      {{--
      ShopifyTitleBar.set({
        title: 'Winning Products',
      });
      --}}

      // trigger button click on image
      $(document).on("click", ".grid-product-img", function(){
        $(this).closest(".grid-product-wrapper").find("button").trigger("click");
      });

      // open product modal
      function openProductModal(name,img,price,cost,profit,aliexpress,facebook,youtube,competitor,google,age,gender,placement,saturation,interest,opinion,description,video){
        $(".product-name").text(name);
        $(".product-aliexpress").attr("href",aliexpress);
        $(".product-price").text(price);
        $(".product-cost").text(cost);
        $(".product-profit").text(profit);

        var breakeven = (price/(price - cost)).toFixed(2);
        $(".product-breakeven").text(breakeven);
        $(".product-age").text(age);
        $(".product-gender").text(gender);
        $(".product-placement").text(placement);

        // opinion
        $(".product-opinion").html(opinion);
        if(opinion){
          $(".opinion-card").show();
        } else{
          $(".opinion-card").hide();
        }

        // description
        $(".product-description").html(description);
        if(description){
          $(".description-card").show();
        } else{
          $(".description-card").hide();
        }

        // interests
        var interest_target = interest.split(',');
        var target =[];
        $.each(interest_target, function (index, interest) {
          target.push('<div class="Polaris-Stack__Item"><span class="Polaris-Badge"><span class="Polaris-Badge__Content">'+interest+'</span></span></div>');
        });
        $('.interest_target').html(target);

        // saturation
        var html = '';
        if(saturation == 'gold'){
           html='<span class="Polaris-Badge Polaris-Badge--statusSuccess"><span class="Polaris-Badge__Content">Gold</span></span>';
        }else if(saturation == 'silver'){
          html='<span class="Polaris-Badge Polaris-Badge--statusAttention"><span class="Polaris-Badge__Content">Silver</span></span>';
        }else if(saturation == 'bronze'){
          html='<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Content">Bronze</span></span>';
        }
        $('.product-saturation').html(html);

        // links
        var spytools = [];
        if(facebook){
          spytools.push('<p><a href="'+facebook+'" target="_blank" class="product-facebook"><span class="fab fa-facebook fa-fw"></span> Facebook ads</a></p>');
        }
        if(youtube){
          spytools.push('<p><a href="'+youtube+'" target="_blank" class="product-youtube"><span class="fab fa-youtube fa-fw"></span> Youtube video</a></p>');
        }
        if(google){
          spytools.push('<p><a href="'+google+'" target="_blank" class="product-google"><span class="fab fa-google fa-fw"></span> Google trends</a></p>');
        }
        if(competitor){
          spytools.push('<p><a href="'+competitor+'" target="_blank" class="product-competitor"><span class="fas fa-globe fa-fw"></span> Shopify website</a></p>');
        }
        $('.spytools').html(spytools);

        // images
        // var img = '/images/product/'+img;
        $(".product-img").attr("src",img);

        // video
        if(video){
          // $('.product-video').html('<video class="rounded" width="100%" height="auto" controls><source src="/product_video/'+video+'" type="video/mp4"><source src="/product_video/'+video+'" type="video/ogg"></video>');
          $('.product-video').html('<video class="rounded" width="100%" height="auto" controls><source src="'+video+'" type="video/mp4"><source src="'+video+'" type="video/ogg"></video>');
          $(".video-card").show();
        } else{
          $('.product-video').html('');
          $(".video-card").hide();
        }

        // open modal
        var modal = $("#productModal");
        openModal(modal);
      }

      function productFilter(){
        loadingBarCustom();

        $(".loader").show();
        var search = $('#search').val();
        var cat_val = $('#SelectCategory').val();
        var saturation_val = $('#SelectSaturation').val();
        var profit_val = $('#SelectProfit').val();
        var filterUrl = "{{ route('filter_products') }}";
        $.ajax({
            url: filterUrl,
            dataType: "json",
            data: {
                q : search,
                category : cat_val,
                saturation : saturation_val,
                profit : profit_val
            },
            success: function(result) {
              if(result.status == 'success'){
                loadingBarCustom(false);

                $(".loader").hide();
                var html = result.html;
                $('.all-products').html(html);
              }
            }
        });
      }

      $("#search").autocomplete({
          source: function(request, response) {
            productFilter();
          },
          minLength: 0,
      });

      $('.filter-option-value').css('display','none');
      $('.'+$('#filter-type').val()).css('display','block');

      $('#filter-type').change(function(e){
        var filter = $(this).val();
        console.log('filter='+filter);
        $('.filter-option-value').css('display','none');
        $('.'+filter).css('display','block');
      });

      $('.filter-change').change(function(e){
        productFilter();
      });

      // $('button#Activator-taggedWith').click(function(e){
      //   $('#selectFilter').toggle();
      // });

      // $(document).mouseup(function (e){

      //   var container = $("#selectFilter");
      //   if (!container.is(e.target) && container.has(e.target).length === 0){
      //     container.fadeOut();
      //   }
      // });

      // $('.lodder').click(function(){
      //   $("#load").show();
      // });
  </script>
@endsection
