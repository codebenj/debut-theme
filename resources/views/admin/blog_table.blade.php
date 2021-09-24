<div class="d-flex flex-row b-feature-menu">
    <div class="{{ url()->current() == url('admin/blogs') ? 'active' : '' }}"><a href="{{ url('admin/blogs') }}">All</a></div>
    <div class="{{ url()->current() == url('admin/blogs/picked-by-editors') ? 'active' : '' }}"><a href="{{ url('admin/blogs/picked-by-editors') }}">Picked by Editors</a></div>
    <div class="{{ url()->current() == url('admin/blogs/most-popular') ? 'active' : '' }}"><a href="{{ url('admin/blogs/most-popular') }}">Most Popular</a></div>
</div>
<table class="table table-bordered table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Image</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Meta Description</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($blogs as $key => $blog)
                    <tr>
                        <th scope="row">{{ $blog->id }}</th>
                        <td><img src="{{ $blog->feature_image }}" alt="" width="50" class="rounded img-thumbnail"></td>
                        <th>
                            <!-- <span class="fas {{ $blog->status == 1 ? 'fa-check' : 'fa-edit' }}"></span> -->
                            @if($blog->status == 1)
                            <span class="badge badge-primary">Published</span>
                            @else
                            <span class="badge badge-warning">Draft</span>
                            @endif
                        </th>
                        <td>{{ (!empty($blog->blog_publish_date) ? date('M d Y', strtotime($blog->blog_publish_date)) : date('M d Y', strtotime($blog->created_at)) ) }}</td>
                        <td><a href="{{Route('blog_slug', $blog->slug)}}?preview=true" target="_blank">{{ $blog->title }}</td>
                       <td class="d-flex flex-column"> 
                        <div class="b-description">{{ $blog->meta_description }}</div>
                        @if ($blog->picked_by_editors == 1)
                        <div class="b-picked-by-editors px-3 py-1 cursor-pointer mt-3"><span class="far fa-folder"></span> Picked by Editors</div>
                        @endif
                        @if ($blog->most_popular == 1)
                        <div class="b-most-popular px-3 py-1 cursor-pointer mt-3"><span class="far fa-folder"></span> Most Popular</div>
                        @endif
                        </td> 
                        <td><a href="{{ route('show_blog', $blog->id) }}" class="btn btn-primary btn-sm btn-block">
                                <span class="fas fa-pen"></span> edit</a></td>
                        <td>
                            <a onclick="return deleted('{{ route('delete_blog', $blog->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
                                <span class="fas fa-trash"></span> Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>