<table class="table table-bordered table-hover mb-0">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Logo</th>
						<th scope="col">Date</th>
						<th scope="col">Name</th>
						<th scope="col">Link</th>
						<th scope="col">Popular</th>
						<th scope="col">Edit</th>
						<th scope="col">Delete</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($partners as $key => $partner)
					<tr>
						<th scope="row">{{ $partner->id }}</th>
						<td><img src="{{ $partner->logo }}" alt="" width="50" class="rounded img-thumbnail"></td>
						<td>{{ date('M d Y', strtotime($partner->created_at)) }}</td>
						
						<td>{{ $partner->name }}</td>
							<td><a href="{{ $partner->link }}" target="_blank">{{ $partner->link }}</td>
							<td> 
								@if ($partner->popular == 1) 
									<span class="fa fa-check"></span> 
								@else 
									<span class="fa fa-times"></span> 
								@endif 
							</td>
								<td>
									<a href="{{ route('show_partner', $partner->id) }}" class="btn btn-primary btn-sm btn-block">
										<span class="fas fa-pen"></span> edit
									</a>
								</td>
								<td>
									<a onclick="return deleted('{{ route('delete_partner', $partner->id) }}');"  href="javascript:void(0);" class="btn btn-primary btn-sm btn-block">
										<span class="fas fa-trash"></span> Delete
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>