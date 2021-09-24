<div class="mb-2 table-responsive rounded">
    <table class="table table-bordered table-hover mb-0 results">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Title</th>
            <th scope="col">Webinar Link</th>
            <th scope="col">Duration</th>
            <th scope="col">Release_date</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
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
<div class="mb-0 pagination-shop text-center">{{ $webinars->appends(request()->except('page'))->links() }}</div>

<script type="text/javascript">
    $('a.page-link').click(function(evt)
    {
        evt.preventDefault();
        var src = $(this).attr('href');
        $.ajax({
            url: src,
            dataType: "json",
            success: function(result)
            {
                if(result.status == 'success'){
                var html = result.html;
                $('.all-webinar').html(html);
                }
            }
        });
    });
</script>
