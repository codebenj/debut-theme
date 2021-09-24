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
			<h4 class="card-header">Add new Update</h4>
			<div class="card-body">
				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif

				<form method="POST" action="{{ route('new_update') }}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="modal_title">Modal Title</label>
						<input type="text" class="form-control" id="modal_title" name="modal_title" placeholder="Here's what's new!" value="Here's what's new!">
					</div>
					<div class="form-group">
						<label for="version">Update Description</label>
						<textarea class="ckeditor-description form-control" name="description"></textarea>
					</div>
					<div class="form-group">
						<label for="theme_file">Upload Image File</label>
						<input type="file" class="form-control-file" id="image_file" name="image_file" accept="image/x-png,image/gif,image/jpeg">
					</div>
					<div class="form-group">
						<label for="version">Youtube Video Link</label>
						<input type="text" class="form-control" id="video_link" name="video_link" placeholder="">
					</div>
					<div class="form-group">
                        <label for="show_until">Show Until</label>
                        <input  class="form-control" type="text" placeholder="Click to show datepicker" name="show_until" id="show_until">
                    </div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label>Footer Button Text</label>
								<input type="text" value='View Changelog' class="form-control" id="footer_button_text" name="footer_button_text">
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label>Footer Button Link</label>
								<input type="text" value="{{ url('/app/changelog') }}" class="form-control" id="footer_button_link" name="footer_button_link">
							</div>
						</div>
					</div>
					<input type="hidden" name="image_path">
					<button type="submit" class="btn btn-primary btn-lg">Submit Update</button>
				</form>
			</div>
		</div>

	</div>
</div>
@endsection

@section("scripts")
<script>
	$(document).ready(function($) {
		$('#show_until').datepicker({
                dateFormat: 'yy-mm-dd'
		});
		
		$('.ckeditor-description').ckeditor({
			allowedContent: true,
		}); 
	});
	$("form").submit(function(e){
		if($(".progress-bar").length == 1){
			if($("input[name='image_path']").val() == ''){
				swal("Please Wait!", "Please wait while image is uploading!", "error");
				e.preventDefault(e);
			}
		}
	});
	$("#image_file").pekeUpload({
		notAjax:false,
		url:"{{ route('upload_update_image') }}",
		data:{ '_token' : '{{ csrf_token() }}','last_used': $("input[name='last_used']").val() },
		allowedExtensions:"jpeg|jpg|png|gif",
		showPreview:true,
		dragMode:true,
		onSubmit:false,
		bootstrap:true,
		delfiletext:"Delete",
		limit:'1',
		showPercent: true,
		limitError:"File Uploaded Already.",
		dragText:"Drag and Drop your file here",
		onFileSuccess:function(file,data){
			$("input[name='image_path']").val(data.url);
		}
	});
</script>
@endsection