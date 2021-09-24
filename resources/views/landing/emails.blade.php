@section('styles')
@endsection

@section('content')
<div>
	@foreach( $data as $datas )
	<p>{{ $datas->name }}</p>
	<p>{{ $datas->email }}</p>
	<p>{{ $datas->message }}</p>
	@endforeach
</div>
@endsection