@extends('layouts.admin')


@section('content')
<div class="row">
    <div class="offset-9 col-md-3">
        <div class="form-group">
            <a class="btn btn-secondary btn-sm form-control" href="{{ route('admin.generate_settings_report') }}"><i class="fa fa-plus"></i> Generate Report</a>
        </div>
    </div>
</div>

<div class="row">
  <div class="col">

    @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger" role="alert">
      {{ session('error') }}
    </div>
    @endif

    <div class="all-courses">
      <div class="mb-2 table-responsive rounded">
        <table class="table table-bordered table-hover mb-0 results">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Report Generate Date</th>
              <th scope="col">Total Paid Stores</th> 
              <th scope="col" style="width: 350px;">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reports as $report)
            <tr>
              <th>{{ $loop->iteration }}</th>
              <td>{{ date('Y-m-d H:i:s', strtotime($report->report_generate_date )) }}(UTC Time)</td>
              <td><span class="badge badge-primary">{{ $report->stores_update_info['total_paid_stores']  }}</span></td>
              <td>
                <a class="btn btn-light btn-sm" href="{{ route('admin.view_settings_report', $report->id) }}"><i class="fa fa-eye"></i>View Report</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mb-0 pagination-shop text-center">{{ $reports->links() }}</div>
    </div>

  </div>
</div>
@endsection

@section("scripts")
<script>
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
