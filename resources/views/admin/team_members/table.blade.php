<table class="table table-bordered table-hover mb-0">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Position</th>
            <th scope="col">Team</th>
            <th scope="col">Hierarchy</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($team_members as $key => $team_member)
        <tr>
            <th scope="row">
                {{ $team_member->id }}
            </th>
            <td>
                <img src="{{ $team_member->image_url }}" alt="" width="50" class="rounded img-thumbnail">
            </td>
            <td>
                {{ $team_member->name }}
            </td>
            <td>
                {{ $team_member->position }}
            </td>
            <td>
                {{ $team_member->team->name }}
            </td>
            <td>
                {{ $team_member->hierarchy }}
            </td>
            <td>
                <a href="{{ route('team-members.edit', $team_member->id) }}" class="btn btn-primary btn-sm btn-block">
                    <span class="fas fa-pen"></span>
                    edit
                </a>
            </td>
            <td>
                <form id="form-delete-{{ $team_member->id }}" action="{{ route('team-members.destroy', $team_member->id) }}" method="POST">
                    @method('delete')
                    @csrf
                </form>
                <a onclick="return deleted('form-delete-{{ $team_member->id }}');"
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