@extends('layouts.admin')

@section('styles')
<style>
.results tr[visible='false'],
.no-result{
  display:none;
}
.results tr[visible='true']{
  display:table-row;
}
.card{
  height: 100%;
}
.pagination-shop .pagination{
	justify-content: center;
}
input#beta_tester {
    width: 18px;
    height: 18px;
    margin-right: 7px;
}

.is_beta_tester{
  width: 18px;
    height: 18px;
}

</style>
@endsection
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

@section('content')
<div class="row">
  <div class="col">
     
    <div class="form-group">
        <form class="form-inline" action="{{url()->current()}}" >
    			<!--@csrf-->
          <div class="form-group flex-fill">
            <input type="text" class="user_search form-control form-control-lg w-100" name="q" id="search" placeholder="Search users.." value="{{ $keyword }}">
          </div>
    		</form>
    </div>

    <!-- Button trigger modal -->
      @php
            if(Session::get('email_not_exists')){
                if(!empty(Session::get('email_not_exists'))){
                  echo '<div class="alert alert-danger" role="alert">"'.Session::get('email_not_exists').'" These emails do not exist.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                }
            }

            if(Session::get('email_exists')){
                  if(!empty(Session::get('email_exists'))){
                    echo '<div class="alert alert-success" role="alert"> Beta Tester User successfully Added!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                  }
            }
          

      @endphp

      <div class="float-left"> 
          <div class="form-group">
             <label><input type="checkbox" id="beta_tester" value="show_all_beta_user" name="beta_tester">Show Beta User</label>
          </div>
      </div> 
      <div class="float-right"> 
        <div class="form-group">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#beta_test_model_form">
            Add beta tester
          </button>
        </div>
      </div>

    <div class="all-users">
      <div class="table-responsive rounded">
        <table class="table table-bordered table-hover mb-2 results">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Shop ID</th>
              <th scope="col">Status</th>
              <th scope="col">Date added</th>
              <th scope="col">Email</th>
              <th scope="col">Domain</th>
              <th scope="col">Plan</th>
              <th scope="col">Beta Tester</th>
              <th scope="col">Trial</th>
              <th scope="col">Script Tags</th>
              {{-- <th scope="col">Last Activity</th> --}}
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
              <th scope="col">{{ $shop->shop_id }}</th>
              <td>
                @if ($shop->status == 'Active')
                <span class="badge badge-primary">{{$shop->status}}</span>
                @else
                <span class="badge badge-light">{{$shop->status}}</span>
                @endif
              </td>
              <td>{{ $shop->created_at }}</td>
              <td>
                <div>{{ $shop->email }}</div>
                @if (isset($shop->paypalSubscription->paypal_email))
                <br/>
                <div>{{ $shop->paypalSubscription->paypal_email }} (Paypal)</div>
                @endif
              </td>
              <td>{{ $shop->name }}<br>{{ $shop->custom_domain }}</td>
              <td>
              @if($shop->alladdons_plan == null || $shop->alladdons_plan == 'Freemium')
                @if($shop->trial_days)
                <span class="badge badge-primary">Trial ({{$shop->count}})</span>
                @else

                  @if($shop->status != 'Pending')
                  <span class="badge badge-light">Freemium ({{$shop->count}})</span>
                  @endif

                @endif
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
              @php
                  $checked = "";
                if($shop->is_beta_tester == 1){
                    $checked = "checked";
                }
              @endphp
              <td><input {{ $shop->deleted_at ? 'disabled' : ''}} type="checkbox" name="checkbox" class="is_beta_tester" value="value" name="is_beta_tester" data-email="{{ $shop->email }}" {{ $checked }} data-domain="{{ $shop->name }}" data-id="{{ $shop->id }}"></td>

              <td>
                <form id="free_trialdays_form" method="POST" action="{{ route('addtrialdays') }}" enctype="multipart/form-data">
                  @csrf
                  <input type='hidden' name='email' value="{{ $shop->email }}">
                  <input type='hidden' name='shopify_domain' value="{{ $shop->name }}">
                  @if($shop->alladdons_plan == null || $shop->alladdons_plan == 'Freemium')
                  <input type='number' name='trial_days' value="{{ $shop->trial_days }}" class="form-control mb-2" min="0" max="60">
                  <button class="btn btn-secondary btn-sm btn-block btn-ladda" data-style="zoom-in" onclick="return addfreetrial();">Update trial</button>
                  @endif
                </form>
              </td>
              
              <td>
                <form id="admin_refresh_script_tags" method="POST" action="{{ route('refresh_script_tags') }}">
                  @csrf
                  <input type='hidden' name='shopify_domain' value="{{ $shop->name }}">
                  <button class="btn btn-secondary btn-sm btn-block btn-ladda" data-style="zoom-in" onclick="return adminRefreshScriptTags();">Refresh </button>
                </form>
              </td>

              {{-- <td>{{ $shop->lastactivity }}</td> --}}
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
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="beta_test_model_form" tabindex="-1" role="dialog" aria-labelledby="beta_test_model_form" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="beta_test_model_form">Add Beta Tester</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('save_beta_tester_users') }}" method="post" id="beta_tester_form">
        @csrf
      <div class="modal-body">
          <div class="form-group">
            <label for="message-text" class="col-form-label">Emails: <span></span></label>
            <textarea class="form-control" id="beta_email" name="beta_email" required></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_beta_tester_btn" onclick="beta_tester_form()">Save changes</button>
      </div>
      </form>

    </div>
  </div>
