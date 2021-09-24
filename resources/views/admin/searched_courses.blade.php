<div class="mb-2 table-responsive rounded">
  <table class="table table-bordered table-hover mb-0 results">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Course name</th>
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
        <td>{{ $course->title }}</td>
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
<div class="mb-0 pagination-shop text-center">{{ $courses->appends(request()->except('page'))->links() }}</div>

<script type="text/javascript">
  $('a.page-link').click(function(evt){
      evt.preventDefault();
      var src = $(this).attr('href');
      $.ajax({
          url: src,
          dataType: "json",
          success: function(result) {
            if(result.status == 'success'){
              var html = result.html;
              $('.all-courses').html(html);
            }
          }
      });
    });
</script>