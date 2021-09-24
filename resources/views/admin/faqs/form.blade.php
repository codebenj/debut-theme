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
            <h4 class="card-header">
                @if (isset($faq))
                Update FAQ
                @else
                Add new FAQ
                @endif
            </h4>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ isset($faq) ? route('frequently-asked-questions.update', $faq->id) : route('frequently-asked-questions.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if (isset($faq))
                    @method('PUT')
                    @endif
                    <div class="form-group">
                        <label for="version">FAQ Title</label>
                        <input class="form-control" type="text" required name="title" value="{{ old('title', isset($faq) ? $faq->title : '') }}">
                    </div>
                    <div class="form-group">
                        <label for="content">FAQ Content</label>
                        <textarea class="form-control" required name="content">{{ old('content', isset($faq) ? $faq->content : '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="categories">FAQ Categories</label>
                        <select name="categories[]" class="categories" multiple>
                            @if (isset($faq))
                                @foreach ($faq->categories as $category)
                                <option value="{{ $category }}" selected>{{ $category }}</option>
                                @endforeach 
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
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
        $('.categories').tokenize2({
            tokensAllowCustom: true,
            searchFromStart: true,
            dataSource: function(search, object) {
                $.ajax('{{ route('frequently-asked-questions.categories')}}', {
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
    });
</script>
@endsection 