</div>
@endsection


@section('scripts')

<script>
  $(document).ready(function() {

    src = "{{ route('users_search') }}";
    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    query : request.term
                },
                success: function(result) {
                  if(result.status == 'success'){
                    var html = result.html;
                    $('.all-users').html(html);
                  }
                }
            });
        },
        minLength: 0,
    });


     // show all beta tester  
       $('#beta_tester').change(function() {
            if(this.checked) {
               var check_or_uncheck = 1;
            }else{
               var check_or_uncheck = 0;
            }
             $.ajax({
              url: '{{ route('get_all_beta_users')}}',
              type: 'POST',
              data: { _token: "{{ csrf_token() }}", beta_tester_user: check_or_uncheck, show_all_beta_tester:"show_all_beta_tester" },
              dataType: 'JSON',
              success: function(result) {
                  if(result.status == 'success'){
                        var html = result.html;
                        $('.all-users').html(html);
                      }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.log("error");
              }
          });
            console.log($('#textbox1').val(this.checked));        
        });
     // show all beta tester  

       $('input.is_beta_tester').change(function() {
        if(this.checked) {
           var beta_tester = 1;
        }else{
           var beta_tester = 0;
        }

        var user_email = $(this).attr("data-email");
        var data_domain = $(this).attr("data-domain");
        var user_id = $(this).attr("data-id");

         $.ajax({
          url: '{{ route('save_beta_tester_user')}}',
          type: 'POST',
          data: { _token: "{{ csrf_token() }}", save_beta_tester_user: beta_tester, user_email: user_email, data_domain: data_domain, user_id: user_id },
          dataType: 'JSON',
          success: function(result) {
              if(result.status == 'success'){
                    swal("Thanks", result.message, "success");
                  }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log("error");
          }
      });
    });

  });

  function changefreeaddons(){
    var form = document.getElementById('free_Addons_form');
    form.submit();
  }
  function addfreetrial(){
    var form = document.getElementById('free_trialdays_form');
    form.submit();
  }

  function adminRefreshScriptTags() {
    var form = document.getElementById('admin_refresh_script_tags');
    form.submit();
  }
  
  function beta_tester_form() {
    var emails = $('textarea#beta_email').val();
    if(emails == null || emails == ""){
        $('textarea#beta_email').addClass('is-invalid');
        return false;
    }
    $('.add_beta_tester_btn').prop('disabled', true);
    document.getElementById("beta_tester_form").submit();
  }  
</script>
@endsection
