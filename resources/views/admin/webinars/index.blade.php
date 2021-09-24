@extends('layouts.admin')
@section('styles')
<style>
.results tr[visible='false'],
.no-result{
    display:none;
}
.results tr[visible='true']{
    display:table-row;
}
.pagination-shop .pagination{
    justify-content: center;
}
.btn-add-product{
    position: fixed;
    bottom: 30px;
    right: 30px;
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="form-group">
            <input type="text" id="search" name="q" class="search form-control form-control-lg" placeholder="Search Webinars.." >
        </div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="all-webinar">
            <div class="mb-2 table-responsive rounded">
                <table class="table table-bordered table-hover mb-0 results">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Presenter</th>
                        <th scope="col">Webinar Link</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Release date</th>
                        <th scope="col">Edit </th>
                        <th scope="col">Delete </th>
                        </tr>
                        <tr class="warning no-result">
                        <td colspan="7">No result</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($webinars as $webinar)
                        <tr>
                        <th>{{ $webinar->id }}</th>
                        <th><img src="{{ $webinar->image }}" alt="" width="50" class="rounded img-thumbnail"></th>
                        <td>{{ $webinar->title }}</td>
                        <td>{{ $webinar->admin_user->name }}
                        <td><a href="{{ $webinar->webinar_link }}" target="_blank">{{ $webinar->webinar_link }}</td>
                        <td>{{ $webinar->duration }}</td>
                        <td>{{ $webinar->release_date ? date('M d Y', strtotime($webinar->release_date)) : '' }}</td>
                        <td>
                            <a href="{{ route('admin.webinars.edit', $webinar->id) }}" class="btn btn-primary btn-sm btn-block">
                            <span class="fas fa-pen"></span> edit
                            </a>
                        </td>
                        <td>
                            <a onclick="return deleted({{ $webinar->id }});"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
                                <span class="fas fa-trash"></span> delete
                            </a>
                            <form id="form-delete-{{ $webinar->id }}" method="POST" action="{{ route("admin.webinars.destroy", $webinar->id) }}">
                                @csrf
                                @method("DELETE")
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mb-0 pagination-shop text-center">{{ $webinars->links() }}</div>
        </div>
    </div>
</div>

<a href="{{ route('admin.webinars.create') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg btn-add-product">
    <span class="fas fa-plus"></span>
</a>
@endsection
@section('scripts')
<script>

    function deleted(id)
    {
        swal({
            title: 'Are you sure you want to delete this webinar ?',
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function() {
            $("#form-delete-" + id).submit()
            return true;
        });
    }

    $(document).ready(function() {
        src = "{{ route('admin.webinar_search') }}";
        $("#search").autocomplete({
            source: function(request, response)
            {
                $.ajax({
                    url: src,
                    dataType: "json",
                    data: {
                        query : request.term
                    },
                    success: function(result) {
                        if(result.status == 'success'){
                            var html = result.html;
                            $('.all-webinar').html(html);
                        }
                    }
                });
            },
            minLength: 0,
        });
    });
</script>
@endsection
