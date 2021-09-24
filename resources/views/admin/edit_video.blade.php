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
                <h4 class="card-header">Modify Video</h4>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" id ='edit_video_form' action="{{ route('edit_video', $video->id) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="version">Video Title</label>
                            <input class="form-control" type="text" required name="title" value="{{ $video->title }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Video Id</label>
                            <input class="form-control" type="text" name="video_id" value="{{ $video->video_id }}">
                        </div>

                        <div class="form-group">
                            <label for="video_author">Select Author</label>
                            <select class="form-control" name="video_author" id="video_author">
                                <option value="1">Please Select Video Author...</option>
                                @foreach($author_detail as $author)
                                    @php $selected = ""; @endphp
                                    @if(trim($video->author_id) == trim($author->id))
                                        @php $selected = "selected"; @endphp
                                    @endif
                                    <option value="{{ $author->id }}" <?php echo $selected; ?>>{{ $author->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="meta_description_new">Video Meta Description</label>
                            <textarea class="form-control" name="meta_description">{{ $video->meta_description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Transcript</label>
                            <textarea class="ckeditor-description form-control" name="transcript">{!! $video->transcript !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Description</label>
                            <textarea class="ckeditor-description form-control" name="description">{!! $video->description !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Publish Date</label>
                            <input  class="form-control" type="text" placeholder="click to show datepicker" name="publish_date" id="video_publish_date" value="{{ $video->publish_date }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Watch Time</label>
                            <input  class="form-control" type="text" name="watching_time" id="video_wattch_time" value="{{ $video->watching_time }}">
                        </div>

                        <div class="form-group">
                            <label for="version">Video Tags</label>
                            <select  name= "video_tags[]"  class="video_tag" multiple>
                                @foreach ($video_tags as $tag)
                                    <option value="{{ $tag }}" selected >{{ $tag }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="version">Video Categories</label>
                            <select  name= "video_categories[]" class="video_category" multiple>
                                @foreach ($video_categories as $category)
                                    <option value="{{ $category }}" selected >{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select autocomplete="off" class="form-control" name="status" id="status">
                                <option {{ $video->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                <option {{ $video->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Update Video</button>
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

            $('.ckeditor-description').ckeditor({
                allowedContent: true,
            });
            $('#video_publish_date').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $(document).on('click','.pkdel',function(){
                e.stopPropagation();
                e.preventDefault();
            });


            $('.ckeditor-description').ckeditor({
                allowedContent: true,

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
