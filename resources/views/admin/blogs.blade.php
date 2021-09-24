@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif
        <div class="form-group">
            <input type="text" id="search" name="q" class="search form-control form-control-lg" placeholder="Search blogs.." >
        </div>
        <div class="table-responsive rounded">
            <div id="blogs_table_data">
            @include('admin.blog_table')
            </div>
        </div>
    </div>
</div>

<a href="{{ route('addblog') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg btn-add-product">
    <span class="fas fa-plus"></span>
</a>
@endsection
@section("scripts")
<script>
    function deleted(link){
        swal({
            title: 'Are you sure you want to delete this blog ?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function() {
            window.location.href = link;
            return true;
        });
    }

    $(document).ready(function() {
                src = "{{ route('ajax_search_blog') }}";
                $("#search").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: src,
                            dataType: "json",
                            data: {
                                query : request.term
                            },
                            success: function(result) {
                                $('#blogs_table_data').html(result.html);
                            }
                        });
                    },
                    minLength: 0,
                });
              });
</script>
@endsection
