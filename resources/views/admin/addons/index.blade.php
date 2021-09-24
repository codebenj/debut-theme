@extends('layouts.admin')

@section('styles')
<style>
    .btn-add-product{
        position: fixed;
        bottom: 30px;
        right: 30px;
    }

    span.tag.label.label-info span {
        display: none;
    }

    .bootstrap-tagsinput{
        pointer-events: none;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group">
            <input type="text" id="search" name="q" class="search form-control form-control-lg" placeholder="Search Add-Ons.." >
        </div>
        <div class="table-responsive rounded">
            <div id="addons_table_data">
                @include('admin.addons.table')
            </div>
        </div>
    </div>
</div>

<a href="{{ route('addons.create') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg btn-add-product">
    <span class="fas fa-plus"></span>
</a>
@endsection

@section("scripts")
<script>
    function deleted(formID){
        swal({
            title: 'Are you sure you want to delete this Add-On?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function() {
            var form = document.getElementById(formID);
            form.submit();
            
            return true;
        });
    }

    $(document).ready(function() {
        src = "{{ route('addons.search') }}";
        $("#search").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: src,
                    dataType: "json",
                    data: {
                        query: request.term
                    },
                    success: function(result) {
                        $('#addons_table_data').html(result.html);
                    }
                });
            },
            minLength: 0,
        });
    });
</script>
@endsection
