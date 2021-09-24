
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
          <th scope="col">Last Activity</th>
          <!-- <th scope="col">Shopify referral</th> -->
       </tr>
        <tr class="warning no-result">
          <td colspan="7">No result</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($shops as $shop)

        @php
        if($shop->deleted_at){
          $shop->status = 'Inactive';
        }
        elseif (empty($shop->password)) {
          $shop->status = 'Pending';
        }
        else{
          $shop->status = 'Active';
        }
        @endphp

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
              <td><input {{ $shop->deleted_at ? 'disabled' : ''}} type="checkbox" class="is_beta_tester" value="value" name="is_beta_tester" data-email="{{ $shop->email }}" {{ $checked }} data-domain="{{ $shop->name }}" data-id="{{ $shop->id }}"></td>

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

          <td>{{ $shop->lastactivity }}</td>
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
  <div class="pagination-shop text-center">{{ $shops->appends(request()->except('page'))->links() }}</div>

<script type="text/javascript">
  $('a.page-link').click(function(evt){
      evt.preventDefault();
      var src = $(this).attr('href');
      $.ajax({
          url: src,
          dataType: "json",
          success: function(result) {
            if(result.status == 'success'){
              var html = result.html;
              $('.all-users').html(html);
            }
          }
      });
    });
  $(document).ready(function(){

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
    
  })
</script>
