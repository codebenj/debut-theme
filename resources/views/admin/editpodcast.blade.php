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
            <h4 class="card-header">Modify Podcast</h4>
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" id ='edit_podcast_form' action="{{ route('edit_podcast', $podcast->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="version">Podcast Title</label>
                        <input class="form-control" type="text" required name="title" value="{{ $podcast->title }}">
                    </div>
                    <div class="form-group">
                        <label for="podcast_author">Select Author</label>
                        <select class="form-control" name="podcast_author" id="podcast_author">
                          <option value="1">Please Select Podcast Author...</option>
                        @foreach($author_detail as $author) 
                            @php $selected = ""; @endphp
                            @if(trim($podcast->author_id) == trim($author->id))
                                    @php $selected = "selected"; @endphp
                            @endif
                          <option value="{{ $author->id }}" <?php echo $selected; ?>>{{ $author->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="meta_description_new">Podcast Meta Description</label>
                        <textarea class="form-control" name="meta_description">{{ $podcast->meta_description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="version">Podcast Description</label>
                        <textarea class="ckeditor-description form-control" name="description">{!! $podcast->description !!}</textarea>
                        <!-- <input type="hidden" name="description" value="{{ $podcast->description }}">
                        <trix-editor input="d"></trix-editor> -->
                    </div>
                     <div class="form-group">
                        <label for="version">Wistia Audio ID</label>
                        <input class="form-control" type="text" required name="podcast_widget" value="{{ $podcast->podcast_widget }}">
                    </div>
                    <div class="form-group">
                        <label for="version">Podcast Transcript</label>
                        <textarea class="ckeditor-description form-control" name="podcast_transcript">{!! $podcast->podcast_transcript !!}</textarea>
                    </div>
                    <div class="form-group">
                            <label for="version">Transcript Time</label>
                            <input class="form-control" type="text" name="transcript_time" value="{{ $podcast->transcript_time }}">
                    </div>

                     <div class="form-group">
                            <label for="version">Podcast Tags</label>
                            <select  name= "podcast_tags[]"  class="podcast_tag" multiple>
                                @foreach ($podcast_tags as $tag)
                                <option value="{{ $tag }}" selected >{{ $tag }}</option>
                                @endforeach 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="version">Podcast Categories</label>
                            <select  name= "podcast_categories[]" class="podcast_category" multiple>
                             @foreach ($podcast_category as $category)
                             <option value="{{ $category }}" selected >{{ $category }}</option>
                             @endforeach 
                         </select>
                     </div>
                     <div class="form-group">
                        <label for="version">Podcast Publish Date</label>
                        <input  class="form-control" type="text" placeholder="click to show datepicker" name="podcast_publish_date" id="podcast_publish_date" value="<?php echo $podcast->podcast_publish_date; ?>">
                    </div>
                    <div class="form-group">
                        <label for="feature_image">Upload New Image File(Will Delete Previous File Automatically)</label>
                        <div class="file-upload-wrapper">

                        <input type="file" class="form-control-file" id="image_file" name="feature_image">
                        <input type="hidden" name="feature_image_source">

                    </div>
                    <div class="form-group">
                        <label for="version">Featured Image Alt Text</label>
                        <input class="form-control" type="text" name="alt_text" value="{{ $podcast->alt_text }}">
                    </div>
                    <div class="form-group">
                        <label for="version">Guest Image Alt Text</label>
                        <input class="form-control" type="text" name="guest_image_alt_text" value="{{ $podcast->guest_image_alt_text }}">
                    </div>
                    <div class="form-group">
                        <div class="filename">Last Used Image</div>
                        <input type="hidden" value="{{ $podcast->feature_image }}" name="last_used">
                    </div>
                    <div class="pekecontainer_prev">
                        <ul></ul>
                        <div class="row pkrw" rel="0">
                            <div class="col-lg-2 col-md-2 col-xs-4">
                                <img class="thumbnail" src="{{ $podcast->feature_image }}" height="64">
                            </div>
                            <div class="col-lg-2 col-md-2 col-xs-2">
                                <a href="javascript:void(0);" class="btn btn-danger pkdel">Will Get Deleted Automatically</a>
                            </div>
                        </div>
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
    var  src = "{{ route('upload_image') }}";
    var image_uploaded;
    $(document).ready(function($) {
        $('.ckeditor-description').ckeditor({
            allowedContent: true,
        });
        $('#podcast_publish_date').datepicker({
            dateFormat: 'yy-mm-dd'
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