@extends('layouts.admin')
@section('styles')
<style type="text/css">
    a.theme_dashboard button.btn.btn-primary {
        margin-bottom: 10px;
    }
    .list-group-item.active{
    	color: #000000;
    }
    .col-xs-4.px-2 {
	    padding-left: 20px!important;
	}
	#cke_announcement_top_bar{
		width: 100% !important;
	}
</style>
@endsection


@section('content')

<div class="container-fluid">
<div class="row" id="wrapper">
    <div class="bg-light border-right col-md-3" id="sidebar-wrapper">
      <div class="list-group list-group-flush">
        <a href="#announcement_bar" data-toggle="pill" class="list-group-item list-group-item-action bg-light active">Announcement bar</a>
      </div>
    </div>
    <div id="page-content-wrapper" class="col-md-9">
		    <div class="tab-content">
		      	{{--  save announcement --}}
		        <div id="announcement_bar" class="tab-pane fade in active show">
		            <h6>Announcement bar</h6>
		            <div class="input-group">
					  <textarea class="ckeditor-description form-control" name="announcement_top_bar" id="announcement_top_bar">
					  	@if(isset($cms_data['announcement_top_bar']['content']))
					  			{{ $cms_data['announcement_top_bar']['content'] }}
					  	@endif
					  </textarea>
					  <input type="hidden" name="copyright_text" value="1">
				    </div>
				    <div class="mt-4 text-right">
					    <button type="button" class="btn btn-primary cms_dashboard_btn" id="announcement_update_btn" data-cms="announcement_top_bar">Update</button>
					 </div>
		        </div>

		    </div>
    </div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">

    $(document).ready(function($) {
    		$(".cms_dashboard_btn").click(function(){
    			var data_title = $(this).attr('data-cms');
    			var data_content = $("#"+data_title).val();
    			// alert(data_content);
    			$.ajax({
			          url: '{{ route('save_cms_dashboard')}}',
			          type: 'POST',
			          data: { _token: "{{ csrf_token() }}", data_title: data_title, data_content: data_content},
			          dataType: 'JSON',
			          success: function(result) {
			              if(result.success == 'ok'){
                          swal("Thanks", "CMS is updated successfully!", "success");
                        }
			          },
			          error: function (jqXHR, textStatus, errorThrown) {
			            console.log('error');
			          }
			      });
    		});


    		$('.ckeditor-description').ckeditor({
	            allowedContent: true,
	            toolbar: 'Full',
		        enterMode : CKEDITOR.ENTER_BR,
		        shiftEnterMode: CKEDITOR.ENTER_P,
	        });


    });

</script>
@endsection 