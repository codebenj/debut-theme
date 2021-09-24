<table class="table table-bordered table-hover mb-0">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Icon</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Category</th>
            <th scope="col" width="100px">Edit</th>
            <th scope="col" width="120px">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($addons as $key => $addon)
        <tr>
            <td>
                <img src="{{ $addon->thumbnail }}" width="50" class="rounded img-thumbnail">
            </td>
            <td>
                <img src="{{ $addon->icon_url }}" width="50" class="rounded img-thumbnail">
            </td>
            <td>
                {{ $addon->name }}
            </td>
            <td>
                {{ $addon->description }}
            </td>
            <td>
                {{ $addon->category ? $addon->category : 'No category' }}
            </td>
            <td>
                <a href="{{ route('addons.edit', $addon->id) }}" class="btn btn-primary btn-sm btn-block">
                    <span class="fas fa-pen"></span> Edit
                </a>
            </td>
            <td>
                <form id="form-{{$addon->id}}" method="POST" action="{{ route('addons.destroy', $addon->id) }}">
                    <input type="hidden" name="_method" value="delete" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
                <a onclick="return deleted('form-{{$addon->id}}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
                    <span class="fas fa-trash"></span> Delete
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
