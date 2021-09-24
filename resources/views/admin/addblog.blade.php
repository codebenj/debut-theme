@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

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
            <h4 class="card-header">Add new Blog</h4>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <?php
                $user = auth()->user();
                ?>

                <form method="POST" action="{{ route('new_blog') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="version">Blog Title</label>
                        <input class="form-control" type="text" required name="title" value="{{ request()->input('title', old('title')) }}">
                    </div>

                    <div class="form-group">
                        <label for="version">Blog Slug Url</label>
                        <input class="form-control" type="text" name="blog_slug" value="{{ request()->input('blog_slug', old('blog_slug')) }}">
                    </div>

                    <div class="form-group">
                        <label for="blog_author">Select Author</label>
                        <select class="form-control" name="blog_author" id="blog_author">
                          <option value="">No Author</option>
                        @foreach($author_detail as $author) 
                          <option value="{{ $author->id }}">{{ $author->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="meta_description_new">Blog Meta Description</label>
                        <textarea class="form-control" name="meta_description">{!! request()->input('meta_description', old('meta_description')) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="version">Blog Description</label>
                        <textarea class="ckeditor-description form-control" name="description">{!! request()->input('description', old('description')) !!}</textarea>
                        <!-- <input id="d" type="hidden" name="description" value="{{ request()->input('description', old('description')) }}">
                        <trix-editor input="d"></trix-editor> -->
                    </div>

                    <div class="form-group">
                        <label for="version">Blog Tags</label>
                        <select  name= "blog_tags[]"  class="blog_tag" multiple></select>
                    </div>


                    <div class="form-group">
                        <label for="version">Blog Categories</label>
                         <select  name= "blog_categories[]" class="blog_category" multiple></select>
                    </div>

                    <div class="form-group">
                        <label for="version">Blog Publish Date</label>
                        <input  class="form-control" type="text" placeholder="click to show datepicker" name="blog_publish_date" id="blog_publish_date" value="{{ request()->input('blog_publish_date', old('blog_publish_date')) }}">
                    </div>


                    
                    <div class="form-group">
                        <label for="theme_file">Blog Image File</label>
                        <input type="file" class="form-control-file" id="image_file" name="feature_image" accept="image/x-png,image/gif,image/jpeg">
                    </div>
                    <div class="form-group">
                        <label for="version">Image Alt Text</label>
                        <input class="form-control" type="text" name="alt_text" value="{{ request()->input('alt_text', old('alt_text')) }}">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select onchange="setAutoPublishDateVisibility(this.value, true)" autocomplete="off" class="form-control" name="status" id="status">
                          <option selected="selected" value="1">Active</option>
                          <option value="0">Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="most_popular" id="most-popular">
                            <label class="form-check-label" for="most-popular">
                                Most Popular
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="picked_by_editors" id="picked-by-editors">
                            <label class="form-check-label" for="picked-by-editors">
                                Picked by Editors
                            </label>
                        </div>
                    </div>
                    <div id="auto_publish_at_container">
                        <div class="form-group">
                            <label for="version">Auto Publish Date</label>
                            <input  class="form-control" type="text" placeholder="Click to show datepicker" name="auto_publish_at" id="auto_publish_at" value="{{ request()->input('auto_publish_at', old('auto_publish_at')) }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Auto Publish Time</label>
                            <input  class="form-control" type="text" placeholder="Click to show timepicker" name="auto_publish_time" id="auto_publish_time" value="">
                        </div>
                    </div>
                        <input type="hidden" name="image_path">
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

    $(document).ready(function($) {
        setAutoPublishDateVisibility(1, true);

        $('#blog_publish_date').datepicker({
                dateFormat: 'yy-mm-dd'
        });

        $('#auto_publish_at').datepicker({
                dateFormat: 'yy-mm-dd'
        });

        $('#auto_publish_time').timepicker();
 
         $(document).on('click','.pkdel',function(){
                    e.stopPropagation();
                    e.preventDefault();
        });

        $('input[name=title]').on('focusout', function () {
            var slug = $("input[name='title']").val().toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
            $("input[name='blog_slug']").val(slug);
        });

        $('.ckeditor-description').ckeditor({
            allowedContent: true,
        });

        $("form").submit(function(e){
          if($("input[name='image_path']").val() == ''){
            swal("Please Wait!", "Please wait while image is uploading!", "error");
            e.preventDefault(e);
          }
        });

        $("#image_file").pekeUpload({
            notAjax:false,
            url:"{{ route('upload_blog_image') }}",
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
                $(':input[type="submit"]').show();

            }
        });

        
 
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
    
 

      
});
  
</script>
@endsection 