<table class="table table-bordered table-hover mb-0">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Image</th>
            <th scope="col">Update Date</th>
            <th scope="col">Video</th>
            <th scope="col">Edit</th>
              <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($updates as $update)
          <tr>
            <th scope="row">{{ $update->id }}</th>
            <td><img src="{{ $update->image }}" alt="" width="50" class="rounded img-thumbnail"></td>
            <td> <?php echo date("F d, Y",strtotime($update->created_at)); ?></td>
             <td><a href="{{ $update->video }}" target="_blank">{{ $update->video }}</td>
              <td>
                <a href="{{ route('show_update', $update->id) }}" class="btn btn-primary btn-sm btn-block">
                  <span class="fas fa-pen"></span> edit
                </a>
              </td>
              <td>
                  <a onclick="return deleted('{{ route('delete_update', $update->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
                  <span class="fas fa-trash"></span> Delete
                </a>
              </td>
          </tr>
          @endforeach
        </tbody>
      </table>