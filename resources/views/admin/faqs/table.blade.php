<table class="table table-bordered table-hover mb-0">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Date</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($faqs as $key => $faq)
        <tr>
            <th scope="row">
                {{ $faq->id }}
            </th>
            <td>
                {{ $faq->title }}
            </td>
            <td>
                {{ $faq->content }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($faq->created_at)->toFormattedDateString() }}
            </td>
            <td>
                <a href="{{ route('frequently-asked-questions.edit', $faq->id) }}" class="btn btn-primary btn-sm btn-block">
                    <span class="fas fa-pen"></span>
                    edit
                </a>
            </td>
            <td>
                <form id="form-delete-{{ $faq->id }}" action="{{ route('frequently-asked-questions.destroy', $faq->id) }}" method="POST">
                    @method('delete')
                    @csrf
                </form>
                <a onclick="return deleted('form-delete-{{ $faq->id }}');"
                    href="javascript:void(0);"
                    class="btn btn-primary btn-sm btn-block"
                >
                    <span class="fas fa-trash"></span>
                    Delete
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>