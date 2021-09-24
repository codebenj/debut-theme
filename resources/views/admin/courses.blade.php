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
        <input type="text" id="search" name="q" class="search form-control form-control-lg" placeholder="Search courses.." >
    </div>

    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif

    <div class="all-courses">
      <div class="mb-2 table-responsive rounded">
        <table class="table table-bordered table-hover mb-0 results">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Image</th>
              <th scope="col">Date added</th>
              <th scope="col">Course name</th>
              <th scope="col">Plan</th>
              <th scope="col">Edit course</th>
            </tr>
            <tr class="warning no-result">
              <td colspan="7">No result</td>
            </tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
            <tr>
              <th>{{ $course->id }}</th>
              <th><img src="{{ $course->image }}" alt="" width="50" class="rounded img-thumbnail"></th>
              <td>{{ date('M d Y', strtotime($course->created_at)) }} </td>
              <td>{{ $course->title }}</td>
              <td>{{ $course->plans }}</td>
              <td>
                <a href="{{ route('show_course', $course->id) }}" class="btn btn-primary btn-sm btn-block">
                  <span class="fas fa-pen"></span> edit
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mb-0 pagination-shop text-center">{{ $courses->links() }}</div>
    </div>

  </div>
</div>

<a href="{{ route('addcourse') }}" class="btn btn-danger btn-lg rounded-circle shadow-lg btn-add-product">
  <span class="fas fa-plus"></span>
</a>
@endsection
@section('scripts')
<script>
  $(document).ready(function() {
    src = "{{ route('courses_search') }}";
    $("#search").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    query : request.term
                },
                success: function(result) {
                  if(result.status == 'success'){
                    var html = result.html;
                    $('.all-courses').html(html);
                  }
                }
            });
        },
        minLength: 0,
    });

  });
</script>
@endsection
