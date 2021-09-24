 <table class="table table-bordered table-hover mb-0">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">User name</th>
            <th scope="col">Feature name</th>
            {{-- <th scope="col">Description</th> --}}
            <th scope="col">Image url</th>
            <th scope="col">Proof image</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($user_requests as $user_request)
          <tr class="user_request_approve_status" data-image="{{ $user_request->extend_trial_proof_image }}" user-id="{{ $user_request->user_id }}" data-feature_id="{{ $user_request->extend_trials_id }}">
            <th scope="row">{{ $user_request->id }}</th>
            <td>{{ $user_request->user_name }}</td>
            <td>{{ $user_request->name }} </td>
            {{-- <td>{{ $user_request->description }}</td> --}}
            <td><a href="{{ $user_request->extend_trial_proof_image }}" target="_blank">{{ $user_request->extend_trial_proof_image }}</a></td>
            <td><img src="{{ $user_request->extend_trial_proof_image }}" alt="" width="50" class="rounded img-thumbnail"></td>
          </tr>
          @endforeach
        </tbody>
      </table>