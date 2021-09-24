<table class="table table-bordered table-hover mb-0">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Date</th>
        <th scope="col">Title</th>
        <th scope="col">Status</th>
        <th scope="col">Meta Description</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($videos as $key => $video)
        <tr>
            <th scope="row">{{ $video->id }}</th>
            <td><img src="{{ $video->thumbnail }}" alt="" width="50" class="rounded img-thumbnail"></td>
            <td>{{ $video->publish_date }}</td>
            <td><a href="{{Route('video_slug', $video->slug)}}" target="_blank">{{ $video->title }}</td>
            <th>
                @if($video->status == 1)
                    <span class="badge badge-primary">Active</span>
                @else
                    <span class="badge badge-warning">Deactive</span>
                @endif
            </th>
            <td>{{ $video->meta_description }}</td>
            <td><a href="{{ route('show_video', $video->id) }}" class="btn btn-primary btn-sm btn-block">
                    <span class="fas fa-pen"></span> edit</a></td>
            <td>
                <a onclick="return deleted('{{ route('delete_video', $video->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
                    <span class="fas fa-trash"></span> Delete
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
