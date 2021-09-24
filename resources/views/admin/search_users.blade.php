<div class="table-responsive rounded">
      <table class="table table-bordered table-hover mb-2 results">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Status</th>
            <th scope="col">Date added</th>
            <th scope="col">Email</th>
            <th scope="col">Domain</th>
            <th scope="col">Plan</th>
            <!-- <th scope="col">Shopify referral</th> -->
          </tr>
          <tr class="warning no-result">
            <td colspan="7">No result</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($shops as $shop)
          <tr>
            <th scope="col">{{ $shop->id }}</th>
            <td>
              @if ($shop->status == 'Active')
              <span class="badge badge-primary">{{$shop->status}}</span>
              @else
              <span class="badge badge-light">{{$shop->status}}</span>
              @endif
            </td>
            <td>{{ $shop->created_at }}</td>
            <td>{{ $shop->email }}</td>
            <td>{{ $shop->name }}<br>{{ $shop->custom_domain }}</td>
            <td>
            @if($shop->alladdons_plan == null || $shop->alladdons_plan == 'Freemium')
              <span class="badge badge-light">Freemium</span>
            @endif
            @if($shop->alladdons_plan == 'basic')
              <span class="badge badge-info">Basic ({{$shop->count}})</span>
            @endif
            @if($shop->alladdons_plan == 'Starter')
              <span class="badge badge-success">Starter ({{$shop->count}})</span>
            @endif
             @if($shop->alladdons_plan == 'Hustler')
              <span class="badge badge-danger">Hustler ({{$shop->count}})</span>
            @endif
             @if($shop->alladdons_plan == 'Master')
              <span class="badge badge-warning">Master ({{$shop->count}})</span>
            @endif
            </td>
            {{--<td>
              <form id="free_Addons_form" method="POST" action="{{ route('freeaddon') }}" enctype="multipart/form-data">
              @csrf
              <input type='hidden' name='email' value="{{ $shop->email }}">
              <input type='hidden' name='shopify_domain' value="{{ $shop->name }}">
              <input type='hidden' name='status' value="{{ $shop->referral }}">
              @if($shop->referral)
              <span class="d-none">Referral</span>
              <button class="btn btn-secondary btn-sm btn-block btn-ladda" data-style="zoom-in" onclick="return changefreeaddons();"><span class="fas fa-times iconshow"></span></button>
              @else
              <button class="btn btn-light btn-sm btn-block freeaddon_change" onclick="return changefreeaddons();"><span class="fas fa-plus iconshow"></span><span class="spinner-border text-dark spinner" style="display: none;"></span></button>
              @endif
              </form>
            </td>--}}
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="pagination-shop text-center">{{ $shop_pagination->links() }}</div>

3
    <!--  if ($request->ajax()) {
        return \Response::json(\View::make('admin.search_users', array('shops' => $allmix,'shop_pagination' => $shop,))->render());
       } -->
2
      <!-- if($request->query('search')){
        $shop =User::where('email', 'like', '%'.$request->query('search').'%')->paginate(100);
      }else{ // }-->
1
<!-- <div class="all_data">
         @include('admin.search_users')
      </div> -->
<script>
$(window).on('hashchange', function() {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getDatas(page);
        }
    }
});
$(document).ready(function() {
    $(document).on('click', '.pagination a', function (e) {
        var url = $(this).attr('href');
        getDatas($(this).attr('href').split('page=')[1]);
        e.preventDefault();
    });
});
function getDatas(page) {
    $.ajax({
        url : 'search?page=' + page,
        type : "get",
        dataType: 'json',
        data:{
            search: $('.search').val()
        },
    }).done(function (data) {
        $('.all_data').html(data);
        location.hash = page;
    }).fail(function (msg) {
        alert('not found');
    });
}
  $(document).ready(function() {
    src = "{{ route('search') }}";
    $(".search").keyup(function(){
    var search = $(".search").val();
    console.log(search);
    $.ajax({
         url: src,
         dataType: "json",
         data: {'search': search},
         success: function(result) {
          console.log(result);
           $('.all_data').html(result);
              // if(result.status == 'found'){
              //   var html = result;
              //   $('.all_data').html(html);
              // }
              // else{
              //     $('#myTable').html('<p>No Result found.</p>');
              // }
           // response(result.html);
         }
     });
  });
  //          $(".search").autocomplete({

  //              source: function(request, response) {
  //                  console.log(request.term);
  //                  // if(request.term !==''){
  //                  //  var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{1,4}$/i;
  //                  //      if (testEmail.test(request.term)){
  //                  //          var data = {
  //                  //         email : request.term}
  //                  //     }else{
  //                  //       var data = {
  //                  //         search : request.term}
  //                  //     }
  //                  // }else{
  //                  //    var data = {
  //                  //         all : 'all'}
  //                  // }
  //                       $.ajax({
  //                      url: src,
  //                      dataType: "json",
  //                      data: {'search': request.term},
  //                      success: function(result) {
  //                       console.log(result);
  //                        $('.all_data').html(result);
  //                           // if(result.status == 'found'){
  //                           //   var html = result;
  //                           //   $('.all_data').html(html);
  //                           // }
  //                           // else{
  //                           //     $('#myTable').html('<p>No Result found.</p>');
  //                           // }
  //                        // response(result.html);
  //                      }
  //                  });

  //              },
  //              minLength: 0,
  //          });
  });
</script>
