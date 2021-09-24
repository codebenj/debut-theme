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
            <h4 class="card-header">Add new Podcast</h4>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('new_podcast') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="version">Podcast Title</label>
                        <input class="form-control" type="text" required name="title" value="{{ request()->input('title', old('title')) }}">
                    </div>
                    <div class="form-group">
                        <label for="podcast_author">Select Author</label>
                        <select class="form-control" name="podcast_author" id="podcast_author">
                          <option value="">Please Select Blog Author...</option>
                          @if(isset($author_detail) && !empty($author_detail))
                          @foreach($author_detail as $author) 
                          <option value="{{ $author->id }}">{{ $author->name}}</option>
                          @endforeach
                          @endif
                      </select>
                    </div>
                     <div class="form-group">
                        <label for="meta_description_new">Podcast Meta Description</label>
                        <textarea class="form-control" name="meta_description">{!! request()->input('meta_description', old('meta_description')) !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="version">Podcast Description</label>
                        <textarea class="ckeditor-description form-control" name="description">{!! request()->input('description', old('description')) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="version">Wistia Audio ID</label>
                            <input class="form-control" type="text" required name="podcast_widget" value="{{ request()->input('podcast_widget', old('podcast_widget')) }}">
                        </div>
                        <div class="form-group">
                            <label for="version">Podcast Transcript</label>
                            <textarea class="ckeditor-description form-control" name="podcast_transcript">{!! request()->input('description', old('description')) !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="version">Transcript Time</label>
                            <input class="form-control" type="text" name="transcript_time" value="{{ request()->input('transcript_time', old('transcript_time')) }}">
                        </div>
                        <div class="form-group">
                            <label for="version">Podcast Tags</label>
                            <select  name= "podcast_tags[]"  class="podcast_tag" multiple></select>
                        </div>
                        <div class="form-group">
                            <label for="version">Podcast Categories</label>
                            <select  name= "podcast_categories[]" class="podcast_category" multiple></select>
                        </div>
                        <div class="form-group">
                            <label for="version">Podcast Publish Date</label>
                            <input  class="form-control" type="text" placeholder="click to show datepicker" name="podcast_publish_date" id="podcast_publish_date" value="{{ request()->input('podcast_publish_date', old('podcast_publish_date')) }}">
                        </div>
                        <div class="form-group">
                            <label for="theme_file">Podcast Image File</label>
                            <input type="file" class="form-control-file" id="image_file" name="feature_image" accept="image/x-png,image/gif,image/jpeg">
                        </div>
                        <div class="form-group">
                            <label for="version">Featured Image Alt Text</label>
                            <input class="form-control" type="text" name="alt_text" value="{{ request()->input('alt_text', old('alt_text')) }}">
                        </div>
                        <div class="form-group">
                            <label for="version">Guest Image Alt Text</label>
                            <input class="form-control" type="text" name="guest_image_alt_text" value="{{ request()->input('guest_image_alt_text', old('guest_image_alt_text')) }}">
                        </div>
                        <input type="hidden" name="image_path">
                        <button type="submit" class="btn btn-primary btn-lg">Submit Podcast</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endsection

    @section("scripts")
    <script type="text/javascript">

        $(document).ready(function($) {
            $('.ckeditor-description').ckeditor({
                allowedContent: true,
            });
            $('.ckeditor-description').ckeditor({
                allowedContent: true,
            });
            $('#podcast_publish_date').datepicker({
                dateFormat: 'yy-mm-dd'
            });

        });

        $("form").submit(function(e){
          if($("input[name='image_path']").val() == ''){
            swal("Please Wait!", "Please wait while image is uploading!", "error");
            e.preventDefault(e);
          }
        });

        $("#image_file").pekeUpload({
            notAjax:false,
            url:"{{ route('upload_image') }}",
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

        $('.podcast_tag').tokenize2({
              tokensAllowCustom:true,
              searchFromStart:true,
              dataSource: function(search, object){
                $.ajax('{{ route('get_all_podcast_meta')}}', {
                    data: { query: search, start: 1 ,'type':'podcast_tag'},
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
            $('.podcast_category').tokenize2({
              tokensAllowCustom:true,
              searchFromStart:true,
              dataSource: function(search, object){
                $.ajax('{{ route('get_all_podcast_meta')}}', {
                    data: { query: search, start: 1 ,'type':'podcast_category'},
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