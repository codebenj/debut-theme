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
            <h4 class="card-header">Modify Integration</h4>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('edit_partner', $partner->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="version">Integration Name</label>
                        <input class="form-control" type="text" required name="p_name" value="{{ $partner->name }}">

                    </div>
					<div class="form-group">
                        <label for="version">Slug</label>
                        <input class="form-control" type="text" name="slug" value="{{ $partner->slug }}">
                    </div>
                    <div class="form-group">
                        <label for="version">Categories</label>
                        <select name= "categories[]" class="category" multiple>
                            @foreach ($partner->categories as $category)
                            <option value="{{ $category }}" selected>{{ $category }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
						<label for="version">Integration Description</label>
						<textarea class="ckeditor-description form-control" name="p_description">{{ $partner->description }}</textarea>
					</div>
                     <div class="form-group">
                         <label for="feature_image">Upload New Image File(Will Delete Previous File Automatically)</label>
                         <input type="file" class="form-control-file" id="p_logo" name="p_logo" accept="image/x-png,image/gif,image/jpeg">
                     </div>
                     <div class="form-group">
                         <div class="filename">Last Used Logo</div>
                         <input type="hidden" value="{{ $partner->logo }}" name="last_used">
                     </div>
                     <div class="pekecontainer_prev">
                         <ul></ul>
                         <div class="row pkrw" rel="0">
                             <div class="col-lg-2 col-md-2 col-xs-4">
                                 <img class="thumbnail" src="{{ $partner->logo }}" height="64">
                             </div>
                             <div class="col-lg-2 col-md-2 col-xs-2">
                                 <a href="javascript:void(0);" class="btn btn-danger pkdel">Will Get Deleted Automatically</a>
                             </div>
                         </div>
                     </div>
					<div class="form-group">
                        <label for="version">Integration link</label>
                        <input class="form-control" type="url" placeholder="https://example.com" name="p_link" value="{{ $partner->link }}">
                    </div>
                    <div class="form-group">
						<label for="version">Integration Offer Description</label>
						<input class="form-control" type="text" name="p_offer_description" value="{{ $partner->offer_description }}">
					</div>
                    <div class="form-group">
						<label for="version">Page Heading</label>
						<input class="form-control" type="text" name="page_heading" value="{{ $partner->page_heading }}">
					</div>
                    <div class="form-group">
						<label for="version">Page Subheading</label>
						<input class="form-control" type="text" name="page_subheading" value="{{ $partner->page_subheading }}">
					</div>
                    <div class="form-group">
						<label for="short_description">Short Description</label>
						<textarea class="form-control" name="short_description">{{ $partner->short_description }}</textarea>
					</div>
                    <div class="form-group">
						<label for="version">SEO Title</label>
						<input class="form-control" type="text" name="seo_title" value="{{ $partner->seo_title }}">
					</div>
                    <div class="form-group">
						<label for="version">SEO Description</label>
						<input class="form-control" type="text" name="seo_description" value="{{ $partner->seo_description }}">
					</div>
					<div class="form-group">
                        <label for="documentation_link">Documentation Link</label>
                        <input class="form-control" type="url" placeholder="https://example.com" name="documentation_link" value="{{ $partner->documentation_link }}">
                    </div>
					<div class="form-group">
                        <label for="about_link">About Link</label>
                        <input class="form-control" type="url" placeholder="https://example.com" name="about_link" value="{{ $partner->about_link }}">
                    </div>
                    <div class="form-group">
                        <label for="supported_countries">Supported Countries</label>
                        <select name= "supported_countries[]" class="supported_country" multiple>
                            @foreach ($partner->supported_countries as $country)
                            <option value="{{ $country->name }}" selected>{{ $country->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="popular" id="popular"  {{ $partner->popular == 1 ?"checked" : "" }} >
                            <label class="form-check-label" for="popular">Mark Integration as Popular</label>
                        </div>
                    </div>
                    <div class="accordion" id="accordionImage">
                        @foreach($partner->images as $key => $image)
                        <div class="card image panel" data-id="image-{{ $key }}">
                            <div class="card-header collapsed p-3" id="image-{{ $key }}" data-toggle="collapse" data-target="#mcollapse-{{ $key }}" aria-expanded="false" aria-controls="mcollapse-{{ $key }}">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white">
                                            <span class="fas fa-grip-vertical"></span>
                                        </span>
                                    </div>
                                    <input required type="text" class="form-control" name="image_title[]" id="image_title_{{ $key }}" placeholder="Title" value="{{ $image->title }}">
                                    <button type="button" onclick="return deleteImage(this,'image-{{ $key }}');" class="btn text-primary"><span class="fas fa-trash-alt"></span></button>
                                </div>
                            </div>
                            <div id="mcollapse-{{ $key }}" class="card-body collapse" aria-labelledby="image-{{ $key }}" data-parent="#accordionImage">
                                <img class="thumbnail" src="{{ $image->image_path }}" height="64">
                                <input type="hidden" class="form-control" name="image_file[]" id="image_file_{{ $key }}"  placeholder="Title" value="{{ $image->image_path }}">
                                <div class="form-group">
                                    <label class="d-block" for="image_desc_{{ $key }}">Description</label>
                                    <textarea required rows="4" class="form-control" id="image_desc_{{ $key }}" name="image_desc[]">{{ $image->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
						<button type="button" class="btn btn-outline-primary btn-block" id="add_image">
						<span class="fas fa-plus"></span>
							Add new image
						</button>
					</div>
                    <button type="submit" class="btn btn-primary btn-lg">Submit Integration</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@section("scripts")
<script type="text/javascript">
    var  src = "{{ route('upload_partner_logo') }}";
    var image_uploaded;

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

			var html = '<div class="card mb-3 image panel"><div class="card-header collapsed p-3" id="image-'+cur_image+'" data-toggle="collapse" data-target="#mcollapse-'+cur_image+'" aria-expanded="false" aria-controls="mcollapse-'+cur_image+'"><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-primary text-white"><span class="fas fa-grip-vertical"></span></span></div><input type="text" class="form-control" required name="image_title['+(cur_image-1)+']" id="image_title_'+cur_image+'" placeholder="Title"></div></div><div id="mcollapse-'+cur_image+'" class="card-body collapse" aria-labelledby="image-'+cur_image+'" data-parent="#accordionImage"><div class="form-group"><label class="d-block" for="image_file_'+cur_image+'">Image</label><input class="form-control" required id="image_file_'+cur_image+'" name="image_file['+(cur_image-1)+']" type="file"></div><div class="form-group"><label class="d-block" for="image_desc_'+cur_image+'">Description</label><textarea required rows="4" class="form-control" id="image_desc_'+cur_image+'" name="image_desc['+(cur_image-1)+']"></textarea></div><button type="button" onclick="return deleteImage(this);" class="btn btn-outline-primary btn-block mt-3"><span class="fa fa-trash"></span> Delete image</button></div></div>';
			$('#accordionImage').append(html);
		});

        $('#popular').on('change', function(){
            this.value = this.checked ? 1 : 0;
        }).change();
    }); // load jquery function

    /// add typehead input 

    image_uploaded=0;
    $("form").submit(function(e){
        if($(".progress-bar").length == 1){
          if($(".progress-bar").html() != '100%' && image_uploaded != 1){
                swal("Please Wait!", "Please wait while logo is uploading!", "error");
                 e.preventDefault(e);
            }
           
        }
          
        });
   
    $("#p_logo").pekeUpload({
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
        dragText:"Drag and Drop your logo here",
        onFileSuccess:function(file,data){
            $("input[name='last_used']").val(data.url);
            image_uploaded = 1;
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