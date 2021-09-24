@extends('layouts.admin')
@section('content')
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
			<h4 class="card-header">Add new Integration</h4>
			<div class="card-body">
				@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
				@endif

				<form method="POST" action="{{ route('save_new_partner') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="version">Integration Name</label>
						<input class="form-control" type="text" required name="p_name" value="{{ request()->input('p_name', old('p_name')) }}">
					</div>

					<div class="form-group">
                        <label for="version">Slug</label>
                        <input class="form-control" type="text" name="slug" value="{{ request()->input('slug', old('slug')) }}">
                    </div>

					<div class="form-group">
                        <label for="version">Categories</label>
                         <select  name= "categories[]" class="category" multiple></select>
                    </div>

					<div class="form-group">
						<label for="version">Integration Description</label>
						<textarea class="ckeditor-description form-control" name="p_description">{!! request()->input('p_description', old('p_description')) !!}</textarea>
					</div>
					<div class="form-group">
						<label for="theme_file">Integration Logo</label>
						<input type="file" class="form-control-file" id="p_logo" name="p_logo" accept="image/x-png,image/gif,image/jpeg">
					</div>
					<div class="form-group">
						<label for="version">Integration link</label>
						<input class="form-control" type="url" placeholder="https://example.com" name="p_link" value="{{ request()->input('p_link', old('p_link')) }}">
					</div>
					<div class="form-group">
						<label for="version">Integration Offer Description</label>
						<input class="form-control" type="text" name="p_offer_description" value="{{ request()->input('p_offer_description', old('p_offer_description')) }}">
					</div>
					<div class="form-group">
						<label for="version">Page Heading</label>
						<input class="form-control" type="text" name="page_heading" value="{{ request()->input('page_heading', old('page_heading')) }}">
					</div>
					<div class="form-group">
						<label for="version">Page Subheading</label>
						<input class="form-control" type="text" name="page_subheading" value="{{ request()->input('page_subheading', old('page_subheading')) }}">
					</div>
                    <div class="form-group">
						<label for="short_description">Short Description</label>
						<textarea class="form-control" name="short_description">{{ request()->input('short_description', old('short_description')) }}</textarea>
					</div>
					<div class="form-group">
						<label for="version">SEO Title</label>
						<input class="form-control" type="text" name="seo_title" value="{{ request()->input('seo_title', old('seo_title')) }}">
					</div>
					<div class="form-group">
						<label for="version">SEO Description</label>
						<input class="form-control" type="text" name="seo_description" value="{{ request()->input('seo_description', old('seo_description')) }}">
					</div>
					<div class="form-group">
						<label for="documentation_link">Documentation Link</label>
						<input class="form-control" type="url" placeholder="https://example.com" name="documentation_link" value="{{ request()->input('documentation_link', old('documentation_link')) }}">
					</div>
					<div class="form-group">
						<label for="about_link">About Link</label>
						<input class="form-control" type="url" placeholder="https://example.com" name="about_link" value="{{ request()->input('about_link', old('about_link')) }}">
					</div>
					<div class="form-group">
                        <label for="supported_countries">Supported Countries</label>
                         <select  name= "supported_countries[]" class="supported_country" multiple></select>
                    </div>
					<div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="popular" id="popular">
                            <label class="form-check-label" for="popular">Mark Integration as Popular </label>
                        </div>
                    </div>
					<div class="accordion" id="accordionImage"></div>
					<div class="form-group">
						<button type="button" class="btn btn-outline-primary btn-block" id="add_image">
						<span class="fas fa-plus"></span>
							Add new image
						</button>
					</div>
					<input type="hidden" name="image_path_logo">

					<button type="submit" class="btn btn-primary btn-lg">Submit Integration</button>
				</form>
			</div>
		</div>

	</div>
</div>
@endsection

@section("scripts")
<script type="text/javascript">
	function deleteImage(event) {
		swal({
			title: 'Are you sure you want to delete this image?',
			text: "",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then(function() {
			$(event).parents('.image').remove();
			swal("Deleted!", "Image successfully Deleted!", "success");
		});
	}

	$(document).ready(function($) {
		$("#accordionImage").sortable({
			items: ".module"
		});

		$('.ckeditor-description').ckeditor({
			allowedContent: true,
		});

		$('input[name=p_name]').on('focusout', function () {
            var slug = $("input[name='p_name']").val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
            $("input[name='slug']").val(slug);
        });

		$('#add_image').click(function(){
			var image_count = $('.image').length;
			var cur_image = image_count+1;

			if (cur_image > 5) {
                swal({
                    title: 'You cannot add more than 5 images.',
                    text: "",
                    type: 'warning',
                    confirmButtonColor: '#3085d6',
                });

                return;
            }

			var html = '<div class="card mb-3 image panel"><div class="card-header collapsed p-3" id="image-'+cur_image+'" data-toggle="collapse" data-target="#mcollapse-'+cur_image+'" aria-expanded="false" aria-controls="mcollapse-'+cur_image+'"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-primary text-white"><span class="fas fa-grip-vertical"></span></span></div><input type="text" required class="form-control" name="image_title[]" id="image_title_'+cur_image+'" placeholder="Title"></div></div><div id="mcollapse-'+cur_image+'" class="card-body collapse" aria-labelledby="image-'+cur_image+'" data-parent="#accordionImage"><div class="form-group"><label class="d-block" for="image_file_'+cur_image+'">Image</label><input class="form-control" required id="image_file_'+cur_image+'" name="image_file[]" type="file"></div><div class="form-group"><label class="d-block" for="image_desc_'+cur_image+'">Description</label><textarea rows="4" required class="form-control" id="image_desc_'+cur_image+'" name="image_desc[]"></textarea></div><button type="button" onclick="return deleteImage(this);" class="btn btn-outline-primary btn-block mt-3"><span class="fa fa-trash"></span> Delete image</button></div></div>';
			$('#accordionImage').append(html);
		});
		
		$('#popular').on('change', function(){
            this.value = this.checked ? 1 : 0;
        }).change();
	});

	$("form").submit(function(e){
		if($("input[name='image_path_logo']").val() == ''){
			swal("Please Wait!", "Please wait while image is uploading!", "error");
			e.preventDefault(e);
		}
	});

	$("#p_logo").pekeUpload({
		notAjax:false,
		url:"{{ route('upload_partner_logo') }}",
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
		dragText:"Drag and Drop your logo here",
		onFileSuccess:function(file,data){
			$("input[name='image_path_logo']").val(data.url);
			$(':input[type="submit"]').show();

		}
	});

	$('.category').tokenize2({
		tokensAllowCustom:true,
		searchFromStart:true,
		dataSource: function(search, object) {
			$.ajax('{{ route('partner_categories')}}', {
				data: { query: search },
				dataType: 'json',
				success: function(data){
					var $items = [];
					$.each(data, function(k, v){
						$items.push(v);
					});
					object.trigger('tokenize:dropdown:fill', [$items]);
				}
			});
		}
	});

	$('.supported_country').tokenize2({
		tokensAllowCustom:true,
		searchFromStart:true,
		dataSource: function(search, object) {
			$.ajax('{{ route('partner_countries')}}', {
				data: { query: search },
				dataType: 'json',
				success: function(data){
					var $items = [];
					$.each(data, function(k, v){
						$items.push(v);
					});
					object.trigger('tokenize:dropdown:fill', [$items]);
				}
			});
		}
	});
</script>
@endsection 