<div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-lg-4 row_upcomingLive mb-4" id='webinar__viewmore'>

    @if($webinars)
    @foreach ($webinars as $webinar)
    <div class="col">
      <div class="card rounded card_upcomingLive">
        <img src="{{ $webinar->image }}" class="card-img-top rounded mb-4" alt="..."/>
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
  @endif
  <div class='viewmore_hidden'>
    {{ $webinars->links() }}
  </div>
</div>

<script>
  var searchValue =  "{{ $searchValue }}" 
  var flag = 0;
  $(function() {
  console.log ( 'SEARCH VALUE',searchValue)
  $(".btn_viewMore").click(function() {
    var $ul = $("ul.pagination").last();
    var $posts = $("#webinar__viewmore");
    if($ul.last().attr('aria-disabled')) {
      console.log('End of view more');
    }
    else {
      var href =  $ul.find("a[aria-label='Next »']").last().attr("href");
      var  viewMoreUrl = href + '&query=' + searchValue
      if(flag == 0) {
        $.get(viewMoreUrl, function(result) {
        if(result.status == 'success'){
            var html = result.html;
            $('#OndemandWebinars').append(html);
            var hideViewMore = $(html).find('ul.pagination li').last();
            if(hideViewMore.last().attr('aria-disabled')) {
              $('.btn_viewMore').css('display','none')
            }
          }
      });
      flag = 1;
      }
    }
  });
});
</script>