<table class="table table-bordered table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Profile Picture</th>
                        <th scope="col">Date added</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin_users as $key => $admin_user)
                    <tr>
                        <th scope="row">{{ $admin_user->id }}</th>
                        <td><img src="{{ $admin_user->profile_image }}" alt="" width="50" class="rounded img-thumbnail"> </td>
                        <td>{{ date('M d Y', strtotime($admin_user->created_at)) }}</td>
                        <td>{{ $admin_user->name }}</td>
                        <td>{{ $admin_user->email }}</td>
                        <td><a href="{{ route('edit_admin_user', $admin_user->id) }}" class="btn btn-primary btn-sm btn-block"><span class="fas fa-pen"></span> edit</a></td>
                        <td><a onclick="return deleted('{{ route('delete_admin_user', $admin_user->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block"><span class="fas fa-trash"></span> Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>