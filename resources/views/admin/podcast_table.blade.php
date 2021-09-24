<table class="table table-bordered table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Meta Description</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($podcasts as $key => $podcast)
                    <tr>
                        <th scope="row">{{ $podcast->id }}</th>
                        <td><img src="{{ $podcast->feature_image }}" alt="" width="50" class="rounded img-thumbnail"></td>
                        <td> {{ (!empty($podcast->podcast_publish_date) ? date('M d Y', strtotime($podcast->podcast_publish_date)) : date('M d Y', strtotime($podcast->created_at)) ) }}</td>
                        <td><a href="{{Route('podcast_slug', $podcast->slug)}}" target="_blank">{{ $podcast->title }}</td>
                        <td>{{ $podcast->meta_description}}</td>
                        <td><a href="{{ route('show_podcast', $podcast->id) }}" class="btn btn-primary btn-sm btn-block" target="_blank"><span class="fas fa-pen"></span> edit</a>
                        </td>
                        <td><a onclick="return deleted('{{ route('delete_podcast', $podcast->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
                                <span class="fas fa-trash"></span> Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>