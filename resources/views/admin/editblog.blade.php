@extends('layouts.admin')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

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
            <h4 class="card-header">Modify Blog</h4>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <?php
                $timestamp = strtotime($blog->blog_publish_date); 
                $blog_custom_date=  date('m/d/Y', $timestamp);
                $user = auth()->user();
                ?>

                <form method="POST" action="{{ route('edit_blog', $blog->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="version">Blog Title</label>
                        <input class="form-control" type="text" required name="title" value="{{ $blog->title }}">

                    </div>

                    <div class="form-group">
                        <label for="version">Blog Slug Url</label>
                        <input class="form-control" type="text" name="blog_slug" value="{{ $blog->slug }}">
                    </div>

                    <div class="form-group">
                        <label for="blog_author">Select Author</label>
                        <select class="form-control" name="blog_author" id="blog_author">
                          <option value="">No Author</option>
                        @foreach($author_detail as $author) 
                            @php $selected = ""; @endphp
                            @if(trim($blog->author_id) == trim($author->id))
                                    @php $selected = "selected"; @endphp
                            @endif
                          <option value="{{ $author->id }}" <?php echo $selected; ?>>{{ $author->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="version">Blog Meta Description</label>
                        <textarea class="form-control" name="meta_description">{{ $blog->meta_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="version">Blog Description</label>
                        <textarea class="ckeditor-description form-control" name="description">{!! $blog->description !!}</textarea>
                        <!-- <input type="hidden" name="description" value="{{ $blog->description }}">
                        <trix-editor input="d"></trix-editor> -->
                    </div>

                     <div class="form-group">
                        <label for="version">Blog Tags</label>
                           <select  name= "blog_tags[]"  class="blog_tag" multiple>
                               @foreach ($blog_tag as $tag)
                         <option value="{{ $tag }}" selected >{{ $tag }}</option>
                            @endforeach 
                           </select>
                    </div>

                    <div class="form-group">
                        <label for="version">Blog Categories</label>
                         <select  name= "blog_categories[]" class="blog_category" multiple>
                              @foreach ($blog_category as $category)
                                <option value="{{ $category }}" selected >{{ $category }}</option>
                            @endforeach 
                         </select>
                    </div>

                    <div class="form-group">
                        <label for="version">Blog Publish Date</label>
                        <input  class="form-control" type="text" placeholder="click to show datepicker" name="blog_publish_date" id="blog_publish_date" value="<?php echo $blog->blog_publish_date; ?>">
                    </div>
                     
                    <div class="form-group">
                        <label for="feature_image">Upload New Image File(Will Delete Previous File Automatically)</label>
                        <input type="file" class="form-control-file" id="image_file" name="feature_image" accept="image/x-png,image/gif,image/jpeg">
                    </div>
                    <div class="form-group">
                        <label for="version">Image Alt Text</label>
                        <input class="form-control" type="text" name="alt_text" value="{{ $blog->alt_text }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select onchange="setAutoPublishDateVisibility(this.value, false)" autocomplete="off" class="form-control" name="status" id="status">
                          <option {{ $blog->status == 1 ? 'selected="selected"' : '' }} value="1">Active</option>
                          <option {{ $blog->status == 0 ? 'selected="selected"' : '' }} value="0">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="most_popular" id="most-popular" {{ $blog->most_popular == 1 ? "checked" : "" }}>
                            <label class="form-check-label" for="most-popular">
                                Most Popular
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="picked_by_editors" id="picked-by-editors"  {{ $blog->picked_by_editors == 1 ? "checked" : "" }}>
                            <label class="form-check-label" for="picked-by-editors">
                                Picked by Editors
                            </label>
                        </div>
                    </div>
                    <div id="auto_publish_at_container" class="form-group">
                        <div class="form-group">
                            <label for="auto_publish_at">Auto Publish Date</label>
                            <input autocomplete="off" class="form-control" type="text" placeholder="Click to show datepicker" name="auto_publish_at" id="auto_publish_at" value="{{ $blog->auto_publish_at }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Auto Publish Time</label>
                            <input autocomplete="off" class="form-control" type="text" placeholder="Click to show datepicker" name="auto_publish_time" id="auto_publish_time" value="{{ $blog->auto_publish_time }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="filename">Last Used Image</div>
                        <input type="hidden" value="{{ $blog->feature_image }}" name="last_used">
                    </div>
                    <div class="pekecontainer_prev">
                        <ul></ul>
                        <div class="row pkrw" rel="0">
                            <div class="col-lg-2 col-md-2 col-xs-4">
                                <img class="thumbnail" src="{{ $blog->feature_image }}" height="64">
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-2">
                                <a href="javascript:void(0);" class="btn btn-danger pkdel">Will Get Deleted Automatically</a>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Submit Article</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@section("scripts")
<script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<script type="text/javascript">

    var  src = "{{ route('upload_blog_image') }}";
    var image_uploaded;
    $(document).ready(function($) {
        setAutoPublishDateVisibility('{{ $blog->status }}', false);

// add date picke input
        $('#blog_publish_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#auto_publish_at').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        $('#auto_publish_time').timepicker();

    /// add aditor on input 
        $('.ckeditor-description').ckeditor({
            allowedContent: true,
        });
    /// add aditor on input 

    /// add typehead input 

       $('.blog_tag').tokenize2({
          tokensAllowCustom:true,
          searchFromStart:true,
         // dataSource:'{{ route('get_all_blog_meta')}}',
          dataSource: function(search, object){
                    $.ajax('{{ route('get_all_blog_meta')}}', {
                        data: { query: search, start: 1 ,'type':'blog_tag'},
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
    /// add typehead input 


    /// add typehead input 

    $('.blog_category').tokenize2({
          tokensAllowCustom:true,
          searchFromStart:true,
         // dataSource:'{{ route('get_all_blog_meta')}}',
          dataSource: function(search, object){
                    $.ajax('{{ route('get_all_blog_meta')}}', {
                        data: { query: search, start: 1 ,'type':'blog_category'},
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


    }); // load jquery function

    /// add typehead input 

    image_uploaded=0;
    $("form").submit(function(e){
        if($(".progress-bar").length == 1){
          if($(".progress-bar").html() != '100%' && image_uploaded != 1){
                swal("Please Wait!", "Please wait while image is uploading!", "error");
                 e.preventDefault(e);
            }
           
        }
          
        });
   
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