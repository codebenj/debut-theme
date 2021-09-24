@extends('layouts.admin')
@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style type="text/css">
        a.theme_dashboard button.btn.btn-primary {
            margin-bottom: 10px;
        }
    </style>
@endsection


@section('content')
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
                <h4 class="card-header">Add new YouTube video</h4>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <?php
                    $user = auth()->user();
                    ?>

                    <form method="POST" action="{{ route('new_video') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="version">Title</label>
                            <input class="form-control" type="text" required name="title" value="{{ request()->input('title', old('title')) }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Video Id</label>
                            <input class="form-control" type="text" name="video_id">
                        </div>

                        <div class="form-group">
                            <label for="video_author">Select Author</label>
                            <select class="form-control" name="video_author" id="video_author">
                                <option value="">Please Select Video Author...</option>
                                @if(isset($author_detail) && !empty($author_detail))
                                    @foreach($author_detail as $author)
                                        <option value="{{ $author->id }}">{{ $author->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="meta_description_new">Video Meta Description</label>
                            <textarea class="form-control" name="meta_description">{!! request()->input('meta_description', old('meta_description')) !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Transcript</label>
                            <textarea class="ckeditor-description form-control" name="transcript">{!! request()->input('transcript', old('transcript')) !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="meta_description_new">Video Description</label>
                            <textarea class="ckeditor-description form-control" name="description">{!! request()->input('video_description', old('video_description')) !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Publish Date</label>
                            <input  class="form-control" type="text" placeholder="click to show datepicker" name="publish_date" id="video_publish_date" value="{{ request()->input('publish_date', old('publish_date')) }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Watch Time</label>
                            <input  class="form-control" type="text" name="watching_time" id="video_wattch_time" value="{{ request()->input('watch_time', old('watch_time')) }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Video Tags</label>
                            <select  name= "video_tags[]"  class="video_tag" multiple></select>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Categories</label>
                            <select  name= "video_categories[]" class="video_category" multiple></select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select autocomplete="off" class="form-control" name="status" id="status">
                                <option selected="selected" value="1">Active</option>
                                <option value="0">Inactive</option>S
                            </select>
                        </div>
                        <input type="hidden" name="image_path">
                        <button type="submit" class="btn btn-primary btn-lg">Add Video</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">

        $(document).ready(function($) {
            setAutoPublishDateVisibility(1, true);

            $('#video_publish_date').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $('#auto_publish_at').datepicker({
                dateFormat: 'yy-mm-dd'
            });

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

            // $("form").submit(function(e){
            //     if($("input[name='image_path']").val() == ''){
            //         swal("Please Wait!", "Please wait while image is uploading!", "error");
            //         e.preventDefault(e);
            //     }
            // });

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

            $('.video_tag').tokenize2({
                tokensAllowCustom:true,
                searchFromStart:true,
                // dataSource:'{{ route('get_all_video_meta')}}',
                dataSource: function(search, object){
                    $.ajax('{{ route('get_all_video_meta')}}', {
                        data: { query: search, start: 1 ,'type':'video_tag'},
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

            $('.video_category').tokenize2({
                tokensAllowCustom:true,
                searchFromStart:true,
                // dataSource:'{{ route('get_all_video_meta')}}',
                dataSource: function(search, object){
                    $.ajax('{{ route('get_all_video_meta')}}', {
                        data: { query: search, start: 1 ,'type':'video_category'},
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
