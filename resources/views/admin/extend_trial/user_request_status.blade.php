@extends('layouts.admin')
@section('styles')
<style>
  .btn-add-product{
    position: fixed;
    bottom: 30px;
    right: 30px;
  }
  .modal_main {
  display: none; 
  position: fixed; 
  z-index: 1; 
  padding-top: 100px; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgb(0,0,0); 
  background-color: rgba(0,0,0,0.4); 
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 70%;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>
@endsection
@section('content')
<div class="row">
  <div class="col">

    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif

    <div class="table-responsive rounded">
      <div id="user_request_data">
       @include("admin.extend_trial.user_request_status_table")
     </div>
   </div>

  <div id="submit_request_model" class="modal_main">
    <div id="request_proof_image" class="modall fadee" tabindex="-1">
        <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Request Proof Image</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <img src="" id="proof_image" class="img-fluid">
                </div>
                <div class="modal-footer">
                  <div class="spinner-border text-primary" role="status" style="display: none;">
                          <span class="sr-only">Loading...</span>
                  </div>
                  <button type="button" class="btn btn-success approve_status" id="approve_btn">Approve</button>
                  <button type="button" class="btn btn-danger approve_status" id="refuse_btn">Refuse</button>
                  <button type="button" class="btn btn-secondary close_btn" data-dismiss="modal">Cancel</button>
                </div>
        </div>
    </div>
  </div>


</div>
</div>


@endsection
@section("scripts")
<script type="text/javascript">

  $(document).ready(function() {
    // opoen model shwo image
                $(".user_request_approve_status").click(function(){
                  var proof_image = $(this).attr('data-image');
                  var user_id = $(this).attr('user-id');
                  var feature_id = $(this).attr('data-feature_id');
                  $('button#approve_btn, button#refuse_btn').attr('user-id', user_id);
                  $('button#approve_btn, button#refuse_btn').attr('data-feature_id', feature_id);
                  $("#request_proof_image img").attr('src', proof_image);
                  // $("#request_proof_image").modal('show');
                  $("#submit_request_model").css('display','block');
                });

            // approve and refuse button request
            $(".approve_status").click(function(){
              var request_detail = '{{ route('extend_feature_request') }}';
              $('.approve_status').attr('disabled','disabled');
              var request_status = $(this).attr('id');
              var user_id = $(this).attr('user-id');
              var feature_id = $(this).attr('data-feature_id');
              $.ajax({
                url: '{{ route('user_request_approve_refuse')}}',
                type: 'POST',
                data: { _token: "{{ csrf_token() }}", request_status: request_status, user_id: user_id, feature_id: feature_id},
                dataType: 'JSON',
                success: function(result) {
                        if(result.status == 'success'){
                                      window.location.href = request_detail;
                                    }
                                  },
                beforeSend: function() {
                  $(".spinner-border").show();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  console.log("error");
                }
              });
            });

            $(".close, .close_btn").click(function(){
              $("#submit_request_model").css('display','none');
            });

            var modal = document.getElementById("submit_request_model");

            window.onclick = function(event) {
              if (event.target == modal) {
                $("#submit_request_model").css('display','none');
              }
            }

            $(document).click(function (e) {
                if ($(e.target).is('#submit_request_model')) {
                    $('#submit_request_model').fadeOut(500);
                }

            });

});



</script>
@endsection
