<table class="table table-bordered table-hover mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Trial Days</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                	@if(isset($extend_features) && !empty($extend_features))
	                    @foreach ($extend_features as $key => $extend_feature)
	                    <tr>
	                        <th scope="row">{{ $extend_feature->id }}</th>
	                        <td>{{ $extend_feature->name }}</td>
	                        <td>{{ $extend_feature->description }}</td>
	                      	<td> {{ $extend_feature->extend_trial_days }}</td> 
	                        <td><a href="{{ route('extend_trial_update', $extend_feature->id) }}" class="btn btn-primary btn-sm btn-block">
	                                <span class="fas fa-pen"></span> edit</a></td>
	                        <td>
	                            <a onclick="return deleted('{{ route('extend_trial_delete', $extend_feature->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
	                                <span class="fas fa-trash"></span> Delete
	                            </a>
	                        </td>
	                    </tr>
	                    @endforeach
	                @endif    
                </tbody>
            </table>