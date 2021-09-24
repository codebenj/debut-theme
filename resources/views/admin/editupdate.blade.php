@extends('layouts.admin')
@section('styles')
<style type="text/css">
	a.theme_dashboard button.btn.btn-primary {
		margin-bottom: 10px;
	}
</style>
@endsection

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<div class="row">
	<div class="col">
		@if($errors->any())
		<div class="alert alert-danger">
			@foreach($errors->all() as $error)
			<p>{{ $error }}</p>
			@endforeach
		</div>
		@endif
		<div class="card">
			<h4 class="card-header">Modify Update</h4>
			<div class="card-body">
				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif

				<form method="POST" action="{{ route('edit_update', $update->id) }}">
					{{ csrf_field() }}
					<!-- <div class="form-group">
					  <label for="formGroupExampleInput">Theme Name</label>
					  <input type="text" class="form-control" id="name" name="name" placeholder="">
					</div> -->
					<div class="form-group">
						<label for="modal_title">Modal Title</label>
						<input type="text" value="{{ $update->modal_title }}" class="form-control" id="modal_title" name="modal_title" placeholder="Here's what's new!">
					</div>
					<div class="form-group">
						<label for="version">Markup Description</label>
						<textarea class="ckeditor-description form-control" name="description">{!! $update->description !!}</textarea>
					</div>
					<div class="form-group">

						<label for="theme_file">Upload New Image File(Will Delete Previous File Automatically)</label>
						<input type="file" class="form-control-file" id="image_file" name="image_file" accept="image/x-png,image/gif,image/jpeg">
					</div>
					<div class="form-group">
						<div class="filename">Last Used Image</div>
						<input type="hidden" value="{{ $update->image }}" name="last_used">
					</div>
					<div class="pekecontainer_prev">
						<ul></ul><div class="row pkrw" rel="0">
							<div class="col-lg-2 col-md-2 col-xs-4">
								<img class="thumbnail" src="{{ $update->image }}" height="64"></div>

								<div class="col-lg-2 col-md-2 col-xs-2"><a href="javascript:void(0);" class="btn btn-danger pkdel">Will Get Deleted Automatically</a>
								</div></div></div>
							</div>
							<div class="form-group">
								<label for="version">Youtube Video Link</label>
								<input type="text" value= '{{ $update->video }}' class="form-control" id="video_link" name="video_link" placeholder="">
							</div>
							<div class="form-group">
								<label for="show_until">Show Until</label>
								<input value='{{ $update->show_until }}' class="form-control" type="text" placeholder="Click to show datepicker" name="show_until" id="show_until">
							</div>
							<div class="row">
								<div class="col">
									<div class="form-group">
										<label>Footer Button Text</label>
										<input type="text" value='{{ $update->footer_button_text }}' class="form-control" id="footer_button_text" name="footer_button_text">
									</div>
								</div>
								<div class="col">
									<div class="form-group">
										<label>Footer Button Link</label>
										<input type="text" value="{{ $update->footer_button_link }}" class="form-control" id="footer_button_link" name="footer_button_link">
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn-primary btn-lg">Submit Update</button>
						</form>
					</div>
				</div>

			</div>
		</div>
		@endsection
		@section("scripts")
		<script>
			var image_uploaded;
			$(document).ready(function($) {
				$('#show_until').datepicker({
					dateFormat: 'yy-mm-dd'
				});

				$('.ckeditor-description').ckeditor({
					allowedContent: true,
				});
			});

			image_uploaded=0;
			$("form").submit(function(e){
				if($(".progress-bar").length == 1){
					if($(".progress-bar").html() != '100%' && image_uploaded != 1){
						swal("Please Wait!", "Please wait while image is uploading!", "error");
						e.preventDefault(e);
					}

				}

			});
			$(document).on('click','.pkdel',function(){
				var parent = $(this).parent('div').parent('div');
				$("input[name='last_used']").val('');
			});
			var  src = "{{ route('upload_update_image') }}";
			$("#image_file").pekeUpload({
				notAjax:false,
				url:src,
				data:{ '_token' : '{{ csrf_token() }}','last_used': $("input[name='last_used']").val() },
				allowedExtensions:"jpeg|jpg|png|gif",
				showPreview:true,
				dragMode:true,
				onSubmit:false,
				bootstrap:true,
				delfiletext:"Delete",
				limit:'1',
				limitError:"File Uploaded Already",
				dragText:"Drag and Drop your file here",
				onFileSuccess:function(file,data){
					$("input[name='last_used']").val(data.url);
					image_uploaded = 1;
				}
			});
		</script>
		@endsection